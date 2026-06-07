<?php

namespace App\Http\Controllers\admin;

use DB;
use App\UnitSetup;
use App\FloorSetup;
use App\SetupProject;
use App\RentCollection;
use App\EbillCollection;
use App\WbillCollection;
use App\PositionInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\ServiceChargeCollection;
use App\Http\Controllers\Controller;
use App\Helper\RepeatedData\MonthList;

class CollectionReportController extends Controller
{
    public function CollectionReport(Request $request)
    {
        $title = "Collection Report";
        $project = '';
        $bills = [];
        $ClientWisebills = [];

        $date = null;
        $from_date = '';
        $to_date = '';

        $fromDate = date('d-m-Y', strtotime(now()));
        $toDate = date('d-m-Y', strtotime(now()));

        $sunit = null;
        $sfloor = null;

        $data = (object)[
            'floors' => FloorSetup::select(['name'])->get(),
            'units' => UnitSetup::select(['name'])->get(),
        ];
        $months = MonthList::getAll();

        if ($request->searched) {

            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));

            $fromDate = date('d-m-Y', strtotime($request->from_date));
            $toDate = date('d-m-Y', strtotime($request->to_date));

            $sunit = $request->unit;
            $sfloor = $request->floor;
            $smonth = $request->CMonth;
            $syear = $request->CYear;
            if($smonth && $syear){
                $date = date('Y-m-d', strtotime('01-' . $smonth . '-' . $syear));
            }
            
            $project = SetupProject::findOrFail(1);

            $clients = PositionInformation::where('status', 1);

            if (isset($request->unit)) {
                $clients = $clients->where('Unit', $request->unit);
            }

            if (isset($request->floor)) {
                $clients = $clients->where('Floor', $request->floor);
            }

            $clients = $clients->select(['id', 'Name', 'Code'])
                ->orderBy('Unit')
                ->orderBy('Floor')
                ->orderBy('PositionNo')
                ->get();

