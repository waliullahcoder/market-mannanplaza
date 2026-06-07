<?php

namespace App\Http\Controllers\Admin;

use App\SetupProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\Report\JamidariIncreaseReport;

class JamiDariIncreaseReportController extends Controller
{
    public function report(Request $request)
    {
        $title = "Jamidari Increase";
        $project = SetupProject::findOrFail(1);

        $report = [];

        if($request->searched){

            $filter = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ];


            $collectionStatusReport = new JamidariIncreaseReport($filter);
            $report = $collectionStatusReport->getReport();

        }

        return view('admin.jamidari_increase_report.jamidari_increase_report', compact(['title',  'project', 'report']));
    }
}
