<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = "Web Site CMS Dashboard";
        // echo "Dew Hunt"; exit();
        return view('admin.index')->with(compact('title'));
        // return view('home');
    }


    public function message_md()
    {
        return view('admin.settings.message_md');
    }

    public function message_md_ajax(Request $request)
    {
        \App\HelperClass::_writeNammedFile($request->message, 'message_md.txt');

        return redirect(route('settings.message_md'))->with('message', 'updated successfully');
    }
}