            foreach ($clients as $client) {
                $ClientWisebills[$client->id] = [
                    'client_name' => $client->Name,
                    'client_code' => $client->Code,
                    'total_rent' => RentCollection::when($date, function ($query, $date) { return $query->where('billing_month', $date);})->where('Client_Code', $client->Code)->whereBetween('ReceiveDate', [$from_date, $to_date])->sum(DB::raw('COALESCE(Amount,0) + COALESCE(penalty,0)')),
                    'rent_collection_date' => RentCollection::when($date, function ($query, $date) { return $query->where('billing_month', $date);})->where('Client_Code', $client->Code)->whereBetween('ReceiveDate', [$from_date, $to_date])->orderBy('id', 'desc')->first(),
                    'total_ebill' => EbillCollection::when($date, function ($query, $date) { return $query->where('billing_month', $date);})->where('Client_Code', $client->Code)->whereBetween('ReceiveDate', [$from_date, $to_date])->sum(DB::raw('COALESCE(Amount,0) + COALESCE(penalty,0)')),
                    'ebill_collection_date' => EbillCollection::when($date, function ($query, $date) { return $query->where('billing_month', $date);})->where('Client_Code', $client->Code)->whereBetween('ReceiveDate', [$from_date, $to_date])->orderBy('id', 'desc')->first(),
                    'total_sbill' => ServiceChargeCollection::when($date, function ($query, $date) { return $query->where('billing_month', $date);})->where('Client_Code', $client->Code)->whereBetween('ReceiveDate', [$from_date, $to_date])->sum(DB::raw('COALESCE(Amount,0) + COALESCE(penalty,0)')),
                    'sbill_collection_date' => ServiceChargeCollection::when($date, function ($query, $date) { return $query->where('billing_month', $date);})->where('Client_Code', $client->Code)->whereBetween('ReceiveDate', [$from_date, $to_date])->orderBy('id', 'desc')->first(),
                ];
            }
        }

        return view('admin.collection_report.collection.collection', compact(['fromDate', 'toDate', 'title', 'sunit', 'sfloor', 'project', 'data', 'date', 'from_date', 'to_date', 'ClientWisebills', 'months']));
    }

    public function CollectionSummaryReport(Request $request)
    {
        $title = "Collection Demand Report";
        $project = '';
        $bills = [];
        $group_floors = [];
        $ClientWisebills = [];

        $smonth = null;
        $syear = null;

        $units = UnitSetup::all();
        $floors = FloorSetup::all();
        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();
        $months = MonthList::getAll();

        if ($request->searched) {
            $project = SetupProject::findOrFail(1);

            $query =  PositionInformation::where('status', 1)->select(['id', 'Name', 'Code', 'Unit', 'Floor']);
            if ($request->unit) {
                $query->where('Unit', $request->unit);
            }
            if ($request->floor) {
                $query->where('Floor', $request->floor);
            }
            if ($request->client_code) {
                $query->where('Code', $request->client_code);
            }
            $clients = $query->orderBy('Unit')
                ->orderBy('Floor')
                ->orderBy('PositionNo')
                ->get();

            $query =  PositionInformation::where('status', 1)->select(['id', 'Name', 'Code', 'Unit', 'Floor']);
            if ($request->unit) {
                $query->where('Unit', $request->unit);
            }
            if ($request->floor) {
                $query->where('Floor', $request->floor);
            }
            if ($request->client_code) {
                $query->where('Code', $request->client_code);
            }
            $group_floors = $query->groupBy('Unit')->groupBy('Floor')->get();

            $smonth = $request->CMonth;
            $syear = $request->CYear;
            $unit = $request->unit;
            $floor = $request->floor;

            $date = date('Y-m-d', strtotime('01-' . $smonth . '-' . $syear));
            $previousDate = date('Y-m-d', strtotime($date . '-1 month'));
            $carbonMonth = Carbon::parse($smonth)->format('m');
            $previousDate = Carbon::createFromDate($syear, $carbonMonth, 1)->subMonth()->format('Y-m-d');
            $previousMonth = Carbon::createFromDate($syear, $carbonMonth, 1)->subMonth()->format('F');
            $previousYear = Carbon::createFromDate($syear, $carbonMonth, 1)->subMonth()->format('Y');

            foreach ($clients as $client) {
                $total_bill = 0;
                $total_collection = 0;

                $prev_rent = RentCollection::where('Client_Code', $client->Code)
                    ->whereDate('billing_month', '<=', $previousDate)
                    ->where(function ($q) {
                        $q->where('ReceiveDate', '<=', '2010-01-01 00:00:00')
                            ->orWhereNull('ReceiveDate');
                    })
                    ->sum('Amount');

                $c_rent = RentCollection::where('Client_Code', $client->Code)
                    ->where('CMonth', $request->CMonth)
                    ->where('CYear', $syear)
                    ->first();

                $prev_eBill = EbillCollection::where('Client_Code', $client->Code)
                    ->whereDate('billing_month', '<', $previousDate)
                    ->where(function ($q) {
                        $q->where('ReceiveDate', '<=', '2010-01-01 00:00:00')
                            ->orWhereNull('ReceiveDate');
                    })
                    ->sum('Amount');

                $c_eBill = EbillCollection::where('Client_Code', $client->Code)
                    ->where('CMonth', $previousMonth)
                    ->where('CYear', $previousYear)
                    ->first();

                $prev_serviceBill = ServiceChargeCollection::where('Client_Code', $client->Code)
                    ->whereDate('billing_month', '<', $previousDate)
                    ->where(function ($q) {
                        $q->where('ReceiveDate', '<=', '2010-01-01 00:00:00')
                            ->orWhereNull('ReceiveDate');
                    })
                    ->sum('Amount');

                $c_serviceBill = ServiceChargeCollection::where('Client_Code', $client->Code)
                    ->where('CMonth', $previousMonth)
                    ->where('CYear', $previousYear)
                    ->first();

                $total_bill = (@$c_rent->Amount ?? 0) + (@$c_eBill->Amount ?? 0) + (@$c_serviceBill->Amount ?? 0) + $prev_rent + $prev_eBill + $prev_serviceBill;

                if (!is_null(@$c_rent->ReceiveDate)) {
                    $total_collection += @$c_rent->Amount;
                }
                if (!is_null(@$c_eBill->ReceiveDate)) {
                    $total_collection += @$c_eBill->Amount;
                }
                if (!is_null(@$c_serviceBill->ReceiveDate)) {
                    $total_collection += @$c_serviceBill->Amount;
                }

                $ClientWisebills[$client->id] = [
                    'client_name' => $client->Name,
                    'client_code' => $client->Code,
                    'unit' => $client->Unit,
                    'floor' => $client->Floor,
                    'prev_jamidari' => $prev_rent,
                    'jamidari_demand' => @$c_rent->Amount ?? 0,
                    'jamidari_collection' => !is_null(@$c_rent->ReceiveDate) ? @$c_rent->Amount : 0,
                    'prev_electric' => $prev_eBill,
                    'electric_demand' => @$c_eBill->Amount ?? 0,
                    'electric_collection' => !is_null(@$c_eBill->ReceiveDate) ? @$c_eBill->Amount : 0,
                    'prev_utility' => $prev_serviceBill,
                    'utility_demand' => @$c_serviceBill->Amount ?? 0,
                    'utility_collection' => !is_null(@$c_serviceBill->ReceiveDate) ? @$c_serviceBill->Amount : 0,
                    'total_bill' => $total_bill,
                    'total_collection' => $total_collection,
                ];
            }
            $ClientWisebills = collect($ClientWisebills);
        }

        return view('admin.collection_report.collection.collection_summary', compact(['title', 'months', 'tenants', 'units', 'floors', 'group_floors', 'smonth', 'syear', 'project', 'ClientWisebills']));
    }
}
