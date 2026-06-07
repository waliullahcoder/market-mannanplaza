<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\FloorSetup;

class FloorSetupController extends Controller
{
    public function index()
    {
    	$title = "Floor Setup";

    	$allFloors = FloorSetup::orderBy('name','asc')->get();

    	return view('admin.floorSetup.index')->with(compact('title','allFloors'));
    }

    public function add()
    {
    	$title = "Add Floor";
    	$formLink = "floorSetup.save";
    	$buttonName = "Save";

    	return view('admin.floorSetup.add')->with(compact('title','formLink','buttonName'));
    }

    public function save(Request $request)
    {
    	// dd($request->all());

        FloorSetup::create([
            'name' => $request->name,
            'code' => $request->code,
            'created_by' => $this->userId,
        ]);

        return redirect(route('floorSetup.index'))->with('msg','Floor Added Successfully');
    }

    public function edit($floorId)
    {
    	$title = "Edit Floor";
    	$formLink = "floorSetup.update";
    	$buttonName = "Update";

    	$floor = FloorSetup::where('id',$floorId)->first();

    	return view('admin.floorSetup.edit')->with(compact('title','formLink','buttonName','floor'));
    }

    public function update(Request $request)
    {
    	// dd($request->all());

    	$floor = FloorSetup::find($request->floorId);

        $floor->update([
            'name' => $request->name,
            'code' => $request->code,
            'updated_by' => $this->userId,
        ]);

        return redirect(route('floorSetup.index'))->with('msg','Floor Updated Successfully');
    }

    public function delete(Request $request)
    {
    	FloorSetup::where('id',$request->floorId)->delete();
    }

    public function status(Request $request)
    {
        $floor = FloorSetup::find($request->floorId);

        if ($floor->status == 1)
        {
            $floor->update( [
                'status' => 0
            ]);
        }
        else
        {
            $floor->update( [
                'status' => 1
            ]);
        }
    }
}
