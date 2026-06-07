<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;

use Auth;
use App\UnitSetup;
use App\SetupProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoucherListController extends Controller
{
    public function index(Request $request)
    {
        $title = "Voucher List";
        $searchFormLink = "voucherList.index";
        $printFormLink = "voucherList.print";
        $print = $request->print;
        $units = UnitSetup::select(['name'])->get();
        $sunit = $request->unit;

        if ($print) {
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));

            $voucherLists = DB::table('view_voucher_approve')
                ->orWhere(function ($query) use ($fromDate, $toDate) {
                    if (!empty($fromDate)) {
                        $query->whereBetween('date', array($fromDate, $toDate));
                    }
                })
                // ->where('showroomId',$this->showroomId)
                ->where('approve', '1')
                ->get();
        } else {
            $voucherLists = DB::table('view_voucher_approve')
                ->where('approve', '1')->get();
            $fromDate = date('01-m-Y');
            $toDate = date('d-m-Y', strtotime(now()));
        }

        return view('admin.voucherList.index')->with(compact('title', 'units', 'sunit', 'searchFormLink', 'printFormLink', 'print', 'fromDate', 'toDate', 'voucherLists'));
    }

    public function print(Request $request)
    {
        $title = "Voucher List";
        $print = $request->print;

        if ($request->fromDate != "" && $request->toDate != "") {
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
            $unit = $request->unit;

            $voucherLists = DB::table('view_voucher_approve')
                ->orWhere(function ($query) use ($fromDate, $toDate, $unit) {
                    if (!empty($fromDate)) {
                        $query->whereBetween('date', array($fromDate, $toDate));
                    }

                    if ($unit) {
                        $query->where('unit_id', $unit);
                    }
                })
                // ->where('showroomId',$this->showroomId)
                ->where('approve', '1')
                ->get();
        } else {
            $voucherLists = DB::table('view_voucher_approve')
                // ->where('showroomId',$this->showroomId)
                ->where('approve', '1')->get();
            $fromDate = "";
            $toDate = "";
        }

        $project = SetupProject::findOrFail(1);

        $pdf = PDF::loadView('admin.voucherList.print', ['title' => $title, 'unit' => $unit, 'project' => $project, 'fromDate' => $fromDate, 'toDate' => $toDate, 'print' => $print, 'voucherLists' => $voucherLists], [], ['orientation' => 'P']);
        return $pdf->stream('voucher_list_' . $fromDate . '_' . $toDate . '.pdf');
    }
}
