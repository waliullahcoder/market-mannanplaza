<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;

use Auth;

use App\CoaSetup;
use App\UnitSetup;
use App\SetupProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrialBalanceController extends Controller
{
    public function index(Request $request)
    {
        $title = "Trial Balance";
        $searchFormLink = "trialBalance.index";
        $printFormLink = "trialBalance.print";
        $print = $request->print;
        $units = UnitSetup::select(['name'])->get();

        // $date = date('Y-m-d', strtotime($request->date));
        $date = $request->date ? date('Y-m-d', strtotime($request->date)) : date('d-m-Y', strtotime(now()));
        $unit = $request->unit;

        $coaLists = CoaSetup::where('general_ledger', 1)->get();

        return view('admin.trialBalance.index')->with(compact('title', 'units', 'unit', 'searchFormLink', 'printFormLink', 'print', 'date', 'coaLists'));
    }

    public function print(Request $request)
    {
        $title = "Print Trial Balance";
        $print = $request->print;

        $date = date('Y-m-d', strtotime($request->date));

        $coaLists = CoaSetup::where('general_ledger', 1)->get();

        $project = SetupProject::findOrFail(1);

        $pdf = PDF::loadView('admin.trialBalance.print', ['title' => $title, 'project' => $project, 'date' => $date, 'print' => $print, 'coaLists' => $coaLists], [], ['orientation' => 'P']);
        return $pdf->stream('trial_balance_' . $date . '.pdf');
    }
}
