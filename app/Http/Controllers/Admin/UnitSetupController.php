<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\UnitSetup;

class UnitSetupController extends Controller
{
    public function index()
    {
    	$title = "Unit Setup";

    	$allUnits = UnitSetup::orderBy('name','asc')->get();

    	return view('admin.unitSetup.index')->with(compact('title','allUnits'));
    }

    public function add()
    {
    	$title = "Add Unit";
    	$formLink = "unitSetup.save";
    	$buttonName = "Save";

    	return view('admin.unitSetup.add')->with(compact('title','formLink','buttonName'));
    }

    public function save(Request $request)
    {
    	// dd($request->all());

        UnitSetup::create([
            'name' => $request->name,
            'code' => $request->code,
            'created_by' => $this->userId,
        ]);

        return redirect(route('unitSetup.index'))->with('msg','Unit Added Successfully');
    }

    public function edit($unitId)
    {
    	$title = "Edit Unit";
    	$formLink = "unitSetup.update";
    	$buttonName = "Update";

    	$unit = UnitSetup::where('id',$unitId)->first();

    	return view('admin.unitSetup.edit')->with(compact('title','formLink','buttonName','unit'));
    }

    public function update(Request $request)
    {
    	// dd($request->all());

    	$unit = UnitSetup::find($request->unitId);

        $unit->update([
            'name' => $request->name,
            'code' => $request->code,
            'updated_by' => $this->userId,
        ]);

        return redirect(route('unitSetup.index'))->with('msg','Unit Updated Successfully');
    }

    public function delete(Request $request)
    {
    	UnitSetup::where('id',$request->unitId)->delete();
    }

    public function status(Request $request)
    {
        $unit = UnitSetup::find($request->unitId);

        if ($unit->status == 1)
        {
            $unit->update( [               
                'status' => 0                
            ]);
        }
        else
        {
            $unit->update( [               
                'status' => 1                
            ]);
        }
    }
}
