@extends('admin.layouts.master')

@section('content')
<form action="{{route('banglalink.store')}}" method="POST">
    @csrf

    <?php $title="Sub Meter Bill Add";?>
    <div class="card noprint">
        <div class="custom-card-header">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="custom-card-title">{{ $title ?? 'Sub Meter Bill Add' }}</h4>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-md-3">
                    <label>Consumer Name</label>
                    <select class="form-control select2" name="consumer_name" id="consumer_name" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->Name }}">({{ $client->Code }}) {{ $client->Name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Bill Month</label>
                    <select class="form-control select2" name="bill_month" id="bill_month">
                        @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Year</label>
                    <select class="form-control select2" name="bill_year" id="bill_year">
                        <option value="2026">2026</option>
                        @for ($i = 2000; $i <= 2055; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Bill No</label>
                    <input type="text" class="form-control" name="bill_no" value="{{ $serial_no ?? '' }}" readonly>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-3">
                    <label>Meter No</label>
                    <input type="text" class="form-control" name="meter_no" required>
                </div>

                <div class="col-md-3">
                    <label>Prepare Date</label>
                    <input type="text" class="form-control add_datepicker" name="prepare_date">
                </div>

                <div class="col-md-3">
                    <label>Unit Rate</label>
                    <input type="number" step="0.01" class="form-control" name="unit_rate" id="unit_rate" value="15" onkeyup="calculateBill()">
                </div>

                <div class="col-md-3">
                    <label>VAT %</label>
                    <input type="number" step="0.01" class="form-control" name="vat_percent" id="vat_percent" value="5" onkeyup="calculateBill()">
                </div>
            </div>

            <h5 class="mt-4">Meter Reading</h5>

            <div class="row mt-2">
                <div class="col-md-3">
                    <label>Previous Peak</label>
                    <input type="number" class="form-control" name="previous_peak" id="previous_peak" onkeyup="calculateBill()">
                </div>

                <div class="col-md-3">
                    <label>Present Peak</label>
                    <input type="number" class="form-control" name="present_peak" id="present_peak" onkeyup="calculateBill()">
                </div>

                <div class="col-md-3">
                    <label>Previous Off Peak</label>
                    <input type="number" class="form-control" name="previous_off_peak" id="previous_off_peak" onkeyup="calculateBill()">
                </div>

                <div class="col-md-3">
                    <label>Present Off Peak</label>
                    <input type="number" class="form-control" name="present_off_peak" id="present_off_peak" onkeyup="calculateBill()">
                </div>
            </div>

            <h5 class="mt-4">Charges</h5>

            <div class="row mt-2">
                <div class="col-md-3">
                    <label>Peak Unit</label>
                    <input type="number" class="form-control" name="peak_unit" id="peak_unit" readonly>
                </div>

                <div class="col-md-3">
                    <label>Off Peak Unit</label>
                    <input type="number" class="form-control" name="off_peak_unit" id="off_peak_unit" readonly>
                </div>

                <div class="col-md-3">
                    <label>Demand Charge</label>
                    <input type="number" step="0.01" class="form-control" name="demand_charge" id="demand_charge" value="1500" onkeyup="calculateBill()">
                </div>

                <div class="col-md-3">
                    <label>Service Charge</label>
                    <input type="number" step="0.01" class="form-control" name="service_charge" id="service_charge" value="1500" onkeyup="calculateBill()">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-3">
                    <label>Electricity Charge</label>
                    <input type="number" step="0.01" class="form-control" name="electricity_charge" id="electricity_charge" readonly>
                </div>

                <div class="col-md-3">
                    <label>Sub Total</label>
                    <input type="number" step="0.01" class="form-control" name="sub_total" id="sub_total" readonly>
                </div>

                <div class="col-md-3">
                    <label>VAT Amount</label>
                    <input type="number" step="0.01" class="form-control" name="vat_amount" id="vat_amount" readonly>
                </div>

                <div class="col-md-3">
                    <label>Grand Total</label>
                    <input type="number" step="0.01" class="form-control" name="grand_total" id="grand_total" readonly>
                </div>
            </div>

        </div>

        <div class="custom-card-footer">
            <div class="col-md-3 offset-md-9">
                <button type="submit" class="btn btn-outline-info btn-lg buttonAddEdit float-right">Save</button>
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
</script>
@endsection