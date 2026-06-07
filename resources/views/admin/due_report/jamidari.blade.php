@extends('admin.layouts.master')

@section('content')

<div id="app">

    <form action="{{ route('jamidari.due.report') }}" method="GET">
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

                    <div class="col-md-4">
                        <label for="Client_Code">Client Code</label>
                        <select class="form-control select2" name="client_code" id="search_code">
                            <option value="">Select An Tenant</option>
                            @foreach ($data->tenants as $tenant)
                            <option value="{{ $tenant->Code }}"
                                @if (request()->client_code == $tenant->Code)
                                selected
                                @endif
                                >{{ $tenant->Code }} ({{ $tenant->Name }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="unit">Unit</label>
                        <select name="unit" class="form-control select2" id="unit">
                            <option value="">Select an option</option>
                            @foreach ($data->units as $unit)
                            <option value="{{ $unit->name }}"
                                @if (request()->unit == $unit->name)
                                selected
                                @endif
                                >{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="floor">Floor</label>
                        <select name="floor" class="form-control select2" id="floor">
                            <option value="">Select an option</option>
                            @foreach ($data->floors as $floor)
                            <option value="{{ $floor->name }}"
                                @if (request()->floor == $floor->name)
                                selected
                                @endif
                                >{{ $floor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="row mt-2">

                    <div class="col-md-4">
                        <label for="client_type">Client Type</label>
                        <select class="form-control select2" id="client_type" name="client_type">
                            <option value="">All</option>
                            <option value="Sale"
                            @if (request()->client_type == "Sale")
                                selected
                            @endif
                            >Sale</option>
                            <option value="Rent"
                            @if (request()->client_type == "Rent")
                                selected
                            @endif
                            >Rent</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="month">Month</label>
                        <select class="form-control select2" id="CMonth" name="CMonth">
                            <option value="">Select an Option</option>
                            @foreach ($data->months as $m)
                            <option value="{{ $m }}"
                            @if (request()->CMonth == $m)
                            selected
                            @endif
                            >{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-4">
                        <label for="year">Year</label>
                        <select class="form-control select2" id="CYear" name="CYear">
                            <option value="">Select an Option</option>
                            @for ($i = 2018; $i <= 2055; $i++)
                            <option value="{{ $i }}"
                            @if (request()->CYear == $i)
                            selected
                            @endif
                            >{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                </div>

            </div>

            <div class="custom-card-footer">
                <div class="row text-right">
                    <div class="col-md-8 offset-md-4">
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

    @if (count($ClientWisebills) != 0)

    <div class="mt-3 report_div table-responsive">

        <div class="text-center">
            <h3 class="font-weight-bold">{{ $project->name }}</h3>
            <p>{{ $project->address }}</p>
            <p>{{ $project->contact }}</p>
            <p>Floor: {{ isset($sfloor) ? $sfloor : 'All' }} - Unit: {{ isset($sunit) ? $sunit : 'All' }}</p>
            <hr style="border:none; border-bottom: 1px solid black;">
            <h4 class="font-weight-bold mt-2">Jamidari Due Report</h4>
            <hr style="border:none; border-bottom: 1px solid black;">
        </div>

        <table class="table table-bordered table-striped table-custom">
            <thead>
                <tr>
                    <th>SL#</th>
                    {{-- <th style="width: 100px">Unit</th> --}}
                    {{-- <th style="width: 100px">Floor</th> --}}
                    <th>Code</th>
                    <th>Position</th>
                    <th>Name</th>
                    <th>Due Months</th>
                    <th style="width: 100px">Due Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                $si = 1;
                $total = 0;
                @endphp

                @foreach ($ClientWisebills as $key => $bill)

                @php
                $total += $bill['client_total_due'];
                @endphp

                <tr id="tr_{{ $key }}">
                    <td>{{ $si }}</td>
                    {{-- <td>{{ $bill['client_unit'] }}</td> --}}
                    {{-- <td>{{ $bill['client_floor'] }}</td> --}}
                    <td>{{ $bill['client_code'] }}</td>
                    <td>{{ $bill['client_position_no'] }}</td>
                    <td>{{ $bill['client_name'] }}</td>
                    <td>{{ $bill['client_due_months'] }}</td>
                    <td>{{ $bill['client_total_due'] }}</td>
                </tr>
                @php
                $si++;
                @endphp
                @endforeach
                <tr>
                    <td colspan="5">
                        <span class="font-weight-bold float-right">Total:</span>
                    </td>
                    <td>{{ $total }}</td>
                </tr>
            </tbody>
            {{-- <tfoot>
                <tr>
                    <td colspan="5">
                        <span class="font-weight-bold float-right">Total:</span>
                    </td>
                    <td>{{ $total }}</td>
                </tr>
            </tfoot> --}}
        </table>
        <p>Print Date: {{ date('d-m-Y h:i:s') }}</p>
    </div>

    @endif

</div>

@endsection
