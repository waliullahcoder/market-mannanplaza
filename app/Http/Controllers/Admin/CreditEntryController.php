<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;
use Auth;
use App\CoaSetup;
use App\UnitSetup;
use App\CreditEntry;
use App\SetupProject;
use App\ShowroomSetup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreditEntryController extends Controller
{

    public function generateVoucher()
    {
        $i = CreditEntry::count();
        $count = $i > 1 ? $i : 1;

        $voucherCode = 'credit_' . $count;
        return $voucherCode;
    }

    public function index(Request $request)
    {
        $title = "Credit Voucher Entry";
        $searchFormLink  = 'creditEntry.index';
        $printFormLink = "creditEntry.print";
        $print = $request->print;

        $units = UnitSetup::select(['name'])->get();

        if ($print) {

            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
            $sunit = $request->unit;

            $transactionLists = CreditEntry::select('tbl_account_transactions.*', 'view_account.debitHeadname as debitHeadname', 'view_account.creditHeadName as creditHeadName')
                ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->orWhere(function ($query) use ($fromDate, $toDate, $sunit) {
                    if (!empty($fromDate)) {
                        $query->whereBetween('tbl_account_transactions.voucher_date', array($fromDate, $toDate));
                    }

                    if ($sunit) {
                        $query->where('tbl_account_transactions.unit_id', $sunit);
                    }
                })
                ->where('tbl_account_transactions.voucher_type', 'CV')
                ->where('tbl_account_transactions.credit_amount', '0')
                ->groupBY('view_account.voucherNo')
                ->orderBY('view_account.debitHeadname', 'asc')
                ->get();

            // dd($transactionLists);
        } else {
            $transactionLists = CreditEntry::select('tbl_account_transactions.*')
                // ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->where('tbl_account_transactions.voucher_type', 'CV')
                ->where('tbl_account_transactions.credit_amount', '0')
                // ->groupBY('view_account.voucherNo')
                ->orderBY('tbl_account_transactions.id', 'desc')
                ->get();
            $fromDate = date('01-m-Y');
            $toDate = date('d-m-Y', strtotime(now()));
            $sunit = "";
        }

        return view('admin.creditEntry.index')->with(compact('title', 'units', 'sunit', 'searchFormLink', 'printFormLink', 'print', 'fromDate', 'toDate', 'transactionLists'));
    }

    public function print(Request $request)
    {
        $title = "Print Credit Voucher Entry";
        $print = $request->print;

        if ($request->fromDate == "" && $request->toDate == "") {
            $transactionLists = CreditEntry::select('tbl_account_transactions.*', 'view_account.debitHeadname as debitHeadname', 'view_account.creditHeadName as creditHeadName')
                ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->where('tbl_account_transactions.voucher_type', 'CV')
                ->where('tbl_account_transactions.credit_amount', '0')
                ->groupBY('view_account.voucherNo')
                ->orderBY('view_account.debitHeadname', 'asc')
                ->get();
            $fromDate = "";
            $toDate = "";
            $sunit = "";
        } else {
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
            $sunit = $request->sunit;

            $transactionLists = CreditEntry::select('tbl_account_transactions.*', 'view_account.debitHeadname as debitHeadname', 'view_account.creditHeadName as creditHeadName')
                ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->orWhere(function ($query) use ($fromDate, $toDate, $sunit) {
                    if (!empty($fromDate)) {
                        $query->whereBetween('tbl_account_transactions.voucher_date', array($fromDate, $toDate));
                    }

                    if ($sunit) {
                        $query->where('tbl_account_transactions.unit_id', $sunit);
                    }
                })
                ->where('tbl_account_transactions.voucher_type', 'CV')
                ->where('tbl_account_transactions.credit_amount', '0')
                ->groupBY('view_account.voucherNo')
                ->orderBY('view_account.debitHeadname', 'asc')
                ->get();
        }

        $project = SetupProject::findOrFail(1);

        $pdf = PDF::loadView('admin.creditEntry.print', ['project' => $project, 'sunit' => $sunit, 'title' => $title, 'fromDate' => $fromDate, 'toDate' => $toDate, 'print' => $print, 'transactionLists' => $transactionLists], [], ['orientation' => 'P']);
        $pdf->stream('credit_voucher_' . $fromDate . '_' . $toDate . '.pdf');
    }

    public function add()
    {
        $title = "Add Credit Voucher Entry";
        $formLink = "creditEntry.save";
        $buttonName = "Save";
        $voucherCode = $this->generateVoucher();

        $units = UnitSetup::select(['name'])->get();
        $debitCoas = CoaSetup::where('head_code', 'LIKE', '%1020%')->orwhere('head_code', 'LIKE', '%1010%')->where('transaction', '1')->orderBy('head_name', 'asc')->get();
        $coas = CoaSetup::where('transaction', '1')->where(function ($q) {
            $q->where('head_code', 'LIKE', '30%')
                ->orwhere('head_code', 'LIKE', '20%');
        })->orderBy('head_name', 'asc')->get();

        return view('admin.creditEntry.add')->with(compact('title', 'formLink', 'buttonName', 'coas', 'debitCoas', 'voucherCode', 'units'));
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $date = date('Y-m-d', strtotime($request->transactionDate));

        CreditEntry::create([
            'voucher_no' => $request->voucharNo,
            'voucher_type' => "CV",
            'voucher_date' => $date,
            'coa_head_code' => $request->debitAccountHead,
            'narration' => $request->remarks,
            'debit_amount' => $request->totalCredit,
            'credit_amount' => "0",
            'posted' => "I",
            'unit_id' => $request->unit
            // 'created_by' => $this->userId
        ]);

        $countCredit = count($request->credit);
        if ($request->credit) {
            $postData = [];
            for ($i = 0; $i < $countCredit; $i++) {
                $postData[] = [
                    'voucher_no' => $request->voucharNo,
                    'voucher_type' => "CV",
                    'voucher_date' => $date,
                    'coa_head_code' => $request->coa[$i],
                    'narration' => $request->remarks,
                    'debit_amount' => "0",
                    'credit_amount' => $request->credit[$i],
                    'posted' => "I",
                    'unit_id' => $request->unit
                    // 'created_by' => $this->userId
                ];
            }
            CreditEntry::insert($postData);
        }

        return redirect(route('creditEntry.index'))->with('msg', 'Credit Voucher Added Successfully');
    }

    public function edit($creditEntryId)
    {
        $title = "Edit Credit Voucher Entry";
        $formLink = "creditEntry.update";
        $buttonName = "Update";

        $info = $this->findCreditInfo($creditEntryId);
        $creditEntry = $info[0];
        $creditEntries = $info[1];

        $units = UnitSetup::select(['name'])->get();
        $creditCoas = CoaSetup::where('head_code', 'LIKE', '%1020%')->orwhere('head_code', 'LIKE', '%1010%')->where('transaction', '1')->orderBy('head_name', 'asc')->get();
        $coas = CoaSetup::where('transaction', '1')->where(function ($q) {
            $q->where('head_code', 'LIKE', '30%')
                ->orwhere('head_code', 'LIKE', '20%');
        })->orderBy('head_name', 'asc')->get();

        return view('admin.creditEntry.edit')->with(compact('title', 'formLink', 'buttonName', 'creditEntry', 'creditEntries', 'coas', 'creditCoas', 'units'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $date = date('Y-m-d', strtotime($request->transactionDate));

        CreditEntry::where('voucher_no', $request->voucharNo)->delete();

        CreditEntry::create([
            'voucher_no' => $request->voucharNo,
            'voucher_type' => "CV",
            'voucher_date' => $date,
            'coa_head_code' => $request->debitAccountHead,
            'narration' => $request->remarks,
            'debit_amount' => $request->totalCredit,
            'credit_amount' => "0",
            'posted' => "I",
            'created_by' => $request->createdBy,
            'unit_id' => $request->unit
            // 'updated_by' => $this->userId
        ]);

        $countCredit = count($request->credit);
        if ($request->credit) {
            $postData = [];
            for ($i = 0; $i < $countCredit; $i++) {
                $postData[] = [
                    'voucher_no' => $request->voucharNo,
                    'voucher_type' => "CV",
                    'voucher_date' => $date,
                    'coa_head_code' => $request->coa[$i],
                    'narration' => $request->remarks,
                    'debit_amount' => "0",
                    'credit_amount' => $request->credit[$i],
                    'posted' => "I",
                    'created_by' => $request->createdBy,
                    'unit_id' => $request->unit
                    // 'updated_by' => $this->userId
                ];
            }
            CreditEntry::insert($postData);
        }

        return redirect(route('creditEntry.index'))->with('msg', 'Credit Voucher Updated Successfully');
    }

    public function view($creditEntryId)
    {
        $title = "View Credit Voucher Entry";

        $info = $this->findCreditInfo($creditEntryId);
        $creditEntry = $info[0];
        $creditEntries = $info[1];

        return view('admin.creditEntry.view')->with(compact('title', 'creditEntry', 'creditEntries'));
    }

    public function printCreditVoucher($creditEntryId)
    {
        $title = "Print Credit Voucher";

        $info = $this->findCreditInfo($creditEntryId);
        $creditEntry = $info[0];
        $creditEntries = $info[1];
        $project = SetupProject::findOrFail(1);

        // return view('admin.creditEntry.printCreditVoucher', ['title' => $title, 'project' => $project, 'creditEntry' => $creditEntry, 'creditEntries' => $creditEntries], [], ['orientation' => 'P']);
        $pdf = PDF::loadView('admin.creditEntry.printCreditVoucher', ['title' => $title, 'project' => $project, 'creditEntry' => $creditEntry, 'creditEntries' => $creditEntries], [], ['orientation' => 'P']);
        $pdf->stream('credit_voucher_' . $creditEntry->voucher_no . '.pdf');
    }

    public function findCreditInfo($creditEntryId)
    {
        $creditEntry = CreditEntry::select('tbl_account_transactions.*', 'tbl_coa.head_name as creditHeadName')
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            ->where('tbl_account_transactions.id', $creditEntryId)
            ->first();

        $creditEntries = CreditEntry::select('tbl_account_transactions.*', 'tbl_coa.head_name as creditHeadName', 'tbl_coa.head_code as creditHeadCode')
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            ->where('voucher_no', $creditEntry->voucher_no)
            ->where('debit_amount', '0')
            ->get();

        return array($creditEntry, $creditEntries);
    }

    public function changePublish(Request $request)
    {
        $creditEntryId = $request->creditEntryId;

        $creditEntry = CreditEntry::find($creditEntryId);

        if ($creditEntry->active == 0) {
            CreditEntry::where('voucher_no', $creditEntry->voucher_no)->update(['active' => 1]);
        } else {
            CreditEntry::where('voucher_no', $creditEntry->voucher_no)->update(['active' => 0]);
        }
    }

    public function delete(Request $request)
    {
        $creditEntry = CreditEntry::find($request->creditEntryId);

        CreditEntry::where('voucher_no', $creditEntry->voucher_no)->delete();
    }

    public function getVoucharNo(Request $request)
    {
        $showroomId = 1;

        // $showroomPrefix = ShowroomSetup::where('id',$showroomId)->first();

        $str = "CV-" . $showroomId . "-";

        $serialNo = CreditEntry::where('voucher_type', 'CV')->where('voucher_no', 'LIKE', '%' . $str . '%')->max('voucher_no');

        if ($serialNo) {
            $serialNo = substr($serialNo, strlen($str));
            $voucherNo = $str . ($serialNo + 1);
        } else {
            $voucherNo = $str . "1000000001";
        }


        echo $voucherNo;
    }

    public function getCoa(Request $request)
    {
        $output = '';
        $total = $request->total;

        $coas = CoaSetup::where('transaction', '1')->orderBy('head_name', 'asc')->get();

        if ($coas) {
            $output .= '<select class="chosen-select form-control coa coa_' . $total . '" id="coa" name="coa[]">';
            $output .= '<option value="">Select Account Name</option>';
            foreach ($coas as $coas) {
                $output .= '<option value="' . $coas->head_code . '">' . $coas->head_name . '</option>';
            }
            $output .= '</select>';
        } else {
            $output .= '<select class="chosen-select form-control coa coa_' . $total . '" id="coa" name="coa[]">';
            $output .= '<option value="">Select Account Name</option>';
            $output .= '</select>';
        }

        echo $output;
    }
}
