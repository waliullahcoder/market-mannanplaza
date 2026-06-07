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

        <form action="{{ route('rent.increment') }}" method="GET">
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
                        <input type="text" class="d-none" autofocus="true">

                        <div class="col-md-6">
                            <label for="from_date">Start Date</label>
                            <input type="text" name="start_date" class="form-control datepicker" autocomplete="off"
                                value="{{ date('d-m-Y', strtotime(request('start_date', date('01-m-Y')))) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="to_date">End Date</label>
                            <input type="text" name="end_date" class="form-control datepicker" autocomplete="off"
                                value="{{ date('d-m-Y', strtotime(request('end_date', date('t-m-Y')))) }}" required>
                        </div>

                    </div>
                </div>

                <div class="custom-card-footer">
                    <div class="row text-right">
                        <div class="col-md-1 col-11 offset-md-11 text-right">
                            <button type="submit" id="search" name="search" value="1"
                                class="btn float-right btn-outline-info btn-lg waves-effect search"><i
                                    class="fa fa-search"></i>
                                Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        @if ($matchedTenants)
            <form action="{{ route('update.tenant.rent') }}" method="POST">
                @csrf

                <table class="table table-bordered table-striped table-custom">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Floor</th>
                            <th>Position</th>
                            <th>Current Rent</th>
                            <th>New Rent</th>
                            <th>
                                <input type="checkbox" id="checkAll">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matchedTenants as $matchedTenant)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $matchedTenant->Code }}</td>
                                <td>{{ $matchedTenant->Name }}</td>
                                <td>{{ $matchedTenant->Unit }}</td>
                                <td>{{ $matchedTenant->Floor }}</td>
                                <td>{{ $matchedTenant->PositionNo }}</td>
                                <td>{{ $matchedTenant->Agg0ne }}</td>
                                <td>{{ round($matchedTenant->Agg0ne + (($matchedTenant->Agg0ne) / 100) * $matchedTenant->incrRate) }}
                                </td>
                                <td>
                                    <input type="checkbox" name="positionIds[]" value="{{ $matchedTenant->id }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row mt-4">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn float-right btn-outline-info btn-lg waves-effect search">
                            <i class="fa fa-save"></i> Update
                        </button>
                    </div>
                </div>

            </form>
        @endif


    </div>

@endsection


@section('custom-js')
    <script>
        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
