<?php

namespace App\Http\Controllers\admin;

use App\UnitSetup;
use Carbon\Carbon;
use App\FloorSetup;
use App\SetupProject;
use App\RentCollection;
use App\EbillCollection;
use App\PositionInformation;
use App\ServiceChargeCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\RepeatedData\MonthList;

class DueReportController extends Controller
{
    public function JamidariDueReport(Request $request)
    {
        $title = "Jamidari Due Report";
        $project = '';
        $bills = [];
        $ClientWisebills = [];

        $data = (object)[
            'floors' => FloorSetup::select(['name'])->get(),
            'units' => UnitSetup::select(['name'])->get(),
            'tenants' => PositionInformation::where('status', 1)->select(['Code', 'Name'])->get(),
            'months' => MonthList::getAll(),
        ];

        $sunit = $request->unit;
        $sfloor = $request->floor;

        if ($request->searched) {
            $project = SetupProject::findOrFail(1);

            $clients = PositionInformation::where('status', 1);

            if (isset($request->client_code)) {
                $clients = $clients->where('Code', $request->client_code);
            }

            if (isset($request->client_type)) {
                $clients = $clients->where('EntryReson', $request->client_type);
            }

            if (isset($request->unit)) {
                $clients = $clients->where('Unit', $request->unit);
            }

            if (isset($request->floor)) {
                $clients = $clients->where('Floor', $request->floor);
            }

            $clients = $clients->select(['id', 'Name', 'Code', 'Unit', 'Floor', 'PositionNo'])
                ->orderBy('Unit', 'asc')
                ->orderBy('Floor', 'asc')
                ->orderBy('PositionNo', 'asc')
                ->get();

            foreach ($clients as $client) {
                $months = "";
                $total_due = 0;

                $due_rents =  RentCollection::where('Client_Code', $client->Code)
                    ->where(function ($q) {
                        $q->where('ReceiveDate', '<=', '2010-01-01 00:00:00')
                            ->orWhereNull('ReceiveDate');
                    });

                if ($request->CMonth) {
                    $due_rents = $due_rents->where('CMonth', $request->CMonth);
                }

                if ($request->CYear) {
                    $due_rents = $due_rents->where('CYear', $request->CYear);
                }

                $due_rents = $due_rents->get();

                foreach ($due_rents as $due_rent) {
                    $months .= Carbon::parse($due_rent->CMonth)->format('M') . ' - ' . $due_rent->CYear . ', ';
                    $total_due += $due_rent->Amount;
                }

                if ($total_due < 1) {
                    continue;
                }

                $ClientWisebills[$client->id] = [
                    'client_name' => $client->Name,
                    'client_code' => $client->Code,
                    'client_unit' => $client->Unit,
                    'client_floor' => $client->Floor,
                    'client_position_no' => $client->PositionNo,
                    'client_due_months' => $months,
                    'client_total_due' => $total_due,
                ];
            }
        }

        return view('admin.due_report.jamidari', compact(['title', 'sunit', 'sfloor', 'data', 'project', 'ClientWisebills']));
    }

