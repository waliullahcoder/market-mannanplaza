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

    <form class="noprint" action="{{ route('collectionDeposit.report') }}" method="GET">
        {{-- <input type="hidden" name="searched" value="true"> --}}

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

                    <div class="col-md-6">
                        <label for="unit">Unit</label>
                        <select name="unit" class="form-control select2" id="unit">
                            <option value="">Select an option</option>
                            @foreach ($units as $unit)
                            <option value="{{ $unit->name }}" @if (request()->unit == $unit->name)
                                selected
                                @endif
                                >{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="floor">Floor</label>
                        <select name="floor" class="form-control select2" id="floor">
                            <option value="">Select an option</option>
                            @foreach ($floors as $floor)
                            <option value="{{ $floor->name }}" @if (request()->floor == $floor->name)
                                selected
                                @endif
                                >{{ $floor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mt-2">
                        <label for="month">Month</label>
                        <select name="month" class="form-control select2" id="month">
                            @foreach ($months as $m)
                            <option value="{{ $m }}"
                            @php
                            $select="" ; $select=request()->month == $m ? "selected" : "";
                            if(!$select){

                                $select = !request()->month && date('F') == $m ? "selected" : "";
                            }
                                @endphp
                                {{ $select }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mt-2">
                        <label for="year">Year</label>
                        <select name="year" class="form-control select2" id="year">
                            @for ($i = 2018; $i <= 2055; $i++) <option value="{{ $i }}"
                            @php
                            $select="" ;
                            $select=request()->CYear == $i ? "selected" : "";
                            if(!$select){

                                $select = !request()->CYear && date('Y') == $i ? "selected" : "";
                            }
                            @endphp
                            {{ $select }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="Client_Code">Client Code</label>
                        <select class="form-control select2" name="client_code" id="search_code">
                            <option value="">Select An Client</option>
                            @foreach ($tenants as $tenant)
                            <option value="{{ $tenant->Code }}" @if (request()->client_code == $tenant->Code)
                                selected
                                @endif
                                >{{ $tenant->Code }} ({{ $tenant->Name }})</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="row">

                </div>
            </div>

            <div class="custom-card-footer">
                <div class="row">

                    <div class="col-md-12 text-right">

                        <button type="submit" id="searched_summary" name="searched_summary" value="true"
                            class="btn btn-outline-info btn-lg waves-effect search"><i class="fa fa-search"></i>
                            Search Summary</button>

                        <button type="submit" id="searched_details" name="searched_details" value="true"
                            class="btn btn-outline-info btn-lg waves-effect search"><i class="fa fa-search"></i>
                            Search Details</button>

                        <button type="button" onclick="print()" class="btn btn-outline-info btn-lg waves-effect ml-2">
                            <i class="fa fa-print"></i>
                            Print Data
                        </button>

                    </div>

                </div>
            </div>
        </div>
    </form>

    @if (request()->searched_details)

    <div class="mt-3 report_div">

        <div class="text-center">
            <h3 class="font-weight-bold">{{ $project->name }}</h3>
            <p>{{ $project->address }}</p>
            <p>{{ $project->contact }}</p>
            <p>Year: {{ request()->year }} - Month: {{ request()->month }}</p>
            <hr style="border:none; border-bottom: 1px solid black;">
            <h4 class="font-weight-bold mt-2">{{ $title }}</h4>
            <hr style="border:none; border-bottom: 1px solid black;">
        </div>

        @foreach ($report as $table)

        @php
        if(!count($table['tbody'])){
        continue;
        }
        @endphp

        <table class="table table-bordered table-striped table-custom">
            <thead>
                <tr>
                    <th colspan="7">Unit: {{ $table['thead']['unit']}}</th>
                    <th colspan="7">Floor: {{ $table['thead']['floor']}}</th>
                </tr>
                <tr>
                    <th>SL#</th>
                    <th>Code</th>
                    <th style="width:200px;">Name</th>
                    <th class="text-right" style="width:100px;">Previous Due</th>
                    <th class="text-right">Jamidari</th>
                    <th class="text-right">Electricity</th>
                    <th class="text-right">S.Chagre</th>
                    <th class="text-right">Month Bill</th>
                    <th class="text-right">Total Bill</th>
                    <th class="text-right">Collection</th>
                    <th class="text-right" style="width:100px;">Deposit Bank</th>
                    <th class="text-right" style="width:100px;">Deposit Cash</th>
                    <th class="text-right" style="width:100px;">Running Due</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($table['tbody'] as $ld)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ld['client_code'] }}</td>
                    <td>{{ $ld['client_name'] }}</td>
                    <td class="text-right">{{ $ld['previous_due'] }}</td>
                    <td class="text-right">{{ $ld['jamidari_demand'] }}</td>
                    <td class="text-right">{{ $ld['electric_demand'] }}</td>
                    <td class="text-right">{{ $ld['utility_demand'] }}</td>
                    <td class="text-right">{{ $ld['current_demand'] }}</td>
                    <td class="text-right">{{ $ld['current_due'] }}</td>
                    <td class="text-right">{{ $ld['collection'] }}</td>
                    <td class="text-right">{{ $ld['deposit_bank'] }}</td>
                    <td class="text-right">{{ $ld['deposit_cash'] }}</td>
                    <td class="text-right">{{ $ld['running_due'] }}</td>
                    <td></td>
                </tr>
                @endforeach

                <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <th class="text-right">{{ $table['tfoot']['total_previous_due'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_jamidari_demand'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_electric_demand'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_utility_demand'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_current_demand'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_current_due'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_collection'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_deposit_bank'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_deposit_cash'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_running_due'] }}</th>
                    <th></th>
                </tr>

            </tbody>
            {{-- <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th class="text-right">{{ $table['tfoot']['total_previous_due'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_jamidari_demand'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_electric_demand'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_utility_demand'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_current_demand'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_current_due'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_collection'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_deposit_bank'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_deposit_cash'] }}</th>
                    <th class="text-right">{{ $table['tfoot']['total_running_due'] }}</th>
                    <th></th>
                </tr>
            </tfoot> --}}
        </table>

        @endforeach


    </div>

    @endif

    @if (request()->searched_summary)

    <div class=" report_div">

        <div class="text-center">
            <h3 class="font-weight-bold">{{ $project->name }}</h3>
            <p>{{ $project->address }}</p>
            <p>{{ $project->contact }}</p>
            <p>Year: {{ request()->year }} - Month: {{ request()->month }}</p>
            <hr style="border:none; border-bottom: 1px solid black;">
            <h4 class="font-weight-bold mt-2">{{ $title }}</h4>
            <hr style="border:none; border-bottom: 1px solid black;">
        </div>

        <table class="table table-bordered table-striped table-custom">
            <thead>
                <tr>
                    <th colspan="11">Unit: {{ request()->unit }}</th>
                </tr>
                <tr>
                    {{-- <th>SL#</th> --}}
                    <th>Floor</th>
                    <th>Types</th>
                    <th class="text-right">Previous Due</th>
                    <th class="text-right">Current Demand</th>
                    <th class="text-right">Total Bill</th>
                    <th class="text-right">Collection</th>
                    <th class="text-right">Running Due</th>
                    <th class="text-right">Deposit Bank</th>
                    <th class="text-right">Deposit Cash</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @php

                $total_previous_due = 0;
                $total_current_demand = 0;
                $total_current_due = 0;
                $total_collection = 0;
                $total_running_due = 0;
                $total_deposit_bank = 0;
                $total_deposit_cash = 0;


                $types = [
                'aRent' => 'Rent',
                'rent' => 'Jamidari',
                'eBill' => "E Bill",
                'service' => "Service Charge",
                ];

                $floor = '';
                @endphp
                @foreach ($report as $ld)
                @foreach ($types as $key => $type)
                <tr>
                    {{-- <td>{{ $loop->iteration }}</td> --}}

                    @if ($ld['floor'] != $floor)
                    <td rowspan="4">{{ $ld['floor'] }}</td>
                    @php
                    $floor = $ld['floor'];
                    @endphp
                    @endif

                    <td>{{ $type }}</td>
                    <td class="text-right">{{ $ld['previous_due'][$key] }}</td>
                    <td class="text-right">{{ $ld['current_demand'][$key] }}</td>
                    <td class="text-right">{{ $ld['previous_due'][$key] + $ld['current_demand'][$key] }}</td>
                    <td class="text-right">{{ $ld['collection']['collection'][$key] }}</td>
                    <td class="text-right">{{ ($ld['previous_due'][$key] + $ld['current_demand'][$key]) -
                        $ld['collection']['collection'][$key] }}</td>
                    <td class="text-right">{{ $ld['collection']['collection_bank'][$key] }}</td>
                    <td class="text-right">{{ $ld['collection']['collection_cash'][$key] }}</td>
                    <td></td>
                </tr>


                @php
                $total_previous_due += $ld['previous_due'][$key];
                $total_current_demand += $ld['current_demand'][$key];
                $total_current_due += $ld['previous_due'][$key] + $ld['current_demand'][$key];
                $total_collection += $ld['collection']['collection'][$key];
                $total_running_due += ($ld['previous_due'][$key] + $ld['current_demand'][$key]) -
                        $ld['collection']['collection'][$key];
                $total_deposit_bank += $ld['collection']['collection_bank'][$key];
                $total_deposit_cash += $ld['collection']['collection_cash'][$key];
                @endphp


                @endforeach
                @endforeach

                <tr>
                    <th colspan="2" class="text-right">Total</th>
                    <th class="text-right">{{ $total_previous_due }}</th>
                    <th class="text-right">{{ $total_current_demand }}</th>
                    <th class="text-right">{{ $total_current_due }}</th>
                    <th class="text-right">{{ $total_collection }}</th>
                    <th class="text-right">{{ $total_running_due }}</th>
                    <th class="text-right">{{ $total_deposit_bank }}</th>
                    <th class="text-right">{{ $total_deposit_cash }}</th>
                    <th></th>
                </tr>
            </tbody>
            {{-- <tfoot>
                <tr>
                    <th colspan="2" class="text-right">Total</th>
                    <th>{{ $total_previous_due }}</th>
                    <th>{{ $total_current_demand }}</th>
                    <th>{{ $total_current_due }}</th>
                    <th>{{ $total_collection }}</th>
                    <th>{{ $total_running_due }}</th>
                    <th>{{ $total_deposit_bank }}</th>
                    <th>{{ $total_deposit_cash }}</th>
                    <th></th>
                </tr>
            </tfoot> --}}
        </table>

    </div>

    @endif

</div>

@endsection
