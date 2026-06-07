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
                        <a href="{{ route('ebill.prepare.index') }}"
                            class="btn btn-outline-info btn-lg waves-effect search float-right"><i
                                class="fa fa-arrow-circle-left"></i>
                            Go Back</a>
                    </div>
                </div>
            </div>

            {{-- <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="unit">Unit</label>
                        <select name="unit" class="form-control select2" id="unit">
                            @foreach ($data->units as $unit)
                                <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="floor">Floor</label>
                        <select name="floor" class="form-control select2" id="floor">
                            @foreach ($data->floors as $floor)
                                <option value="{{ $floor->name }}">{{ $floor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="serialNo">Serial No</label>
                        <input type="text" class="form-control" value="{{ $data->serial_no }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for="month">Month</label>
                        <select name="CMonth" class="form-control select2" id="month">
                            <option value="January" @if ($data->current_time->englishMonth == 'January')
                                selected
                                @endif >January</option>
                            <option value="February" @if ($data->current_time->englishMonth == 'February')
                                selected
                                @endif >February</option>
                            <option value="March" @if ($data->current_time->englishMonth == 'March')
                                selected
                                @endif >March</option>
                            <option value="April" @if ($data->current_time->englishMonth == 'April')
                                selected
                                @endif >April</option>
                            <option value="May" @if ($data->current_time->englishMonth == 'May')
                                selected
                                @endif >May</option>
                            <option value="June" @if ($data->current_time->englishMonth == 'June')
                                selected
                                @endif >June</option>
                            <option value="July" @if ($data->current_time->englishMonth == 'July')
                                selected
                                @endif >July</option>
                            <option value="August" @if ($data->current_time->englishMonth == 'August')
                                selected
                                @endif >August</option>
                            <option value="September" @if ($data->current_time->englishMonth == 'September')
                                selected
                                @endif >September</option>
                            <option value="October" @if ($data->current_time->englishMonth == 'October')
                                selected
                                @endif >October</option>
                            <option value="November" @if ($data->current_time->englishMonth == 'November')
                                selected
                                @endif >November</option>
                            <option value="December" @if ($data->current_time->englishMonth == 'December')
                                selected
                                @endif >December</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="year">Year</label>
                        <select name="CYear" class="form-control select2" id="year">
                            @for ($i = 2015; $i <= 2055; $i++)
                                <option value="{{ $i }}" @if ($i == $data->current_time->year)
                                    selected
                            @endif
                            >{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="unit">Prepare Date</label>
                        <input type="text" name="PaidDate" class="form-control add_datepicker">
                    </div>

                </div>

            </div> --}}

            {{-- <div class="custom-card-footer">
                <div class="row text-right">
                    <div class="col-md-12">
                        <button type="button" id="search" class="btn btn-outline-info btn-lg waves-effect search"><i
                                class="fa fa-search"></i>
                            Search</button>

                        <button type="submit" id="save" class="btn btn-outline-info btn-lg waves-effect ml-2"><i
                                class="fa fa-save"></i> Save</button>


                        <button type="button" id="print" onclick="printTable()"
                            class="btn btn-outline-info btn-lg waves-effect search ml-2"><i class="fa fa-print"></i>
                            Print</button>
                    </div>
                </div>
            </div> --}}
        </div>
    </form>


    <div class="mt-5 report_div">

        {{-- <div class="d-flex justify-content-between font-weight-bold">
            <span>Unit: ${unit}</span>
            <span class="float-right">Floor: ${floor}</span>
        </div> --}}

        <table class="table table-bordered table-striped table-custom">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Client Code</th>
                    <th>Client Name</th>
                    <th>Position</th>
                    <th>P. Unit</th>
                    <th>C. Unit</th>
                    <th>U. Unit</th>
                    <th>L. Unit</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>

            </thead>
            <tbody>
                @php
                $i=1;
                @endphp
                @foreach ($data->bills as $bill)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $bill->position_holder->Code }}</td>
                        <td>{{ $bill->position_holder->Name }}</td>
                        <td>{{ $bill->position_holder->PositionNo }}</td>
                        <td>{{ $bill->PreviousUnit }}</td>
                        <td>{{ $bill->LastUnit }}</td>
                        <td>{{ $bill->UsesUnit }}</td>
                        <td>{{ $bill->LossUnit }}</td>
                        <td>{{ $bill->Amount }}</td>
                        <td align="center">
                            @if (Auth::user()->role != 4)

                            <form action="{{ route('ebill.prepare.delete.individual') }}" method="POST" id="delete-form-{{ $bill->id }}">
                                @csrf
                                <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                <span onclick="document.getElementById('delete-form-{{ $bill->id }}').submit()" class="text-danger">X</span>
                            </form>

                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" class="text-right">Total</th>
                    <th>{{ $data->bills->sum('UsesUnit') }}</th>
                    <th></th>
                    <th>{{ $data->bills->sum('Amount') }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>


    <script>
        function printTable() {
            print();
        }

    </script>

@endsection
