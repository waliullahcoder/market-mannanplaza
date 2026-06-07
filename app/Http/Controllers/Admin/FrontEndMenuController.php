<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\FrontEndMenu;
use App\Page;

use DB;

class FrontEndMenuController extends Controller
{
    public function index()
    {
    	$title = "Front-End Menu Management";

        $nullMenus = FrontEndMenu::select('tbl_frontend_menu.*','parent_menu as parentName')
            ->whereNull('parent_menu');

    	$menus = DB::table('tbl_frontend_menu as tab1')
            ->select('tab1.*','tab2.menu_name as parentName')
            ->join('tbl_frontend_menu as tab2','tab2.id','=','tab1.parent_menu')
            ->union($nullMenus)
            ->orderBy('parentName','asc')
            ->orderBy('menu_name','asc')
            ->get();

    	// $menus = Menu::orderBy('menu_name','asc')->get();

    	return view('admin.frontEndMenu.index')->with(compact('title','menus'));
    }

    public function add()
    {
    	$title = "Add Menu";
    	$formLink = "frontEndMenu.save";
    	$buttonName = "Save";

    	$menus = FrontEndMenu::orderBy('menu_name','asc')->get();

        $menuOrderBy = FrontEndMenu::whereNull('parent_menu')->max('order_by');

        if (@$menuOrderBy)
        {
            $orderBy = $menuOrderBy+1;
        }
        else
        {
            $orderBy = 1;
        }

    	return view('admin.frontEndMenu.add')->with(compact('title','formLink','buttonName','menus','orderBy'));
    }

    public function save(Request $request)
    {
        $checkMenuLink = FrontEndMenu::where('menu_link',$request->menuLink)->first();

        if ($checkMenuLink)
        {
            return redirect(route('frontEndMenu.add'))->with('error',"This Menu Already Exists With This '".$request->menuLink."' Menu Link");
        }
        else
        {
            $frontendMenuId = FrontEndMenu::create([
                'parent_menu' => $request->parentMenu,
                'menu_name' => $request->menuName,
                'menu_link' => $request->menuLink,
                'order_by' => $request->orderBy,
                'created_by' => $this->userId,
            ]);

            Page::create([
                'frontend_menu_id' => $frontendMenuId->id,
                'page_name' => $request->menuName,
                'created_by' => $this->userId,
            ]);
        }

        return redirect(route('frontEndMenu.add'))->with('msg','Menu Added Successfully');
    }

    public function edit($menuId)
    {
        // echo $menuId; exit();
        $title = "Edit Front-End Menu";
        $formLink = "frontEndMenu.update";
        $buttonName = "Update";

        $menuInfo = FrontEndMenu::where('id',$menuId)->first();

        $menus = FrontEndMenu::orderBy('menu_name','asc')->get();

        return view('admin.frontEndMenu.edit')->with(compact('title','formLink','buttonName','menus','menuInfo'));
    }

    public function update(Request $request)
    {
        $checkMenuLink = FrontEndMenu::where('id','!=',$request->menuId)->where('menu_link',$request->menuLink)->first();

        if ($checkMenuLink)
        {
            return redirect(route('frontEndMenu.edit',$request->menuId))->with('error',"This Menu Already Exists With This '".$request->menuLink."' Menu Link");
        }
        else
        {
            $menu = FrontEndMenu::find($request->menuId);

            $menu->update([
                'parent_menu' => $request->parentMenu,
                'menu_name' => $request->menuName,
                'menu_link' => $request->menuLink,
                'order_by' => $request->orderBy,
                'updated_by' => $this->userId,
            ]);

            $page = Page::where('frontend_menu_id',$request->menuId)->first();

            $page->update([
                'page_name' => $request->menuName,
                'updated_by' => $this->userId,
            ]);

        }

        return redirect(route('frontEndMenu.index'))->with('msg','Menu Updated Successfully');
    }

    public function delete(Request $request)
    {
        FrontEndMenu::where('id',$request->menuId)->delete();
    }

    public function status(Request $request)
    {
        $menu = FrontEndMenu::find($request->menuId);

        if ($menu->status == 1)
        {
            $menu->update( [               
                'status' => 0                
            ]);
        }
        else
        {
            $menu->update( [               
                'status' => 1                
            ]);
        }
    }

    public function menuStatus(Request $request)
    {
        $menu = FrontEndMenu::find($request->menuId);

        if ($menu->menu_status == 1)
        {
            $menu->update( [               
                'menu_status' => 0                
            ]);
        }
        else
        {
            $menu->update( [               
                'menu_status' => 1                
            ]);
        }
    }

    public function footerMenuStatus(Request $request)
    {
        $menu = FrontEndMenu::find($request->menuId);

        if ($menu->footer_menu_status == 1)
        {
            $menu->update( [               
                'footer_menu_status' => 0                
            ]);
        }
        else
        {
            $menu->update( [               
                'footer_menu_status' => 1                
            ]);
        }
    }

    public function maxOrderBy(Request $request)
    {
        if ($request->parentMenuId)
        {
            $menuOrderBy = FrontEndMenu::where('parent_menu',$request->parentMenuId)->max('order_by');
        }
        else
        {
            $menuOrderBy = FrontEndMenu::whereNull('parent_menu')->max('order_by');
        }

        if (@$menuOrderBy)
        {
            $orderBy = $menuOrderBy+1;
        }
        else
        {
            $orderBy = 1;
        }
        
        if($request->ajax())
        {
            return response()->json([
                'orderBy'=>$orderBy
            ]);
        }   
    }
}
