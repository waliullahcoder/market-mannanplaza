<?php

namespace App\Helper\Report;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DailyIncomeExpense
{

    protected $filter;

    protected $incomeList;

    protected $ExpenseList;

    public function __construct($filter)
    {
        $this->filter = $filter;
        $this->incomeList = $this->getIncomeList();
        $this->ExpenseList = $this->getExpenseList();
    }

    public function getPrevBalance()
    {

        $prevTotalIncome =  DB::table('tbl_account_transactions')
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            ->where('tbl_account_transactions.approve', 1)
            ->whereBetween('tbl_account_transactions.voucher_date', array("0000-00-00", $this->filter['fromDate']))
            ->where('voucher_type', 'cv')
            ->where('tbl_account_transactions.credit_amount', '>', 0);

        if ($this->filter['sunit']) {
            $prevTotalIncome = $prevTotalIncome->where('tbl_account_transactions.unit_id', $this->filter['sunit']);
        }

        $prevTotalIncome = $prevTotalIncome->sum('credit_amount');


        $prevTotalExpense =  DB::table('tbl_account_transactions')
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            ->where('tbl_account_transactions.approve', 1)
            ->whereBetween('tbl_account_transactions.voucher_date', array("0000-00-00", $this->filter['fromDate']))
            ->where('voucher_type', 'dv')
            ->where('tbl_account_transactions.debit_amount', '>', 0);

        if ($this->filter['sunit']) {
            $prevTotalExpense = $prevTotalExpense->where('tbl_account_transactions.unit_id', $this->filter['sunit']);
        }

        $prevTotalExpense = $prevTotalExpense
            ->sum('debit_amount');

        // dd($prevTotalIncome, $prevTotalExpense);

        $prevBalance = $prevTotalIncome - $prevTotalExpense;

        return $prevBalance;
    }

    public function getIncomeList()
    {
        $incomeLists = DB::table('tbl_account_transactions')
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            ->where('tbl_account_transactions.approve', 1)
            ->whereBetween('tbl_account_transactions.voucher_date', array($this->filter['fromDate'], $this->filter['toDate']))
            ->where('voucher_type', 'cv')
            ->where('tbl_account_transactions.credit_amount', '>', 0);

        if ($this->filter['sunit']) {
            $incomeLists = $incomeLists->where('tbl_account_transactions.unit_id', $this->filter['sunit']);
        }

        $incomeLists = $incomeLists->get();

        return $incomeLists;
    }

    public function getExpenseList()
    {
        $expenseLists = DB::table('tbl_account_transactions')
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            ->where('tbl_account_transactions.approve', 1)
            ->whereBetween('tbl_account_transactions.voucher_date', array($this->filter['fromDate'], $this->filter['toDate']))
            ->where('voucher_type', 'dv')
            ->where('tbl_account_transactions.debit_amount', '>', 0);

        if ($this->filter['sunit']) {
            $expenseLists = $expenseLists->where('tbl_account_transactions.unit_id', $this->filter['sunit']);
        }

        $expenseLists = $expenseLists
            ->get();

        return $expenseLists;
    }

    public function incomeTable()
    {
        $incomeTable = [];

        $i = 0;
        $prevI = null;
        $previousDate = null;
        $previousHead = null;
        // $previousAmount = 0;

        foreach ($this->incomeList as $income) {

            // array amount sum if date and head is same
            if ($previousDate == $income->voucher_date && $previousHead == $income->head_code) {
                $incomeTable[$prevI]['amount'] += $income->credit_amount;
            } else {
                $incomeTable[$i]['timestamp'] = strtotime($income->voucher_date);
                $incomeTable[$i]['date'] = date('d-m-Y',  strtotime($income->voucher_date));
                $incomeTable[$i]['head'] = $income->head_name;
                $incomeTable[$i]['amount'] = $income->credit_amount;
                $prevI = $i;
                $i++;
            }

            $previousDate = $income->voucher_date;
            $previousHead = $income->head_code;
        }


        // sort array start
        $timestamps = array_column($incomeTable, 'timestamp');
        array_multisort($timestamps, SORT_DESC, $incomeTable);
        // sort array end

        return $incomeTable;
    }

    public function ExpenseTable()
    {
        $expenseTable = [];

        $i = 0;
        $prevI = null;
        $previousDate = null;
        $previousHead = null;

        foreach ($this->ExpenseList as $Expense) {

            // array amount sum if date and head is same
            if ($previousDate == $Expense->voucher_date && $previousHead == $Expense->head_code) {
                $expenseTable[$prevI]['amount'] += $Expense->debit_amount;
            } else {
                $expenseTable[$i]['timestamp'] = strtotime($Expense->voucher_date);
                $expenseTable[$i]['date'] = date('d-m-Y',  strtotime($Expense->voucher_date));
                $expenseTable[$i]['head'] = $Expense->head_name;
                $expenseTable[$i]['amount'] = abs($Expense->debit_amount);
                $prevI = $i;
                $i++;
            }


            $previousDate = $Expense->voucher_date;
            $previousHead = $Expense->head_code;
        }

        // sort array start
        $timestamps = array_column($expenseTable, 'timestamp');
        array_multisort($timestamps, SORT_DESC, $expenseTable);
        // sort array end

        return $expenseTable;
    }


    public function getReport()
    {
        return [
            'prevBalance' => $this->getPrevBalance(),
            'incomeList' => $this->incomeTable(),
            'ExpenseList' => $this->ExpenseTable(),
        ];
    }
}
