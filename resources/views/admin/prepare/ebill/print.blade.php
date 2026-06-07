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
        @if (count($data->bills) > 0)
            @foreach ($data->bills as $bill)
                @php
                    $i = 0;
                    $total = 0;
                    $sbPenalty = 0;
                    $tenant = '';

                    // if (!isset($bill[0])){
                    // continue;
                    // }

                    if (isset($bill[0])) {
                        $total += $bill[0]->Amount;
                    }

                    if (isset($bill[1])) {
                        $total += $bill[1]->Amount;
                    }

                    if (isset($bill[2])) {
                        foreach ($bill[2] as $sb) {
                            $total += $sb->Amount;
                            $sbPenalty += round($sb->Amount * 0.10);
                        }
                    }

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
                                <p class="font-weight-bold mt-2">Utility Collection Voucher ({{ $copy }})</p>
                                <span class="font-weight-bold">Pay Circle:</span>

                                @if (isset($bill[0]))
                                    @if ($bill[0] != null)
                                        <span>{{ $bill[0]->CMonth }} - {{ $bill[0]->CYear }}</span>
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-4 text-right">
                                <svg id="{{ $bill['billCode'] }}"></svg>
                            </div>
                            <script>
                                JsBarcode("#{{ $bill['billCode'] }}",
                                    "{{ $bill['tenant']->ID }}-{{ date('M', strtotime($bill['month'])) }}-{{ $bill['year'] }}-2"
                                );
                            </script>
                        </div>

                        <div class="row mt-5 align-items-end">
                            <div class="col-lg-4">
                                <table class="table border-0 table-borderless">
                                    <tr>
                                        <td style="width:160px;" class="font-weight-bold">Unit</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td class="font-weight-bold">{{ $bill['tenant']->Unit }}</td>
                                    </tr>
                                    <tr style="margin-top: 20px">
                                        <td style="width:160px;" class="font-weight-bold">Wp Unit</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        @if (isset($bill[1]))
                                            <td class="font-weight-bold">{{ $bill[1]->PreviousUnit }}</td>
                                        @else
                                            <td class="font-weight-bold">0</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td style="width:160px;" class="font-weight-bold">Uses Unit</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td class="font-weight-bold">{{ isset($bill[1]) ? $bill[1]->UsesUnit : 0 }}</td>
                                    </tr>
                                    <tr style="margin-top: 20px">
                                        <td style="width:160px;" class="font-weight-bold">EP Unit</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td class="font-weight-bold">{{ isset($bill[0]) ? $bill[0]->PreviousUnit : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;" class="font-weight-bold">Uses Unit</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td class="font-weight-bold">{{ isset($bill[0]) ? $bill[0]->UsesUnit : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;" class="font-weight-bold">Additional Usable Unit</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td class="font-weight-bold">{{ isset($bill[0]) ? $bill[0]->LossUnit : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;" class="font-weight-bold">Total Unit</td>
                                        @php
                                            $totalUnit = 0;
                                            if(isset($bill[0])){
                                                $totalUnit = $bill[0]->UsesUnit + $bill[0]->LossUnit;
                                            }
                                        @endphp
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td class="font-weight-bold">{{ $totalUnit }}</td>
                                    </tr>
                                    @php
                                        $previous_bills = \App\EbillCollection::where('Client_Code', $bill[0]->Client_Code)
                                            ->where('id', '!=', $bill[0]->id)
                                            ->where('billing_month', '<', date('Y-m-d', strtotime($bill[0]->billing_month)))
                                            ->whereNull('ReceiveDate')
                                            ->sum('Amount');
                                        $currentMonth = \Carbon\Carbon::parse('2025-03-08');
                                        $now = \Carbon\Carbon::parse('2025-04-08');

                                        // If billing_month is the current month and today is before the 10th
                                        if ($currentMonth->isSameMonth($now) && $now->day < 10) {
                                            // Go to the previous month
                                            $targetBillingMonth = $currentMonth->copy()->subMonth()->startOfMonth();
                                        } else {
                                            // Use the original billing month
                                            $targetBillingMonth = $currentMonth->startOfMonth();
                                        }

                                        $penulty_bills = \App\EbillCollection::where('Client_Code', $bill[0]->Client_Code)
                                            ->where('id', '!=', $bill[0]->id)
                                            ->where('billing_month', '<', $targetBillingMonth->toDateString())
                                            ->where('billing_month', '>', '2024-03-15')
                                            ->whereNull('ReceiveDate')
                                            ->whereNotIn('billing_month', ['2024-07-01'])
                                            ->sum('Amount');
                                        $previous_due = $previous_bills + round($penulty_bills * 0.10);


                                        $previous_due2 = 0;
                                        if(@$bill[2][0]){
                                            $previous_bills2 = \App\ServiceChargeCollection::where('Client_Code', $bill[2][0]->Client_Code)
                                                ->where('id', '!=', $bill[2][0]->id)
                                                ->where('billing_month', '<', date('Y-m-d', strtotime($bill[2][0]->billing_month)))
                                                ->whereNull('ReceiveDate')
                                                ->sum('Amount');

                                            // If billing_month is the current month and today is before the 10th
                                            if ($currentMonth->isSameMonth($now) && $now->day < 10) {
                                                // Go to the previous month
                                                $targetBillingMonth = $currentMonth->copy()->subMonth()->startOfMonth();
                                            } else {
                                                // Use the original billing month
                                                $targetBillingMonth = $currentMonth->startOfMonth();
                                            }

                                            $penulty_bills2 = \App\ServiceChargeCollection::where('Client_Code', $bill[2][0]->Client_Code)
                                                ->where('id', '!=', $bill[2][0]->id)
                                                ->where('billing_month', '<', $targetBillingMonth->toDateString())
                                                ->where('billing_month', '>', '2024-03-15')
                                                ->whereNull('ReceiveDate')
                                                ->whereNotIn('billing_month', ['2024-07-01'])
                                                ->sum('Amount');
                                            $previous_due2 = $previous_bills2 + round($penulty_bills2 * 0.10);
                                        }
                                    @endphp
                                    <tr>
                                        <td style="width:160px;" class="font-weight-bold">Total Bill</td>
                                        <td style="width:20px;" class="font-weight-bold">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                                style="font-size: 15px;">{{ $total }}</span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;" class="font-weight-bold">Total Bill with Late Charge
                                        </td>
                                        <td style="width:20px;" class="font-weight-bold">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                                style="font-size: 15px;">{{ $total + round(($bill[0]->Amount / 100) * 10) + round($sbPenalty) }}</span>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td style="width:150px; white-space: nowrap;" class="font-weight-bold pr-2">Previous
                                            Due </td>
                                        <td style="width:20px;" class="font-weight-bold">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                            style="font-size: 15px;">{{ $previous_due + $previous_due2 }}</span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-4">
                                <table class="table border-0 table-borderless">
                                    <tr class="pb-2">
                                        <td style="width:120px;" class="font-weight-bold">Wc Unit</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        @if (isset($bill10))
                                            <td class="font-weight-bold">{{ $bill[1]->LastUnit }}</td>
                                        @else
                                            <td class="font-weight-bold">0</td>
                                        @endif
                                    </tr>

                                    <tr class="pb-2">
                                        <td style="width:120px;" class="font-weight-bold">W Bill</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        @if (isset($bill[1]))
                                            <td><span class="font-weight-bold"
                                                    style="font-size: 16px;">{{ $bill[1]->Amount }}</span></td>
                                        @else
                                            <td><span class="font-weight-bold" style="font-size: 16px;">0</span></td>
                                        @endif
                                    </tr>

                                    <tr class="pb-2" style="margin-top: 20px">
                                        <td style="width:120px;" class="font-weight-bold">EC Unit</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        @if (isset($bill[0]))
                                            <td class="font-weight-bold">{{ $bill[0]->LastUnit }}</td>
                                        @else
                                            <td class="font-weight-bold">0</td>
                                        @endif
                                    </tr>
                                    <tr class="pb-2">
                                        <td style="width:120px;" class="font-weight-bold">E Bill</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold" style="font-size: 16px;">{{ @$bill[0]->Amount ?? 0 }}</span></td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td style="width:120px;" class="font-weight-bold">E Bill with late charges</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                                style="font-size: 16px;">{{ isset($bill[0]) ? $bill[0]->Amount + round($bill[0]->Amount * 0.10) : 0 }}</span>
                                        </td>
                                    </tr>
                                    @php
                                        $last_month_paid = \App\EbillCollection::where('Client_Code', $bill[0]->Client_Code)
                                            ->where('billing_month', '<', date('Y-m-d', strtotime($bill[0]->billing_month)))
                                            ->whereNotNull('ReceiveDate')
                                            ->whereBetween(\DB::raw('DATE(ReceiveDate)'), [
                                                date('Y-m-01', strtotime($bill[0]->billing_month . ' -1 month')),
                                                date('Y-m-t', strtotime($bill[0]->billing_month . ' -1 month')),
                                            ])
                                            ->sum(DB::raw('Amount + penalty'));
                                    @endphp
                                    <tr class="pb-2">
                                        <td style="width:120px;" class="font-weight-bold pr-2">Last Month Paid : </td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                            style="font-size: 15px;">{{ $last_month_paid }}</span></td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td style="width:120px;" class="font-weight-bold pr-2">Previous Due : </td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                            style="font-size: 15px;">{{ $previous_due }}</span></td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td style="width:120px;" class="font-weight-bold pr-2">Total Due Without Charge : </td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                            style="font-size: 15px;">{{ $previous_due + @$bill[0]->Amount }}</span></td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td style="width:120px;" class="font-weight-bold pr-2">Total Due With Charge : </td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                            style="font-size: 15px;">{{ $previous_due + @$bill[0]->Amount + round(@$bill[0]->Amount * 0.10) }}</span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-4">
                                <table class="table border-0 table-borderless">
                                    <tr>
                                        <td style="width:140px;" class="font-weight-bold">Meter No</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td>{{ $bill['tenant']->ebill_meter_no }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:140px;" class="font-weight-bold">Floor No</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td>{{ $bill['tenant']->Floor }}</td>
                                    </tr>

                                    <tr>
                                        <td style="width:140px;" class="font-weight-bold">Client Code</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td>{{ $bill['tenant']->Code }}</td>
                                    </tr>

                                    <tr>
                                        <td style="width:140px;" class="font-weight-bold">Client Name</td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td>{{ $bill['tenant']->Name }}</td>
                                    </tr>

                                    @if (isset($bill[2]))
                                        @foreach ($bill[2] as $sb)
                                            <tr>
                                                <td class="font-weight-bold">{{ $sb->utility->name }}</td>
                                                <td class="font-weight-bold" width="10">:</td>
                                                <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                                        style="font-size: 16px;">{{ $sb->Amount }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">With Late Charge</td>
                                                <td class="font-weight-bold" width="10">:</td>
                                                <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                                        style="font-size: 16px;">{{ $sb->Amount + round($sb->Amount * 0.10) }}</span></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @php
                                        $last_month_paid2 = \App\ServiceChargeCollection::where('Client_Code', $bill['tenant']->Code)
                                            ->where('billing_month', '<', date('Y-m-d', strtotime($bill[0]->billing_month)))
                                            ->whereNotNull('ReceiveDate')
                                            ->whereBetween(\DB::raw('DATE(ReceiveDate)'), [
                                                date('Y-m-01', strtotime($bill[0]->billing_month . ' -1 month')),
                                                date('Y-m-t', strtotime($bill[0]->billing_month . ' -1 month')),
                                            ])
                                            ->sum(DB::raw('Amount + penalty'));
                                    @endphp
                                    <tr class="pb-2">
                                        <td style="width:140px;" class="font-weight-bold">Last Month Paid : </td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                                style="font-size: 16px;">{{ $last_month_paid2 }}</span>
                                        </td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td style="width:120px;" class="font-weight-bold pr-2">Previous Due : </td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                            style="font-size: 15px;">{{ $previous_due2 }}</span></td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td style="width:120px;" class="font-weight-bold pr-2">Total Due Without Charge : </td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                            style="font-size: 15px;">{{ $previous_due2 + @$bill[2][0]->Amount }}</span></td>
                                    </tr>
                                    <tr class="pb-2">
                                        <td style="width:120px;" class="font-weight-bold pr-2">Total Due With Charge : </td>
                                        <td class="font-weight-bold" width="10">:</td>
                                        <td style="border: 2px solid black;width:100px;"><span class="font-weight-bold"
                                            style="font-size: 15px;">{{ $previous_due2 + @$bill[2][0]->Amount + round(@$bill[2][0]->Amount * 0.10) }}</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered mt-2">
                                    <tr>
                                        <td style="width:350px;" class="font-weight-bold pb-2">Paid Amount (Inword)</td>
                                        <td style="width:20px;" class="text-center font-weight-bold">:</td>
                                        <td><span class="font-weight-bold"
                                                style="font-size: 16px;">{{ HelperClass::numberToWords($total) }} Only
                                            </span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:350px;" class="font-weight-bold pb-2">Paid Amount With Late
                                            Charge
                                            (Inword)
                                        </td>
                                        <td style="width:20px;" class="text-center font-weight-bold">:</td>
                                        <td><span class="font-weight-bold"
                                                style="font-size: 16px;">{{ HelperClass::numberToWords($total + round(($bill[0]->Amount / 100) * 10)) }}
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
                                <span>{{ Auth::user()->name }}</span>
                                <hr style="border:none; border-bottom: 1px solid black;">
                                <span>Print By</span>
                            </div>
                        </div>

                        <p class="text-center" style="margin-top:30px">Please pay your bill in date of 10th per month.
                            Otherwise your
                            Electric Supply will be disconnected. Thank you for your co-operation.</p>

                        <div class="row" style="margin-top:30px">
                            <div class="col-md-3">
                                <span>Print Date: {{ date('d-F-Y', strtotime(now())) }}</span>
                            </div>
                            <div class="col-md-2 offset-md-7 text-center">
                                <span>Print Time {{ date('h:i a', strtotime(now())) }}</span>
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
