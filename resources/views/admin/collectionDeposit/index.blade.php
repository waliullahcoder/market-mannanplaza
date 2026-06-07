@extends('admin.layouts.master')

@section('content')
    <div id="app">

        <form action="{{ route('collectionDeposit.index') }}" method="GET">
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

                        <div class="col-md-3">
                            <label for="unit">Unit</label>
                            <select name="unit" class="form-control select2" id="unit" required>
                                <option value="">Select an option</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->name }}" @if (request()->unit == $unit->name) selected @endif>
                                        {{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="start_date">Collection Start Date</label>
                                <input type="text" name="start_date" class="form-control datepicker"
                                    value="{{ request()->start_date ? request()->start_date : $defaultDates['start_date'] }}"
                                    autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="end_date">Collection End Date</label>
                                <input type="text" name="end_date" class="form-control datepicker"
                                    value="{{ request()->end_date ? request()->end_date : $defaultDates['end_date'] }}"
                                    autocomplete="off">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <label for="bill_type">Bill Type</label>
                            <select name="bill_type" class="form-control select2" id="bill_type">
                                <option value="">Select an option</option>
                                <option value="Utility" @if (request()->bill_type == 'Utility') selected @endif>Utility</option>
                                <option value="Rent" @if (request()->bill_type == 'Rent') selected @endif>Rent</option>
                                <option value="EBill" @if (request()->bill_type == 'EBill') selected @endif>EBill</option>
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

                            <button type="button" id="saveBtn" onclick="saveData()"
                                class=" btn btn-outline-info btn-lg waves-effect save">
                                <i class="fa fa-save"></i> Save
                            </button>

                        </div>

                    </div>
                </div>
            </div>
        </form>


        <form action="{{ route('collectionDeposit.save') }}" method="POST" id="saveForm">
            @csrf

            <input type="hidden" name="unit" value="{{ request()->unit }}">


            <div class="mt-3 report_div">

                {{-- <div class="text-center">
                <h3 class="font-weight-bold">{{ $project->name }}</h3>
                <p>{{ $project->address }}</p>
                <p>{{ $project->contact }}</p>
                <p>Year: {{ $smonth }} - Month: {{ $syear }}</p>
                <hr style="border:none; border-bottom: 1px solid black;">
                <h4 class="font-weight-bold mt-2">{{ $title }}</h4>
                <hr style="border:none; border-bottom: 1px solid black;">
            </div> --}}

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date">Deposit Date</label>
                            <input type="text" name="date" class="form-control to_date" required autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control" onchange="typeChange()" required>
                                {{-- <option value="Bank">Bank</option> --}}
                                <option value="Cash">Cash</option>
                            </select>
                        </div>
                    </div>

                    {{-- <div class="col-md-3 d-none" id="remarks">
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <input type="text" name="remarks" class="form-control">
                    </div>
                </div> --}}

                    <div class="col-md-3" id="bank">
                        <div class="form-group">
                            <label for="bank">Cash</label>
                            <select name="bank" id="bank" class="form-control">
                                {{-- <option value="">Select Option</option> --}}
                                @foreach ($coaHeads['banks'] as $bank)
                                    <option value="{{ $bank->head_code }}">{{ $bank->head_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 d-none" id="cash">
                        <div class="form-group">
                            <label for="cash">Cash</label>
                            <select name="cash" id="cash" class="form-control">
                                <option value="">Select Option</option>
                                @foreach ($coaHeads['cashs'] as $cash)
                                    <option value="{{ $cash->head_code }}">{{ $cash->head_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="total_deposit">Deposit Amount</label>
                            <input type="text" class="form-control" id="selectTotalInput" value="0" readonly>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-custom">
                        <thead>
                            <tr>
                                <td>SL#</td>
                                <td>Unit</td>
                                <td>Floor</td>
                                <td>Code</td>
                                <td>Name</td>
                                <td>Bill Time</td>
                                <td>Collection Date</td>
                                <td>Bill Type</td>
                                <td>Amount</td>
                                <td>Rant Penalty</td>
                                <td>Ebill Penalty</td>
                                <td>
                                    <input type="checkbox" id="select-all">
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $ld)
                                <tr id="tr">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ld['client']->Unit }}</td>
                                    <td>{{ $ld['client']->Floor }}</td>
                                    <td>{{ $ld['client']->Code }}</td>
                                    <td>{{ $ld['client']->Name }}</td>
                                    <td>{{ $ld['bill_info']->CMonth }} - {{ $ld['bill_info']->CYear }}</td>
                                    <td>{{ date('d-m-Y', strtotime($ld['bill_info']->ReceiveDate)) }}</td>
                                    <td>{{ $ld['bill_type'] }}</td>
                                    <td>
                                        <input type="hidden" id="amount_{{ $loop->iteration }}"
                                            value="{{ $ld['bill_info']->Amount }}">
                                        {{ $ld['bill_info']->Amount }}
                                    </td>
                                    <td>
                                        @if ($ld['bill_type'] == 'Rent')
                                            <input type="hidden" id="penalty2_{{ $loop->iteration }}"
                                                value="{{ $ld['bill_info']->penalty }}">
                                            {{ $ld['bill_info']->penalty }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ld['bill_type'] == 'EBill')
                                            <input type="hidden" id="penalty_{{ $loop->iteration }}"
                                                value="{{ $ld['bill_info']->penalty }}">
                                            {{ $ld['bill_info']->penalty }}
                                        @endif
                                    </td>
                                    <td>
                                        <input type="checkbox"
                                            name="bills[{{ $ld['bill_type'] }}][{{ $ld['bill_info']->id }}]"
                                            onchange="getSelectedTotal()" id="{{ $loop->iteration }}"
                                            class="action_checkbox">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" id="save" class=" btn btn-outline-info btn-lg waves-effect search">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>


        </form>

    </div>
@endsection


@section('custom-js')
    <script>
        $(document).ready(function() {

            $('#select-all').click(function(event) {
                if (this.checked) {
                    // Iterate each checkbox
                    $(':checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $(':checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });

            $('#selectTotalInput').change(function(e) {
                e.preventDefault();
                getSelectedTotal();
            });

            $('#select-all').change(function(e) {
                e.preventDefault();
                getSelectedTotal();
            });


        });

        function saveData() {
            $('#saveForm').submit();
        }

        function typeChange() {

            let type = $('#type').val();

            if (type == "Cash") {
                // $('#remarks').removeClass('d-none');
                // $('#bank').addClass('d-none');
                $('#bank').addClass('d-none');
                $('#cash').removeClass('d-none');
            } else if (type == "Bank") {
                $('#cash').addClass('d-none');
                $('#bank').removeClass('d-none');
            } else if (type == "") {
                $('#bank').addClass('d-none');
                $('#cash').addClass('d-none');
            }

        }

        function getSelectedTotal() {

            let totalAmount = 0;

            $('.action_checkbox').each(function(index, el) {
                let isChecked = $(el).is(':checked');

                if (isChecked) {
                    let checkedId = $(el).attr('id');
                    let amount = +$('#amount_' + checkedId).val();
                    if ($('#penalty_' + checkedId).length) {
                        totalAmount += +$('#penalty_' + checkedId).val();
                    }
                    if ($('#penalty2_' + checkedId).length) {
                        totalAmount += +$('#penalty2_' + checkedId).val();
                    }
                    totalAmount += amount;
                }
            });

            $('#selectTotalInput').val(totalAmount);

        }
    </script>
@endsection
