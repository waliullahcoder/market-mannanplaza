<?php

namespace App\Http\Controllers\Admin;

use App\CoaSetup;
use App\CreditEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TrialBalance;
use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class BalanceSheetController extends Controller
{
    public function index(Request $request)
    {
        $title = "Balance Sheet";
        $searchFormLink = "balanceSheet.index";
        $printFormLink = "balanceSheet.print";
        $print = $request->print;

        // $head_codes = CoaSetup::where('head_code', 'like', '301%')->where('head_code', '!=', '301')->pluck('head_code')->toArray();
        // CreditEntry::whereIn('coa_head_code', $head_codes)->where('approve', 1)->sum('credit_amount');
        // CreditEntry::query()->delete();

        $assets = $this->assets('Assets');
        $liabilities = $this->assets('Liabilities');
        $currentPFL = $this->profitLoss();
        $data = [
            'assets' => $assets,
            'liabilities' => $liabilities,
            'currentPFL' => $currentPFL,
        ];

        if (!is_null($request->print)) {
            $report_title = 'Balance Sheet';
            $pdf = Pdf::loadView('admin.balanceSheet.print', compact('report_title', 'data'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream('balance_sheet_' . date('d_m_Y_h_i_s') . '.pdf');
        }

        $title = 'Balance Sheet';
        $coas = CoaSetup::where('general_ledger', 1)->orderBy('head_name', 'asc')->get();
        $disable_form = true;
        return view('admin.balanceSheet.index', compact('title', 'coas', 'data', 'searchFormLink', 'printFormLink', 'disable_form'));
    }

    public function assets($parent_head)
    {
        $parents = CoaSetup::where('parent_head_name', $parent_head)->orderBy('head_name', 'asc')->get();

        $info = [];
        foreach ($parents as $parent) {
            $childs = CoaSetup::select('head_name', 'head_code', 'id')
                ->where('parent_head_name', $parent->head_name)
                ->get();
            $childInfo = [];
            foreach ($childs as $child) {
                $childInfo[] = [
                    'id' => $child->id,
                    'headCode' => $child->head_code,
                    'headName' => $parent->head_name,
                    'name' => $child->head_name,
                    'amount' => $this->getAmount($child->head_code)
                ];
            }

            $info[] = [
                'id' => $parent->id,
                'headCode' => $parent->head_code,
                'head' => $parent->head_name,
                'childs' => $childInfo
            ];
        }
        return $info;
    }

    public function getAmount($headCode)
    {
        $balance = 0;
        $headReports = TrialBalance::select('*')
            ->where('coa_head_code', 'LIKE', $headCode . '%')
            ->get();

        foreach ($headReports as $headReport) {
            if ($headReport->head_type == 'I' || $headReport->head_type == 'L') {
                $balance += $headReport->credit_amount - $headReport->debit_amount;
            } else {
                $balance += $headReport->debit_amount - $headReport->credit_amount;
            }
        }
        return $balance;
    }

    private function profitLoss()
    {
        $totalIncome = TrialBalance::where('head_type', 'I')->sum(DB::raw('credit_amount - debit_amount'));
        $totalExpanse = trialBalance::where('head_type', 'E')->sum(DB::raw('debit_amount - credit_amount'));
        return $totalIncome - $totalExpanse;
    }
}
