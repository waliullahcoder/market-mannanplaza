<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\ServiceChargeCollection;
use App\Http\Controllers\Controller;
use App\PositionInformation;
use App\UtilitySetup;
use Illuminate\Support\Facades\Auth;

class ServiceChargePrepareController extends Controller
{

    public function generateSerialNo()
    {
        $curr_serial_no = ServiceChargeCollection::orderBy('id', 'desc')->select(['SerialNo'])->pluck('SerialNo')->first();
        $new_serial_no = $curr_serial_no + 1;

        return $new_serial_no;
    }

    public function index()
    {
        $title = "Service Charge List";

        $data = (object)[
            'wbill_list' => ServiceChargeCollection::groupBy('SerialNo')->orderBy('billing_month', 'desc')->with(['position_holder'])->get(),
        ];

        return view('admin.prepare.service_charge.index', compact(['title', 'data']));
    }

    public function addAuto()
    {
        $title = "Prepare Service Charge";
        $formLink = "service.charge.prepare.save";
        $buttonName = "Auto Service Charge Posting";
        $serial_no = $this->generateSerialNo();
        $utilities = UtilitySetup::all();

        return view('admin.prepare.service_charge.add_auto', compact(['title', 'formLink', 'buttonName', 'serial_no', 'utilities']));
    }

    public function addindividual()
    {
        $title = "Prepare Service Charge";
        $formLink = "service.charge.prepare.save";
        $buttonName = "Auto Service Charge Posting";
        $serial_no = $this->generateSerialNo();
        $utilities = UtilitySetup::all();

        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        return view('admin.prepare.service_charge.add_individual', compact(['tenants','title', 'formLink', 'buttonName', 'serial_no', 'utilities']));
    }

    public function save(Request $request)
    {
        $alreadyHave = ServiceChargeCollection::where('CYear', $request->CYear)->where('CMonth', $request->CMonth)->get();

        if (count($alreadyHave) == 0) {
            // get last month data
            $last_bill_dates = ServiceChargeCollection::orderBy('id', 'desc')->select(['CMonth', 'CYear'])->first();
            $serial_no = $this->generateSerialNo();

            $lastbills = ServiceChargeCollection::where('CYear', $last_bill_dates->CYear)->where('CMonth', $last_bill_dates->CMonth)->get();
           // dd("DDD",$last_bill_dates->CYear,$last_bill_dates->CMonth,$lastbills);
            foreach ($lastbills as $lastbill) {
                ServiceChargeCollection::create([
                    'Client_Code' => $lastbill->Client_Code,
                    'CMonth' => $request->CMonth,
                    'CYear' => $request->CYear,
                    'billing_month' => date('Y-m-d', strtotime('01-' . $request->CMonth . '-' . $request->CYear)),
                    'Utility_ID' => $lastbill->Utility_ID,
                    'Amount' => $lastbill->Amount,
                    'SerialNo' => $serial_no,
                    'PaidDate' => $lastbill->PaidDate,
                    'PositionNo' => $lastbill->PositionNo,
                    'Project_ID' => 1,
                    'CreateBy' => Auth::user()->name,
                ]);
            }
        }

        return redirect(route('service.charge.prepare'));
    }

    public function saveIndividual(Request $request)
    {
        foreach ($request->sl as $sl) {

            $client = PositionInformation::where('Code',  $request->client_code[$sl])->first();

            if (!$client) {
                return back()->with('error', 'Client Not Found with code of ' .  $request->client_code[$sl]);
            }

            $last_bill_dates = ServiceChargeCollection::orderBy('id', 'desc')->select(['CMonth', 'CYear'])->first();

            $exists = ServiceChargeCollection::where('CYear', $request->CYear[$sl])
                ->where('CMonth', $request->CMonth[$sl])
                ->where('Client_Code', $request->client_code[$sl])
                ->where('Utility_ID', $request->service[$sl])
                ->first();

            if ($exists) {
                continue;
            }

            ServiceChargeCollection::create([
                'Client_Code' => $request->client_code[$sl],
                'CMonth' =>  $request->CMonth[$sl],
                'CYear' =>  $request->CYear[$sl],
                'billing_month' => date('Y-m-d', strtotime('01-' . $request->CMonth[$sl] . '-' . $request->CYear[$sl])),
                'Utility_ID' => $request->service[$sl],
                'Amount' => $request->amount[$sl],
                'SerialNo' => $request->serial_no[$sl],
                'PaidDate' => date('Y-m-d h:i:s', strtotime($request->paid_date[$sl])),
                'PositionNo' =>  $client->PositionNo,
                'Project_ID' => 1,
                'CreateBy' => Auth::user()->name,
            ]);
        }

        return redirect(route('service.charge.prepare'))->with('msg', 'Successfully Added');
    }

    public function view($id)
    {
        $title = "Service Charge Collection View";

        $data = (object)[
            'bills' => ServiceChargeCollection::where('serialNo', $id)->with(['position_holder', 'utility'])->get(),
        ];
         $serial_no = $this->generateSerialNo();
        $utilities = UtilitySetup::all();

        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        return view('admin.prepare.service_charge.view', compact(['title', 'data','utilities','tenants']));
    }

    public function billUpdate(Request $request)
    {

        $bill = ServiceChargeCollection::findOrFail($request->bill_id);

        $bill->Client_Code = $request->client_code;
        $bill->CMonth = $request->CMonth;
        $bill->CYear = $request->CYear;
        $bill->PaidDate = $request->paid_date;
        $bill->Utility_ID = $request->utility_id;
        $bill->Amount = $request->amount;

        $bill->save();

        return back()->with('success', 'Bill updated successfully');
    }


    public function delete(Request $request)
    {
        ServiceChargeCollection::where('serialNo', $request->wbill)->delete();
    }
}
