<?php

namespace App\Helper\Report;

use App\UnitSetup;
use App\FloorSetup;
use App\RentCollection;
use App\EbillCollection;
use App\PositionInformation;
use App\ServiceChargeCollection;

class CollectionStatusReport
{

    public $filter;

    function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function getDetailsTable()
    {
        $table = [];

        // fetch data start

        // floors
        $floors = [$this->filter['floor']];
        if (!$this->filter['floor']) {
            $floors = FloorSetup::select(['name'])->get()->pluck('name')->toArray();
        }

        // units
        $units = [$this->filter['unit']];
        if (!$this->filter['unit']) {
            $units = UnitSetup::select(['name'])->get()->pluck('name')->toArray();
        }

        // fetch data end


        foreach ($floors as $floor) {
            foreach ($units as $unit) {

                // table thead boilerplate
                $tmptable = [
                    'thead' => [
                        'unit' => $unit,
                        'floor' => $floor,
                    ],
                    'tbody' => [],
                    'tfoot' => [],
                ];


                $tbody = [];

                if (!$this->filter['client_code']) {

                    $tenants = PositionInformation::where('status', 1)->select(['Code', "Name"])
                        ->where('Unit', $unit)
                        ->where('Floor', $floor)
                        ->get();
                } else {

                    $tenants = PositionInformation::where('status', 1)->select(['Code', "Name"])
                        ->where('Code', $this->filter['client_code'])
                        ->where('Unit', $unit)
                        ->where('Floor', $floor)
                        ->get();
                }

                $tfoot = [
                    'total_previous_due' => 0,
                    'total_jamidari_demand' => 0,
                    'total_electric_demand' => 0,
                    'total_utility_demand' => 0,
                    'total_current_demand' => 0,
                    'total_current_due' => 0,
                    'total_collection' => 0,
                    'total_deposit_bank' => 0,
                    'total_deposit_cash' => 0,
                    'total_running_due' => 0,
                ];

                foreach ($tenants as $tenant) {

                    $previous_due = $this->getTenantPreviousDue($tenant);
                    $current_demands = $this->getTenantCurrentDemand($tenant);
                    $current_demand = $current_demands['rent'] + $current_demands['ebill'] + $current_demands['utility'];

                    $collection = $this->getTenantCollection($tenant);
                    $deposit_bank = $this->getTenantCollection($tenant, 'Bank');
                    $deposit_cash = $this->getTenantCollection($tenant, 'Cash');
                    $current_due = $previous_due + $current_demand;

                    $rent = $current_demands['rent'];
                    $eBill = $current_demands['ebill'];
                    $serviceBill = $current_demands['utility'];

                    $tbodyLd = [
                        "client_code" => $tenant->Code,
                        "client_name" => $tenant->Name,
                        "previous_due" => $previous_due,
                        'jamidari_demand' => $rent,
                        'electric_demand' => $eBill,
                        'utility_demand' => $serviceBill,
                        "current_demand" => $current_demand,
                        "current_due" => $current_due,
                        "collection" => $collection,
                        "deposit_bank" => $deposit_bank,
                        "deposit_cash" => $deposit_cash,
                        "running_due" => $current_due - $collection,
                    ];

                    $tfoot['total_previous_due'] += $previous_due;
                    $tfoot['total_jamidari_demand'] += $rent;
                    $tfoot['total_electric_demand'] += $eBill;
                    $tfoot['total_utility_demand'] += $eBill;
                    $tfoot['total_current_demand'] += $current_demand;
                    $tfoot['total_current_due'] += $current_due;
                    $tfoot['total_collection'] += $collection;
                    $tfoot['total_deposit_bank'] += $deposit_bank;
                    $tfoot['total_deposit_cash'] += $deposit_cash;
                    $tfoot['total_running_due'] += $current_due - $collection;

                    array_push($tbody, $tbodyLd);
                }


                $tmptable['tbody'] = $tbody;
                $tmptable['tfoot'] = $tfoot;


                array_push($table, $tmptable);
            }
        }

        // dd($tenants);
        // dd($this->filter);
        // dd($table);

        return $table;
    }

