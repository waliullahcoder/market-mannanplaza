<?php

namespace App\Http\Controllers\Admin;

use App\UnitSetup;
use App\FloorSetup;
use App\HelperClass;
use App\TenantStamps;
use App\RentCollection;
use App\EbillCollection;
use App\PositionInformation;
use Illuminate\Http\Request;
use App\ServiceChargeCollection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PositionInformationController extends Controller
{
    public function index()
    {
        $title = "Position Informations";

        $positions = PositionInformation::select(['id', 'Code', 'Name', 'Mobile', 'Unit', 'Floor', 'PositionNo', 'status'])
        ->orderBy('Unit')
        ->orderBy('Floor')
        ->orderBy('PositionNo')
        ->get();

        return view('admin.position.index', compact(['title', 'positions']));
    }

    public function stampIndex($tenantId)
    {

        $tenant = PositionInformation::findOrFail($tenantId);

        $title = "Tenant Stamps for - " . $tenant->Name . " ( " . $tenant->Code . " )";

        $stamps = TenantStamps::where('tenant_id', $tenantId)->get();

        return view('admin.tenant_stamps.index', compact(['title', 'stamps', 'tenantId']));
    }

    public function add()
    {
        $title = "Position Informations";
        $formLink = 'positionInformation.save';
        $buttonName = "Save";

        $data = (object)[
            'floors' => FloorSetup::select(['name'])->get(),
            'units' => UnitSetup::select(['name'])->get(),
        ];

        return view('admin.position.add', compact(['title', 'formLink', 'buttonName', 'data']));
    }


    public function save(Request $request)
    {
        $request->validate([
            "Code" => 'required',
            "Name" => 'required',
        ]);


        if (isset($request->tenant_image)) {
            $tenant_image = \App\HelperClass::UploadImage($request->tenant_image, 'admins', 'public/uploads/tenant/image/');
        } else {
            $tenant_image = "";
        }

        // dd($tenant_image);

        // if($request->EntryReason == "Rent"){
        //     $Agg0ne = $request->PositionSize * $request->RentRate;
        // }else{
        //     $Agg0ne = $request->Agg0ne;
        // }

        $Agg0ne = $request->Agg0ne;
        $data = [
            "Code" => $request->Code,
            "Name" => $request->Name,
            "FName" => $request->FName,
            "MName" => $request->MName,
            "SName" => $request->SName,
            "Mobile" => $request->Mobile,
            "NationalID" => $request->NationalID,
            "PassportNo" => $request->PassportNo,
            "EntryReson" => $request->EntryReason,
            "Floor" => $request->Floor,
            "Unit" => $request->Unit,
            'address' => $request->address,
            "Project" => "Kassaf Shopping Center",
            "IsActive" => "Yes",
            "EntryBy" => Auth::user()->name,
            "PositionNo" => $request->PositionNo,
            "PositionSize" => $request->PositionSize,
            "ebill_meter_no" => $request->ebillMeterno,
            "wbill_meter_no" => $request->wbillMeterno,
            "tenant_image" => $tenant_image,
            "EndDate" => date('Y-m-d h:i:s', strtotime($request->EndDate)),
            "DepositeAmount" => $request->DepositeAmount,
            "LastSalesAmount" => $request->LastSalesAmount,
            "RentRate" => $request->RentRate,
            "Agg0ne" => $Agg0ne,
            "AggTwo" => $request->AggTwo,
            "incrRate" => $request->incrRate,
            "MonthlyDeduct" => $request->MonthlyDeduct,
        ];

        PositionInformation::create($data);
        return redirect(route('positionInformation.index'))->with('msg', 'Position created Successfully');
    }


    public function stampAdd($tenantId)
    {
        $title = "Position Informations Stamp";
        $formLink = 'positionInformation.save.stamps';
        $buttonName = "Save";
        $goBackLink = route('positionInformation.index.stamp', $tenantId);

        return view('admin.tenant_stamps.add', compact(['title', 'formLink', 'buttonName', 'goBackLink', 'tenantId']));
    }

    public function stampSave(Request $request)
    {

        if (isset($request->stamp_image)) {
            $stamp_image = \App\HelperClass::UploadImage($request->stamp_image, 'admins', 'public/uploads/tenant/image/');
        } else {
            $stamp_image = "";
        }

        TenantStamps::create([
            'tenant_id' => $request->tenant_id,
            'stamp_no' => $request->stamp_no,
            'stamp_image' => $stamp_image,
        ]);


        return redirect(route('positionInformation.index.stamp', $request->tenant_id))->with('msg', 'Stamp created Successfully');

    }


    public function view(PositionInformation $position)
    {
        $title = "Position Information";
        $formLink = 'positionInformation.update';
        $buttonName = "Update";

        $data = (object)[
            'position' => $position,
            'floors' => FloorSetup::select(['name'])->get(),
            'units' => UnitSetup::select(['name'])->get(),
        ];

        // dd($data->position);

        return view('admin.position.view', compact(['title', 'formLink', 'buttonName', 'data']));
    }

    public function edit(PositionInformation $position)
    {
        $title = "Position Information Update";
        $formLink = 'positionInformation.update';
        $buttonName = "Update";

        $data = (object)[
            'position' => $position,
            'floors' => FloorSetup::select(['name'])->get(),
            'units' => UnitSetup::select(['name'])->get(),
        ];

        return view('admin.position.edit', compact(['title', 'formLink', 'buttonName', 'data']));
    }

    public function stampEdit($stampId)
    {
        $title = "Stamp Information Update";
        $formLink = 'positionInformation.update.stamp';
        $buttonName = "Update";

        $stamp = TenantStamps::findOrFail($stampId);

        return view('admin.tenant_stamps.edit', compact(['title', 'formLink', 'buttonName', 'stamp']));
    }

    public function stampUpdate(Request $request)
    {

        $stamp = TenantStamps::findOrFail($request->stamp_id);

        if (isset($request->stamp_image)) {
            $stamp_image = \App\HelperClass::UploadImage($request->stamp_image, 'admins', 'public/uploads/tenant/image/');
        } else {
            $stamp_image = $request->old_stamp_image;
        }

        $stamp->update([
            'stamp_no' => $request->stamp_no,
            'stamp_image' => $stamp_image,
        ]);


        return redirect(route('positionInformation.index.stamp', $request->tenant_id))->with('msg', 'Stamp created Successfully');

    }

    public function update(Request $request)
    {
        $request->validate([
            "id" => 'required',
            "Code" => 'required',
            "Name" => 'required',
        ]);

        $check = PositionInformation::whereNotIn('id', [$request->id])->where('Code', $request->Code)->first();
        if($check){
            return redirect()->back()->withErrors('Client Code Already Exists!');
        }


        if (isset($request->tenant_image)) {
            $tenant_image = \App\HelperClass::UploadImage($request->tenant_image, 'admins', 'public/uploads/tenant/image/');
        } else {
            $tenant_image = $request->previousUserImage;
        }


        // if($request->EntryReason == "Rent"){
        //     $Agg0ne = $request->PositionSize * $request->RentRate;
        // }else{
        //     $Agg0ne = $request->Agg0ne;
        // }

        $Agg0ne = $request->Agg0ne;


        $data = [
            "Code" => $request->Code,
            "Name" => $request->Name,
            "FName" => $request->FName,
            "MName" => $request->MName,
            "SName" => $request->SName,
            "Mobile" => $request->Mobile,
            "NationalID" => $request->NationalID,
            'address' => $request->address,
            "PassportNo" => $request->PassportNo,
            "EntryReson" => $request->EntryReason,
            "Floor" => $request->Floor,
            "Unit" => $request->Unit,
            "PositionNo" => $request->PositionNo,
            "PositionSize" => $request->PositionSize,
            "ebill_meter_no" => $request->ebillMeterno,
            "wbill_meter_no" => $request->wbillMeterno,
            "tenant_image" => $tenant_image,
            "EndDate" => date('Y-m-d h:i:s', strtotime($request->EndDate)),
            "DepositeAmount" => $request->DepositeAmount,
            "LastSalesAmount" => $request->LastSalesAmount,
            "RentRate" => $request->RentRate,
            "Agg0ne" => $Agg0ne,
            "AggTwo" => $request->AggTwo,
            "incrRate" => $request->incrRate,
            "MonthlyDeduct" => $request->MonthlyDeduct,
        ];

        $position = PositionInformation::findOrFail($request->id);

        $position->update($data);

        return redirect(route('positionInformation.index'))->with('msg', 'Position Updated Successfully');
    }

    public function delete(Request $request)
    {

        $client = PositionInformation::findOrFail($request->position);

        $rentDataCount = RentCollection::where('Client_Code', $client->Code)->count();
        if($rentDataCount){
            return [
                'status' => false,
            ];
        }


        $ebillDataCount = EbillCollection::where('Client_Code', $client->Code)->count();
        if($ebillDataCount){
            return [
                'status' => false,
            ];
        }

        $sbillDataCount = ServiceChargeCollection::where('Client_Code', $client->Code)->count();
        if($sbillDataCount){
            return [
                'status' => false,
            ];
        }

        PositionInformation::findOrFail($request->position)->delete();
        return [
            'status' => true,
        ];

    }

    public function stampDelete(Request $request)
    {
        TenantStamps::findOrFail($request->stamp)->delete();
    }


    public function status(Request $request)
    {
        $position = PositionInformation::findOrFail($request->position);
        $position->toggleStatus();
    }
}
