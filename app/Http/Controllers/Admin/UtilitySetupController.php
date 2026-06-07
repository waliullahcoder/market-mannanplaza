<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\UtilitySetup;

class UtilitySetupController extends Controller
{
    public function index()
    {
    	$title = "Utility Setup";

    	$allUtilities = UtilitySetup::orderBy('name','asc')->get();

    	return view('admin.utilitySetup.index')->with(compact('title','allUtilities'));
    }

    public function add()
    {
    	$title = "Add Utility";
    	$formLink = "utilitySetup.save";
    	$buttonName = "Save";

    	return view('admin.utilitySetup.add')->with(compact('title','formLink','buttonName'));
    }

    public function save(Request $request)
    {
    	// dd($request->all());

        UtilitySetup::create([
            'name' => $request->name,
            'code' => $request->code,
            'created_by' => $this->userId,
        ]);

        return redirect(route('utilitySetup.index'))->with('msg','Utility Added Successfully');
    }

    public function edit($utilityId)
    {
    	$title = "Edit Utility";
    	$formLink = "utilitySetup.update";
    	$buttonName = "Update";

    	$utility = UtilitySetup::where('id',$utilityId)->first();

    	return view('admin.utilitySetup.edit')->with(compact('title','formLink','buttonName','utility'));
    }

    public function update(Request $request)
    {
    	// dd($request->all());

    	$utility = UtilitySetup::find($request->utilityId);

        $utility->update([
            'name' => $request->name,
            'code' => $request->code,
            'updated_by' => $this->userId,
        ]);

        return redirect(route('utilitySetup.index'))->with('msg','Utility Updated Successfully');
    }

    public function delete(Request $request)
    {
    	UtilitySetup::where('id',$request->utilityId)->delete();
    }

    public function status(Request $request)
    {
        $utility = UtilitySetup::find($request->utilityId);

        if ($utility->status == 1)
        {
            $utility->update( [               
                'status' => 0                
            ]);
        }
        else
        {
            $utility->update( [               
                'status' => 1                
            ]);
        }
    }
}
