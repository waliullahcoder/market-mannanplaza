<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;

use App\UnitSetup;
use App\SetupProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\Report\DailyIncomeExpense;
use App\HelperClass;

class IncomeStatementController extends Controller
{
    public function index(Request $request)
    {
        $title = "Income Statement";
        $searchFormLink = "incomeStatement.index";
        $printFormLink = "incomeStatement.print";
        $print = $request->print;
        $units = UnitSetup::select(['name'])->get();

        $fromDate = $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : date('01-m-Y');
        $toDate = $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : date('d-m-Y', strtotime(now()));
        $sunit = $request->unit;

        $query = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.coa_head_code as headCode', 'tbl_coa.head_name as headName', DB::raw('(SUM(tbl_account_transactions.credit_amount) - SUM(tbl_account_transactions.debit_amount)) as amount'))
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            // ->where('showroom_id',$this->showroomId)
            ->where('tbl_account_transactions.approve', 1)
            ->whereBetween('tbl_account_transactions.voucher_date', array($fromDate, $toDate))
            ->where('tbl_coa.head_type', 'I')
            ->groupBy('tbl_account_transactions.coa_head_code', 'tbl_coa.head_code');

        if ($sunit) {
            $query->where('tbl_account_transactions.unit_id', $sunit);
        }

        if ($request->budget_type) {
            $budget_type = $request->budget_type;
            $query->where(function ($q) use ($budget_type) {
                $q->where('tbl_coa.budget_type', $budget_type)
                    ->orWhereNull('tbl_coa.budget_type');
            });
        }

        $incomeLists = $query->get();

        $query = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.coa_head_code as headCode', 'tbl_coa.head_name as headName', DB::raw('(SUM(tbl_account_transactions.debit_amount) - SUM(tbl_account_transactions.credit_amount)) as amount'))
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            // ->where('showroom_id',$this->showroomId)
            ->where('tbl_account_transactions.approve', 1)
            ->whereBetween('tbl_account_transactions.voucher_date', array($fromDate, $toDate))
            ->where('tbl_coa.head_type', 'E');

        if ($sunit) {
            $query->where('tbl_account_transactions.unit_id', $sunit);
        }

        if ($request->budget_type) {
            $budget_type = $request->budget_type;
            $query->where(function ($q) use ($budget_type) {
                $q->where('tbl_coa.budget_type', $budget_type)
                    ->orWhereNull('tbl_coa.budget_type');
            });
        }

        $expenseLists = $query->groupBy('tbl_account_transactions.coa_head_code', 'tbl_coa.head_code')
            ->get();

        return view('admin.incomeStatement.index')->with(compact('title', 'searchFormLink', 'printFormLink', 'print', 'fromDate', 'toDate', 'incomeLists', 'expenseLists', 'units', 'sunit'));
    }

