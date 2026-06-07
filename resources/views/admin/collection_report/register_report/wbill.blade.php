@extends('admin.layouts.master')

@section('content')

    <div id="app">

        <form action="{{ route('water.bill.register') }}" method="GET">
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
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="search_code" class="float-left mt-2">Find By Code</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control select2" name="search_code" id="search_code">
                                        @foreach ($tenants as $tenant)
                                            <option value="{{ $tenant->Code }}" @if ($search_code == $tenant->Code)
                                                selected
                                        @endif
                                        >{{ $tenant->Code }} ({{ $tenant->Name }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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

        @if (count($bills) != 0)

            <div class="report_div">

                <div class="text-center">
                    <h3 class="font-weight-bold">{{ $project->name }}</h3>
                    <p>{{ $project->address }}</p>
                    <p>{{ $project->contact }}</p>
                    <hr style="border:none; border-bottom: 1px solid black;">
                    <h4 class="font-weight-bold mt-2">Water Bill Register</h4>
                    <hr style="border:none; border-bottom: 1px solid black;">
                </div>

                <div class="row my-4">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td width="100px">Unit Name</td>
                                <td width="20px">:</td>
                                <td width="100px">{{ $client_info->Unit }}</td>
                            </tr>

                            <tr>
                                <td width="100px">Position</td>
                                <td width="20px">:</td>
                                <td width="100px">{{ $client_info->PositionNo }}</td>
                            </tr>

                            <tr>
                                <td width="100px">Position Holder</td>
                                <td width="20px">:</td>
                                <td width="100px">{{ $client_info->Name }}</td>
                            </tr>

                            <tr>
                                <td width="100px">Mobile No</td>
                                <td width="20px">:</td>
                                <td width="100px">{{ $client_info->Mobile }}</td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-md-6">

                        <table>
                            <tr>
                                <td width="100px">Floor Name</td>
                                <td width="20px">:</td>
                                <td width="100px">{{ $client_info->Floor }}</td>
                            </tr>

                            <tr>
                                <td width="100px">Position Size</td>
                                <td width="20px">:</td>
                                <td width="100px">{{ $client_info->PositionSize }}</td>
                            </tr>

                            <tr>
                                <td width="100px">Monthly Rent</td>
                                <td width="20px">:</td>
                                <td width="100px">{{ $client_info->Agg0ne }}</td>
                            </tr>

                        </table>

                    </div>
                </div>

                <table class="table table-bordered table-striped table-custom">
                    <thead>
                        <tr>
                            <td>Collection Date</td>
                            <td>Serial No</td>
                            <td>Month</td>
                            <td>Year</td>
                            <td>P.Unit</td>
                            <td>C.Unit</td>
                            <td>Uses Unit</td>
                            <td>Amount</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total = 0;
                        @endphp
                        @foreach ($bills as $bill)
                            <tr id="tr_{{ $bill->id }}">
                                <td>{{ date('d-M-y', strtotime($bill->ReceiveDate)) }}</td>
                                <td>{{ $bill->SerialNo }}</td>
                                <td>{{ $bill->CMonth }}</td>
                                <td>{{ $bill->CYear }}</td>
                                <td>{{ $bill->PreviousUnit }}</td>
                                <td>{{ $bill->LastUnit }}</td>
                                <td>{{ $bill->UsesUnit }}</td>
                                <td>{{ $bill->Amount }}</td>
                            </tr>
                            @php
                            $total += $bill->Amount;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <span class="font-weight-bold float-right">Total:</span>
                            </td>
                            <td>{{ $total }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>

@endsection
