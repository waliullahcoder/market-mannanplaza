@extends('admin.layouts.masterReport')

@section('search_card_body')
<div class="row">
    <div class="col-md-12 form-group">
        <input class="form-control" type="hidden" name="print" value="print">
    </div>
</div>

<div class="row">

    <div class="col-md-4">
        <label for="unit">Unit</label>
        <select name="unit" class="form-control select2" id="unit">
            <option value="">Select an option</option>
            @foreach ($units as $unit)
            <option value="{{ $unit->name }}">{{ $unit->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 form-group">
        <label for="from-date">From Date</label>
        <input type="text" class="form-control datepicker" id="{{ $print == 'print' ? '' : 'from_date' }}"
            name="fromDate" value="{{ date('d-m-Y',strtotime($fromDate)) }}" placeholder="Select Date From">
    </div>

    <div class="col-md-4 form-group">
        <label for="to-date">To Date</label>
        <input type="text" class="form-control datepicker" id="{{ $print == 'print' ? '' : 'to_date' }}" name="toDate"
            value="{{ date('d-m-Y',strtotime($toDate)) }}" placeholder="Select Date To">
    </div>

</div>
@endsection

@section('print_card_header')
<input type="hidden" name="sunit" value="{{ $sunit }}">
<input type="hidden" name="fromDate" value="{{ $fromDate }}">
<input type="hidden" name="toDate" value="{{ $toDate }}">

<input type="hidden" id="print_value" name="print" value="{{ $print }}">
@endsection

@section('print_card_body')
<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered table-sm">
            <thead class="thead-green">
                <tr>
                    <td colspan="4" style="font-size: 20px; font-weight: bold; text-align: center;">Income</td>
                </tr>

                <tr>
                    <th width="20px">Sl</th>
                    <th width="100px">Date</th>
                    <th>Head Name</th>
                    <th width="80px">Balance</th>
                </tr>
            </thead>

            <tbody>
                @php
                $sl = 1;
                $totalIncome = 0;
                @endphp
                <tr>
                    <td align="right" colspan="3">Previous Balance</td>
                    <td align="right">{{ $report['prevBalance'] }}</td>
                </tr>
                @foreach ($report['incomeList'] as $incomeList)
                @php
                $totalIncome = $totalIncome + $incomeList['amount'];
                @endphp
                <tr>
                    <td>{{ $sl++ }}</td>
                    <td>{{ $incomeList['date'] }}</td>
                    <td>{{ $incomeList['head'] }}</td>
                    <td align="right">{{ $incomeList['amount'] }}</td>
                </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3" align="right"><b>Total Income</b></td>
                    <td align="right" style="font-weight: bold;">{{ $totalIncome >= 0 ? $totalIncome :
                        '('.abs($totalIncome).')' }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="col-md-6">
        <table class="table table-bordered table-sm">
            <thead class="thead-green">
                <tr>
                    <td colspan="4" style="font-size: 20px; font-weight: bold; text-align: center;">Expense</td>
                </tr>

                <tr>
                    <th width="20px">Sl</th>
                    <th width="100px">Date</th>
                    <th>Head Name</th>
                    <th width="80px">Balance</th>
                </tr>
            </thead>

            <tbody>
                @php
                $sl = 1;
                $totalExpanse = 0;
                @endphp
                @foreach ($report['ExpenseList'] as $expenseList)
                @php
                $totalExpanse = $totalExpanse + $expenseList['amount'];
                @endphp
                <tr>
                    <td>{{ $sl++ }}</td>
                    <td>{{ $expenseList['date'] }}</td>
                    <td>{{ $expenseList['head'] }}</td>
                    <td align="right">{{ $expenseList['amount'] }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" align="right"><b>Total Expense</b></td>
                    <td align="right" style="font-weight: bold;">{{ $totalExpanse >= 0 ? $totalExpanse :
                        '('.abs($totalExpanse).')' }}</td>
                </tr>
                <tr>
                    <td colspan="3" align="right"><b>Closing Balance</b></td>
                    <td align="right" style="font-weight: bold;">{{ $report['prevBalance'] + $totalIncome - $totalExpanse }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

{{-- <div class="row">
    <div class="col-md-12">
        @if ($totalIncome > $totalExpanse)
        <p style="background: green; font-size: 20px; font-weight: bold; color: white; text-align: center;">Net Profit:
            {{ $totalIncome - $totalExpanse }}</p>
        @endif

        @if ($totalIncome < $totalExpanse) <p
            style="background: red; font-size: 20px; font-weight: bold; color: white; text-align: center;">Net Lose: {{
            $totalExpanse - $totalIncome }}</p>
            @endif
    </div>
</div> --}}
@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
            Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            var table = $('#dataTable').DataTable( {
                "order": [[0, "asc"]]
            } );

            table.on('order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            // $('[data-toggle="tooltip"]').tooltip();
        });
</script>
@endsection
