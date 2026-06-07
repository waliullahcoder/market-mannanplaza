<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;

use App\UnitSetup;

use App\VoucherApprove;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoucherApproveController extends Controller
{
    public function index(Request $request)
    {
        $title = "Voucher Approves";
        $searchFormLink  = 'voucherApprove.index';
        $print = $request->print;
        $units = UnitSetup::select(['name'])->get();

        if ($print) {

            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
            $Approve_status = $request->Approve_status;



            $voucherLists = DB::table('view_voucher_approve')
                ->orWhere(function ($query) use ($fromDate, $toDate, $Approve_status) {
                    if (!empty($fromDate)) {
                        $query->whereBetween('date', array($fromDate, $toDate));
                    }
                    if ($Approve_status) {

                        if ($Approve_status == 'Pending') {
                            $Approve_status = 0;
                        } else {
                            $Approve_status = 1;
                        }


                        $query->where('approve', $Approve_status);
                    }
                })
                // ->where('showroomId',$this->showroomId)
                ->get();
        } else {
            $voucherLists = DB::table('view_voucher_approve')->where('approve', 0)->get();
            $fromDate = date('01-m-Y');
            $toDate = date('d-m-Y', strtotime(now()));
            $Approve_status = $request->Approve_status;
        }

        return view('admin.voucherApprove.index')->with(compact('title', 'units', 'searchFormLink', 'print', 'Approve_status', 'fromDate', 'toDate', 'voucherLists'));
    }

    public function view($voucherApproveId)
    {
        $title = "View Account Voucher Details";
        $accountTransaction = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.*', 'tbl_coa.head_name as accountHeadName')
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            ->where('tbl_account_transactions.id', $voucherApproveId)
            ->first();

        $voucherType = $accountTransaction->voucher_type;

        $accountTransactionLists = DB::table('tbl_account_transactions')
            ->select('tbl_account_transactions.*', 'tbl_coa.head_name as accountHeadName')
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            // ->where('tbl_account_transactions.showroom_id',$this->showroomId)
            ->where('voucher_no', $accountTransaction->voucher_no)
            ->where('voucher_type', $voucherType)
            ->where(function ($query) use ($voucherType) {
                if ($voucherType == "DV") {
                    $query->where('credit_amount', 0);
                }

                if ($voucherType == "CV") {
                    $query->where('debit_amount', 0);
                }
            })
            ->orderBy('tbl_account_transactions.id', 'asc')
            ->get();

        return view('admin.voucherApprove.view')->with(compact('title', 'accountTransaction', 'accountTransactionLists'));
    }

    public function approve(Request $request)
    {
        $voucherApproveId = $request->voucherApproveId;
        $view = $request->view;

        $userId = Auth::user()->id;

        $accountTransaction = VoucherApprove::find($voucherApproveId);

        if ($accountTransaction->approve == 0) {
            VoucherApprove::where('voucher_no', $accountTransaction->voucher_no)->update(['approve' => 1, 'approve_by' => $userId]);
        } else {
            VoucherApprove::where('voucher_no', $accountTransaction->voucher_no)->update(['approve' => 0, 'approve_by' => $userId]);
        }

        if ($view) {
            return redirect(route('voucherApprove.view', $voucherApproveId));
            // return view('admin.voucherApprove.view')->with(compact('title','accountTransaction','accountTransactionLists'));
        }
    }
}
