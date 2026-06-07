<?php

namespace App\Http\Controllers\Admin;

use App\UnitSetup;
use App\SetupProject;
use App\RentCollection;
use App\EbillCollection;
use App\WbillCollection;
use App\PositionInformation;
use Illuminate\Http\Request;
use App\ServiceChargeCollection;
use App\Http\Controllers\Controller;

class ReprintController extends Controller
{

    public function jamidariView()
    {
        $title = "Prepare Jamidari Charge Individual";
        $formLink = "jamidari.reprint";
        $buttonName = "Print";

        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        return view('admin.reprint.jamidari', compact(['tenants', 'title', 'formLink', 'buttonName']));
    }

    public function jamidari(Request $request)
    {
        $title = "Jamidari Collection Print";
        // $searchFormLink = "tenant.report.search";
        $printFormLink  = "tenant.report.print";

        $data = (object)[
            'bills' => RentCollection::where('Client_Code', $request->client_code)
                ->where('CMonth', $request->CMonth)
                ->where('CYear', $request->CYear)
                ->with(['position_holder'])->get(),

            'copies' => ['Office Copy', 'Client Copy'],
            'project' => SetupProject::findOrFail(1),
        ];

        return view('admin.prepare.jamidari.print', compact(['title',  'printFormLink', 'data']));
    }

    public function ebillView()
    {
        $title = "Prepare Ebill Charge Individual";
        $formLink = "ebill.reprint";
        $buttonName = "Print";

        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        return view('admin.reprint.ebill', compact(['tenants', 'title', 'formLink', 'buttonName']));
    }

    public function ebill(Request $request)
    {
        $title = "Jamidari Collection Print";
        $searchFormLink = "tenant.report.search";
        $printFormLink  = "tenant.report.print";

        // get month and year and unit and floor
        // $parameters = EbillCollection::where('serialNo', $id)->with(['position_holder'])->first();

        // get tenant Codes
        // $tenant = PositionInformation::where('Code', $request->client_code)
        //     ->select(['Code'])
        //     ->first();

        $tenants = PositionInformation::where('status', 1);

        if ($request->client_code) {

            $tenants = $tenants->where('Code', $request->client_code);
        }

        $tenants = $tenants->get();

        $data = (object)[
            'bills' => [],
            'copies' => ['Office Copy', 'Client Copy'],
            'project' => SetupProject::findOrFail(1),
            'unit_prices' => UnitSetup::all(),
        ];


        foreach ($tenants as $tenant) {

            $data->bills[$tenant->Code]['tenant'] = $tenant;
            $data->bills[$tenant->Code]['billCode'] = $request->CMonth . '-' . $request->CYear . '-' . $tenant->ID;

            $data->bills[$tenant->Code]['month'] = $request->CMonth;
            $data->bills[$tenant->Code]['year'] = $request->CYear;

            // fetch Ebill
            $ebills = EbillCollection::where('CMonth', $request->CMonth)->where('CYear', $request->CYear)->where('Client_Code', $tenant->Code)->get();

            foreach ($ebills as $ebill) {
                $data->bills[$tenant->Code][0] = $ebill;
            }

            // fetch Wbill
            $wbills = WbillCollection::where('CMonth', $request->CMonth)->where('CYear', $request->CYear)->where('Client_Code', $tenant->Code)->get();

            foreach ($wbills as $wbill) {
                $data->bills[$tenant->Code][1] = $wbill;
            }

            // fetch Ebill
            $sbills = ServiceChargeCollection::where('CMonth', $request->CMonth)->where('CYear', $request->CYear)->where('Client_Code', $tenant->Code)->get();

            foreach ($sbills as $sbill) {
                $data->bills[$tenant->Code][2] = [$sbill];
            }
        }


        // dd($data->bills);

        return view('admin.prepare.ebill.print', compact(['title', 'searchFormLink', 'printFormLink', 'data']));
    }
}
