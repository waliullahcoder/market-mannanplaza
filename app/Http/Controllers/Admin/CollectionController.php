<?php

namespace App\Http\Controllers\Admin;

use App\EbillCollection;
use App\Http\Controllers\Controller;
use App\PositionInformation;
use App\RentCollection;
use App\ServiceChargeCollection;
use App\WbillCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public $services = [
        '1' => RentCollection::class,
        '2' => EbillCollection::class,
        '3' => WbillCollection::class,
        '4' => ServiceChargeCollection::class,
    ];

    public $classNamesToText = [
        'App\RentCollection' => 'Rent',
        'App\EbillCollection' => 'Electric Bill',
        'App\WbillCollection' => 'Water Bill',
        'App\ServiceChargeCollection' => 'Service Charge',
    ];

    public function addbyCode(Request $request)
    {
        $title = "Bill Collection by code";
        $bills = [];
        $search_code = '';

        $classToNormal = $this->classNamesToText;

        if ($request->searched) {
            $search_code = $request->search_code;
            foreach ($this->services as $key => $class) {
                $service_class = new $class();
                $service_pending_bills = $service_class::where('Client_Code', $search_code)
                    ->where(function ($q) {
                        $q->orWhereNull('ReceiveDate')
                            ->orWhere('ReceiveDate', '<', '2010-1-1 00:00:00');
                    })
                    ->where('Amount', '>', 0)
                    ->get();

                foreach ($service_pending_bills as  $service_pending_bill) {
                    $service_pending_bill->CLASS_NAME = $class;
                    array_push($bills, $service_pending_bill);
                }
            }
        }

        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

        return view('admin.collection.bycode.add', compact(['title', 'bills', 'classToNormal', 'search_code', 'tenants']));
    }

    public function savebyCode(Request $request)
    {
        if (!$request->ids) {
            return back()->with('error', 'Please check boxes to continue');
        }

        foreach ($request->ids as $id) {
            $service_class = new $request->class_name[$id]();
            $this_service_row = $service_class::findOrFail($id);

            $this_service_row->update([
                'ReceiveDate' => date('Y-m-d h:i:s'),
            ]);

            $now = date('Y-m-d');
            $startDate = date('2024-03-15');
            $lastDate = new Carbon(date('Y-m-d', strtotime('10-' . $this_service_row->CMonth . '-' . $this_service_row->CYear)));
            if (in_array($request->class_name[$id], ['App\EbillCollection','App\ServiceChargeCollection'])) {
                $lastDate = $lastDate->addMonths(1);
            }
            
            if ($request->class_name[$id] == 'App\RentCollection') {
                $startDate = date('2024-06-10');
                if(\Str::startsWith($this_service_row->Client_Code, 'U3') || Str::startsWith($this_service_row->Client_Code, 'u3')){
                    $lastDate = $lastDate->addMonths(1);
                }
            }

            if (strtotime($now) > strtotime($lastDate) && strtotime($lastDate) > strtotime($startDate)) {
                $this_service_row->update([
                    'penalty' => round(($this_service_row->Amount / 100) * 10),
                ]);
            }
        }
        return back()->with('msg', 'Collection Added Successfully');
    }

    public function addbyBarCode()
    {
        $title = "Bill Collection by barcode";
        return view('admin.collection.bybarcode.add', compact(['title']));
    }

    public function getbyBarCode(Request $request)
    {
        $data = [];

        $bar_code_value = $request->barcode_value;
        $bar_code_value = explode('-', $bar_code_value);

        $tenant_id = $bar_code_value[0];
        $month = $bar_code_value[1];
        $year = $bar_code_value[2];
        $service_type = $bar_code_value[3];

        // add tenant
        $tenant = PositionInformation::where('status', 1)->where('ID', $tenant_id)
            ->select(['Code', 'Name', 'PositionNo', 'Unit', 'Floor'])
            ->first();
        $data['tenant'] = $tenant;

        // add month full name
        $fullNameOfMonth = Carbon::parse($month)->englishMonth;
        $data['month'] = $fullNameOfMonth;

        // add year
        $data['year'] = $year;

        // add service
        $data['service'] = $this->classNamesToText[$this->services[$service_type]];
        $data['service_class'] = $this->services[$service_type];

        // get bill info
        $service_class = new $this->services[$service_type]();

        $bill = $service_class->where('CMonth', $fullNameOfMonth)
            ->where('CYear', $year)
            ->where('Client_Code', $tenant->Code)
            ->where(function ($q) {
                $q->orWhereNull('ReceiveDate')
                    ->orWhere('ReceiveDate', '<', '2010-1-1 00:00:00');
            })
            ->first();

        $data['panalty'] = 0;

        if ($bill == Null) {
            $data['status'] = false;
            $data['message'] = '*Already Paid';
        } else {
            
            $now = date('Y-m-d');
            $startDate = date('2024-03-15');
            $lastDate = new Carbon(date('Y-m-d', strtotime('16-' . $this_service_row->CMonth . '-' . $this_service_row->CYear)));
            if (in_array($this->services[$service_type], ['App\EbillCollection', 'App\ServiceChargeCollection'])) {
                $lastDate = $lastDate->addMonths(1);
            }
            
            if ($this->services[$service_type] == 'App\RentCollection') {
                $startDate = date('2024-06-10');
                if(\Str::startsWith($this_service_row->Client_Code, 'U3') || Str::startsWith($this_service_row->Client_Code, 'u3')){
                    $lastDate = $lastDate->addMonths(1);
                }
            }
            
            if (strtotime($now) > strtotime($lastDate) && strtotime($lastDate) > strtotime($startDate)) {
                $data['panalty'] = round(($bill->Amount / 100) * 10);
            }

            $data['status'] = true;
            $data['bill'] = $bill;
        }

        return $data;
    }
}
