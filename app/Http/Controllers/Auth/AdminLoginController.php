<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Admin;
use Hash;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('adminLogout');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $users = Admin::where('email',$request->email)->first();

        //validate data
        $this->validate($request, [
            'email'=>'required|email|exists:admins,email',
            'password'=>'required|min:6',
        ]);

        if ($users->status == 0)
        {
        	$message = "You Are Not Active For Login.";
            return redirect(route('admin.login'))->with('msg',$message)->withInput();
        }

        // if (!password_verify($request->password, $users->password))
        // {
        //     echo $message = "password not matched";
        //     return redirect(route('admin.login'))->with('passwordMessage',$message)->withInput();
        // }

        //attemt to log the admin in
        if(Auth::guard('admin')->attempt(['email'=> $request->email, 'password'=> $request->password], $request->remember))
        {
            //if successful, then redirect to their intended location
            return redirect()->intended(route('admin.index'));
        }
        else
        {
            $message = "Password Not Matched.";
            return redirect(route('admin.login'))->with('passwordMessage',$message)->withInput();
        }

        //if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function adminLogout(Request $request)
    {
        $this->guard()->logout();

        return redirect(route('admin.login'));
    }
}
