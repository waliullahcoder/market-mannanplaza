<?php

namespace App\Http\Controllers\Admin;

use App\UnitSetup;
use App\FloorSetup;
use App\SetupProject;
use App\PositionInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class TenantReportController extends Controller
{
    public function index()
    {
        $title = "Client Report";
        $searchFormLink = "tenant.report.search";
        $printFormLink  = "tenant.report.print";

        $data = (object)[
            'floors' => FloorSetup::select(['name'])->get(),
            'units' => UnitSetup::select(['name'])->get(),
            'project' => SetupProject::findOrFail(1),
        ];


        return view('admin.tenant_report.index', compact(['title', 'searchFormLink', 'printFormLink', 'data']));
    }

    public function search(Request $request)
    {
        // dd($request->all());

        $response = [];

        if ($request->units) {
            $units = $request->units;
        } else {
            $units = UnitSetup::select('name')->get()->pluck('name')->toArray();
        }

        if ($request->floors) {
            $floors = $request->floors;
        } else {
            $floors = FloorSetup::select('name')->get()->pluck('name')->toArray();
        }


        foreach ($units as $unit) {
            foreach ($floors as $floor) {
                $response[$unit][$floor] = PositionInformation::where('status', 1)->where('Unit', $unit)->where('Floor', $floor)
                    ->orderBy('Unit', 'asc')
                    ->orderBy('Floor', 'asc')
                    ->orderBy('PositionNo', 'asc');

                if($request->type){
                    $response[$unit][$floor] = $response[$unit][$floor]->where('EntryReson', $request->type);
                }

                $response[$unit][$floor] = $response[$unit][$floor]->get();
            }
        }

        // if ($request->units) {
        //     foreach ($request->units as $unit) {
        //         foreach ($request->floors as $floor) {

        //             $response[$unit][$floor] = PositionInformation::where('Unit', $unit)->where('Floor', $floor)
        //                 ->orderBy('Unit', 'asc')
        //                 ->orderBy('Floor', 'asc')
        //                 ->orderBy('PositionNo', 'asc')
        //                 ->get();
        //         }
        //     }
        // } else {
        //     $units = UnitSetup::all();
        //     $floors = FloorSetup::all();

        //     foreach ($units as $unit) {
        //         foreach ($floors as $floor) {
        //             $response[$unit->name][$floor->name] = PositionInformation::where('Unit', $unit->name)->where('Floor', $floor->name)
        //                 ->orderBy('Unit', 'asc')
        //                 ->orderBy('Floor', 'asc')
        //                 ->orderBy('PositionNo', 'asc')
        //                 ->get();
        //         }
        //     }
        // }



        return $response;
    }
}
