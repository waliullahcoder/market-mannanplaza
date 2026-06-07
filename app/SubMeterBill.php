<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubMeterBill extends Model
{
    protected $table = 'sub_meter_bills';

    protected $fillable = [
        'bill_no',
        'consumer_name',
        'bill_month',
        'bill_year',
        'meter_no',
        'prepare_date',
        'previous_peak',
        'present_peak',
        'previous_off_peak',
        'present_off_peak',
        'peak_unit',
        'off_peak_unit',
        'unit_rate',
        'demand_charge',
        'service_charge',
        'electricity_charge',
        'sub_total',
        'vat_percent',
        'vat_amount',
        'grand_total',
    ];
}