<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Menu;
use App\MenuAction;
use App\MenuActionType;

use DB;

class MenuController extends Controller
{
    public function index()
    {
        $title = "Menu Management";

        $nullMenus = Menu::select('tbl_menus.*','parent_menu as parentName')
            ->whereNull('parent_menu');

        $menus = DB::table('tbl_menus as tab1')
            ->select('tab1.*','tab2.menu_name as parentName')
            ->join('tbl_menus as tab2','tab2.id','=','tab1.parent_menu')
            ->union($nullMenus)
            ->orderBy('parentName','asc')
            ->orderBy('order_by','asc')
            ->get();

        // $menus = Menu::orderBy('menu_name','asc')->get();

        return view('admin.menu.index')->with(compact('title','menus'));
    }

    public function add()
    {
        $title = "Add Menu";
        $formLink = "menu.save";
        $buttonName = "Save";

        $menus = Menu::orderBy('menu_name','asc')->get();

        $menuOrderBy = Menu::whereNull('parent_menu')->max('order_by');

        if (@$menuOrderBy)
        {
            $orderBy = $menuOrderBy+1;
        }
        else
        {
            $orderBy = 1;
        }

        return view('admin.menu.add')->with(compact('title','formLink','buttonName','menus','orderBy'));
    }

    public function save(Request $request)
    {
        if ($request->menuLink == 'admin.index')
        {
            Menu::create([
                'parent_menu' => $request->parentMenu,
                'menu_name' => $request->menuName,
                'menu_link' => $request->menuLink,
                'menu_icon' => $request->menuIcon,
                'order_by' => $request->orderBy,
            ]);
        }
        else
        {
            $checkMenuLink = Menu::where('menu_link',$request->menuLink)->first();

            if ($checkMenuLink)
            {
                return redirect(route('menu.add'))->with('error',"This Menu Already Exists With This '".$request->menuLink."' Menu Link");
            }
            else
            {
                Menu::create([
                    'parent_menu' => $request->parentMenu,
                    'menu_name' => $request->menuName,
                    'menu_link' => $request->menuLink,
                    'menu_icon' => $request->menuIcon,
                    'order_by' => $request->orderBy,
                ]);
            }
        }

        return redirect(route('menu.add'))->with('msg','Menu Added Successfully');
    }

    public function edit($menuId)
    {
        // echo $menuId; exit();
        $title = "Edit Menu";
        $formLink = "menu.update";
        $buttonName = "Update";

        $menuInfo = Menu::where('id',$menuId)->first();

        $menus = Menu::orderBy('menu_name','asc')->get();

        return view('admin.menu.edit')->with(compact('title','formLink','buttonName','menus','menuInfo'));
    }

    public function update(Request $request)
    {
        if ($request->menuLink == 'admin.index')
        {
            $menu = Menu::find($request->menuId);

            $menu->update([
                'parent_menu' => $request->parentMenu,
                'menu_name' => $request->menuName,
                'menu_link' => $request->menuLink,
                'menu_icon' => $request->menuIcon,
                'order_by' => $request->orderBy,
            ]);
        }
        else
        {        
            $checkMenuLink = Menu::where('id','!=',$request->menuId)->where('menu_link',$request->menuLink)->first();

            if ($checkMenuLink)
            {
                return redirect(route('menu.edit',$request->menuId))->with('error',"This Menu Already Exists With This '".$request->menuLink."' Menu Link");
            }
            else
            {
                $menu = Menu::find($request->menuId);

                $menu->update([
                    'parent_menu' => $request->parentMenu,
                    'menu_name' => $request->menuName,
                    'menu_link' => $request->menuLink,
                    'menu_icon' => $request->menuIcon,
                    'order_by' => $request->orderBy,
                ]);

            }
        }

        return redirect(route('menu.index',$request->menuId))->with('msg','Menu Updated Successfully');
    }

    public function delete(Request $request)
    {
        Menu::where('id',$request->menuId)->delete();
        MenuAction::where('parent_menu_id',$request->menuId)->delete();
    }

    public function status(Request $request)
    {
        $menu = Menu::find($request->menuId);

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

    public function maxOrderBy(Request $request)
    {
        if ($request->parentMenuId)
        {
            $menuOrderBy = Menu::where('parent_menu',$request->parentMenuId)->max('order_by');
        }
        else
        {
            $menuOrderBy = Menu::whereNull('parent_menu')->max('order_by');
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
