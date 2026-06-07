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

class TransactionLedgerController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $title = "Transaction Ledger";
        $searchFormLink = "transactionLedger.index";
        $printFormLink = "transactionLedger.print";
        $print = $request->print;
        $units = UnitSetup::select(['name'])->get();

        $transactionLedgerLists = CoaSetup::where('transaction', '1')->get();

        $fromDate = $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : date('01-m-Y');
        $toDate = $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : date('d-m-Y', strtotime(now()));
        $lastDate = Date('Y-m-d', strtotime("-1 day", strtotime($fromDate)));
        $transactionLedgerHead = $request->transactionLedgerHead;
        $sunit = $request->unit;

        $previousBalance = DB::table('tbl_account_transactions')
            ->select(DB::raw('(SUM(debit_amount) - SUM(credit_amount)) as previousBalance'))
            // ->where('showroom_id',$this->showroomId)
            ->where('voucher_date', '<=', $lastDate)
            ->where('coa_head_code', $transactionLedgerHead)
            ->where('approve', 1);

        if ($sunit) {
            $previousBalance = $previousBalance->where('unit_id', $sunit);
        }

        $previousBalance = $previousBalance->first();

        $transactionLedgerReports = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.*')
            // ->where('showroom_id',$this->showroomId)
            ->whereBetween('voucher_date', array($fromDate, $toDate))
            ->where('coa_head_code', $transactionLedgerHead)
            ->where('approve', 1);

        if ($sunit) {
            $transactionLedgerReports = $transactionLedgerReports->where('unit_id', $sunit);
        }

        $transactionLedgerReports = $transactionLedgerReports->orderby('voucher_no')
            ->get();

        return view('admin.transactionLedger.index')->with(compact('title', 'units', 'sunit', 'searchFormLink', 'printFormLink', 'print', 'fromDate', 'toDate', 'transactionLedgerLists', 'transactionLedgerReports', 'transactionLedgerHead', 'previousBalance'));
    }

    public function print(Request $request)
    {
        $title = "Print Transaction Ledger";
        $print = $request->print;

        $fromDate = date('Y-m-d', strtotime($request->fromDate));
        $toDate = date('Y-m-d', strtotime($request->toDate));
        $lastDate = Date('Y-m-d', strtotime("-1 day", strtotime($fromDate)));
        $transactionLedgerHead = $request->transactionLedgerHead;
        $sunit = $request->sunit;

        $transactionLedgerHeadName = CoaSetup::where('head_code', $transactionLedgerHead)->first();

        $previousBalance = DB::table('tbl_account_transactions')
            ->select(DB::raw('(SUM(debit_amount) - SUM(credit_amount)) as previousBalance'))
            // ->where('showroom_id',$this->showroomId)
            ->where('voucher_date', '<=', $lastDate)
            ->where('coa_head_code', $transactionLedgerHead)
            ->where('approve', 1);

        if ($sunit) {
            $previousBalance = $previousBalance->where('unit_id', $sunit);
        }

        $previousBalance = $previousBalance->first();


        $transactionLedgerReports = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.*')
            // ->where('showroom_id',$this->showroomId)
            ->whereBetween('voucher_date', array($fromDate, $toDate))
            ->where('coa_head_code', $transactionLedgerHead)
            ->where('approve', 1);

        if ($sunit) {
            $transactionLedgerReports = $transactionLedgerReports->where('unit_id', $sunit);
        }

        $transactionLedgerReports = $transactionLedgerReports->orderby('voucher_no')
            ->get();


        $project = SetupProject::findOrFail(1);

        $pdf = PDF::loadView('admin.transactionLedger.print', ['title' => $title, 'sunit' => $sunit, 'project' => $project, 'fromDate' => $fromDate, 'toDate' => $toDate, 'print' => $print, 'transactionLedgerReports' => $transactionLedgerReports, 'transactionLedgerHeadName' => $transactionLedgerHeadName, 'previousBalance' => $previousBalance], [], ['orientation' => 'P']);
        return $pdf->stream('transaction_ledger_' . $fromDate . '_' . $toDate . '.pdf');
    }
}
