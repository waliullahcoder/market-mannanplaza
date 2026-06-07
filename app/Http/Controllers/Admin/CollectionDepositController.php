<?php

namespace App\Http\Controllers\Admin;

use App\CoaSetup;
use App\UnitSetup;
use App\FloorSetup;
use App\CreditEntry;
use App\SetupProject;
use App\RentCollection;
use App\EbillCollection;
use App\PositionInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\ServiceChargeCollection;
use App\Http\Controllers\Controller;
use App\Helper\RepeatedData\MonthList;
use App\Helper\Report\CollectionStatusReport;

class CollectionDepositController extends Controller
{
    public function index(Request $request)
    {

        $title = "Collection Deposit";
        $project = SetupProject::findOrFail(1);
        $banks = CoaSetup::where('head_code', '1010101')->get();
        $cashs = CoaSetup::where('parent_head_name', 'Cash In Hand')->orderBy('head_name', 'asc')->get();
        $units = UnitSetup::select(['name'])->get();
        $coaHeads = [
            'banks' => $banks,
            'cashs' => $cashs,
        ];

        $defaultDates = [
            'start_date' => Carbon::now()->startOfMonth()->format('d-m-Y'),
            'end_date' => Carbon::now()->endOfMonth()->format('d-m-Y'),
        ];

        $data = [];

        if ($request->searched) {
            $start_date = date("Y-m-d", strtotime($request->start_date));
            $end_date = date("Y-m-d", strtotime($request->end_date));
            $sunit = $request->unit;

            $clients =  PositionInformation::where('status', 1)->select(['id', 'Name', 'Code', 'Unit', 'Floor']);

            if ($sunit) {
                $clients = $clients->where('Unit', $sunit);
            }
            $clients = $clients->get();
            foreach ($clients as $client) {

                if ($request->bill_type == null) {
                    $billsType = ['Rent', 'Utility', 'EBill'];
                } else {
                    $billsType = [$request->bill_type];
                }

                // rent start
                if (in_array('Rent', $billsType)) {

                    $total_rents = RentCollection::where('Client_Code', $client->Code)
                        ->whereNull('deposit_date')
                        ->where(function ($q) use ($start_date, $end_date) {
                            $q->where('ReceiveDate', '>=', $start_date . ' 00:00:00')
                                ->where('ReceiveDate', '<=', $end_date . ' 23:59:59');
                        })
                        ->get();

                    foreach ($total_rents as $total_rent) {

                        $ld = [
                            'client' => $client,
                            'bill_type' => "Rent",
                            'bill_info' => $total_rent,
                        ];

                        array_push($data, $ld);
                    }
                }
                // rent end

                // ebill start
                if (in_array('EBill', $billsType)) {

                    $total_eBills = EbillCollection::where('Client_Code', $client->Code)
                        ->whereNull('deposit_date')
                        ->where(function ($q) use ($start_date, $end_date) {
                            $q->where('ReceiveDate', '>=', $start_date . ' 00:00:00')
                                ->where('ReceiveDate', '<=', $end_date . ' 23:59:59');
                        })
                        ->get();

                    foreach ($total_eBills as $total_eBill) {

                        $ld = [
                            'client' => $client,
                            'bill_type' => "EBill",
                            'bill_info' => $total_eBill,
                        ];

                        array_push($data, $ld);
                    }
                }
                // ebill end

                // utility start
                if (in_array('Utility', $billsType)) {

                    $total_serviceBills = ServiceChargeCollection::where('Client_Code', $client->Code)
                        ->whereNull('deposit_date')
                        ->where(function ($q) use ($start_date, $end_date) {
                            $q->where('ReceiveDate', '>=', $start_date . ' 00:00:00')
                                ->where('ReceiveDate', '<=', $end_date . ' 23:59:59');
                        })
                        ->get();

                    foreach ($total_serviceBills as $total_serviceBill) {

                        $ld = [
                            'client' => $client,
                            'bill_type' => "Utility",
                            'bill_info' => $total_serviceBill,
                        ];

                        array_push($data, $ld);
                    }
                }
                // utility end
            }
        }

        return view('admin.collectionDeposit.index', compact('title', 'project', 'coaHeads', 'units', 'data', 'defaultDates'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'type' => 'required',
            'unit' => 'required',
        ]);

        $voucherNo = 'autocoll-' . (string)(CreditEntry::count() + 1);
        $date = date('Y-m-d', strtotime($request->date));

        $rentTotal = 0;
        $ebillTotal = 0;
        $utilityTotal = 0;
        $TotalAll = 0;

        // save rent start
        if (array_key_exists("Rent", $request->bills)) {
            foreach ($request->bills['Rent'] as $bill => $value) {
                $rent = RentCollection::find($bill);
                $rent->update([
                    'deposit_date' => $date,
                    'type' => $request->type,
                    'remarks' => $request->remarks,
                    'cash' => $request->cash,
                    'bank' => $request->bank,
                ]);
                $ebillTotal += $rent->Amount + $rent->penalty;
            }

            CreditEntry::insert([
                'voucher_no' => $voucherNo,
                'voucher_type' => "CV",
                'voucher_date' => $date,
                'coa_head_code' => 30101,
                'narration' => $request->remarks,
                'debit_amount' => "0",
                'credit_amount' => $rentTotal,
                'posted' => "I",
                'unit_id' => $request->unit,
                'approve' => 1,
            ]);
        }
        // save rent end

        // save EBill start
        if (array_key_exists("EBill", $request->bills)) {
            foreach ($request->bills['EBill'] as $bill => $value) {
                $ebill = EbillCollection::find($bill);
                $ebill->update([
                    'deposit_date' => $date,
                    'type' => $request->type,
                    'remarks' => $request->remarks,
                    'cash' => $request->cash,
                    'bank' => $request->bank,
                ]);
                $ebillTotal += $ebill->Amount + $ebill->penalty;
            }

            CreditEntry::insert([
                'voucher_no' => $voucherNo,
                'voucher_type' => "CV",
                'voucher_date' => $date,
                'coa_head_code' => 30102,
                'narration' => $request->remarks,
                'debit_amount' => "0",
                'credit_amount' => $ebillTotal,
                'posted' => "I",
                'unit_id' => $request->unit,
                'approve' => 1,
            ]);
        }
        // save EBill end

        // save Utility start
        if (array_key_exists("Utility", $request->bills)) {
            foreach ($request->bills['Utility'] as $bill => $value) {

                $utility = ServiceChargeCollection::find($bill);

                $utility->update([
                    'deposit_date' => $date,
                    'type' => $request->type,
                    'remarks' => $request->remarks,
                    'cash' => $request->cash,
                    'bank' => $request->bank,
                ]);

                $utilityTotal += $utility->Amount;
            }

            CreditEntry::insert([
                'voucher_no' => $voucherNo,
                'voucher_type' => "CV",
                'voucher_date' => $date,
                'coa_head_code' => 30103,
                'narration' => $request->remarks,
                'debit_amount' => "0",
                'credit_amount' => $utilityTotal,
                'posted' => "I",
                'unit_id' => $request->unit,
                'approve' => 1,
            ]);
        }
        // save Utility end

        $TotalAll = $rentTotal + $ebillTotal + $utilityTotal;

        // debit entry start
        $debitHeads = [
            'Cash' => $request->cash,
            'Bank' => $request->bank,
        ];

        CreditEntry::create([
            'voucher_no' => $voucherNo,
            'voucher_type' => "CV",
            'voucher_date' => $date,
            'coa_head_code' => $debitHeads[$request->type],
            'narration' => $request->remarks,
            'debit_amount' => $TotalAll,
            'credit_amount' => "0",
            'posted' => "I",
            'unit_id' => $request->unit,
            'approve' => 1,
            // 'created_by' => $this->userId
        ]);
        // debit entry end

        return back();
    }

    public function report(Request $request)
    {
        $title = "Collection Status Report";
        $project = SetupProject::findOrFail(1);
        $units = UnitSetup::all();
        $floors = FloorSetup::all();
        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();
        $months = MonthList::getAll();


        $report = [];

        if ($request->searched_details) {

            $filter = [
                'client_code' => $request->client_code,
                'unit' => $request->unit,
                'floor' => $request->floor,
                'month' => $request->month,
                'year' => $request->year,
            ];


            $collectionStatusReport = new CollectionStatusReport($filter);
            $report = $collectionStatusReport->getDetailsReport();
        }

        if ($request->searched_summary) {

            $request->validate([
                'unit' => 'required',
            ]);

            $filter = [
                'client_code' => $request->client_code,
                'unit' => $request->unit,
                'floor' => $request->floor,
                'month' => $request->month,
                'year' => $request->year,
            ];


            $collectionStatusReport = new CollectionStatusReport($filter);
            $report = $collectionStatusReport->getSummaryReport();

            // dd($report);

        }

        return view('admin.deposit_report.deposit_report', compact(['title', 'months', 'tenants', 'units', 'floors', 'project', 'report']));
    }
}
