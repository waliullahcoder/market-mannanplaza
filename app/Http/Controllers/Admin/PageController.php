<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Page;
use App\Post;
use App\FrontEndMenu;

use DB;

class PageController extends Controller
{
    public function index()
    {
        $title = "Pages";

        $pages = Page::select('tbl_pages.*','tbl_frontend_menu.menu_name as menuName')
        	->leftJoin('tbl_frontend_menu','tbl_frontend_menu.id','=','tbl_pages.frontend_menu_id')
        	->orderBy('page_name','asc')
        	->get();

        return view('admin.page.index')->with(compact('title','pages'));
    }

    public function add()
    {
    	$title = "Add Page";
    	$formLink = "page.save";
    	$buttonName = "Save";

    	$frontendMenus = FrontEndMenu::orderBy('menu_name','asc')->get();

    	return view('admin.page.add')->with(compact('title','formLink','buttonName','frontendMenus'));
    }

    public function save(Request $request)
    {
    	// dd($request->all());

        Page::create([
            'frontend_menu_id' => $request->parentMenu,
            'page_name' => $request->pageName,
            'created_by' => $this->userId,
        ]);

        return redirect(route('page.index'))->with('msg','Page Added Successfully');
    }

    public function edit($pageId)
    {
    	$title = "Edit Page";
    	$formLink = "page.update";
    	$buttonName = "Update";

    	$frontendMenus = FrontEndMenu::orderBy('menu_name','asc')->get();

    	$page = Page::where('id',$pageId)->first();

    	return view('admin.page.edit')->with(compact('title','formLink','buttonName','frontendMenus','page'));
    }

    public function update(Request $request)
    {
    	// dd($request->all());

    	$page = Page::find($request->pageId);

        $page->update([
            'frontend_menu_id' => $request->parentMenu,
            'page_name' => $request->pageName,
            'updated_by' => $this->userId,
        ]);

        return redirect(route('page.index'))->with('msg','Page Updated Successfully');
    }

    public function delete(Request $request)
    {
        $postCount = Post::where('page_id',$request->pageId)->count();
        if ($postCount > 0)
        {        
            if($request->ajax())
            {
                return response()->json([
                    'postCounts'=>$postCount,
                ]);
            }
        }
        else
        {
            Page::where('id',$request->pageId)->delete();
        }
    }

    public function status(Request $request)
    {
        $page = Page::find($request->pageId);

        if ($page->status == 1)
        {
            $page->update( [               
                'status' => 0                
            ]);
        }
        else
        {
            $page->update( [               
                'status' => 1                
            ]);
        }
    }
}