    public function getTenantCollection($tenant, $type = null)
    {

        $total_rentCollection = RentCollection::where('Client_Code', $tenant->Code)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->whereNotNull('ReceiveDate');

        if ($type) {
            $total_rentCollection = $total_rentCollection->where('type', $type);
        }

        $total_rentCollection = $total_rentCollection->sum('Amount');

        $total_ebillCollection = EbillCollection::where('Client_Code', $tenant->Code)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->whereNotNull('ReceiveDate');

        if ($type) {
            $total_ebillCollection = $total_ebillCollection->where('type', $type);
        }

        $total_ebillCollection = $total_ebillCollection->sum('Amount');

        $total_serviceCollection = ServiceChargeCollection::where('Client_Code', $tenant->Code)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->whereNotNull('ReceiveDate');

        if ($type) {
            $total_serviceCollection = $total_serviceCollection->where('type', $type);
        }

        $total_serviceCollection = $total_serviceCollection->sum('Amount');

        $total_collection = $total_rentCollection + $total_ebillCollection + $total_serviceCollection;

        return $total_collection;
    }

    public function getCollection($unit, $floor, $clients)
    {

        $saleClients = $clients->where('EntryReson', 'Sale')->pluck('code')->toArray();
        $rentClients = $clients->where('EntryReson', 'Rent')->pluck('code')->toArray();

        $rentCollection = RentCollection::whereIn('Client_Code', $rentClients)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->where(function ($q) {
                $q->where('ReceiveDate', '>=', '2010-01-01 00:00:00')
                    ->orWhereNull('ReceiveDate');
            });
        $rentCollection = $rentCollection->get();

        $saleRentCollection = RentCollection::whereIn('Client_Code', $saleClients)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->where(function ($q) {
                $q->where('ReceiveDate', '>=', '2010-01-01 00:00:00')
                    ->orWhereNull('ReceiveDate');
            });
        $saleRentCollection = $saleRentCollection->get();

        $total_ebillCollection = EbillCollection::whereIn('Client_Code', $clients)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->where(function ($q) {
                $q->where('ReceiveDate', '>=', '2010-01-01 00:00:00')
                    ->orWhereNull('ReceiveDate');
            });
        $total_ebillCollection = $total_ebillCollection->get();

        $total_serviceCollection = ServiceChargeCollection::whereIn('Client_Code', $clients)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->where(function ($q) {
                $q->where('ReceiveDate', '>=', '2010-01-01 00:00:00')
                    ->orWhereNull('ReceiveDate');
            });
        $total_serviceCollection = $total_serviceCollection->get();


        return [
            'collection' => [
                'aRent' => $saleRentCollection->sum("Amount"),
                'rent' => $rentCollection->sum("Amount"),
                'eBill' =>  $total_ebillCollection->sum("Amount"),
                'service' => $total_serviceCollection->sum("Amount"),
            ],
            'collection_bank' => [
                'aRent' => $saleRentCollection->where('type', 'Bank')->sum("Amount"),
                'rent' => $rentCollection->where('type', 'Bank')->sum("Amount"),
                'eBill' =>  $total_ebillCollection->where('type', 'Bank')->sum("Amount"),
                'service' => $total_serviceCollection->where('type', 'Bank')->sum("Amount"),
            ],
            'collection_cash' => [
                'aRent' => $saleRentCollection->where('type', 'Cash')->sum("Amount"),
                'rent' => $rentCollection->where('type', 'Cash')->sum("Amount"),
                'eBill' =>  $total_ebillCollection->where('type', 'Cash')->sum("Amount"),
                'service' => $total_serviceCollection->where('type', 'Cash')->sum("Amount"),
            ],
        ];
    }

    public function getTenantCurrentDemand($tenant)
    {
        $total_rent = RentCollection::where('Client_Code', $tenant->Code)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->sum('Amount');

        $total_eBill = EbillCollection::where('Client_Code', $tenant->Code)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->sum('Amount');

        $total_serviceBill = ServiceChargeCollection::where('Client_Code', $tenant->Code)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->sum('Amount');

        // $total_bill = $total_rent + $total_eBill + $total_serviceBill;

        return [
            'rent' => $total_rent,
            'ebill' => $total_eBill,
            'utility' => $total_serviceBill,
        ];
    }

