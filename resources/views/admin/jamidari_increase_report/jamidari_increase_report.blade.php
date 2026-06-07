@extends('admin.layouts.master')

@section('content')

<div id="app">

    <form action="{{ route('jamidariIncrease.report') }}" method="GET">
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

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="text" name="start_date" id="start_date" class="form-control datepicker"
                                autocomplete="off" value="{{ request()->start_date ? date('Y-m-d', strtotime(request()->start_date)) : date('01-m-Y') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="text" name="end_date" id="end_date" class="form-control datepicker"
                                autocomplete="off" value="{{ request()->end_date ? date('Y-m-d', strtotime(request()->end_date)) : date('d-m-Y', strtotime(now())) }}">
                        </div>
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

    @if (request()->searched)

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


        <table class="table table-bordered table-striped table-custom">
            <thead>
                <tr>
                    <th>SL#</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>Increase Date</th>
                    <th>Increase Rate (sqft)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report as $ld)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ld['client']['Code'] }}</td>
                    <td>{{ $ld['client']['Name'] }}</td>
                    <td>{{ date('d-m-Y', strtotime($ld['client']['BusinessStart'])) }}</td>
                    <td>{{ $ld['increase_date'] }}</td>
                    <td>{{ $ld['client']['incrRate'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </div>

    @endif

</div>

@endsection
