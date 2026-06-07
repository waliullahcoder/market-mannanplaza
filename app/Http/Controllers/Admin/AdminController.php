<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Admin;
use App\UserRoles;
use DB;

class AdminController extends Controller
{
    public function index()
    {
        $title = "User Management";

        $currentRole = UserRoles::where('id',$this->userRole)->first();
        $users = Admin::select('admins.*','tbl_user_roles.name as userRoleName')
            ->leftJoin('tbl_user_roles','tbl_user_roles.id','=','admins.role')
            ->where('tbl_user_roles.level','>=',$currentRole->level)
            ->orderBy('tbl_user_roles.level','ASC')
            ->get();


        return view('admin.users.index')->with(compact('title','users'));
    }

    public function addUser()
    {
        $title = "Add New User";
        $formLink = "user.save";
        $buttonName = "Save";

        $currentRole = UserRoles::where('id',$this->userRole)->first();
        $userRoles = UserRoles::where('level','>=',$currentRole->level)->orderBy('level','ASC')->get();

        return view('admin.users.add')->with(compact('title','formLink','buttonName','userRoles'));
    }

    public function saveUser(Request $request)
    {
        $this->validation($request);

        if (isset($request->userImage))
        {
            $userImage = \App\HelperClass::UploadImage($request->userImage,'admins','public/uploads/admin_images/');
        }
        else
        {
            $userImage = "";
        }

        $users = Admin::create( [
            'role' => $request->role,
            'name' => $request->name,
            'username' => $request->username,
            'image' => $userImage,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect(route('user.index'))->with('msg','User Added Successfully');
    }

    public function editUser($id)
    {
        $title = "Edit User";
        $formLink = "user.update";
        $buttonName = "Update";

        $currentRole = UserRoles::where('id',$this->userRole)->first();
        $userRoles = UserRoles::where('level','>=',$currentRole->level)->orderBy('level','ASC')->get();
        $users = Admin::where('id',$id)->first();

        return view('admin.users.edit')->with(compact('title','formLink','buttonName','users','userRoles'));
    }

    public function updateUser(Request $request)
    {
        $this->validate(request(), [
            'role' => 'required',
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
        ]);

        $userId = $request->userId;

        if (isset($request->userImage))
        {
            $userImage = \App\HelperClass::UploadImage($request->userImage,'admins','public/uploads/admin_images/');
        }
        else
        {
            $userImage = $request->previousUserImage;
        }

        $users = Admin::find($userId);

        $users->update( [
            'role' => $request->role,
            'name' => $request->name,
            'username' => $request->username,
            'image' => $userImage,
            'email' => $request->email,
        ]);

        // $product = Product::create($request->all());

        return redirect(route('user.index'))->with('msg','User Updated Successfully');
    }

    public function password($id,$link = null)
    {
        $title = "Change Password";
        $formLink = "user.savePassword";
        $buttonName = "Update";
        $users = Admin::where('id',$id)->first();
        return view('admin.users.changePassword')->with(compact('title','formLink','link','buttonName','users'));
    }

    public function passwordChange(Request $request)
    {
        $this->validate(request(), [
            'password' => 'required',

        ]);
        $userId = $request->userId;

        $users = Admin::find($userId);

        $users->update( [
            'password' => bcrypt($request->password),
        ]);

        // $product = Product::create($request->all());

        return redirect(route('user.index'))->with('msg','Password Changed Successfully');
    }

    public function changeUserStatus(Request $request)
    {
        $userId = $request->userId;
        $status = $request->status;

        $userInfo = Admin::where('id',$userId)->first();

        $users = Admin::find($userId);

        if ($users->status == 0)
        {
            $users->update( [
                'status' => 1,
            ]);
        }
        else
        {
            $users->update( [
                'status' => 0,
            ]);
        }


    }

    public function deleteUser(Request $request)
    {
        Admin::where('id',$request->userId)->delete();
    }

    public function userProfile($userId,$link = null)
    {
    	$title = "User Profile";
        $user = Admin::select('admins.*','tbl_user_roles.name as userRoleName')
        	->join('tbl_user_roles','tbl_user_roles.id','=','admins.role')
            ->where('admins.id',$userId)
            ->first();

        // dd($user);

        return view('admin.users.profile')->with(compact('title','user','link'));
    }


    public function validation(Request $request)
    {
        $this->validate(request(), [
            'role' => 'required',
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);
    }
}
