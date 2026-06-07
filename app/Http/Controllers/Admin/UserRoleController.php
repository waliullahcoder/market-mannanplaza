<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\UserRoles;
use App\Menu;

class UserRoleController extends Controller
{
	public function index()
	{
    	$title = "User Role Management";

    	// $userRoles = UserRoles::orderBy('name','asc')->get();

        $currentRole = UserRoles::where('id',$this->userRole)->first();
        $userRoles = UserRoles::where('level','>=',$currentRole->level)->orderBy('name','ASC')->get();

    	return view('admin.userRole.index')->with(compact('title','userRoles'));
	}

	public function add()
	{
        $title = "Add User Roles";
        $formLink = "userRole.save";
        $buttonName = "Save";

        $currentRole = UserRoles::where('id',$this->userRole)->first();
        $userRoleLists = UserRoles::where('level','>=',$currentRole->level)->orderBy('level','ASC')->get();

        return view('admin.userRole.add')->with(compact('title','formLink','buttonName','userRoleLists'));
	}

	public function save(Request $request)
	{
		// dd($request->all());

        if(!$request->parentRole)
        {
            $level = '1';
        }
        elseif($request->parentRole)
        {
            $parentRoleInfo = UserRoles::where('id',$request->parentRole)->first();
            $level = $parentRoleInfo->level + 1;
        }

        UserRoles::create([
            'name' => $request->name,
            'parent_role' => $request->parentRole,
            'level' => $level,
        ]);

        return redirect(route('userRole.index'))->with('msg','User Role Added Successfully');
	}

	public function edit($userRoleId)
	{
        $title = "Edit User Roles";
        $formLink = "userRole.update";
        $buttonName = "Update";

        $currentRole = UserRoles::where('id',$this->userRole)->first();
        $userRoleLists = UserRoles::where('level','>=',$currentRole->level)->orderBy('level','ASC')->get();

        $userRole = UserRoles::where('id',$userRoleId)->first();

        return view('admin.userRole.edit')->with(compact('title','formLink','buttonName','userRole','userRoleLists'));
	}

	public function update(Request $request)
	{
		$userRole = UserRoles::find($request->userRoleId);

        if(!$request->parentRole)
        {
            $level = '1';
        }
        elseif($request->parentRole)
        {
            $parentRoleInfo = UserRoles::where('id',$request->parentRole)->first();
            $level = $parentRoleInfo->level + 1;
        }

        $userRole->update([
            'name' => $request->name,
            'parent_role' => $request->parentRole,
            'level' => $level,
        ]);

        return redirect(route('userRole.index'))->with('msg','User Role Updated Successfully');
	}

    public function delete(Request $request)
    {
        UserRoles::where('id',$request->userRoleId)->delete();
    }

    public function status(Request $request)
    {
        $userRole = UserRoles::find($request->userRoleId);

        if ($userRole->status == 1)
        {
            $userRole->update([
                'status' => 0
            ]);
        }
        else
        {
            $userRole->update([
                'status' => 1
            ]);
        }
    }

    public function permission($userRoleid)
    {
        $title = "User Permission";
        $formLink = "userRole.permissionUpdate";
        $buttonName = "Update";

        $userMenus = Menu::orderBy('order_by','ASC')->where('status',1)->get();
        $userRoles = UserRoles::where('id',$userRoleid)->first();
        return view('admin.userRole.permission')->with(compact('title','formLink','buttonName','userRoles','userMenus'));
    }

    public function permissionUpdate(Request $request)
    {
        $userroleId = $request->userroleId;
        $userRoles = UserRoles::find($userroleId);

        if(@$request->usermenu)
        {
        	$usermenus = implode(',', $request->usermenu);
        }
        else
        {
            $usermenus = '';
        }

        if(@$request->usermenuAction)
        {
            $usermenuAction = implode(',', @$request->usermenuAction);
        }
        else
        {
            $usermenuAction = '';
        }

        $userRoles->update( [
            'permission' => @$usermenus,
            'action_permission' => @$usermenuAction,
        ]);

        return redirect(route('userRole.index'))->with('msg','User Role Permission Updated Successfully');
    }
}
