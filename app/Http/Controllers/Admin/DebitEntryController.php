<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;
use Auth;
use App\CoaSetup;
use App\UnitSetup;
use App\DebitEntry;
use App\SetupProject;
use App\ShowroomSetup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DebitEntryController extends Controller
{
    public function generateVoucher()
    {
        $i = DebitEntry::count();
        $count = $i > 1 ? $i : 1;
        $voucherCode = 'debit_' . $count;
        return $voucherCode;
    }

    public function index(Request $request)
    {
        $title = "Debit Voucher Entry";
        $searchFormLink  = 'debitEntry.index';
        $printFormLink = "debitEntry.print";
        $print = $request->print;
        $units = UnitSetup::select(['name'])->get();

        if ($print) {
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
            $sunit = $request->unit;

            $transactionLists = DebitEntry::select('tbl_account_transactions.*', 'view_account.debitHeadname as debitHeadname', 'view_account.creditHeadName as creditHeadName')
                ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->orWhere(function ($query) use ($fromDate, $toDate, $sunit) {
                    if (!empty($fromDate)) {
                        $query->whereBetween('tbl_account_transactions.voucher_date', array($fromDate, $toDate));
                    }

                    if ($sunit) {
                        $query->where('unit_id', $sunit);
                    }
                })
                ->where('tbl_account_transactions.voucher_type', 'DV')
                ->where('tbl_account_transactions.debit_amount', '0')
                ->groupBY('view_account.voucherNo')
                ->orderBY('view_account.debitHeadname', 'asc')
                ->get();
        } else {
            $transactionLists = DebitEntry::select('tbl_account_transactions.*')
                // ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->where('tbl_account_transactions.voucher_type', 'DV')
                ->where('tbl_account_transactions.debit_amount', '0')
                ->orderBY('tbl_account_transactions.id', 'desc')
                // ->groupBY('view_account.voucherNo')
                // ->orderBY('view_account.debitHeadname', 'asc')
                ->get();
            $fromDate = date('01-m-Y');
            $toDate = date('d-m-Y', strtotime(now()));
            $sunit = "";
        }

        return view('admin.debitEntry.index')->with(compact('title', 'searchFormLink', 'printFormLink', 'sunit', 'print', 'fromDate', 'toDate', 'transactionLists', 'units'));
    }

    public function print(Request $request)
    {
        $title = "Print Debit Voucher Entry";
        $print = $request->print;
        $project = SetupProject::findOrFail(1);
        $sunit = $request->sunit;

        if ($request->fromDate == "" && $request->toDate == "") {
            $transactionLists = DebitEntry::select('tbl_account_transactions.*', 'view_account.debitHeadname as debitHeadname', 'view_account.creditHeadName as creditHeadName')
                ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
                ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->where('tbl_account_transactions.voucher_type', 'DV')
                ->where('tbl_account_transactions.debit_amount', '0')
                ->groupBY('view_account.voucherNo')
                ->orderBY('view_account.debitHeadname', 'asc')
                ->get();
            $fromDate = "";
            $toDate = "";
        } else {
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));

            $transactionLists = DebitEntry::select('tbl_account_transactions.*', 'view_account.debitHeadname as debitHeadname', 'view_account.creditHeadName as creditHeadName')
                ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
                ->orWhere(function ($query) use ($fromDate, $toDate, $sunit) {
                    if (!empty($fromDate)) {
                        $query->whereBetween('tbl_account_transactions.voucher_date', array($fromDate, $toDate));
                    }

                    if ($sunit) {
                        $query->where('unit_id', $sunit);
                    }
                })
                ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->where('tbl_account_transactions.voucher_type', 'DV')
                ->where('tbl_account_transactions.debit_amount', '0')
                ->groupBY('view_account.voucherNo')
                ->orderBY('view_account.debitHeadname', 'asc')
                ->get();
        }

        $pdf = PDF::loadView('admin.debitEntry.print', ['project' => $project, 'sunit' => $sunit, 'title' => $title, 'fromDate' => $fromDate, 'toDate' => $toDate, 'print' => $print, 'transactionLists' => $transactionLists], [], ['orientation' => 'P']);
        $pdf->stream('debit_voucher_' . $fromDate . '_' . $toDate . '.pdf');
    }

    public function add()
    {
        $title = "Add Debit Voucher Entry";
        $formLink = "debitEntry.save";
        $buttonName = "Save";
        $voucherCode = $this->generateVoucher();
        $units = UnitSetup::select(['name'])->get();

        // $showrooms = ShowroomSetup::where('status','1')->get();
        $creditCoas = CoaSetup::where('head_code', 'LIKE', '%1020%')->orwhere('head_code', 'LIKE', '%1010%')->where('transaction', '1')->orderBy('head_name', 'asc')->get();

        $coas = CoaSetup::where('transaction', '1')->where(function ($q) {
            $q->where('head_code', 'LIKE', '40%')
                ->orwhere('head_code', 'LIKE', '10%');
        })->orderBy('head_name', 'asc')->get();

        return view('admin.debitEntry.add')->with(compact('title', 'formLink', 'buttonName', 'coas', 'creditCoas', 'voucherCode', 'units'));
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $date = date('Y-m-d', strtotime($request->transactionDate));

        $debit = DebitEntry::create([
            'voucher_no' => $request->voucharNo,
            'voucher_type' => "DV",
            'voucher_date' => $date,
            'coa_head_code' => $request->creditAccountHead,
            'narration' => $request->remarks,
            'debit_amount' => "0",
            'credit_amount' => $request->totalDebit,
            'posted' => "I",
            'unit_id' => $request->unit,
        ]);


        $countDebit = count($request->debit);
        if ($request->debit) {
            $postData = [];
            for ($i = 0; $i < $countDebit; $i++) {
                $postData[] = [
                    'voucher_no' => $request->voucharNo,
                    'voucher_type' => "DV",
                    'voucher_date' => $date,
                    'coa_head_code' => $request->coa[$i],
                    'narration' => $request->remarks,
                    'debit_amount' => $request->debit[$i],
                    'credit_amount' => "0",
                    'posted' => "I",
                    'unit_id' => $request->unit
                    // 'created_by' => $this->userId
                ];
            }
            DebitEntry::insert($postData);
        }

        return redirect(route('debitEntry.index'))->with('msg', 'Debit Voucher Added Successfully');
    }

    public function edit($debitEntryId)
    {
        $title = "Edit Debit Voucher Entry";
        $formLink = "debitEntry.update";
        $buttonName = "Update";

        $info = $this->findDebitInfo($debitEntryId);

        $debitEntry = $info[0];
        $debitEntries = $info[1];

        $units = UnitSetup::select(['name'])->get();
        $creditCoas = CoaSetup::where('head_code', 'LIKE', '%1020%')->orwhere('head_code', 'LIKE', '%1010%')->where('transaction', '1')->orderBy('head_name', 'asc')->get();
        $coas = CoaSetup::where('transaction', '1')->where(function ($q) {
            $q->where('head_code', 'LIKE', '40%')
                ->orwhere('head_code', 'LIKE', '10%');
        })->orderBy('head_name', 'asc')->get();

        return view('admin.debitEntry.edit')->with(compact('title', 'formLink', 'buttonName', 'debitEntry', 'debitEntries', 'coas', 'creditCoas', 'units'));
    }

    public function update(Request $request)
    {
        DB::transaction(function () use ($request) {
            $date = date('Y-m-d', strtotime($request->transactionDate));
            DebitEntry::where('voucher_no', $request->voucharNo)->where('voucher_type', 'DV')->delete();

            DebitEntry::create([
                'voucher_no' => $request->voucharNo,
                'voucher_type' => "DV",
                'voucher_date' => $date,
                'coa_head_code' => $request->creditAccountHead,
                'narration' => $request->remarks,
                'debit_amount' => "0",
                'credit_amount' => $request->totalDebit,
                'posted' => "I",
                // 'created_by' => $request->createdBy,
                'unit_id' => $request->unit
                // 'updated_by' => $this->userId
            ]);

            $countDebit = count($request->debit);
            if ($request->debit) {
                $postData = [];
                for ($i = 0; $i < $countDebit; $i++) {
                    $postData[] = [
                        'voucher_no' => $request->voucharNo,
                        'voucher_type' => "DV",
                        'voucher_date' => $date,
                        'coa_head_code' => $request->coa[$i],
                        'narration' => $request->remarks,
                        'debit_amount' => $request->debit[$i],
                        'credit_amount' => "0",
                        'posted' => "I",
                        // 'created_by' => $request->createdBy,
                        'unit_id' => $request->unit
                        // 'updated_by' => $this->userId
                    ];
                }
                DebitEntry::insert($postData);
            }
        });

        return redirect(route('debitEntry.index'))->with('msg', 'Debit Voucher Updated Successfully');
    }

    public function view($debitEntryId)
    {
        $title = "View Debit Voucher Entry";

        $info = $this->findDebitInfo($debitEntryId);
        $debitEntry = $info[0];
        $debitEntries = $info[1];

        return view('admin.debitEntry.view')->with(compact('title', 'debitEntry', 'debitEntries'));
    }

    public function printDebitVoucher($debitEntryId)
    {
        $title = "Print Debit Voucher";

        $info = $this->findDebitInfo($debitEntryId);
        $debitEntry = $info[0];
        $debitEntries = $info[1];
        $project = SetupProject::findOrFail(1);

        // return view('admin.debitEntry.printDebitVoucher', ['title' => $title, 'project' => $project, 'debitEntry' => $debitEntry, 'debitEntries' => $debitEntries], [], ['orientation' => 'P']);
        $pdf = PDF::loadView('admin.debitEntry.printDebitVoucher', ['title' => $title, 'project' => $project, 'debitEntry' => $debitEntry, 'debitEntries' => $debitEntries], [], ['orientation' => 'P']);
        return $pdf->stream('debit_voucher_' . $debitEntry->voucher_no . '.pdf');
    }

    public function findDebitInfo($debitEntryId)
    {
        $debitEntry = DebitEntry::select('tbl_account_transactions.*')
            ->where('voucher_type', 'DV')
            ->where('tbl_account_transactions.id', $debitEntryId)
            ->first();

        $debitEntries = DebitEntry::with('coa')->select('tbl_account_transactions.*')
            ->where('voucher_no', $debitEntry->voucher_no)
            ->where('voucher_type', 'DV')
            ->where('debit_amount', '>', 0)
            ->get();

        return array($debitEntry, $debitEntries);
    }

    public function changePublish(Request $request)
    {
        $debitEntryId = $request->debitEntryId;

        $debitEntry = DebitEntry::find($debitEntryId);

        if ($debitEntry->active == 0) {
            DebitEntry::where('voucher_no', $debitEntry->voucher_no)->update(['active' => 1]);
        } else {
            DebitEntry::where('voucher_no', $debitEntry->voucher_no)->update(['active' => 0]);
        }
    }

    public function delete(Request $request)
    {
        $debitEntry = DebitEntry::find($request->debitEntryId);

        DebitEntry::where('voucher_no', $debitEntry->voucher_no)->delete();
    }

    public function getVoucharNo(Request $request)
    {
        $showroomId = $request->showroomId;

        $showroomPrefix = ShowroomSetup::where('id', $showroomId)->first();

        $str = "DV-" . $showroomPrefix->prefix . "-";

        $serialNo = DebitEntry::where('voucher_type', 'DV')->where('voucher_no', 'LIKE', '%' . $str . '%')->max('voucher_no');

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
            $output .= '<select class="select2 form-control coa coa_' . $total . '" id="coa" name="coa[]">';
            $output .= '<option value="">Select Account Name</option>';
            foreach ($coas as $coas) {
                $output .= '<option value="' . $coas->head_code . '">' . $coas->head_name . '</option>';
            }
            $output .= '</select>';
        } else {
            $output .= '<select class="select2 form-control coa coa_' . $total . '" id="coa" name="coa[]">';
            $output .= '<option value="">Select Account Name</option>';
            $output .= '</select>';
        }

        echo $output;
    }
}
