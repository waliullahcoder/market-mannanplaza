<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\CoaSetup;
use App\UnitSetup;
use App\SetupProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CashBookController extends Controller
{
    public function index(Request $request)
    {
        $title = "Cash Book";
        $searchFormLink = "cashBook.index";
        $printFormLink = "cashBook.print";
        $print = $request->print;
        $units = UnitSetup::select(['name'])->get();


        $fromDate = $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : date('01-m-Y');
        $toDate = $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : date('d-m-Y', strtotime(now()));


        $lastDate = Date('Y-m-d', strtotime("-1 day", strtotime($fromDate)));
        $sunit = $request->unit;
        $cashBookHead = $request->cashBookHead;

        $coaHeadCode = CoaSetup::where('head_name', 'Cash In Hand')->first();

        $cashBookLists = CoaSetup::where('transaction', '1')->where('head_code', 'LIKE', '%' . $coaHeadCode->head_code . '%')->get();

        $previousBalance = DB::table('tbl_account_transactions')
            ->where('voucher_date', '<=', $lastDate);
        // ->where('coa_head_code', 'LIKE', '10101%')

        if ($sunit) {
            $previousBalance = $previousBalance->where('tbl_account_transactions.unit_id', $sunit);
        }

        if ($cashBookHead) {
            $previousBalance = $previousBalance->where('coa_head_code', $cashBookHead);
        }

        if ($sunit) {
            $previousBalance = $previousBalance->where('unit_id', $sunit);
        }

        $previousBalance = $previousBalance->where('approve', 1)
            ->sum(DB::raw('debit_amount -credit_amount'));

        $cashBookReports = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.*')
            // ->where('showroom_id',$this->showroomId)
            ->whereBetween('voucher_date', array($fromDate, $toDate))
            // ->where('coa_head_code', 'LIKE', '10101%')
            ->where('approve', 1);

        if ($cashBookHead) {
            $cashBookReports = $cashBookReports->where('coa_head_code', $cashBookHead);
        }

        if ($sunit) {
            $cashBookReports = $cashBookReports->where('tbl_account_transactions.unit_id', $sunit);
        }

        $cashBookReports = $cashBookReports->orderBy('voucher_date', 'asc')->orderby('voucher_no')
            ->get();

        return view('admin.cashBook.index')->with(compact('title', 'units', 'cashBookLists', 'searchFormLink', 'printFormLink', 'print', 'fromDate', 'toDate', 'cashBookReports', 'previousBalance'));
    }

    public function print(Request $request)
    {
        $title = "Print Cash Book";
        $searchFormLink = "cashBook.index";
        $printFormLink = "cashBook.print";
        $print = $request->print;

        $fromDate = $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : date('01-m-Y');
        $toDate = $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : date('d-m-Y', strtotime(now()));
        $lastDate = Date('Y-m-d', strtotime("-1 day", strtotime($fromDate)));
        $sunit = $request->unit;
        $cashBookHead = $request->cashBookHead;

        $coaHeadCode = CoaSetup::where('head_name', 'Cash In Hand')->first();

        $previousBalance = DB::table('tbl_account_transactions')
            ->where('voucher_date', '<=', $lastDate);
        // ->where('coa_head_code', 'LIKE', '10101%')

        if ($sunit) {
            $previousBalance = $previousBalance->where('tbl_account_transactions.unit_id', $sunit);
        }

        if ($cashBookHead) {
            $previousBalance = $previousBalance->where('coa_head_code', $cashBookHead);
        }

        if ($sunit) {
            $previousBalance = $previousBalance->where('unit_id', $sunit);
        }

        $previousBalance = $previousBalance->where('approve', 1)
            ->sum(DB::raw('debit_amount -credit_amount'));

        $cashBookReports = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.*')
            // ->where('showroom_id',$this->showroomId)
            ->whereBetween('voucher_date', array($fromDate, $toDate))
            // ->where('coa_head_code', 'LIKE', '10101%')
            ->where('approve', 1);

        if ($cashBookHead) {
            $cashBookReports = $cashBookReports->where('coa_head_code', $cashBookHead);
        }

        if ($sunit) {
            $cashBookReports = $cashBookReports->where('tbl_account_transactions.unit_id', $sunit);
        }

        $cashBookReports = $cashBookReports->orderBy('voucher_date', 'asc')->orderby('voucher_no')
            ->get();

        $project = SetupProject::findOrFail(1);

        $pdf = PDF::loadView('admin.cashBook.print', ['title' => $title, 'project' => $project, 'fromDate' => $fromDate, 'toDate' => $toDate, 'print' => $print, 'cashBookReports' => $cashBookReports, 'previousBalance' => $previousBalance], [], ['orientation' => 'P']);
        return $pdf->stream('cash_book_' . $fromDate . '_' . $toDate . '.pdf');
    }
}
