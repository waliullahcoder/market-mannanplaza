<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Post;
use App\Page;

class PostController extends Controller
{
    public function index($pageId)
    {
    	$pageName = Page::where('id',$pageId)->first();

        $title = "All Posts ( ".$pageName->page_name." )";

        $posts = Post::where('page_id',$pageId)->orderBy('id','asc')->get();

        return view('admin.post.index')->with(compact('title','posts','pageId'));
    }

    public function add($pageId)
    {
    	$pageName = Page::where('id',$pageId)->first();

    	$title = "Add Post ( ".$pageName->page_name." )";
        $formLink = "post.save";
        $buttonName = "Save";

        return view('admin.post.add')->with(compact('title','formLink','buttonName','pageId'));
    }

    public function save(Request $request)
    {
    	// dd($request->all());

    	$this->validate(request(), [
    		'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    		'innerImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    	]);

    	if($request->image)
    	{
    		$width = $request->width;
    		$height = $request->height;
    		$image = \App\HelperClass::UploadImage($request->image,'tbl_posts','public/uploads/post_images/',@$width,@$height);
    	}

    	if($request->innerImage)
    	{
    		$width = $request->innerWidth;
    		$height = $request->innerHeight;
    		$innerImage = \App\HelperClass::UploadImage($request->innerImage,'tbl_posts','public/uploads/post_images/',@$width,@$height);
    	}

    	Post::create( [
    		'page_id' => $request->pageId,
    		'post_name' => $request->postName,
    		'title' => $request->title,
    		'inner_title' => $request->innerTitle,
    		'description' => $request->description,
    		'url_link' => $request->link,
    		'icon' => $request->icon,
    		'image' => @$image,
    		'width' => $request->width,
    		'height' => $request->height,
    		'inner_image' => @$innerImage,
    		'inner_width' => $request->innerWidth,
    		'inner_height' => $request->innerHeight,
    		'meta_title' => $request->metaTitle,
    		'meta_keyword' => $request->metaKeyword,
    		'meta_description' => $request->metaDescription,
    		'order_by' => $request->orderBy,
    		'created_by' => $this->userId,
    	]);

    	return redirect(route('post.index',$request->pageId))->with('msg','Post Successfuly Saved');
    }

    public function edit($postId)
    {
        $post = Post::where('id',$postId)->first();
        $page = Page::where('id',$post->page_id)->first();

        $title = "Edit Post ( ".$page->page_name." >>> ".$post->post_name." )";
        $formLink = "post.update";
        $buttonName = "Update";

        return view('admin.post.edit')->with(compact('title','formLink','buttonName','post'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

    	$this->validate(request(), [
    		'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    		'innerImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    	]);

    	if($request->image)
    	{
    		$width = $request->width;
    		$height = $request->height;
    		$image = \App\HelperClass::UploadImage($request->image,'tbl_posts','public/uploads/post_images/',@$width,@$height);
    	}
    	else
    	{
    		$width = $request->previousWidth;
    		$height = $request->previousHeight;
    		$image = $request->previousImage;
    	}

    	if($request->innerImage)
    	{
    		$innerWidth = $request->innerWidth;
    		$innerHeight = $request->innerHeight;
    		$innerImage = \App\HelperClass::UploadImage($request->innerImage,'tbl_posts','public/uploads/post_images/',@$innerWidth,@$innerHeight);
    	}
    	else
    	{
    		$innerWidth = $request->previousInnerWidth;
    		$innerHeight = $request->previousInnerHeight;
    		$innerImage = $request->previousInnerImage;
    	}

        $post = Post::find($request->postId);
        
        $post->update([
    		'page_id' => $request->pageId,
    		'post_name' => $request->postName,
    		'title' => $request->title,
    		'inner_title' => $request->innerTitle,
    		'description' => $request->description,
    		'url_link' => $request->link,
    		'icon' => $request->icon,
    		'image' => $image,
    		'width' => $width,
    		'height' => $height,
    		'inner_image' => $innerImage,
    		'inner_width' => $innerWidth,
    		'inner_height' => $innerHeight,
    		'meta_title' => $request->metaTitle,
    		'meta_keyword' => $request->metaKeyword,
    		'meta_description' => $request->metaDescription,
    		'order_by' => $request->orderBy,
    		'created_by' => $this->userId,
        ]);

        return redirect(route('post.index',$request->pageId))->with('msg','Post Updated Successfully');
    }

    public function delete(Request $request)
    {
        Post::where('id',$request->postId)->delete();
    }

    public function status(Request $request)
    {
        $post = Post::find($request->postId);

        if ($post->status == 1)
        {
            $post->update([               
                'status' => 0                
            ]);
        }
        else
        {
            $post->update([               
                'status' => 1                
            ]);
        }
    }
}
