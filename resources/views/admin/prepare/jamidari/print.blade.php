@php
    use App\HelperClass;
@endphp

@extends('admin.layouts.master')

@section('content')

    <style>
        @media print {
            div {
                break-inside: avoid;
            }
        }
    </style>

    <div class="mt-4 noprint">
        <div class="row">
            <div class="col-md-2 offset-md-10 text-right">
                <button class="btn btn-info" onclick="print()">Print</button>
            </div>
        </div>
    </div>

    <div id="report_div" class="report_div bg-white">
        @if ($data->bills->count() > 0)
            @foreach ($data->bills as $bill)
                @php
                    $i = 0;
                @endphp

                @foreach ($data->copies as $copy)
                    <div class="mt-3 p-4">

                        <div class="row">

                            <div class="col-md-3">
                                <img class="img-fluid" src="{{ asset('public/elite-admin/assets/images/ksc_logo.png') }}"
                                    height="140" style="width: auto; height: 140px;" alt="">
                            </div>

                            <div class="col-md-5 text-center">
                                <h3 style="letter-spacing: 3px;font-weight: bold;">{{ $data->project->name }}</h3>
                                <p>{{ $data->project->address }}</p>
                                <p>{{ $data->project->contact }}</p>
                                <p class="font-weight-bold">{{ $bill->position_holder->Unit }}</p>
                                <p>
                                    <span class="font-weight-bold">Pay Circle</span>
                                    <span>{{ $bill->CMonth }} - {{ $bill->CYear }}</span>
                                </p>
                                <p class="font-weight-bold mt-2">Jamidari Collection Voucher ({{ $copy }})</p>
                            </div>

                            <div class="col-md-4 text-right">
                                <svg id="bill_id_{{ $bill->id }}"></svg>
                            </div>
                            <script>
                                JsBarcode("#bill_id_{{ $bill->id }}",
                                    "{{ $bill->position_holder->ID }}-{{ date('M', strtotime($bill->CMonth)) }}-{{ $bill->CYear }}-1");
                            </script>

                        </div>

                        <div class="row mt-5">

                            <div class="col-md-4">
                                <table class="table border-0 table-borderless">
                                    <tr class="pb-2">
                                        <td style="width:180px;" class="font-weight-bold pr-2">Serial No :</td>
                                        <td>{{ $bill->SerialNo }}</td>
                                    </tr>

                                    <tr class="pb-2">
                                        <td style="width:180px;" class="font-weight-bold pr-2">Tenant : </td>
                                        <td>{{ $bill->position_holder->Code }} ({{ $bill->position_holder->Name }})</td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td style="width:180px;" class="font-weight-bold pr-2">Name of Month : </td>
                                        <td>{{ $bill->CMonth }}</td>
                                    </tr>

                                    <tr class="pb-2">
                                        <td style="width:180px;" class="font-weight-bold pr-2">Rent Amount : </td>
                                        @if ($bill->position_holder->EntryReson == 'Rent')
                                            <td><span class="font-weight-bold"
                                                    style="font-size: 16px;">{{ $bill->position_holder->Agg0ne }}</span>
                                            </td>
                                        @else
                                            <td><span class="font-weight-bold"
                                                    style="font-size: 16px;">{{ $bill->position_holder->Agg0ne }}</span>
                                            </td>
                                        @endif
                                    </tr>

                                    <tr class="pb-2">
                                        <td style="width:180px;" class="font-weight-bold pr-2">With Late Charge : </td>
                                        <td><span class="font-weight-bold"
                                                style="font-size: 16px;">{{ round(($bill->Amount / 100) * 10) + $bill->Amount }}</span>
                                        </td>
                                    </tr>
                                    @php
                                        $previous_bills = \App\RentCollection::where('Client_Code', $bill->Client_Code)
                                            ->where('id', '!=', $bill->id)
                                            ->where('billing_month', '<', date('Y-m-d', strtotime($bill->billing_month)))
                                            ->whereNull('ReceiveDate')
                                            ->sum('Amount');
                                        $penulty_bills = \App\RentCollection::where('Client_Code', $bill->Client_Code)
                                            ->where('id', '!=', $bill->id)
                                            ->where('billing_month', '<', date('Y-m-d', strtotime($bill->billing_month)))
                                            ->where('billing_month', '>', '2024-06-10')
                                            ->whereNull('ReceiveDate')
                                            ->whereNotIn('billing_month', ['2024-07-01', '2024-08-01'])
                                            ->sum('Amount');
                                        $previous_due = $previous_bills + round(($penulty_bills / 100) * 10);
                                    @endphp
                                    <tr class="pb-2">
                                        <td style="width:150px; white-space: nowrap;" class="font-weight-bold pr-2">Previous
                                            Due : </td>
                                        <td class="font-weight-bold" style="width:150px; font-size: 16px;">
                                            {{ $previous_due }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-4">
                                <table style="margin-top: 115px;">
                                    <tr class="pb-2">
                                        <td style="width:150px;" class="font-weight-bold pr-2">Year :</td>
                                        <td>{{ $bill->CYear }}</td>
                                    </tr>

                                    <tr class="pb-2">
                                        <td style="width:150px;" class="font-weight-bold pr-2">Mothly Deduct : </td>
                                        <td><span class="font-weight-bold"
                                                style="font-size: 16px;">{{ $bill->position_holder->MonthlyDeduct }}</span>
                                        </td>
                                    </tr>
                                    @php
                                        $last_month_paid = \App\RentCollection::where('Client_Code', $bill->Client_Code)
                                            ->where('billing_month', '<', date('Y-m-d', strtotime($bill->billing_month)))
                                            ->whereNotNull('ReceiveDate')
                                            ->whereBetween(\DB::raw('DATE(ReceiveDate)'), [
                                                date('Y-m-01', strtotime($bill->billing_month . ' -1 month')),
                                                date('Y-m-t', strtotime($bill->billing_month . ' -1 month')),
                                            ])
                                            ->sum(DB::raw('Amount + penalty'));
                                    @endphp
                                    <tr class="pb-2">
                                        <td style="width:150px;" class="font-weight-bold pr-2">Last Month Paid : </td>
                                        <td><span class="font-weight-bold"
                                                style="font-size: 16px;">{{ $last_month_paid }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-4">
                                <table class="table border-0 table-borderless">
                                    <tr>
                                        <td style="width:150px;" class="font-weight-bold pb-2">
                                            <span> Date :</span>
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($bill->PaidDate)) }}</td>
                                    </tr>
                                </table>

                                <table style="margin-top:30px;">
                                    <tr class="pb-2">
                                        <td style="width:150px;" class="font-weight-bold pr-2">Paid Amount : </td>
                                        @php
                                            $paid_amount = $bill->Amount;
                                        @endphp
                                        <td class="font-weight-bold"
                                            style="border: 2px solid black;width:150px; font-size: 16px;">
                                            {{ $paid_amount }}</td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td style="width:150px; white-space: nowrap;" class="font-weight-bold pr-2">With
                                            Late Charge : </td>
                                        @php
                                            $paid_amount = $bill->Amount;
                                            $current_with_charge = round(($bill->Amount / 100) * 10) + $paid_amount;
                                        @endphp
                                        <td class="font-weight-bold"
                                            style="border: 2px solid black;width:150px; font-size: 16px;">
                                            {{ $current_with_charge }}</td>
                                    </tr>
                                    @php
                                        $total_payable_with_charge = $previous_due + $current_with_charge;
                                    @endphp
                                    <tr class="pb-2">
                                        <td style="width:150px; white-space: nowrap;" class="font-weight-bold pr-2">
                                            Total Due Without Charge : </td>
                                        <td class="font-weight-bold"
                                            style="border: 2px solid black;width:150px; font-size: 16px;">
                                            {{ $previous_due + $paid_amount }}</td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td style="width:150px; white-space: nowrap;" class="font-weight-bold pr-2">
                                            Total Due With Charge : </td>
                                        <td class="font-weight-bold"
                                            style="border: 2px solid black;width:150px; font-size: 16px;">
                                            {{ $total_payable_with_charge }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered mt-2">
                                    <tr>
                                        <td style="width:450px;" class="font-weight-bold pb-2">Paid Amount (Inword)</td>
                                        <td style="width:20px;" class="text-center font-weight-bold">:</td>
                                        <td><span class="font-weight-bold"
                                                style="font-size: 16px;">{{ HelperClass::numberToWords($paid_amount) }}
                                                Only
                                            </span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:450px;" class="font-weight-bold pb-2">Paid Amount With Late Charge
                                            (Inword)
                                        </td>
                                        <td style="width:20px;" class="text-center font-weight-bold">:</td>
                                        <td><span class="font-weight-bold"
                                                style="font-size: 16px;">{{ HelperClass::numberToWords($paid_amount + round(($bill->Amount / 100) * 10)) }}
                                                Only
                                            </span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:450px;" class="font-weight-bold pb-2">Total Payable Amount With
                                            Late Charge
                                            (Inword)
                                        </td>
                                        <td style="width:20px;" class="text-center font-weight-bold">:</td>
                                        <td><span class="font-weight-bold"
                                                style="font-size: 16px;">{{ HelperClass::numberToWords($total_payable_with_charge) }}
                                                Only
                                            </span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row" style="margin-top:30px">
                            <div class="col-md-3">
                                <span>&nbsp;</span>
                                <hr style="border:none; border-bottom: 1px solid black; width: 200px;">
                                <span>On behalf of Client Signature</span>
                            </div>
                            <div class="col-md-2 offset-md-7 text-center">
                                <span>{{ $bill->CreateBy }}</span>
                                <hr style="border:none; border-bottom: 1px solid black;">
                                <span>Print By</span>
                            </div>
                        </div>

                        <p class="text-center" style="margin-top:30px">Please pay your bill in date of 10th per month .
                            Otherwise your Electric Supply will be disconnected. Thank you for your co-operation.</p>

                        <div class="row" style="margin-top:30px">
                            <div class="col-md-3">
                                <span>Print Date: {{ date('d-F-Y', strtotime(now())) }}</span>
                            </div>
                            <div class="col-md-2 offset-md-7 text-center">
                                <span>Print Time {{ date('h:i:s a', strtotime(now())) }}</span>
                            </div>
                        </div>

                    </div>

                    @if ($i == 0)
                        <hr style="border:none; border-bottom: 1px dashed black; padding-bottom: 10px;">
                    @endif


                    @php
                        $i = 1;
                    @endphp
                @endforeach
            @endforeach
        @else
            <h2 class="text-center mt-4">No Data Found</h2>
        @endif

    </div>

@endsection
