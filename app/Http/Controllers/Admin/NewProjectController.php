<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewProjectController extends Controller
{
    public function index()
    {
    	$title = "New Project";

    	// $allFloors = FloorSetup::orderBy('name','asc')->get();

    	return view('admin.newProject.index')->with(compact('title'));
    }

    public function add()
    {
    	$title = "New Project";
    	$formLink = "newProject.save";
    	$buttonName = "Save";

    	return view('admin.newProject.add')->with(compact('title','formLink','buttonName'));
    }

    public function save(Request $request)
    {
    	dd($request->all());

        FloorSetup::create([
            'name' => $request->name,
            'code' => $request->code,
            'created_by' => $this->userId,
        ]);

        return redirect(route('floorSetup.index'))->with('msg','Floor Added Successfully');
    }

    public function findProductPrice(Request $request)
    {
    	$amount = $request->amount;
    	$discount = $request->discount;

    	$discountValue = ($discount * 100)/($amount + $discount);

    	$productPrice = $amount - $discountValue;        
        
        if($request->ajax())
        {
            return response()->json([
                'discountValue'=>$discountValue,
                'productPrice'=>$productPrice,
            ]);
        }
    }
}
