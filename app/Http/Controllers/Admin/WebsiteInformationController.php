<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\WebsiteInformation;

class WebsiteInformationController extends Controller
{
    public function index()
    {
        $title = "Website Information";

        $websiteInformation = WebsiteInformation::first();
        $websiteInformationCount = WebsiteInformation::count();

        return view('admin.websiteInformation.index')->with(compact('title','websiteInformation','websiteInformationCount'));
    }

    public function add()
    {
        $title = "Add Website Information";
        $formLink = "websiteInformation.save";
        $buttonName = "Save";

        return view('admin.websiteInformation.add')->with(compact('title','formLink','buttonName'));
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
            $width = '195';
            $height = '55';
            $logoOne = \App\HelperClass::UploadImage($request->siteLogo1,'tbl_website_information','public/uploads/site_logo/logo1/',@$width,@$height);
        }

       if($request->siteLogo2)
       {
            $width = '273';
            $height = '97';
            $logoTwo = \App\HelperClass::UploadImage($request->siteLogo2,'tbl_website_information','public/uploads/site_logo/logo2/',@$width,@$height);
        }

        if($request->sitefavIcon)
        {
            $favIcon = \App\HelperClass::UploadImage($request->sitefavIcon,'tbl_website_information','public/uploads/site_logo/fav_icon/');
        }

        WebsiteInformation::create( [
            'website_name' => $request->siteName,
            'prefix_title' => $request->titlePrefix,
            'website_title' => $request->siteTitle,
            'website_link' => $request->websiteLink,
            'developed_by' => $request->developedBy,
            'developer_website_link' => $request->developerWebsiteLink,
            'phone_one' => $request->phoneNumberOne,
            'phone_two' => $request->phoneNumberTwo,
            'phone_three' => $request->phoneNumberThree,
            'logo_one' => $logoOne,
            'logo_two' => $logoTwo,
            'fav_icon' => $favIcon,
            'meta_title' => $request->metaTitle,
            'meta_keyword' => $request->metaKeyword,
            'meta_description' => $request->metaDescription,
            'created_by' => $this->userId,
        ]);

        return redirect(route('websiteInformation.index'))->with('msg','Website Information Successfuly Saved');
    }

    public function edit($id)
    {
        $title = "Edit Website Information";
        $formLink = "websiteInformation.update";
        $buttonName = "Update";
        $websiteInformation = WebsiteInformation::where('id',$id)->first();

        return view('admin.websiteInformation.edit')->with(compact('title','formLink','buttonName','websiteInformation'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $websiteInformation = WebsiteInformation::find($request->websiteInformationId);

        $this->validate(request(), [
            'siteLogo1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'siteLogo2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',          
            'sitefavIcon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'                    
        ]);

        if($request->siteLogo1)
        {
            $width = '195';
            $height = '55';
            $logoOne = \App\HelperClass::UploadImage($request->siteLogo1,'tbl_website_information','public/uploads/site_logo/logo1/',@$width,@$height);
        }
        else
        {
            $logoOne = $request->previousSiteLogo1;
        }

        if($request->siteLogo2)
        {
            $width = '273';
            $height = '97';
            $logoTwo = \App\HelperClass::UploadImage($request->siteLogo2,'tbl_website_information','public/uploads/site_logo/logo2/',@$width,@$height);
        }
        else
        {
            $logoTwo = $request->previousSiteLogo2;
        }

        if($request->sitefavIcon)
        {
            $favIcon = \App\HelperClass::UploadImage($request->sitefavIcon,'tbl_website_information','public/uploads/site_logo/fav_icon/');
        }
        else
        {
            $favIcon = $request->previousSitefavIcon;
        }

        $websiteInformation->update([
            'website_name' => $request->siteName,
            'prefix_title' => $request->titlePrefix,
            'website_title' => $request->siteTitle,
            'website_link' => $request->websiteLink,
            'developed_by' => $request->developedBy,
            'developer_website_link' => $request->developerWebsiteLink,
            'phone_one' => $request->phoneNumberOne,
            'phone_two' => $request->phoneNumberTwo,
            'phone_three' => $request->phoneNumberThree,
            'logo_one' => $logoOne,
            'logo_two' => $logoTwo,
            'fav_icon' => $favIcon,
            'meta_title' => $request->metaTitle,
            'meta_keyword' => $request->metaKeyword,
            'meta_description' => $request->metaDescription,
            'created_by' => $this->userId,
        ]);

        return redirect(route('websiteInformation.index'))->with('msg','Website Information Successfuly Updated');
    }
}
