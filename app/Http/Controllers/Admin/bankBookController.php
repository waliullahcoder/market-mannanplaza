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

class bankBookController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $title = "Bank Book";
        $searchFormLink = "bankBook.index";
        $printFormLink = "bankBook.print";
        $print = $request->print;
        $units = UnitSetup::select(['name'])->get();

        $coaHeadCode = CoaSetup::where('head_name', 'Cash At Bank')->first();

        $bankBookLists = CoaSetup::where('transaction', '1')->where('head_code', 'LIKE', $coaHeadCode->head_code . '%')->get();

        $fromDate = $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : date('01-m-Y');
        $toDate = $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : date('d-m-Y', strtotime(now()));

        $lastDate = Date('Y-m-d', strtotime("-1 day", strtotime($fromDate)));
        $bankBookHead = $request->bankBookHead;
        $sunit = $request->unit;

        $previousBalance = DB::table('tbl_account_transactions')
            ->select(DB::raw('(SUM(debit_amount) - SUM(credit_amount)) as previousBalance'))
            // ->where('showroom_id',$this->showroomId)
            ->where('voucher_date', '<=', $lastDate)
            ->where('coa_head_code', 'LIKE', '10102%')
            ->where('approve', 1);

        if ($bankBookHead) {
            $previousBalance = $previousBalance->where('coa_head_code', $bankBookHead);
        }

        if ($sunit) {
            $previousBalance = $previousBalance->where('tbl_account_transactions.unit_id', $sunit);
        }

        $previousBalance = $previousBalance->first();

        $bankBooksReports = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.*')
            // ->where('showroom_id',$this->showroomId)
            ->whereBetween('voucher_date', array($fromDate, $toDate))
            ->where('coa_head_code', 'LIKE', '10102%')
            ->where('approve', 1);

        if ($bankBookHead) {
            $bankBooksReports = $bankBooksReports->where('coa_head_code', $bankBookHead);
        }

        if ($sunit) {
            $bankBooksReports = $bankBooksReports->where('tbl_account_transactions.unit_id', $sunit);
        }

        $bankBooksReports = $bankBooksReports->orderby('voucher_no')
            ->get();

        return view('admin.bankBook.index')->with(compact('title', 'sunit', 'searchFormLink', 'printFormLink', 'print', 'fromDate', 'toDate', 'bankBookLists', 'bankBooksReports', 'bankBookHead', 'previousBalance', 'units'));
    }

    public function print(Request $request)
    {
        // dd($request->all());
        $title = "Bank Book";
        $searchFormLink = "bankBook.index";
        $printFormLink = "bankBook.print";
        $print = $request->print;
        $sunit = $request->sunit;

        $fromDate = date('Y-m-d', strtotime($request->fromDate));
        $toDate = date('Y-m-d', strtotime($request->toDate));
        $lastDate = Date('Y-m-d', strtotime("-1 day", strtotime($fromDate)));
        $bankBookHead = $request->bankBookHead;

        $previousBalance = DB::table('tbl_account_transactions')
            ->select(DB::raw('(SUM(debit_amount) - SUM(credit_amount)) as previousBalance'))
            // ->where('showroom_id',$this->showroomId)
            ->where('voucher_date', '<=', $lastDate)
            ->where('coa_head_code', $bankBookHead)
            ->where('approve', 1);

        if ($sunit) {
            $previousBalance = $previousBalance->where('tbl_account_transactions.unit_id', $sunit);
        }

        $previousBalance = $previousBalance->first();

        $bankBooksReports = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.*')
            // ->where('showroom_id',$this->showroomId)
            ->whereBetween('voucher_date', array($fromDate, $toDate))
            ->where('coa_head_code', $bankBookHead)
            ->where('approve', 1);
        if ($sunit) {
            $bankBooksReports = $bankBooksReports->where('tbl_account_transactions.unit_id', $sunit);
        }

        $bankBooksReports = $bankBooksReports->orderby('voucher_no')
            ->get();
        $project = SetupProject::findOrFail(1);


        $pdf = PDF::loadView('admin.bankBook.print', ['title' => $title, 'sunit' => $sunit, 'project' => $project, 'fromDate' => $fromDate, 'toDate' => $toDate, 'print' => $print, 'bankBooksReports' => $bankBooksReports, 'previousBalance' => $previousBalance], [], ['orientation' => 'P']);
        return $pdf->stream('bank_book_' . $fromDate . '_' . $toDate . '.pdf');
    }
}
