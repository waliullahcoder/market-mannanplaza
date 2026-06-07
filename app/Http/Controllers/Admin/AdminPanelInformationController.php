<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\AdminPanelInformation;

class AdminPanelInformationController extends Controller
{
    public function index()
    {
    	$title = "Admin Panel Information";

    	$adminInformation = AdminPanelInformation::first();
        $adminInformationCount = AdminPanelInformation::count();

    	return view('admin.adminPanelInformation.index')->with(compact('title','adminInformation','adminInformationCount'));
    }

    public function add()
    {
    	$title = "Add Admin Information";
        $formLink = "adminPanelInformation.save";
        $buttonName = "Save";

    	return view('admin.adminPanelInformation.add')->with(compact('title','formLink','buttonName'));
    }

    public function save(Request $request)
    {
    	// dd($request->all());

        $this->validate(request(), [
            'siteLogo1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'siteLogo2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sitefavIcon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($request->siteLogo1)
        {
            $width = $request->siteLogo1Width;
            $height = $request->siteLogo1Height;
            $logoOne = \App\HelperClass::UploadImage($request->siteLogo1,'tbl_admin_panel_information','public/uploads/admin_logo/logo1/',@$width,@$height);
        }
        else
        {
            $logoOne = "";
        }

        if($request->siteLogo2)
        {
            $width = $request->siteLogo2Width;
            $height = $request->siteLogo2Height;
            $logoTwo = \App\HelperClass::UploadImage($request->siteLogo2,'tbl_admin_panel_information','public/uploads/admin_logo/logo2/',@$width,@$height);
        }
        else
        {
            $logoTwo = "";
        }

        if($request->sitefavIcon)
        {
            $width = $request->sitefavIconWidth;
            $height = $request->sitefavIconHeight;
            $favIcon = \App\HelperClass::UploadImage($request->sitefavIcon,'tbl_admin_panel_information','public/uploads/admin_logo/fav_icon/',@$width,@$height);
        }
        else
        {
            $favIcon = "";
        }

        AdminPanelInformation::create( [
            'website_name' => $request->siteName,
            'prefix_title' => $request->titlePrefix,
            'website_title' => $request->siteTitle,
            'developed_by' => $request->developedBy,
            'developer_website_link' => $request->developerWebsiteLink,
            'logo_one' => $logoOne,
            'logo_one_width' => $request->siteLogo1Width,
            'logo_one_height' => $request->siteLogo1Height,
            'logo_two' => $logoTwo,
            'logo_two_width' => $request->siteLogo2Width,
            'logo_two_height' => $request->siteLogo2Height,
            'fav_icon' => $favIcon,
            'fav_icon_width' => $request->sitefavIconWidth,
            'fav_icon_height' => $request->sitefavIconHeight,
            'created_by' => $this->userId,
        ]);

        return redirect(route('adminPanelInformation.index'))->with('msg','Admin Information Successfuly Saved');
    }

    public function edit($id)
    {
    	$title = "Edit Admin Information";
        $formLink = "adminPanelInformation.update";
        $buttonName = "Update";

    	$adminInformation = AdminPanelInformation::where('id',$id)->first();

    	return view('admin.adminPanelInformation.edit')->with(compact('title','formLink','buttonName','adminInformation'));
    }

    public function update(Request $request)
    {
    	// dd($request->all());
    	$websiteInformation = AdminPanelInformation::find($request->websiteInformationId);

        $this->validate(request(), [
            'siteLogo1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'siteLogo2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sitefavIcon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

       if($request->siteLogo1)
       {
            $siteLogo1Width = $request->siteLogo1Width;
            $siteLogo1Height = $request->siteLogo1Height;
            $logoOne = \App\HelperClass::UploadImage($request->siteLogo1,'tbl_admin_panel_information','public/uploads/admin_logo/logo1/',@$width,@$height);
        }
        else
        {
            $siteLogo1Width = $request->previousSiteLogo1Width;
            $siteLogo1Height = $request->previousSiteLogo1Height;
        	$logoOne = $request->previousSiteLogo1;
        }

       if($request->siteLogo2)
       {
            $siteLogo2Width = $request->siteLogo2Width;
            $siteLogo2Height = $request->siteLogo2Height;
            $logoTwo = \App\HelperClass::UploadImage($request->siteLogo2,'tbl_admin_panel_information','public/uploads/admin_logo/logo2/',@$width,@$height);
        }
        else
        {
            $siteLogo2Width = $request->previousSiteLogo2Width;
            $siteLogo2Height = $request->previousSiteLogo2Height;
        	$logoTwo = $request->previousSiteLogo2;
        }

        if($request->sitefavIcon)
        {
            $sitefavIconWidth = $request->sitefavIconWidth;
            $sitefavIconHeight = $request->sitefavIconHeight;
            $favIcon = \App\HelperClass::UploadImage($request->sitefavIcon,'tbl_admin_panel_information','public/uploads/admin_logo/fav_icon/',@$width,@$height);
        }
        else
        {
            $sitefavIconWidth = $request->previousSitefavIconWidth;
            $sitefavIconHeight = $request->previousSitefavIconHeight;
        	$favIcon = $request->previousSitefavIcon;
        }

        $websiteInformation->update([
            'website_name' => $request->siteName,
            'prefix_title' => $request->titlePrefix,
            'website_title' => $request->siteTitle,
            'developed_by' => $request->developedBy,
            'developer_website_link' => $request->developerWebsiteLink,
            'logo_one' => $logoOne,
            'logo_one_width' => $siteLogo1Width,
            'logo_one_height' => $siteLogo1Height,
            'logo_two' => $logoTwo,
            'logo_two_width' => $siteLogo2Width,
            'logo_two_height' => $siteLogo2Height,
            'fav_icon' => $favIcon,
            'fav_icon_width' => $sitefavIconWidth,
            'fav_icon_height' => $sitefavIconHeight,
            'updated_by' => $this->userId,
        ]);

        return redirect(route('adminPanelInformation.index'))->with('msg','Admin Information Successfuly Updated');
    }
}