    public function ServiceDueReport(Request $request)
    {
        $title = "Utility Due Report";
        $project = '';
        $bills = [];
        $ClientWisebills = [];
        $sunit = '';
        $sfloor = '';
        $sutility = '';

        $data = (object)[
            'floors' => FloorSetup::select(['name'])->get(),
            'units' => UnitSetup::select(['name'])->get(),
            'tenants' => PositionInformation::where('status', 1)->select(['Code', 'Name'])->get(),
            'months' => MonthList::getAll(),
        ];

        if ($request->searched) {
            $project = SetupProject::findOrFail(1);

            $clients = PositionInformation::where('status', 1);

            if (isset($request->client_code)) {
                $clients = $clients->where('Code', $request->client_code);
            }

            if (isset($request->unit)) {
                $clients = $clients->where('Unit', $request->unit);
                $sunit = $request->unit;
            }

            if (isset($request->floor)) {
                $clients = $clients->where('Floor', $request->floor);
                $sfloor = $request->floor;
            }

            $clients = $clients->select(['id', 'Name', 'Code', 'Unit', 'Floor', 'PositionNo'])
                ->orderBy('Unit')
                ->orderBy('Floor')
                ->orderBy('PositionNo')
                ->get();

            foreach ($clients as $client) {
                $months = "";
                $total_due = 0;

                if ($request->utility_type == null) {

                    $due_ebills =  EbillCollection::where('Client_Code', $client->Code)
                        ->where(function ($q) {
                            $q->where('ReceiveDate', '<=', '2010-01-01 00:00:00')
                                ->orWhereNull('ReceiveDate');
                        });

                    if ($request->CMonth) {
                        $due_ebills = $due_ebills->where('CMonth', $request->CMonth);
                    }

                    if ($request->CYear) {
                        $due_ebills = $due_ebills->where('CYear', $request->CYear);
                    }

                    $due_ebills = $due_ebills->where('Amount', '>', 0)->get();

                    foreach ($due_ebills as $due_ebill) {
                        $months .= 'Electric (' . Carbon::parse($due_ebill->CMonth)->format('M') . ' - ' . $due_ebill->CYear . '),';
                        $total_due += $due_ebill->Amount;
                    }

                    $due_service_bills =  ServiceChargeCollection::where('Client_Code', $client->Code)
                        ->where(function ($q) {
                            $q->where('ReceiveDate', '<=', '2010-01-01 00:00:00')
                                ->orWhereNull('ReceiveDate');
                        });

                    if ($request->CMonth) {
                        $due_service_bills = $due_service_bills->where('CMonth', $request->CMonth);
                    }

                    if ($request->CYear) {
                        $due_service_bills = $due_service_bills->where('CYear', $request->CYear);
                    }

                    $due_service_bills = $due_service_bills->where('Amount', '>', 0)->get();

                    foreach ($due_service_bills as $due_service_bill) {
                        $months .= $due_service_bill->utility->name . ' (' . Carbon::parse($due_service_bill->CMonth)->format('M') . ' - ' . $due_service_bill->CYear . '),';
                        $total_due += $due_service_bill->Amount;
                    }
                } else {

                    $sutility = $request->utility_type;

                    if ($request->utility_type == 'electric') {
                        $due_ebills =  EbillCollection::where('Client_Code', $client->Code)
                            ->where(function ($q) {
                                $q->where('ReceiveDate', '<=', '2010-01-01 00:00:00')
                                    ->orWhereNull('ReceiveDate');
                            });

                        if ($request->CMonth) {
                            $due_ebills = $due_ebills->where('CMonth', $request->CMonth);
                        }

                        if ($request->CYear) {
                            $due_ebills = $due_ebills->where('CYear', $request->CYear);
                        }

                        $due_ebills = $due_ebills->where('Amount', '>', 0)->get();

                        foreach ($due_ebills as $due_ebill) {
                            $months .= 'Electric (' . Carbon::parse($due_ebill->CMonth)->format('M') . ' - ' . $due_ebill->CYear . '),';
                            $total_due += $due_ebill->Amount;
                        }
                    }

                    if ($request->utility_type == 'service') {

                        $due_service_bills =  ServiceChargeCollection::where('Client_Code', $client->Code)
                            ->where(function ($q) {
                                $q->where('ReceiveDate', '<=', '2010-01-01 00:00:00')
                                    ->orWhereNull('ReceiveDate');
                            });

                        if ($request->CMonth) {
                            $due_service_bills = $due_service_bills->where('CMonth', $request->CMonth);
                        }

                        if ($request->CYear) {
                            $due_service_bills = $due_service_bills->where('CYear', $request->CYear);
                        }

                        $due_service_bills = $due_service_bills->where('Amount', '>', 0)->get();

                        foreach ($due_service_bills as $due_service_bill) {
                            $months .= $due_service_bill->utility->name . ' (' . Carbon::parse($due_service_bill->CMonth)->format('M') . ' - ' . $due_service_bill->CYear . '),';
                            $total_due += $due_service_bill->Amount;
                        }
                    }
                }

                if ($total_due < 1) {
                    continue;
                }

                $ClientWisebills[$client->id] = [
                    'client_name' => $client->Name,
                    'client_code' => $client->Code,
                    'client_unit' => $client->Unit,
                    'client_floor' => $client->Floor,
                    'client_position_no' => $client->PositionNo,
                    'client_due_months' => $months,
                    'client_total_due' => $total_due,
                ];
            }
        }

        return view('admin.due_report.service', compact(['sunit', 'sfloor', 'sutility', 'title', 'data', 'project', 'ClientWisebills']));
    }
}
