<?php

namespace App\Http\Controllers\Admin;

use App\UnitSetup;
use Carbon\Carbon;
use App\FloorSetup;
use App\SetupProject;
use App\RentCollection;
use App\PositionInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JamidariPrepareController extends Controller
{

    public function generateSerialNo()
    {
        $curr_serial_no = RentCollection::orderBy('id', 'desc')->select(['SerialNo'])->pluck('SerialNo')->first();
        $new_serial_no = $curr_serial_no + 1;

        return $new_serial_no;
    }

    public function index()
    {
        $title = "Jamidari List";
        $searchFormLink = "tenant.report.search";
        $printFormLink  = "tenant.report.print";

        $data = (object)[
            'jamidari_list' => RentCollection::groupBy('SerialNo')->orderBy('billing_month', 'desc')->with(['position_holder'])->get(),
        ];

        return view('admin.prepare.jamidari.index', compact(['title', 'searchFormLink', 'printFormLink', 'data']));
    }

    public function add()
    {
        $title = "Add Jamidari";
        $searchFormLink = "tenant.report.search";
        $printFormLink  = "tenant.report.print";

        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        $data = (object)[
            'floors' => FloorSetup::select(['name'])->get(),
            'units' => UnitSetup::select(['name'])->get(),
            'serial_no' =>  $this->generateSerialNo(),
            'current_time' => Carbon::now(),
        ];

        return view('admin.prepare.jamidari.add', compact(['title', 'searchFormLink', 'printFormLink', 'data', 'tenants']));
    }

    public function addindividual()
    {
        $title = "Prepare Jamidari Charge Individual";
        $formLink = "jamidari.prepare.save.individual";
        $buttonName = "Auto Jamiradi Posting";
        $serial_no = $this->generateSerialNo();


        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        return view('admin.prepare.jamidari.add_individual', compact(['tenants', 'title', 'formLink', 'buttonName', 'serial_no']));
    }

    public function saveIndividual(Request $request)
    {

        $client = PositionInformation::where('Code',  $request->client_code)->first();

        $exists = RentCollection::where('CYear', $request->CYear)
            ->where('CMonth', $request->CMonth)
            ->where('Client_Code', $request->client_code)
            ->first();

        if ($exists) {
            return back()->with('error', 'Already Added');
        }

        RentCollection::create([
            'Client_Code' => $request->client_code,
            'CMonth' =>  $request->CMonth,
            'CYear' =>  $request->CYear,
            'billing_month' => date('Y-m-d', strtotime('01-' . $request->CMonth . '-' . $request->CYear)),
            'Amount' => $request->amount - $client->MonthlyDeduct,
            'SerialNo' =>  $this->generateSerialNo(),
            'PaidDate' => date('Y-m-d h:i:s', strtotime($request->paid_date)),
            'PositionNo' =>  $client->PositionNo,
            'Project_ID' => 1,
            'CreateBy' => Auth::user()->name,
        ]);

        return redirect(route('jamidari.prepare.index'))->with('msg', 'Successfully Added');
    }


    public function save(Request $request)
    {
        DB::transaction(function () use ($request) {
            $tenants = PositionInformation::where('Unit', $request->unit)->where('Floor', $request->floor);

            if ($request->search_code) {
                $tenants = $tenants->where('Code', $request->search_code);
            }

            $tenants =  $tenants->get();
            $serial_no = $this->generateSerialNo();

            foreach ($tenants as $tenant) {
                $check = RentCollection::where('Client_Code', $tenant->Code)->where('CMonth', $request->CMonth)->where('CYear', $request->CYear)->first();
                if ($check == null) {
                    RentCollection::create([
                        'Client_Code' => $tenant->Code,
                        'CMonth' => $request->CMonth,
                        'CYear' => $request->CYear,
                        'billing_month' => date('Y-m-d', strtotime('01-' . $request->CMonth . '-' . $request->CYear)),
                        'Amount' => $tenant->Agg0ne - $tenant->MonthlyDeduct,
                        'SerialNo' => $serial_no,
                        'PaidDate' => date('Y-m-d h:i:s', strtotime($request->PaidDate)),
                        'Project_ID' => 1,
                        'PositionNo' => $tenant->PositionNo,
                        'CreateBy' => Auth::user()->name,
                    ]);
                }
            }
        });

        return redirect(route('jamidari.prepare.index'));
    }

    public function view($id)
    {
        $title = "Jamidari Collection View";
        $searchFormLink = "tenant.report.search";
        $printFormLink  = "tenant.report.print";

        $data = (object)[
            'bills' => RentCollection::where('serialNo', $id)->with(['position_holder'])->get(),
        ];

        return view('admin.prepare.jamidari.view', compact(['title', 'searchFormLink', 'printFormLink', 'data']));
    }

    public function print($id)
    {
        $title = "Jamidari Collection Print";
        $searchFormLink = "tenant.report.search";
        $printFormLink  = "tenant.report.print";


        $data = (object)[
            'bills' => RentCollection::where('serialNo', $id)->with(['position_holder'])->get(),
            'copies' => ['Office Copy', 'Client Copy'],
            'project' => SetupProject::findOrFail(1),
        ];

        return view('admin.prepare.jamidari.print', compact(['title', 'searchFormLink', 'printFormLink', 'data']));
    }

    public function delete(Request $request)
    {
        RentCollection::where('serialNo', $request->serialNo)->delete();
    }

    public function deleteIndividual(Request $request)
    {
        RentCollection::where('id', $request->bill_id)->delete();
        return back();
    }

    public function search(Request $request)
    {
        $response = [];

        if ($request->unit) {

            if ($request->search_code) {
                $response[$request->unit][$request->floor] = PositionInformation::where('Code', $request->search_code)->where('Agg0ne', '!=', 0)->where('status', 1)->orderBy('PositionNo', 'asc')->get();
            } else {
                $response[$request->unit][$request->floor] = PositionInformation::where('Unit', $request->unit)->where('Floor', $request->floor)->where('Agg0ne', '!=', 0)->where('status', 1)->orderBy('PositionNo', 'asc')->get();
            }
        }

        return $response;
    }


    public function getTenantInfo(Request $request)
    {
        $tenant = PositionInformation::where('Code', $request->client_code)->select(['Agg0ne'])->first();
        return $tenant;
    }
}