    public function getCurrentDemand($unit, $floor, $clients)
    {

        $saleClients = $clients->where('EntryReson', 'Sale')->pluck('code')->toArray();
        $rentClients = $clients->where('EntryReson', 'Rent')->pluck('code')->toArray();

        $saleRent = RentCollection::whereIn('Client_Code', $saleClients)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->sum('Amount');

        $rent = RentCollection::whereIn('Client_Code', $rentClients)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->sum('Amount');

        $total_eBill = EbillCollection::whereIn('Client_Code', $clients)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->sum('Amount');

        $total_serviceBill = ServiceChargeCollection::whereIn('Client_Code', $clients)
            ->where('CMonth', $this->filter['month'])
            ->where('CYear', $this->filter['year'])
            ->sum('Amount');

        return [
            'aRent' => $rent,
            'rent' => $saleRent,
            'eBill' => $total_eBill,
            'service' => $total_serviceBill,
        ];
    }

    public function getTenantPreviousDue($tenant)
    {
        $total_rent = RentCollection::where('Client_Code', $tenant->Code)
            ->where('CMonth', "!=", $this->filter['month'])
            ->where('CYear', "!=", $this->filter['year'])
            ->whereNull('ReceiveDate')
            ->sum('Amount');

        $total_eBill = EbillCollection::where('Client_Code', $tenant->Code)
            ->where('CMonth', "!=", $this->filter['month'])
            ->where('CYear', "!=", $this->filter['year'])
            ->whereNull('ReceiveDate')
            ->sum('Amount');

        $total_serviceBill = ServiceChargeCollection::where('Client_Code', $tenant->Code)
            ->where('CMonth', "!=", $this->filter['month'])
            ->where('CYear', "!=", $this->filter['year'])
            ->whereNull('ReceiveDate')
            ->sum('Amount');

        $previous_due = $total_rent + $total_eBill + $total_serviceBill;

        return $previous_due;
    }

    public function getPreviousDue($unit, $floor, $clients)
    {

        $saleClients = $clients->where('EntryReson', 'Sale')->pluck('code')->toArray();
        $rentClients = $clients->where('EntryReson', 'Rent')->pluck('code')->toArray();

        $saleRent = RentCollection::whereIn('Client_Code', $saleClients)
            ->where('CMonth', "!=", $this->filter['month'])
            ->where('CYear', "!=", $this->filter['year'])
            ->whereNull('ReceiveDate')
            ->sum('Amount');

        $rent = RentCollection::whereIn('Client_Code', $rentClients)
            ->where('CMonth', "!=", $this->filter['month'])
            ->where('CYear', "!=", $this->filter['year'])
            ->whereNull('ReceiveDate')
            ->sum('Amount');

        $total_eBill = EbillCollection::whereIn('Client_Code', $clients)
            ->where('CMonth', "!=", $this->filter['month'])
            ->where('CYear', "!=", $this->filter['year'])
            ->whereNull('ReceiveDate')
            ->sum('Amount');

        $total_serviceBill = ServiceChargeCollection::whereIn('Client_Code', $clients)
            ->where('CMonth', "!=", $this->filter['month'])
            ->where('CYear', "!=", $this->filter['year'])
            ->whereNull('ReceiveDate')
            ->sum('Amount');

        return [
            'aRent' => $saleRent,
            'rent' => $rent,
            'eBill' => $total_eBill,
            'service' => $total_serviceBill,
        ];
    }

    public function getDetailsReport()
    {
        $report = $this->getDetailsTable();
        return $report;
    }


    public function getSummaryTable()
    {
        $table = [];

        // fetch data start
        $floors = [$this->filter['floor']];
        if (!$this->filter['floor']) {
            $floors = FloorSetup::select(['name'])->get()->pluck('name')->toArray();
        }
        $unit = $this->filter['unit'];



        $table = [];

        foreach ($floors as $floor) {

            $clients = PositionInformation::where('status', 1)->where("Unit", $unit)
                ->where("Floor", $floor)->select('Code')->get();

            $previous_due = $this->getPreviousDue($unit, $floor, $clients);
            $current_demand = $this->getCurrentDemand($unit, $floor, $clients);
            $collection = $this->getCollection($unit, $floor, $clients);

            $table[] = [
                'floor' => $floor,
                'previous_due' => $previous_due,
                'current_demand' => $current_demand,
                'collection' => $collection,
            ];
        }

        return $table;
    }

    public function getSummaryReport()
    {
        $report = $this->getSummaryTable();
        return $report;
    }
}
