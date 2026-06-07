@extends('admin.layouts.masterPrint')

@section('content')
    <table id="report-header">
        <tr>
            @if ($fromDate == "" && $toDate == "")
                <td>Credit Voucher List From</td>
            @else
                <td>
                    Credit Voucher List From {{ date('Y-m-d',strtotime($fromDate)) }} Month  Of {{ date('Y-m-d',strtotime($toDate)) }}
                    @if ($sunit)
                        Unit : {{ $sunit }}
                    @endif
                </td>
            @endif
        </tr>
    </table>

    <div id="pad-bottom"></div>

    <table  id="report-table">
        <thead>
            <tr>
                <th width="20px">SL</th>
                <th width="100px">Vouchar No</th>
                <th width="60px">Date</th>
                <th width="150px">Debit Head</th>
                <th width="150px">Credit Head</th>
                <th width="90px">Account Status</th>
                <th width="50px">Amount</th>
            </tr>
        </thead>

        <tbody>
            @php
                $i = 0;
                $total = 0;
            @endphp
            @foreach ($transactionLists as $transactionList)
                @php
                    $i++;
                    $total = $total + $transactionList->credit_amount;
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $transactionList->voucher_no }}</td>
                    <td>{{ date('d-m-Y',strtotime($transactionList->voucher_date)) }}</td>
                    <td>{{ $transactionList->debitHeadname }}</td>
                    @php
                        $credit_head_codes = \App\CreditEntry::where('voucher_no', $transactionList->voucher_no)->where('voucher_type', 'CV')->where('credit_amount', '>', 0)->pluck('coa_head_code')->toArray();
                        $creditHeads = \App\CoaSetup::whereIn('head_code', $credit_head_codes)->get();
                    @endphp
                    <td>
                        @foreach($creditHeads as $item)
                        {{ ($loop->iteration > 1 ? ', ' : ' ') . $item->head_name }}
                        @endforeach
                    </td>
                    <td align="center">
                        @php
                            if ($transactionList->approve == 1)
                            {
                                echo "Approve";
                            }
                            else
                            {
                                echo "Pending";
                            }
                        @endphp
                    </td>
                    <td align="right">{{ $transactionList->debit_amount }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td style="text-align: center;" colspan="6"><b>Total</b></td>
                <td style="text-align: right;"><b>{{ $total }}</b></td>
            </tr>
        </tfoot>
    </table>

    <div id="pad-bottom"></div>

    <table  id="report-table">
    </table>
@endsection
