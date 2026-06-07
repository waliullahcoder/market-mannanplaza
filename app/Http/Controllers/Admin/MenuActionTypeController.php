<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\MenuActionType;

class MenuActionTypeController extends Controller
{
	public function index()
	{
		$title = "Menu Action Type";

		$menuActionTypes = MenuActionType::orderBy('action_id','asc')->get();

    	return view('admin.menuActionType.index')->with(compact('title','menuActionTypes'));
	}

    public function add()
    {
    	$title = "Add Menu Action Type";
    	$formLink = "menuActionType.save";
    	$buttonName = "Save";

    	$menuActionTypeActionId = MenuActionType::max('action_id');

    	if ($menuActionTypeActionId)
    	{
    		$actionId = $menuActionTypeActionId + 1;
    	}
    	else
    	{
    		$actionId = 1;
    	}
    	

    	return view('admin.menuActionType.add')->with(compact('title','formLink','buttonName','actionId'));
    }

    public function save(Request $request)
    {
        $checkMenuActionType = MenuActionType::where('name',$request->name)->first();

        if ($checkMenuActionType)
        {
            return redirect(route('menuActionType.add'))->with('error',"This Menu Action Type Already Exists With This '".$request->name."' Name");
        }
        else
        {
            MenuActionType::create([
                'name' => $request->name,
                'action_id' => $request->actionId,
            ]);

            return redirect(route('menuActionType.add'))->with('msg','Menu Action Type Added Successfully');
        }    
    }

    public function edit($typeId)
    {
    	$title = "Edit Menu Action Type";
    	$formLink = "menuActionType.update";
    	$buttonName = "Update";

    	$menuActionType = MenuActionType::where('id',$typeId)->first();    	

    	return view('admin.menuActionType.edit')->with(compact('title','formLink','buttonName','menuActionType'));
    }

    public function update(Request $request)
    {
        $checkMenuActionType = MenuActionType::where('id','!=',$request->typeId)->where('name',$request->name)->first();

        if ($checkMenuActionType)
        {
            return redirect(route('menuActionType.edit',$request->typeId))->with('error',"This Menu Action Type Already Exists With This '".$request->name."' Name");
        }
        else
        {
        	$menuActionType = MenuActionType::find($request->typeId);

            $menuActionType->update([
                'name' => $request->name,
                'action_id' => $request->actionId,
            ]);

            return redirect(route('menuActionType.index'))->with('msg','Menu Action Type Updated Successfully');
        }    
    }

    public function delete(Request $request)
    {       
        MenuActionType::where('id',$request->typeId)->delete();
    }

    public function status(Request $request)
    {
        $menuActionType = MenuActionType::find($request->typeId);

        if ($menuActionType->status == 1)
        {
            $menuActionType->update( [               
                'status' => 0                
            ]);
        }
        else
        {
            $menuActionType->update( [               
                'status' => 1                
            ]);
        }
    }
}
