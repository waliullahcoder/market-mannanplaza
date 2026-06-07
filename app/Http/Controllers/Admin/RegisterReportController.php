<?php

namespace App\Http\Controllers\admin;

use App\SetupProject;
use App\RentCollection;
use App\EbillCollection;
use App\WbillCollection;
use App\PositionInformation;
use Illuminate\Http\Request;
use App\ServiceChargeCollection;
use App\Http\Controllers\Controller;

class RegisterReportController extends Controller
{
    public function jamidariRegister(Request $request)
    {
        $title = "Jamidari Register";
        $bills = [];
        $search_code = '';
        $client_info = '';

        $project = SetupProject::findOrFail(1);
        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        if ($request->searched) {
            $search_code = $request->search_code;

            $bills = RentCollection::where('ReceiveDate', '>', '2010-01-01 00:00:00')
                ->where('Client_Code', $search_code)
                ->orderBy('id', 'desc')
                ->get();

            $client_info = PositionInformation::where('Code', $search_code)->first();
        }

        // dd($bills);

        return view('admin.collection_report.register_report.jamidari', compact(['tenants', 'title', 'bills', 'search_code', 'project', 'client_info']));
    }

    public function electricRegister(Request $request)
    {
        $title = "Electric Bill Register";
        $bills = [];
        $search_code = '';
        $client_info = '';

        $project = SetupProject::findOrFail(1);

        if ($request->searched) {
            $search_code = $request->search_code;
            $bills = EbillCollection::where('ReceiveDate', '>', '2010-01-01 00:00:00')
            ->where('Client_Code', $search_code)
            ->orderBy('id', 'desc')
            ->get();
            $client_info = PositionInformation::where('Code', $search_code)->first();
        }

        // dd($bills);
        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        return view('admin.collection_report.register_report.ebill', compact(['tenants', 'title', 'bills', 'search_code', 'project', 'client_info']));
    }

    public function waterRegister(Request $request)
    {
        $title = "Water Bill Register";
        $bills = [];
        $search_code = '';
        $client_info = '';

        $project = SetupProject::findOrFail(1);

        if ($request->searched) {
            $search_code = $request->search_code;
            $bills = WbillCollection::where('ReceiveDate', '>', '2010-01-01 00:00:00')
            ->where('Client_Code', $search_code)
            ->orderBy('id', 'desc')
            ->get();
            $client_info = PositionInformation::where('Code', $search_code)->first();
        }

        // dd($bills);
        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        return view('admin.collection_report.register_report.wbill', compact(['tenants', 'title', 'bills', 'search_code', 'project', 'client_info']));
    }

    public function serviceRegister(Request $request)
    {
        $title = "Electric Bill Register";
        $bills = [];
        $search_code = '';
        $client_info = '';


        $project = SetupProject::findOrFail(1);

        if ($request->searched) {
            $search_code = $request->search_code;
            $bills = ServiceChargeCollection::where('ReceiveDate', '>', '2010-01-01 00:00:00')
            ->where('Client_Code', $search_code)
            ->orderBy('id', 'desc')
            ->get();
            $client_info = PositionInformation::where('Code', $search_code)->first();
        }

        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        // dd($bills);

        return view('admin.collection_report.register_report.service', compact(['tenants', 'title', 'bills', 'search_code', 'project', 'client_info']));
    }
}
