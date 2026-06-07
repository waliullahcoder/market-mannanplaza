@extends('admin.layouts.master')

@section('content')


    <form action="{{ route('jamidari.prepare.save') }}" method="POST">
        @csrf

        <div class="card noprint">
            <div class="custom-card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="custom-card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('service.charge.prepare') }}" class="btn btn-outline-info btn-lg waves-effect search float-right"><i class="fa fa-arrow-circle-left"></i>
                            Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <div class="mt-5 report_div">

        <div class="d-flex justify-content-between font-weight-bold">
            <span>Unit: {{ $data->bills[0]->position_holder->Unit }}</span>
            <span class="float-right">Floor: {{ $data->bills[0]->position_holder->Floor }}</span>
        </div>

        <table class="table table-bordered table-striped table-custom">
            <thead>
                <tr>
                    <th style="width:20px;">SL</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Floor</th>
                    <th>PositionNo</th>
                    <th>Utility Name</th>
                    <th style="width:100px;">Bill</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 1;
                $total_rent = 0;
                @endphp
                @foreach ($data->bills as $bill)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $bill->Client_Code }}</td>
                        <td>{{ $bill->position_holder->Name }}</td>
                        <td>{{ $bill->position_holder->Unit }}</td>
                        <td>{{ $bill->position_holder->Floor }}</td>
                        <td>{{ $bill->position_holder->PositionNo }}</td>
                        <td>{{ $bill->utility->name }}</td>
                        <td>{{ $bill->Amount }}</td>
                    </tr>
                    @php
                    $total_rent += $bill->Amount;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="7" class="text-right font-weight-bold">Total Floor Rent</td>
                    <td>{{ $total_rent }}</td>
                </tr>
            </tbody>
        </table>



    </div>


    <script>
        function printTable() {
            print();
        }

    </script>

@endsection
