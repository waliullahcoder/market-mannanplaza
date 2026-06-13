<?php

namespace App\Http\Controllers\Admin;

use App\UnitSetup;
use Carbon\Carbon;
use App\FloorSetup;
use App\SetupRates;
use App\SetupProject;
use App\EbillCollection;
use App\SubMeterBill;
use App\WbillCollection;
use App\PositionInformation;
use App\ServiceChargeCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BanglaLinkPrepareController extends Controller
{
  
  
     public function index()
    {
        $title = 'Sub Meter Bill List';
        $addLink = 'sub-meter-bill.add';
        $bills = SubMeterBill::latest()->get();

        return view('admin.prepare.banglalink.index', compact('title', 'addLink', 'bills'));
    }

    public function add()
    {
        $title = 'Add Sub Meter Bill';
        $formLink = 'sub-meter-bill.store';

        $lastBill = SubMeterBill::latest('id')->first();
        $clients = PositionInformation::get();
        $serial_no = $lastBill ? 'BILL-' . str_pad($lastBill->id + 1, 5, '0', STR_PAD_LEFT) : 'BILL-00001';

        return view('admin.prepare.banglalink.add', compact('title', 'formLink', 'serial_no','clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'consumer_name' => 'required',
            'present_peak' => 'nullable|numeric',
            'previous_peak' => 'nullable|numeric',
            'present_off_peak' => 'nullable|numeric',
            'previous_off_peak' => 'nullable|numeric',
        ]);

        SubMeterBill::create($request->all());

        return redirect()
            ->route('banglalink.index')
            ->with('success', 'Sub Meter Bill Created Successfully');
    }

    public function edit($id)
    {
        $title = 'Edit Sub Meter Bill';
        $formLink = 'sub-meter-bill.update';
        $bill = SubMeterBill::findOrFail($id);
        $lastBill = SubMeterBill::latest('id')->first();
        $clients = PositionInformation::get();
        $serial_no = $lastBill ? 'BILL-' . str_pad($lastBill->id + 1, 5, '0', STR_PAD_LEFT) : 'BILL-00001';
        return view('admin.prepare.banglalink.edit', compact('title', 'formLink', 'bill','clients','lastBill'));
    }
   

    public function update(Request $request, $id)
    {
        $request->validate([
            'consumer_name' => 'required',
            'present_peak' => 'nullable|numeric',
            'previous_peak' => 'nullable|numeric',
            'present_off_peak' => 'nullable|numeric',
            'previous_off_peak' => 'nullable|numeric',
        ]);

        $bill = SubMeterBill::findOrFail($id);
        $bill->update($request->all());

        return redirect()
            ->route('banglalink.index')
            ->with('success', 'Sub Meter Bill Updated Successfully');
    }

    public function delete($id)
    {
        $bill = SubMeterBill::findOrFail($id);
        $bill->delete();

        return redirect()
            ->route('sub-meter-bill.index')
            ->with('success', 'Sub Meter Bill Deleted Successfully');
    }

    
}
