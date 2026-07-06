@extends('admin.layouts.master')

@section('content')
     
    <form action="{{ route($formLink) }}" method="POST">
        @csrf
        <div class="card noprint">
                @php
                    $errmessage = Session::get('errorMesg');
                @endphp

                @if (isset($errmessage))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Ops!</strong> {{ $errmessage }}
                    </div>
                @endif

                @php
                    Session::forget('errorMesg');
                @endphp
            <div class="custom-card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="custom-card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-4">
                         @if ($bills == []) 
                        <a href="{{ route('service.charge.prepare') }}"
                            class="btn btn-outline-info btn-lg waves-effect search float-right"><i
                                class="fa fa-arrow-circle-left"></i>
                            Go Back</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                     <div class="col-md-4">
                            <label for="floor">Floor</label>
                            <select name="floor" class="form-control select2" id="floor">
                                @foreach ($floors as $floor)
                                    <option value="{{ $floor->name }}">
                                        {{ $floor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    <div class="col-md-4">
                        <label for="month">Month</label>
                        <select name="CMonth" class="form-control select2" id="month">
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="year">Year</label>
                        <select name="CYear" class="form-control select2" id="year">
                            <option value="2026">2026</option>
                            @for ($i = 2000; $i <= 2055; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                            <label for="floor">Passage Charge</label>
                            <input type="text" class="form-control" name="service_charge">
                    </div>
                    <div class="col-md-6">
                            <label for="floor">Service Charge</label>
                            <input type="text" class="form-control" name="passage_charge">
                    </div>
                   

                </div>
            </div>

             <div class="custom-card-footer">
                        <div class="row ">
                         @if ($bills == [])    
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn-block btn-outline-info bg-none btn-lg buttonAddEdit float-right" style="background: none;border: 1px solid;" name="action" value="search">Search</button>
                        </div>
                        <div class="col-md-6 text-left">
                            <button type="submit" class="btn-block btn-outline-info bg-none btn-lg buttonAddEdit float-right" style="background: none;border: 1px solid;">Auto
                                Service Charge
                                Posting</button>
                            </div>
                        </div>
                        </div>
                        @else
                        <a href="{{ route('service.charge.prepare.add.auto') }}"
                            class="btn btn-outline-info btn-lg waves-effect search float-right"><i
                                class="fa fa-arrow-circle-left"></i>
                            Go Back</a>
                        @endif
                    
        </div>

         @if ($bills != [])
            <form action="{{ route('ebill.prepare.save') }}" method="POST" id="ebillForm">
                @csrf
                <div class="mt-5">
                    <div class="report_div">
                        <table v-if="bills" class="table table-bordered table-striped table-custom">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Client Code</th>
                                    <th>Client Name</th>
                                    <th>Floor</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bills as $clientCode => $bill)
                                    @php
                                        $row = $bill->first();
                                    @endphp

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->Client_Code }}</td>
                                        <td>{{ $row->position_holder->Name }}</td>
                                        <td>{{ $row->PositionNo }}</td>
                                        <td>{{ $cmonth }}</td>
                                        <td>{{ $cyear }}</td>
                                        <td>{{ $bill->sum('Amount') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        @endif
    </form>

@endsection
