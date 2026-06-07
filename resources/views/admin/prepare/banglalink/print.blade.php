@extends('admin.layouts.master')

@section('content')

<style>
.bill-box{
    background:#fff;
    padding:20px;
    margin-bottom:20px;
    /* margin-top:-300px; */
    border-radius:5px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
}

.bill-header{
    text-align:center;
    margin-bottom:20px;
}

.bill-header h1{
    font-size:40px;
    margin-bottom:5px;
}

.section-title{
    text-align:center;
    margin:20px 0;
    font-weight:bold;
    font-size:26px;
}

.info{
    display:flex;
    justify-content:space-between;
    margin:20px 0;
}

.bill-table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

.bill-table th,
.bill-table td{
    border:1px solid #000;
    padding:8px;
    text-align:center;
}

.total{
    text-align:right;
    margin-top:15px;
}

.total h2{
    color:#d00000;
}

@media print{
     @page {
        size: A4;
        margin-top: -50mm;
    }

    .noprint,
    .main-sidebar,
    .main-header,
    .content-header,
    .card,
    .custom-card-header{
        display:none !important;
    }

    .content-wrapper{
        margin-left:0 !important;
    }

    .bill-box{
        box-shadow:none;
        border:none;
         margin-top:-100px !important;
    }
     

    body{
        background:#fff;
    }

    body,
    table,
    td,
    th,
    p,
    span,
    div {
        font-size: 18px !important;
        line-height: 1.5 !important;
    }

    .section-title{
        font-size: 32px !important;
        font-weight: bold !important;
    }

    h1{
        font-size: 40px !important;
    }

    h2{
        font-size: 28px !important;
    }

    h3{
        font-size: 24px !important;
        margin-bottom: 10px !important;
        font-weight: bold !important;
    }

    .bill-table th{
        font-size: 20px !important;
        font-weight: bold !important;
    }

    .bill-table td{
        font-size: 18px !important;
        padding: 10px !important;
    }

    .info{
        font-size: 20px !important;
        font-weight: bold !important;
    }

    .total h2{
        font-size: 30px !important;
        font-weight: bold !important;
    }
}
</style>



@foreach($bills as $bill)
<div class="bill-box printable-bill" id="bill-{{ $bill->id }}" style="display:none;">

    <!-- <div class="bill-header">
        <h1>Mannan Plaza</h1>
        <p>B-25, Khilkhet Bazar, Dhaka-1229</p>
        <p>Phone: 8920404, 8914387, 8917035</p>
    </div> -->

    <div class="section-title">
        SUB - METER BILL
    </div>

    <div class="info">
        <div>
            <strong>Name & Address:</strong><br>
            {{ $bill->consumer_name }}
            SW(H) Plot No# 04, Gulshan Avenue, Gulshan-1, Dhaka.
        </div>

        <div>
            <strong>Bill Month:</strong><br>
            {{ $bill->bill_month }} {{ $bill->bill_year }}
        </div>
    </div>

    <div class="info">
        <div>
            Bill No: {{ $bill->bill_no }} <br>
            Meter No: {{ $bill->meter_no }}
        </div>

        <div>
            Prepare Date: {{ $bill->prepare_date }}
        </div>
    </div>

    <h3>Description of Meter Reading</h3>

    <table class="bill-table" style="height:265px; width:100%;">
    <tbody>
        <tr>
            <td rowspan="2" style="text-align:center;font-weight: bold !important;">Status</td>
            <td rowspan="2" style="text-align:center;font-weight: bold !important;">Date</td>
            <td colspan="2" style="text-align:center;font-weight: bold !important;">Reading</td>
            <td rowspan="2" style="text-align:center;font-weight: bold !important;">Remarks</td>
        </tr>

        <tr>
            <td style="text-align:center;">Peak</td>
            <td style="text-align:center;">Off Peak</td>
        </tr>

        <tr>
            <td>Present</td>
            <td>01-{{ $bill->bill_month }}-{{ $bill->bill_year }}</td>
            <td>{{ $bill->present_peak }}</td>
            <td>{{ $bill->present_off_peak }}</td>
            <td></td>
        </tr>

        <tr>
            <td>Previous</td>
            <td>   {{
                    \Carbon\Carbon::createFromFormat('F Y', $bill->bill_month.' '.$bill->bill_year)
                    ->subMonth()
                    ->format('01-F-Y')
                }}</td>
            <td>{{ $bill->previous_peak }}</td>
            <td>{{ $bill->previous_off_peak }}</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="2" style="text-align:center;">Total</td>
            <td>{{ $bill->peak_unit }}</td>
            <td>{{ $bill->off_peak_unit }}</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="5" style="text-align:center; height:80px;">
                Total Consumed Units(Peak + Off Peak) = {{ $bill->peak_unit + $bill->off_peak_unit }}
            </td>
        </tr>
    </tbody>
