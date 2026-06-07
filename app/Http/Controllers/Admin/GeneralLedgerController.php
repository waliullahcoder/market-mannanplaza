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

class GeneralLedgerController extends Controller
{
    public function index(Request $request)
    {
        $title = "General Ledger";
        $searchFormLink = "generalLedger.index";
        $printFormLink = "generalLedger.print";
        $print = $request->print;
        $units = UnitSetup::select(['name'])->get();

        $generalLedgerLists = CoaSetup::where('general_ledger', '1')->get();

        $fromDate = $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : date('01-m-Y');
        $toDate = $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : date('d-m-Y', strtotime(now()));
        $lastDate = Date('Y-m-d', strtotime("-1 day", strtotime($fromDate)));
        $generalLedgerHead = $request->generalLedgerHead;
        $sunit = $request->unit;

        $previousBalance = DB::table('tbl_account_transactions')
            ->select(DB::raw('(SUM(debit_amount) - SUM(credit_amount)) as previousBalance'))
            // ->where('showroom_id',$this->showroomId)
            ->where('voucher_date', '<=', $lastDate)
            ->where('coa_head_code', 'LIKE', '%' . $generalLedgerHead . '%')
            ->where('approve', 1);

        if ($sunit) {
            $previousBalance = $previousBalance->where('unit_id', $sunit);
        }

        $previousBalance = $previousBalance->first();


        $generalLedgerReports = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.*')
            // ->where('showroom_id',$this->showroomId)
            ->whereBetween('voucher_date', array($fromDate, $toDate))
            ->where('coa_head_code', 'LIKE', '%' . $generalLedgerHead . '%')
            ->where('approve', 1);

        if ($sunit) {
            $generalLedgerReports = $generalLedgerReports->where('unit_id', $sunit);
        }

        $generalLedgerReports = $generalLedgerReports->orderby('voucher_no')
            ->get();

        return view('admin.generalLedger.index')->with(compact('title', 'searchFormLink', 'printFormLink', 'print', 'fromDate', 'toDate', 'generalLedgerLists', 'generalLedgerReports', 'generalLedgerHead', 'previousBalance', 'units', 'sunit'));
    }

    public function print(Request $request)
    {
        $title = "Print General Ledger";
        $print = $request->print;

        $fromDate = date('Y-m-d', strtotime($request->fromDate));
        $toDate = date('Y-m-d', strtotime($request->toDate));
        $lastDate = Date('Y-m-d', strtotime("-1 day", strtotime($fromDate)));
        $generalLedgerHead = $request->generalLedgerHead;
        $sunit = $request->sunit;

        $generalLedgerHeadName = CoaSetup::where('head_code', $generalLedgerHead)->first();

        $previousBalance = DB::table('tbl_account_transactions')
            ->select(DB::raw('(SUM(debit_amount) - SUM(credit_amount)) as previousBalance'))
            // ->where('showroom_id',$this->showroomId)
            ->where('voucher_date', '<=', $lastDate)
            ->where('coa_head_code', 'LIKE', '%' . $generalLedgerHead . '%')
            ->where('approve', 1);

        if ($sunit) {
            $previousBalance = $previousBalance->where('unit_id', $sunit);
        }

        $previousBalance = $previousBalance->first();

        $generalLedgerReports = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.*')
            // ->where('showroom_id',$this->showroomId)
            ->whereBetween('voucher_date', array($fromDate, $toDate))
            ->where('coa_head_code', 'LIKE', '%' . $generalLedgerHead . '%')
            ->where('approve', 1);

        if ($sunit) {
            $generalLedgerReports = $generalLedgerReports->where('unit_id', $sunit);
        }

        $generalLedgerReports = $generalLedgerReports->orderby('voucher_no')
            ->get();

        $project = SetupProject::findOrFail(1);

        $pdf = PDF::loadView('admin.generalLedger.print', ['title' => $title, 'sunit' => $sunit, 'project' => $project, 'fromDate' => $fromDate, 'toDate' => $toDate, 'print' => $print, 'generalLedgerReports' => $generalLedgerReports, 'generalLedgerHeadName' => $generalLedgerHeadName, 'previousBalance' => $previousBalance], [], ['orientation' => 'P']);
        return $pdf->stream('general_ledger_list_' . $fromDate . '_' . $toDate . '.pdf');
    }
}
