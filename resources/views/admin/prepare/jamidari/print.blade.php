@php
    use App\HelperClass;
@endphp

@extends('admin.layouts.master')

@section('content')

    <style>
        .mt-5, .my-5{
            margin-top:1rem!important;
        }
        .table td, .table th{
            padding:1px !important;
            font-size:21px;
        }
        .pr-2, .px-2{
             font-size:21px;
        }
        @media print {
            div {
                break-inside: avoid;
            }
            #report_div{
                margin-top:-100px;
            }
            p,tr,td{
                font-size:21px;
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
                                <p class="font-weight-bold"> {{ optional($bill->position_holder)->Unit ?? '' }}</p>
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
                                    "{{ date('M', strtotime($bill->CMonth)) }}-{{ $bill->CYear }}");
                            </script>

                        </div>

                        <div class="row mt-5">

                            <div class="col-md-5">
                                <table class="table border-0 table-borderless">
                                    <tr class="pb-2">
                                        <td class="font-weight-bold pr-2">Serial No :</td>
                                        <td>{{ $bill->SerialNo }}</td>
                                    </tr>

                                    <tr class="pb-2">
                                        <td class="font-weight-bold pr-2">Shop/Office Name : </td>
                                        <td>{{ $bill->position_holder->SName }}</td>
                                    </tr>
                                     <tr class="pb-2">
                                        <td class="font-weight-bold pr-2">Position Holder Name : </td>
                                        <td>{{ $bill->position_holder->Name }}</td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td class="font-weight-bold pr-2">Floor Name : </td>
                                        <td>{{ $bill->position_holder->Floor }}</td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td class="font-weight-bold pr-2">Name of Month : </td>
                                        <td>{{ $bill->CMonth }}</td>
                                    </tr>

                                    <tr class="pb-2">
                                        <td class="font-weight-bold pr-2">Rent Amount : </td>
                                        @if ($bill->position_holder->EntryReson == 'Rent')
                                            <td><span class="font-weight-bold"
                                                    style="font-size:21px">{{ $bill->position_holder->Agg0ne }}</span>
                                            </td>
                                        @else
                                            <td><span class="font-weight-bold"
                                                    style="font-size:21px">{{ $bill->position_holder->Agg0ne }}</span>
                                            </td>
                                        @endif
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
                                   
                                </table>
                            </div>

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

                            <div class="col-md-3">
                                <table style="margin-top: 115px;">
                                    <tr class="pb-2">
                                        <td class="font-weight-bold pr-2">Position No : </td>
                                        <td><span style="font-size:21px">{{ $bill->position_holder->PositionNo }}</span>
                                        </td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td class="font-weight-bold pr-2">Year :</td>
                                        <td style="font-size:21px">{{ $bill->CYear }}</td>
                                    </tr>

                                    <tr class="pb-2">
                                        <td class="font-weight-bold pr-2">Mothly Deduct : </td>
                                        <td><span class="font-weight-bold"
                                                style="font-size:21px">{{ $bill->position_holder->MonthlyDeduct }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-4">
                                <table class="table border-0 table-borderless">
                                    <tr>
                                        <td class="font-weight-bold pb-2">
                                            <span> Date :</span>
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($bill->PaidDate)) }}</td>
                                    </tr>
                                </table>

                                <table style="margin-top:10px;">
                                    <tr class="pb-2">
                                        <td class="font-weight-bold pr-2">Paid Amount : </td>
                                        @php
                                            $paid_amount = $bill->Amount;
                                        @endphp
                                        <td class="font-weight-bold"
                                            style="border: 3px solid black;width:180px; font-size:30px">
                                            {{ $paid_amount }}</td>
                                    </tr>
                                    @php
                                            $paid_amount = $bill->Amount;
                                            $current_with_charge = round(($bill->Amount / 100) * 10) + $paid_amount;
                                        @endphp
                                    
                                    @php
                                        $total_payable_with_charge = $previous_due + $current_with_charge;
                                    @endphp
                                    
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered mt-2">
                                    <tr>
                                        <td class="font-weight-bold pb-2">Paid Amount (Inword)</td>
                                        <td class="text-center font-weight-bold">:</td>
                                        <td><span class="font-weight-bold"
                                                style="font-size:21px">{{ HelperClass::numberToWords($paid_amount) }}
                                                Only
                                            </span></td>
                                    </tr>
                                  
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <span>&nbsp;</span>
                                <hr style="border:none; border-bottom: 1px solid black;">
                                 <span class="font-weight-bold" style="font-size:21px">Receiver</span>
                            </div>
                            <div class="col-md-2 offset-md-7 text-center">
                               <br>
                                <hr style="border:none; border-bottom: 1px solid black;">
                                <span class="font-weight-bold" style="font-size:21px">Authorized</span>
                            </div>
                        </div>

                        <p class="text-center" style="margin-top:30px">This is a Demo Print, If any advice please mention</p>

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
                        <hr style="border:none;  padding-bottom: 10px;">
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
