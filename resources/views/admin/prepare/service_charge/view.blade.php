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
                @php
                    $message = Session::get('success');
                @endphp

                @if (isset($message))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success!</strong> {{ $message }}
                    </div>
                @endif

                @php
                    Session::forget('msg');
                @endphp
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
                    <th style="width:100px;">Action</th>
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
                        <td> <button type="button"
                            class="btn btn-sm btn-info editBillBtn"
                            data-id="{{ $bill->id }}"
                            data-month="{{ $bill->CMonth }}"
                            data-year="{{ $bill->CYear }}"
                            data-paid-date="{{ $bill->PaidDate }}"
                            data-client_code="{{ $bill->Client_Code }}"
                            data-service="{{ $bill->Utility_ID }}"
                            data-amount="{{ $bill->Amount }}"
                            data-toggle="modal"
                            data-target="#editBillModal">
                            Edit
                        </button></td>
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

<!--Modal-->
<div class="modal fade" id="editBillModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('service.charge.prepare.update') }}" method="POST">
            @csrf

            <input type="hidden" name="bill_id" id="edit_bill_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Bill</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <label>Client Code</label>
                            <select class="form-control" name="client_code" id="edit_client_code">
                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->Code }}">
                                        {{ $tenant->Code }} ({{ $tenant->Name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Month</label>
                            <select class="form-control" name="CMonth" id="edit_month">
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
                            <label>Year</label>
                            <select class="form-control" name="CYear" id="edit_year">
                                <option value="2026" selected>2026</option>
                                @for ($i = 2000; $i <= 2055; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label>Prepare Date</label>
                            <input type="text" class="form-control add_datepicker" name="paid_date" id="edit_paid_date">
                        </div>

                        <div class="col-md-4">
                            <label>Service Name</label>
                            <select class="form-control" name="utility_id" id="edit_service">
                                @foreach ($utilities as $utility)
                                    <option value="{{ $utility->id }}">{{ $utility->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Amount</label>
                            <input type="number" class="form-control" name="amount" id="edit_amount" required>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).on('click', '.editBillBtn', function () {
        $('#edit_bill_id').val($(this).data('id'));
        $('#edit_client_code').val($(this).data('client_code')).trigger('change');
        $('#edit_month').val($(this).data('month')).trigger('change');
        $('#edit_year').val($(this).data('year')).trigger('change');
        $('#edit_paid_date').val($(this).data('paid-date'));
        $('#edit_service').val($(this).data('service')).trigger('change');
        $('#edit_amount').val($(this).data('amount'));
    });
</script>

<!--//Modal-->
    <script>
        function printTable() {
            print();
        }

    </script>

@endsection
