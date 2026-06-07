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
        <form action="{{ route('collection.summary.report') }}" method="GET">
            <input type="hidden" name="searched" value="true">
            <div class="card noprint">
                <div class="custom-card-header">
                    <h4 class="custom-card-title">{{ $title }}</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="unit">Unit</label>
                            <select name="unit" class="form-control select2" id="unit">
                                <option value="">Select an option</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->name }}"
                                        {{ request('unit') == $unit->name ? 'selected' : '' }}>
                                        {{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="floor">Floor</label>
                            <select name="floor" class="form-control select2" id="floor">
                                <option value="">Select an option</option>
                                @foreach ($floors as $floor)
                                    <option value="{{ $floor->name }}"
                                        {{ request('floor') == $floor->name ? 'selected' : '' }}>
                                        {{ $floor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="month">Month</label>
                            <select name="CMonth" class="form-control select2" id="month">
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
                            <select name="CYear" class="form-control select2" id="year">
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

                        <div class="col-md-6 mt-2">
                            <label for="Client_Code">Client Code</label>
                            <select class="form-control select2" name="client_code" id="search_code">
                                <option value="">Select An Client</option>
                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->Code }}"
                                        {{ request('client_code') == $tenant->Code ? 'selected' : '' }}>
                                        {{ $tenant->Code }} ({{ $tenant->Name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="custom-card-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" id="search" class="btn btn-outline-info btn-lg waves-effect search"><i
                                    class="fa fa-search"></i>
                                Search</button>
                            <button type="button" onclick="print()" class="btn btn-outline-info btn-lg waves-effect ml-2">
                                <i class="fa fa-print"></i>
                                Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if (count($ClientWisebills) > 0)
            <div class="mt-3 report_div table-responsive">
                <div class="text-center">
                    <h3 class="font-weight-bold">{{ $project->name }}</h3>
                    <p>{{ $project->address }}</p>
                    <p>{{ $project->contact }}</p>
                    <p>Year: {{ $syear }} - Month: {{ $smonth }}</p>
                    <hr style="border:none; border-bottom: 1px solid black;">
                    <h4 class="font-weight-bold mt-2">{{ $title }}</h4>
                    <hr style="border:none; border-bottom: 1px solid black;">
                </div>
                @php
                    $si = 1;
                    $t_prev_jamidari = 0;
                    $t_total_jamidari = 0;
                    $t_prev_electric = 0;
                    $t_total_electric = 0;
                    $t_prev_utility = 0;
                    $t_total_utility = 0;
                    $t_total_bill = 0;
                    $t_total_collection = 0;
                    $t_total_due = 0;
                @endphp
                @foreach ($group_floors as $floor)
                    <table class="table table-bordered table-striped table-custom">
                        <thead>
                            <tr>
                                <td colspan="2">{{ $floor->Unit }}</td>
                                <td colspan="8"></td>
                                <td class="text-right" colspan="2">{{ $floor->Floor }}</td>
                            </tr>
                            <tr>
                                <td style="width:50px;">SL#</td>
                                <td style="width:140px;">Code</td>
                                <td style="width:230px;">Name</td>
                                <td style="width:140px;" class="text-right">Prev Jamidari Due</td>
                                <td style="width:140px;" class="text-right">Jamidari Demand</td>
                                <td style="width:140px;" class="text-right">Prev Electric Due</td>
                                <td style="width:140px;" class="text-right">Electric Demand</td>
                                <td style="width:140px;" class="text-right">Prev Utility Due</td>
                                <td style="width:140px;" class="text-right">Utility Demand</td>
                                <td style="width:140px;" class="text-right">Total Demand</td>
                                <td style="width:140px;" class="text-right">Collection</td>
                                <td style="width:140px;" class="text-right">Due</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $si = 1;
                                $prev_jamidari = 0;
                                $total_jamidari = 0;
                                $prev_electric = 0;
                                $total_electric = 0;
                                $prev_utility = 0;
                                $total_utility = 0;
                                $total_bill = 0;
                                $total_collection = 0;
                                $total_due = 0;
                            @endphp

                            @foreach ($ClientWisebills->where('unit', $floor->Unit)->where('floor', $floor->Floor) as $key => $bill)
                                @php
                                    if ($bill['total_bill'] == 0 && $bill['total_collection'] == 0) {
                                        continue;
                                    }

                                    $prev_jamidari += $bill['prev_jamidari'];
                                    $total_jamidari += $bill['jamidari_demand'];
                                    $prev_electric += $bill['prev_electric'];
                                    $total_electric += $bill['electric_demand'];
                                    $prev_utility += $bill['prev_utility'];
                                    $total_utility += $bill['utility_demand'];
                                    $total_bill += $bill['total_bill'];
                                    $total_collection += $bill['total_collection'];
                                    $total_due += $bill['total_bill'] - $bill['total_collection'];
                                @endphp

                                <tr id="tr_{{ $key }}">
                                    <td>{{ $si }}</td>
                                    <td>{{ $bill['client_code'] }}</td>
                                    <td>{{ $bill['client_name'] }}</td>
                                    <td class="text-right">{{ $bill['prev_jamidari'] }}</td>
                                    <td class="text-right">{{ $bill['jamidari_demand'] }}</td>
                                    <td class="text-right">{{ $bill['prev_electric'] }}</td>
                                    <td class="text-right">{{ $bill['electric_demand'] }}</td>
                                    <td class="text-right">{{ $bill['prev_utility'] }}</td>
                                    <td class="text-right">{{ $bill['utility_demand'] }}</td>
                                    <td class="text-right">{{ $bill['total_bill'] }}</td>
                                    <td class="text-right">{{ $bill['total_collection'] }}</td>
                                    <td class="text-right">{{ $bill['total_bill'] - $bill['total_collection'] }}
                                    </td>
                                </tr>
                                @php
                                    $si++;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <span class="font-weight-bold float-right">Total:</span>
                                </td>
                                <td class="text-right">{{ $prev_jamidari }}</td>
                                <td class="text-right">{{ $total_jamidari }}</td>
                                <td class="text-right">{{ $prev_electric }}</td>
                                <td class="text-right">{{ $total_electric }}</td>
                                <td class="text-right">{{ $prev_utility }}</td>
                                <td class="text-right">{{ $total_utility }}</td>
                                <td class="text-right">{{ $total_bill }}</td>
                                <td class="text-right">{{ $total_collection }}</td>
                                <td class="text-right">{{ $total_due }}</td>
                            </tr>
                        </tfoot>
                        @php
                            $t_prev_jamidari += $prev_jamidari;
                            $t_total_jamidari += $total_jamidari;
                            $t_prev_electric += $prev_electric;
                            $t_total_electric += $total_electric;
                            $t_prev_utility += $prev_utility;
                            $t_total_utility += $total_utility;
                            $t_total_bill += $total_bill;
                            $t_total_collection += $total_collection;
                            $t_total_due += $total_due;
                        @endphp
                    </table>
                @endforeach
                <table class="table table-bordered table-striped table-custom">
                    <thead>
                        <tr>
                            <td style="width:50px;"></td>
                            <td style="width:140px;"></td>
                            <td style="width:230px;"></td>
                            <td style="width:140px;" class="text-right">{{ $t_prev_jamidari }}</td>
                            <td style="width:140px;" class="text-right">{{ $t_total_jamidari }}</td>
                            <td style="width:140px;" class="text-right">{{ $t_prev_electric }}</td>
                            <td style="width:140px;" class="text-right">{{ $t_total_electric }}</td>
                            <td style="width:140px;" class="text-right">{{ $t_prev_utility }}</td>
                            <td style="width:140px;" class="text-right">{{ $t_total_utility }}</td>
                            <td style="width:140px;" class="text-right">{{ $t_total_bill }}</td>
                            <td style="width:140px;" class="text-right">{{ $t_total_collection }}</td>
                            <td style="width:140px;" class="text-right">{{ $t_total_due }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
        @endif
    </div>
@endsection
