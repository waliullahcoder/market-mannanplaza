@extends('admin.layouts.masterPrint')

@section('content')
    <table id="report-header">
        <tr>
            <td>Credit Voucher</td>
        </tr>
    </table>

    <div id="pad-bottom"></div>

    <table id="account-voucher-header">
        <thead>
            <tr>
                <th align="left">
                    Voucher No: {{ $creditEntry->voucher_no }}
                </th>
                <th align="right">
                    Date: {{ date('d-m-Y', strtotime($creditEntry->voucher_date)) }}
                </th>
            </tr>
        </thead>
    </table>

    <div id="pad-bottom"></div>

    <table id="account-voucher-table">
        <thead>
            <tr>
                <th colspan="2" align="left" style="padding: 10px 10px">Narration: {{ $creditEntry->narration }}
                </th>
            </tr>
        </thead>

        <tbody>
            @foreach ($creditEntries as $item)
                <tr>
                    <td style="padding: 10px;">{{ $item->creditHeadName }} - {{ $item->creditHeadCode }}</td>
                    <td align="right" style="padding: 10px;">{{ $item->credit_amount }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <th style="text-align: left; padding: 10px">
                    @php
                        $inWords = \App\HelperClass::numberToWords($creditEntry->debit_amount);
                    @endphp
                    In Words : {{ $inWords }} Taka Only.
                    <b></b>
                </th>
                <th style="text-align: right; padding: 10px">
                    {{ number_format($creditEntry->debit_amount) }}
                </th>
            </tr>
        </tfoot>
    </table>

    <div style="padding: 60px"></div>

    <table id="voucher-sign-table">
        <tr>
            <td>
                <span>
                    <h3 class="overline">Receive From</h3>
                </span>
            </td>
            <td align="right">
                <span>
                    <span>
                        <h3 class="overline">Accountant</h3>
                    </span>
                </span>
            </td>
        </tr>
    </table>
@endsection
