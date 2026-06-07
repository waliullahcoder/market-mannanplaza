<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Menu;
use App\MenuAction;
use App\MenuActionType;
use DataTables;
use PDF;

class MenuActionController extends Controller
{
    public function index($menuId)
    {
        $title = "Menu Action";

        $menuActions = MenuAction::select('tbl_menu_actions.*','tbl_menus.menu_name as parentMenuName')
            ->leftJoin('tbl_menus','tbl_menus.id','tbl_menu_actions.parent_menu_id')
            ->where('tbl_menu_actions.parent_menu_id',$menuId)
            ->orderBy('tbl_menu_actions.order_by','asc')
            ->get();

        return view('admin.menuAction.index')->with(compact('title','menuActions','menuId'));
    }

    public function add($menuId)
    {
        $menu = Menu::where('id',$menuId)->first();
        $menuActionOrderBy = MenuAction::where('parent_menu_id',$menuId)->max('order_by');

        $menuActionTypes = MenuActionType::orderBy('action_id','asc')->get();

        $orderBy = $menuActionOrderBy + 1;

        $title = "Add Menu Action ( ".$menu->menu_name." )";
        $formLink = "menuAction.save";
        $buttonName = "Save";

        return view('admin.menuAction.add')->with(compact('title','formLink','buttonName','orderBy','menuActionTypes','menuId'));
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $checkMenuAcionLink = MenuAction::where('action_link',$request->actionLink)->first();

        if ($checkMenuAcionLink)
        {
            return redirect(route('menu.add'))->with('error',"This Menu Action Already Exists With This '".$request->actionLink."' Menu Action Link");
        }
        else
        {
            MenuAction::create([
                'parent_menu_id' => $request->parentMenuId,
                'menu_type' => $request->menuType,
                'action_name' => $request->actionName,
                'action_link' => $request->actionLink,
                'order_by' => $request->orderBy,
            ]);

            return redirect(route('menuAction.add',$request->parentMenuId))->with('msg','Menu Added Successfully');
        }        
    }

    public function edit($menuActionId)
    {
        $menuAction = MenuAction::where('id',$menuActionId)->first();

        $menu = Menu::where('id',$menuAction->parent_menu_id)->first();

        $menuActionTypes = MenuActionType::orderBy('action_id','asc')->get();

        $title = "Edit Menu Action ( ".$menu->menu_name." )";
        $formLink = "menuAction.update";
        $buttonName = "Update";

        return view('admin.menuAction.edit')->with(compact('title','formLink','buttonName','menuActionTypes','menuAction'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $checkMenuAcionLink = MenuAction::where('id','!=',$request->menuActionId)->where('action_link',$request->actionLink)->first();

        if ($checkMenuAcionLink)
        {
            return redirect(route('menuAction.edit',$request->menuActionId))->with('error',"This Menu Action Already Exists With This '".$request->actionLink."' Menu Action Link");
        }
        else
        {
            $menuAction = MenuAction::find($request->menuActionId);
            $menuAction->update([
                'parent_menu_id' => $request->parentMenuId,
                'menu_type' => $request->menuType,
                'action_name' => $request->actionName,
                'action_link' => $request->actionLink,
                'order_by' => $request->orderBy,
            ]);

            return redirect(route('menuAction.index',$request->parentMenuId))->with('msg','Menu Updated Successfully');
        }        
    }

    public function delete(Request $request)
    {
        MenuAction::where('id',$request->menuActionId)->delete();
    }

    public function status(Request $request)
    {
        $menuAction = MenuAction::find($request->menuActionId);

        if ($menuAction->status == 1)
        {
            $menuAction->update( [               
                'status' => 0                
            ]);
        }
        else
        {
            $menuAction->update( [               
                'status' => 1                
            ]);
        }
    }

    // public function print()
    // {
    //     $pdf = PDF::loadView('admin.menuAction.print',['name'=>'Dew Hunt'],[],['orientation'=>'L']);
    //     return $pdf->stream('pdf_check.pdf');
    // }
}
