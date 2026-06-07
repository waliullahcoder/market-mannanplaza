<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\SocialLinks;

class SocialLinksController extends Controller
{
    public function index()
    {
    	$title = "Social Link Management";

        $socialLinks = SocialLinks::orderBy('order_by')->get();

    	return view('admin.socialLink.index')->with(compact('title','socialLinks'));
    }

    public function add()
    {
    	$title = "Add Social Links";
    	$formLink = "socialLink.save";
    	$buttonName = "Save";

        $socialLinkOrderBy = SocialLinks::max('order_by');

        if (@$socialLinkOrderBy)
        {
            $orderBy = $socialLinkOrderBy+1;
        }
        else
        {
            $orderBy = 1;
        }

    	return view('admin.socialLink.add')->with(compact('title','formLink','buttonName','orderBy'));
    }

    public function save(Request $request)
    {
    	// dd($request->all());
        SocialLinks::create([
            'name' => $request->name,
            'icon' => $request->socialLinkIcon,
            'link' => $request->socialLink,
            'order_by' => $request->orderBy,
            'created_by' => $this->userId,
        ]);

        return redirect(route('socialLink.add'))->with('msg','Socila Link Added Successfully');
    }

    public function edit($socialId)
    {
        $title = "Edit Social Link";
        $formLink = "socialLink.update";
        $buttonName = "Update";

        $socialLink = SocialLinks::where('id',$socialId)->first();

        return view('admin.socialLink.edit')->with(compact('title','formLink','buttonName','socialLink'));
    }

    public function update(Request $request)
    {
    	$socialLink = SocialLinks::find($request->socialLinkId);

        $socialLink->update([
            'name' => $request->name,
            'icon' => $request->socialLinkIcon,
            'link' => $request->socialLink,
            'order_by' => $request->orderBy,
            'created_by' => $this->userId,
        ]);

        return redirect(route('socialLink.index'))->with('msg','Socila Link Updated Successfully');
    }

    public function delete(Request $request)
    {
        SocialLinks::where('id',$request->menuId)->delete();
    }

    public function status(Request $request)
    {
        $socialLink = SocialLinks::find($request->menuId);

        if ($socialLink->status == 1)
        {
            $socialLink->update( [               
                'status' => 0                
            ]);
        }
        else
        {
            $socialLink->update( [               
                'status' => 1                
            ]);
        }
    }
}
