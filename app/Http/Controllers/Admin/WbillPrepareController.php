<?php

namespace App\Http\Controllers\Admin;

use App\UnitSetup;
use Carbon\Carbon;
use App\FloorSetup;
use App\SetupRates;
use App\WbillCollection;
use App\ServiceChargeCollection;
use App\PositionInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WbillPrepareController extends Controller
{

    public function generateSerialNo()
    {
        $curr_serial_no = WbillCollection::orderBy('id', 'desc')->select(['SerialNo'])->pluck('SerialNo')->first();


        if ($curr_serial_no) {
            $new_serial_no = $curr_serial_no + 1;
        } else {
            $new_serial_no = "100001";
        }

        return $new_serial_no;
    }

    public function index()
    {
        // $data =  \App\EbillCollection::where('billing_month', '2025-08-01')->where('LossUnit', 10)->get();
        // foreach($data as $item){
        //     $amount = ($item->UsesUnit + 7) * 22;
        //     $item->update([
        //         'lossUnit' => 7,
        //         'Amount' => $amount >= 700 ? $amount : 700
        //     ]);
        // }
        $title = "Water Bill List";
        // $printFormLink  = "tenant.report.print";

        $data = (object)[
            'wbill_list' => WbillCollection::groupBy('SerialNo')->with(['position_holder'])->get(),
        ];

        return view('admin.prepare.wbill.index', compact(['title', 'data']));
    }

    public function add(Request $request)
    {

        $bills = [];
        $rate = 0;

        $sunit = 0;
        $sfloor = 0;
        $CMonth = 0;
        $CYear = 0;
        $PaidDate = 0;

        if ($request->searched) {
            $sunit = $request->unit;
            $sfloor = $request->floor;
            $CMonth = $request->CMonth;
            $CYear = $request->CYear;
            $PaidDate = $request->PaidDate;


            if ($request->search_code) {
                $tenants =  PositionInformation::where('status', 1)->where('Code', $request->search_code)->get();
            } else {
                $tenants = PositionInformation::where('status', 1)->where('Unit', $sunit)->where('Floor', $sfloor)->get();
            }

            foreach ($tenants as $tenant) {
                $bills[$tenant->ID] = $tenant;
                $bills[$tenant->ID]->last_unit = WbillCollection::where('Client_Code', $tenant->Code)->orderBy('id', 'desc')->first();
            }

            $rate = SetupRates::where('type', 'wbill')->first()->rate;
        }

        $bills = (object)$bills;
        $bills = json_encode($bills);

        // dd($rate);

        $title = "Add Water Bill";
        $searchFormLink = "wbill.prepare.search";
        $printFormLink  = "tenant.report.print";

        $data = (object)[
            'floors' => FloorSetup::select(['name'])->get(),
            'units' => UnitSetup::select(['name'])->get(),
            'serial_no' =>  $this->generateSerialNo(),
            'current_time' => Carbon::now(),
        ];

        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        return view('admin.prepare.wbill.add', compact(['tenants', 'PaidDate', 'CYear', 'CMonth', 'title', 'searchFormLink', 'printFormLink', 'data', 'bills', 'rate', 'sunit', 'sfloor']));
    }


    public function addindividual()
    {
        $title = "Add Water Bill Individual";
        $formLink = "wbill.prepare.save.individual";
        $buttonName = "Wbill Posting";
        $serial_no = $this->generateSerialNo();
        // $rents = RentCollection::all();

        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        $rate = SetupRates::where('type', 'wbill')->first()->rate;
        return view('admin.prepare.wbill.add_individual', compact(['tenants', 'rate','title', 'formLink', 'buttonName', 'serial_no']));
    }

    public function save(Request $request)
    {
        $serial_no = $this->generateSerialNo();

        foreach ($request->codes as $code) {

            $position_holder = PositionInformation::where('Code', $code)->first();

            $check = WbillCollection::where('Client_Code', $position_holder->Code)->where('CMonth', $request->CMonth)->where('CYear', $request->CYear)->first();

            if ($check == null) {
                WbillCollection::create([
                    'Client_Code' => $code,
                    'CMonth' => $request->CMonth,
                    'CYear' => $request->CYear,
                    'billing_month' => date('Y-m-d', strtotime('01-' . $request->CMonth . '-' . $request->CYear)),
                    'PreviousUnit' => $request->prev_unit[$code],
                    'LastUnit' => $request->last_unit[$code],
                    'UsesUnit' => $request->uUnit[$code],
                    'SerialNo' => $serial_no,
                    'Amount' => $request->bill[$code],
                    'PaidDate' => date('Y-m-d h:i:s', strtotime($request->PaidDate)),
                    'PositionNo' => $position_holder->PositionNo,
                    'Project_ID' => 1,
                    'CreateBy' => Auth::user()->name,
                ]);
            }
        }

        return redirect(route('wbill.prepare.index'));
    }

    public function saveIndividual(Request $request)
    {
        $client = PositionInformation::where('Code',  $request->client_code)->first();
        // $last_bill_dates = WbillCollection::orderBy('id', 'desc')->select(['CMonth', 'CYear'])->first();

        $exists = WbillCollection::where('CYear', $request->CYear)
            ->where('CMonth', $request->CMonth)
            ->where('Client_Code', $request->client_code)
            ->first();

        if ($exists) {
            return back()->with('error', 'Already Added');
        }

        WbillCollection::create([
            'Client_Code' => $request->client_code,
            'CMonth' =>  $request->CMonth,
            'CYear' =>  $request->CYear,
            'Amount' => $request->amount,
            'billing_month' => date('Y-m-d', strtotime('01-' . $request->CMonth . '-' . $request->CYear)),
            'PreviousUnit' => $request->old_reading,
            'LastUnit' => $request->new_reading,
            'UsesUnit' => $request->new_reading - $request->old_reading,
            'SerialNo' =>  $this->generateSerialNo(),
            'PaidDate' => date('Y-m-d h:i:s', strtotime($request->paid_date)),
            'PositionNo' =>  $client->PositionNo,
            'Project_ID' => 1,
            'CreateBy' => Auth::user()->name,
        ]);


        return redirect(route('wbill.prepare.index'))->with('msg', 'Successfully Added');
    }

    public function updateIndividual(Request $request, $id)
    {
        $wbill = WbillCollection::findOrFail($id);

        $exists = WbillCollection::where('id', '!=', $id)
            ->where('CYear', $request->CYear)
            ->where('CMonth', $request->CMonth)
            ->where('Client_Code', $wbill->Client_Code)
            ->first();

        if ($exists) {
            return back()->with('error', 'Already Added');
        }

        if ($request->old_reading > $request->new_reading) {
            return back()->with('error', 'Last unit must be greater than or equal previous unit!');
        }

        $wbill->update([
            'CMonth'         => $request->CMonth,
            'CYear'          => $request->CYear,
            'Amount'         => $request->amount,
            'billing_month'  => date('Y-m-d', strtotime('01-' . $request->CMonth . '-' . $request->CYear)),
            'PreviousUnit'   => $request->old_reading,
            'LastUnit'       => $request->new_reading,
            'UsesUnit'       => $request->new_reading - $request->old_reading,
            'PaidDate'       => date('Y-m-d H:i:s', strtotime($request->paid_date)),
            'UpdateBy'       => Auth::user()->name,
        ]);

        return back()->with('msg', 'Successfully Updated');
    }

    public function view($id)
    {
        $title = "View Water Bill";
        $searchFormLink = "wbill.prepare.search";
        $printFormLink  = "tenant.report.print";

        $data = (object)[
            'bills' => WbillCollection::where('SerialNo', $id)->get(),
        ];

        return view('admin.prepare.wbill.view', compact(['title', 'searchFormLink', 'printFormLink', 'data']));
    }

    public function delete(Request $request)
    {
        WbillCollection::where('serialNo', $request->wbill)->delete();
		ServiceChargeCollection::where('serialNo', $request->wbill)->delete();
    }

    public function getWbillInfo(Request $request)
    {
        if ($request->ajax()) {

            // fetch old reading
            $last_unit = WbillCollection::where('Client_Code', $request->client_code)->orderBy('id', 'desc')->first()->LastUnit;
            if ($last_unit == null) {
                $last_unit = $last_unit['LastUnit'] = 0;
            }

            // get ebill rates
            $rate = SetupRates::where('type', 'wbill')->first()->rate;

            $data = [
                'last_unit' => $last_unit,
                'rate' => $rate,
            ];

            return $data;
        }
    }
}