    public function print(Request $request)
    {
        $title = "Print Income Statement";
        $print = $request->print;

        $fromDate = date('Y-m-d', strtotime($request->fromDate));
        $toDate = date('Y-m-d', strtotime($request->toDate));
        $sunit = $request->sunit;

        $query = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.coa_head_code as headCode', 'tbl_coa.head_name as headName', DB::raw('(SUM(tbl_account_transactions.credit_amount) - SUM(tbl_account_transactions.debit_amount)) as amount'))
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            // ->where('showroom_id',$this->showroomId)
            ->where('tbl_account_transactions.approve', 1)
            ->whereBetween('tbl_account_transactions.voucher_date', array($fromDate, $toDate))
            ->where('tbl_coa.head_type', 'I')
            ->groupBy('tbl_account_transactions.coa_head_code', 'tbl_coa.head_code');
        if ($sunit) {
            $query->where('tbl_account_transactions.unit_id', $sunit);
        }
        if ($request->budget_type) {
            $budget_type = $request->budget_type;
            $query->where(function ($q) use ($budget_type) {
                $q->where('tbl_coa.budget_type', $budget_type)
                    ->orWhereNull('tbl_coa.budget_type');
            });
        }

        $incomeLists = $query->get();

        $query = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.coa_head_code as headCode', 'tbl_coa.head_name as headName', DB::raw('(SUM(tbl_account_transactions.debit_amount) - SUM(tbl_account_transactions.credit_amount)) as amount'))
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            // ->where('showroom_id',$this->showroomId)
            ->where('tbl_account_transactions.approve', 1)
            ->whereBetween('tbl_account_transactions.voucher_date', array($fromDate, $toDate))
            ->where('tbl_coa.head_type', 'E')
            ->groupBy('tbl_account_transactions.coa_head_code', 'tbl_coa.head_code');

        if ($sunit) {
            $query->where('tbl_account_transactions.unit_id', $sunit);
        }

        if ($request->budget_type) {
            $budget_type = $request->budget_type;
            $query->where(function ($q) use ($budget_type) {
                $q->where('tbl_coa.budget_type', $budget_type)
                    ->orWhereNull('tbl_coa.budget_type');
            });
        }

        $expenseLists = $query->groupBy('tbl_account_transactions.coa_head_code', 'tbl_coa.head_code')
            ->get();

        $project = SetupProject::findOrFail(1);

        if ($request->sunit) {
            $unit = UnitSetup::where('name', 'like', $request->sunit)->first();
            $stitle = 'ইউনিট - ' . HelperClass::convertEnglishToBangla($unit->code);
        } else {
            $units = UnitSetup::all();
            $unit_str = '';
            foreach ($units as $key => $unit) {
                $unit_str .= ($key > 0 ? ' ও ' : '') . HelperClass::convertEnglishToBangla($unit->code);
            }
            $stitle = 'ইউনিট - ' . $unit_str;
        }

        // return view('admin.incomeStatement.print', ['title' => $title, 'stitle' => $stitle, 'sunit' => $sunit, 'project' => $project, 'fromDate' => $fromDate, 'toDate' => $toDate, 'print' => $print, 'incomeLists' => $incomeLists, 'expenseLists' => $expenseLists], [], ['orientation' => 'P']);
        $pdf = PDF::loadView('admin.incomeStatement.print', ['title' => $title, 'stitle' => $stitle, 'sunit' => $sunit, 'project' => $project, 'fromDate' => $fromDate, 'toDate' => $toDate, 'print' => $print, 'incomeLists' => $incomeLists, 'expenseLists' => $expenseLists], [], ['orientation' => 'P']);
        return $pdf->stream('income_statement_' . $fromDate . '_' . $toDate . '.pdf');
    }

    public function dailyIncomeExpense(Request $request)
    {
        $title = "Daily Income Expense";
        $searchFormLink = "daily.income.expense";
        $printFormLink = "daily.income.expense.print";
        $print = $request->print;
        $units = UnitSetup::select(['name'])->get();

        $fromDate = $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : date('01-m-Y');
        $toDate = $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : date('d-m-Y', strtotime(now()));
        $sunit = $request->unit;

        $filter = [
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'sunit' => $sunit,
        ];

        $dailyIncomeExpense = new DailyIncomeExpense($filter);
        $report = $dailyIncomeExpense->getReport();

        return view('admin.incomeExpenseReport.index')->with(compact('title', 'searchFormLink', 'printFormLink', 'print', 'fromDate', 'toDate', 'report', 'units', 'sunit'));
    }

    public function dailyIncomeExpensePrint(Request $request)
    {
        $title = "Daily Income Expense Print";
        $print = $request->print;

        $fromDate = date('Y-m-d', strtotime($request->fromDate));
        $toDate = date('Y-m-d', strtotime($request->toDate));
        $sunit = $request->sunit;

        $filter = [
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'sunit' => $sunit,
        ];

        $dailyIncomeExpense = new DailyIncomeExpense($filter);
        $report = $dailyIncomeExpense->getReport();

        $project = SetupProject::findOrFail(1);

        $pdf = PDF::loadView('admin.incomeExpenseReport.print', ['title' => $title, 'sunit' => $sunit, 'fromDate' => $fromDate, 'toDate' => $toDate, 'report' => $report, 'project' => $project, 'print' => $print], [], ['orientation' => 'P']);
        return $pdf->stream('income_statement_' . $fromDate . '_' . $toDate . '.pdf');
    }
}
