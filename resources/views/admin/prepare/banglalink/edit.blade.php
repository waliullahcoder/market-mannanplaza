@extends('admin.layouts.master')

@section('content')
<form action="{{ route('banglalink.update', $bill->id) }}" method="POST">
    @csrf

    <div class="card noprint">
        <div class="custom-card-header">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="custom-card-title">{{ $title ?? 'Edit Sub Meter Bill' }}</h4>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-md-3">
                    <label>Consumer Name</label>
                    <select class="form-control select2" name="consumer_name" id="consumer_name" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->Name }}"
                                {{ old('consumer_name', $bill->consumer_name) == $client->Name ? 'selected' : '' }}>
                                ({{ $client->Code }}) {{ $client->Name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Bill Month</label>
                    <select class="form-control select2" name="bill_month" id="bill_month">
                        @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                            <option value="{{ $month }}"
                                {{ old('bill_month', $bill->bill_month) == $month ? 'selected' : '' }}>
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Year</label>
                    <select class="form-control select2" name="bill_year" id="bill_year">
                        @for ($i = 2000; $i <= 2055; $i++)
                            <option value="{{ $i }}"
                                {{ old('bill_year', $bill->bill_year) == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Bill No</label>
                    <input type="text" class="form-control" name="bill_no"
                           value="{{ old('bill_no', $bill->bill_no) }}" readonly>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-3">
                    <label>Meter No</label>
                    <input type="text" class="form-control" name="meter_no"
                           value="{{ old('meter_no', $bill->meter_no) }}" required>
                </div>

                <div class="col-md-3">
                    <label>Prepare Date</label>
                    <input type="text" class="form-control add_datepicker" name="prepare_date"
                           value="{{ old('prepare_date', $bill->prepare_date) }}">
                </div>

                <div class="col-md-3">
                    <label>Unit Rate</label>
                    <input type="number" step="0.01" class="form-control" name="unit_rate" id="unit_rate"
                           value="{{ old('unit_rate', $bill->unit_rate) }}" onkeyup="calculateBill()" onchange="calculateBill()">
                </div>

                <div class="col-md-3">
                    <label>VAT %</label>
                    <input type="number" step="0.01" class="form-control" name="vat_percent" id="vat_percent"
                           value="{{ old('vat_percent', $bill->vat_percent) }}" onkeyup="calculateBill()" onchange="calculateBill()">
                </div>
            </div>

            <h5 class="mt-4">Meter Reading</h5>

            <div class="row mt-2">
                <div class="col-md-3">
                    <label>Previous Peak</label>
                    <input type="number" class="form-control" name="previous_peak" id="previous_peak"
                           value="{{ old('previous_peak', $bill->previous_peak) }}" onkeyup="calculateBill()" onchange="calculateBill()">
                </div>

                <div class="col-md-3">
                    <label>Present Peak</label>
                    <input type="number" class="form-control" name="present_peak" id="present_peak"
                           value="{{ old('present_peak', $bill->present_peak) }}" onkeyup="calculateBill()" onchange="calculateBill()">
                </div>

                <div class="col-md-3">
                    <label>Previous Off Peak</label>
                    <input type="number" class="form-control" name="previous_off_peak" id="previous_off_peak"
                           value="{{ old('previous_off_peak', $bill->previous_off_peak) }}" onkeyup="calculateBill()" onchange="calculateBill()">
                </div>

                <div class="col-md-3">
                    <label>Present Off Peak</label>
                    <input type="number" class="form-control" name="present_off_peak" id="present_off_peak"
                           value="{{ old('present_off_peak', $bill->present_off_peak) }}" onkeyup="calculateBill()" onchange="calculateBill()">
                </div>
            </div>

            <h5 class="mt-4">Charges</h5>

            <div class="row mt-2">
                <div class="col-md-3">
                    <label>Peak Unit</label>
                    <input type="number" class="form-control" name="peak_unit" id="peak_unit"
                           value="{{ old('peak_unit', $bill->peak_unit) }}" readonly>
                </div>

                <div class="col-md-3">
                    <label>Off Peak Unit</label>
                    <input type="number" class="form-control" name="off_peak_unit" id="off_peak_unit"
                           value="{{ old('off_peak_unit', $bill->off_peak_unit) }}" readonly>
                </div>

                <div class="col-md-3">
                    <label>Demand Charge</label>
                    <input type="number" step="0.01" class="form-control" name="demand_charge" id="demand_charge"
                           value="{{ old('demand_charge', $bill->demand_charge) }}" onkeyup="calculateBill()" onchange="calculateBill()">
                </div>

                <div class="col-md-3">
                    <label>Service Charge</label>
                    <input type="number" step="0.01" class="form-control" name="service_charge" id="service_charge"
                           value="{{ old('service_charge', $bill->service_charge) }}" onkeyup="calculateBill()" onchange="calculateBill()">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-3">
                    <label>Electricity Charge</label>
                    <input type="number" step="0.01" class="form-control" name="electricity_charge" id="electricity_charge"
                           value="{{ old('electricity_charge', $bill->electricity_charge) }}" readonly>
                </div>

                <div class="col-md-3">
                    <label>Sub Total</label>
                    <input type="number" step="0.01" class="form-control" name="sub_total" id="sub_total"
                           value="{{ old('sub_total', $bill->sub_total) }}" readonly>
                </div>

                <div class="col-md-3">
                    <label>VAT Amount</label>
                    <input type="number" step="0.01" class="form-control" name="vat_amount" id="vat_amount"
                           value="{{ old('vat_amount', $bill->vat_amount) }}" readonly>
                </div>

                <div class="col-md-3">
                    <label>Grand Total</label>
                    <input type="number" step="0.01" class="form-control" name="grand_total" id="grand_total"
                           value="{{ old('grand_total', $bill->grand_total) }}" readonly>
                </div>
            </div>

        </div>

        <div class="custom-card-footer">
            <div class="col-md-3 offset-md-9">
                <button type="submit" class="btn btn-outline-info btn-lg buttonAddEdit float-right">Update</button>
            </div>
        </div>
    </div>
</form>

<script>
function getVal(id){
    return Number($('#' + id).val()) || 0;
}

function calculateBill(){
    let previousPeak = getVal('previous_peak');
    let presentPeak = getVal('present_peak');
    let previousOffPeak = getVal('previous_off_peak');
    let presentOffPeak = getVal('present_off_peak');

    let unitRate = getVal('unit_rate');
    let demandCharge = getVal('demand_charge');
    let serviceCharge = getVal('service_charge');
    let vatPercent = getVal('vat_percent');

    let peakUnit = presentPeak - previousPeak;
    let offPeakUnit = presentOffPeak - previousOffPeak;

    if(peakUnit < 0) peakUnit = 0;
    if(offPeakUnit < 0) offPeakUnit = 0;

    let totalUnit = peakUnit + offPeakUnit;
    let electricityCharge = totalUnit * unitRate;

    let subTotal = electricityCharge + demandCharge + serviceCharge;
    let vatAmount = subTotal * vatPercent / 100;
    let grandTotal = subTotal + vatAmount;

    $('#peak_unit').val(peakUnit);
    $('#off_peak_unit').val(offPeakUnit);
    $('#electricity_charge').val(electricityCharge.toFixed(2));
    $('#sub_total').val(subTotal.toFixed(2));
    $('#vat_amount').val(vatAmount.toFixed(2));
    $('#grand_total').val(grandTotal.toFixed(2));
}

$(document).ready(function(){
    calculateBill();
});
</script>
@endsection