<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Sliders;

class SlidersController extends Controller
{
    public function index()
    {
    	$title = "Slider Images Management";

    	$sliders = Sliders::orderBy('id','desc')->get();

    	// dd($sliders);

    	return view('admin.sliders.index')->with(compact('title','sliders'));
    }

    public function add()
    {
    	$title = "Add Slider Image";
        $formLink = "sliders.save";
        $buttonName = "Save";

    	return view('admin.sliders.add')->with(compact('title','formLink','buttonName'));
    }

    public function save(Request $request)
    {
    	// dd($request->all());

    	$this->validate(request(), [
    		'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    	]);

    	if($request->image)
    	{
    		$width = $request->width;
    		$height = $request->height;
    		$image = \App\HelperClass::UploadImage($request->image,'tbl_sliders','public/uploads/slider_image/',@$width,@$height);
    	}

    	Sliders::create( [
    		'first_title' => $request->firstTitle,
    		'second_title' => $request->secondTitle,
    		'third_title' => $request->thirdTitle,
    		'description' => $request->description,
    		'image' => $image,
    		'width' => $request->width,
    		'height' => $request->height,
    		'link' => $request->link,
    		'meta_title' => $request->metaTitle,
    		'meta_keyword' => $request->metaKeyword,
    		'meta_description' => $request->metaDescription,
    		'order_by' => $request->orderBy,
    		'created_by' => $this->userId,
    	]);

    	return redirect(route('sliders.index'))->with('msg','Slider Added Successfuly Saved');
    }

    public function edit($sliderId)
    {
    	$title = "Edit Slider Image";
        $formLink = "sliders.update";
        $buttonName = "Update";

        $slider = Sliders::where('id',$sliderId)->first();

    	return view('admin.sliders.edit')->with(compact('title','formLink','buttonName','slider'));
    }

    public function update(Request $request)
    {
    	// dd($request->all());

    	$slider = Sliders::find($request->sliderId);

    	$this->validate(request(), [
    		'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    	]);

    	if($request->image)
    	{
    		$width = $request->width;
    		$height = $request->height;
    		$image = \App\HelperClass::UploadImage($request->image,'tbl_sliders','public/uploads/slider_image/',@$width,@$height);
    	}
    	else
    	{
    		$image = $request->previousImage;
            $width = $request->previousWidth;
            $height = $request->previousHeight;
    	}

    	$slider->update( [
    		'first_title' => $request->firstTitle,
    		'second_title' => $request->secondTitle,
    		'third_title' => $request->thirdTitle,
    		'description' => $request->description,
    		'image' => $image,
    		'width' => $width,
    		'height' => $height,
    		'link' => $request->link,
    		'meta_title' => $request->metaTitle,
    		'meta_keyword' => $request->metaKeyword,
    		'meta_description' => $request->metaDescription,
    		'order_by' => $request->orderBy,
    		'created_by' => $this->userId,
    	]);

    	return redirect(route('sliders.index'))->with('msg','Slider Added Successfuly Saved');
    }

    public function delete(Request $request)
    {
        Sliders::where('id',$request->sliderId)->delete();
    }

    public function status(Request $request)
    {
        $Slider = Sliders::find($request->sliderId);

        if ($Slider->status == 1)
        {
            $Slider->update( [               
                'status' => 0                
            ]);
        }
        else
        {
            $Slider->update( [               
                'status' => 1                
            ]);
        }
    }
}