</table>

    <br>

    <h3>Calculation of Bill</h3>

    <table class="bill-table" style="height:327px; width:100%;">
            <tbody>
                <tr>
                    <td style="text-align:center;font-weight: bold !important;"><strong>SL#</strong></td>
                    <td style="text-align:center;font-weight: bold !important;"><strong>Description</strong></td>
                    <td style="text-align:center;font-weight: bold !important;"><strong>Consumed</strong></td>
                    <td style="text-align:center;font-weight: bold !important;"><strong>Rate</strong></td>
                    <td style="text-align:center;font-weight: bold !important;"><strong>Amount(Tk)</strong></td>
                    <td style="text-align:center;font-weight: bold !important;"><strong>Remarks</strong></td>
                </tr>

                <tr>
                    <td style="text-align:center;">1.</td>
                    <td>Electricity Charge</td>
                    <td>Electricity Unit</td>
                    <td>Tk. {{ number_format($bill->unit_rate, 2) }} Per Unit</td>
                    <td>{{ number_format($bill->electricity_charge, 2) }}</td>
                    <td></td>
                </tr>

                <tr>
                    <td style="text-align:center;">2.</td>
                    <td>Demand Charge</td>
                    <td>40 KW</td>
                    <td>Tk. {{ number_format($bill->demand_charge, 2) }} Fixed</td>
                    <td>{{ number_format($bill->demand_charge, 2) }}</td>
                    <td></td>
                </tr>

                <tr>
                    <td style="text-align:center;">3.</td>
                    <td>Service Charge</td>
                    <td>01 Meter</td>
                    <td>Tk. {{ number_format($bill->service_charge, 2) }} Fixed</td>
                    <td>{{ number_format($bill->service_charge, 2) }}</td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="4" style="text-align:right;font-weight: bold !important;">
                        <strong>Sub Total (Tk)&nbsp;&nbsp;</strong>
                    </td>
                    <td style="font-weight: bold !important;">{{ number_format($bill->sub_total, 2) }}</td>
                    <td></td>
                </tr>

                <tr>
                    <td style="text-align:center;">4.</td>
                    <td>VAT</td>
                    <td>{{ $bill->vat_percent ?? 5 }}%</td>
                    <td></td>
                    <td>{{ number_format($bill->vat_amount, 2) }}</td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="4" style="text-align:right;font-weight: bold !important;">
                        <strong>Grand Total (Tk)&nbsp;&nbsp;</strong>
                    </td>
                    <td style="font-weight: bold !important;"><strong>{{ number_format($bill->grand_total, 2) }}</strong></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="6" style="text-align:center; height:70px;">
                        @php
                            $amount = $bill->grand_total;

                            $taka = floor($amount);
                            $paisa = round(($amount - $taka) * 100);

                            $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);

                            $words = ucfirst($formatter->format($taka)) . ' Taka';

                            if ($paisa > 0) {
                                $words .= ' And ' . ucfirst($formatter->format($paisa)) . ' Paisa';
                            }

                            $words .= ' Only';
                        @endphp
                        <strong>Amount In Words:  {{ $words }} </strong>
                    </td>
                </tr>
            </tbody>
        </table>

    <div class="total">
        <h2>Grand Total: Tk {{ number_format($bill->grand_total, 2) }}</h2>
    </div>
</div>
@endforeach

<script>
function printBill(id){
    $('.printable-bill').hide();
    $('#bill-' + id).show();

    setTimeout(function(){
        window.print();

        setTimeout(function(){
            $('#bill-' + id).hide();
        }, 500);

    }, 300);
}
</script>

@endsection