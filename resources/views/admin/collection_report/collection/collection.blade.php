@extends('admin.layouts.master')

@section('custom_css')
    <style>
        @media print {
            @page {
                size: landscape
            }
        }
    </style>
@endsection

@section('content')

    <div id="app">

        <form action="{{ route('collection.report') }}" method="GET">
            <input type="hidden" name="searched" value="true">

            <div class="card noprint">
                <div class="custom-card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="custom-card-title">{{ $title }}</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="unit">Unit</label>
                            <select name="unit" class="form-control select2" id="unit" required>
                                <option value="">Select an option</option>
                                @foreach ($data->units as $unit)
                                    <option value="{{ $unit->name }}"
                                        {{ request('unit') == $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="floor">Floor</label>
                            <select name="floor" class="form-control select2" id="floor">
                                <option value="">Select an option</option>
                                @foreach ($data->floors as $floor)
                                    <option value="{{ $floor->name }}"
                                        {{ request('floor') == $floor->name ? 'selected' : '' }}>{{ $floor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="from_date">Collection Start Date</label>
                            <input type="text" name="from_date" class="form-control datepicker"
                                value="{{ $fromDate }}" autocomplete="off" autofocus="false">
                        </div>

                        <div class="col-md-3">
                            <label for="to_date">Collection Start Date</label>
                            <input type="text" name="to_date" class="form-control datepicker" value="{{ $toDate }}"
                                autocomplete="off" autofocus="false">
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="month">Month</label>
                            <select name="CMonth" class="form-control select" id="month" data-placeholder="Select Month">
                                <option value="">Select Month<option>
                                @foreach ($months as $m)
                                    @php
                                        $select = '';
                                        $select = request()->CMonth == $m ? 'selected' : '';
                                        if (!$select) {
                                            $select = !request()->CMonth && date('F') == $m ? 'selected' : '';
                                        }
                                    @endphp
                                    <option value="{{ $m }}" {{ $select }}>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="year">Year</label>
                            <select name="CYear" class="form-control select" id="year" data-placeholder="Select Year">
                                <option value="">Select Year<option>
                                @for ($i = 2018; $i <= 2055; $i++)
                                    @php
                                        $select = '';
                                        $select = request()->CYear == $i ? 'selected' : '';
                                        if (!$select) {
                                            $select = !request()->CYear && date('Y') == $i ? 'selected' : '';
                                        }
                                    @endphp
                                    <option value="{{ $i }}" {{ $select }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                    </div>
                </div>

                <div class="custom-card-footer">
                    <div class="row text-right">
                        <div class="col-md-2 col-6 offset-md-9 text-right">
                            <button type="submit" id="search"
                                class="btn float-right btn-outline-info btn-lg waves-effect search"><i
                                    class="fa fa-search"></i>
                                Search</button>
                        </div>
                        <div class="col-md-1 col-6 text-left">
                            <button type="button" onclick="print()" class="btn btn-outline-info btn-lg waves-effect ml-2">
                                <i class="fa fa-print"></i>
                                Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if (count($ClientWisebills) != 0)
            <div class="mt-3 report_div table-responsive">
                <div class="text-center">
                    <h3 class="font-weight-bold">{{ $project->name }}</h3>
                    <p>{{ $project->address }}</p>
                    <p>{{ $project->contact }}</p>
                    <hr style="border:none; border-bottom: 1px solid black;">
                    <h4 class="font-weight-bold mt-2">
                        Collection Report
                    </h4>
                    <span>Unit: {{ isset($sunit) ? $sunit : 'All' }} - Floor:{{ isset($sfloor) ? $sfloor : 'All' }}</span>
                    <br>
                    <span>Date: {{ date('d-m-Y', strtotime($from_date)) }} to
                        {{ date('d-m-Y', strtotime($to_date)) }}</span>
                    <hr style="border:none; border-bottom: 1px solid black;">
                </div>

                <table class="table table-bordered table-striped table-custom">
                    <thead>
                        <tr>
                            <td>SL#</td>
                            <td>Code</td>
                            <td>Name</td>
                            <td>Jamidari</td>
                            <td>Electric Bill</td>
                            <td>Service Charge</td>
                            <td>Total Collection</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $si = 1;

                            $total_rent = 0;
                            $total_ebill = 0;
                            // $total_wbill = 0;
                            $total_sbill = 0;
                            $total_total = 0;

                        @endphp

                        @foreach ($ClientWisebills as $key => $bill)
                            @php
                                $total = $bill['total_rent'] + $bill['total_ebill'] + $bill['total_sbill'];
                                if ($total == 0) {
                                    continue;
                                }

                                $total_rent += $bill['total_rent'];
                                $total_ebill += $bill['total_ebill'];
                                // $total_wbill += $bill['total_wbill'];
                                $total_sbill += $bill['total_sbill'];
                                $total_total += $total;
                            @endphp

                            <tr id="tr_{{ $key }}">
                                <td>{{ $si }}</td>
                                <td>{{ $bill['client_code'] }}</td>
                                <td>{{ $bill['client_name'] }}</td>
                                <td>{{ $bill['total_rent'] }} -
                                    ({{ $bill['rent_collection_date'] ? date('d-m-Y', strtotime($bill['rent_collection_date']->ReceiveDate)) : '' }})
                                </td>
                                <td>{{ $bill['total_ebill'] }} -
                                    ({{ $bill['ebill_collection_date'] ? date('d-m-Y', strtotime($bill['ebill_collection_date']->ReceiveDate)) : '' }})
                                </td>
                                <td>{{ $bill['total_sbill'] }} -
                                    ({{ $bill['sbill_collection_date'] ? date('d-m-Y', strtotime($bill['sbill_collection_date']->ReceiveDate)) : '' }})
                                </td>
                                <td>{{ $total }}</td>
                            </tr>
                            @php
                                $si++;
                            @endphp
                        @endforeach

                        <tr>
                            <td colspan="3">
                                <span class="font-weight-bold float-right">Total:</span>
                            </td>
                            <td>{{ $total_rent }}</td>
                            <td>{{ $total_ebill }}</td>
                            <td>{{ $total_sbill }}</td>
                            <td>{{ $total_total }}</td>
                        </tr>
                    </tbody>
                    {{-- <tfoot>
                <tr>
                    <td colspan="3">
                        <span class="font-weight-bold float-right">Total:</span>
                    </td>
                    <td>{{ $total_rent }}</td>
                    <td>{{ $total_ebill }}</td>
                    <td>{{ $total_sbill }}</td>
                    <td>{{ $total_total }}</td>
                </tr>
            </tfoot> --}}
                </table>
            </div>
        @endif

    </div>

@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {
            $('.select').select2({
                allowClear: true
            });
        });
    </script>
@endsection