@extends('admin.layouts.master')

@section('content')
    <div id="app">

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
                                <label for="barcode_code" class="float-left font-weight-bold mt-2">Collection
                                    Barcode</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="barcode_code" name="barcode_code">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="custom-card-footer">
                <div class="row">
                    <div class="col-md-2">
                        <h5 class="text-danger font-weight-bold mt-3" id="errorMessageEl"></h5>
                    </div>
                    <div class="col-md-8 offset-md-2">
                        <button type="button" id="save" onclick="$('#wbillForm').submit()"
                            class="float-right btn btn-outline-info btn-lg waves-effect ml-2"><i class="fa fa-save"></i>
                            Save</button>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('collection.save.bycode') }}" method="POST" id="wbillForm">
            @csrf

            <div class="mt-5 report_div">

                <table v-if="bills" class="table table-bordered table-striped table-custom">
                    <thead>
                        <th>Client Code</th>
                        <th>Client Name</th>
                        <th>Position No.</th>
                        <th>Unit</th>
                        <th>Floor</th>
                        <th>Month</th>
                        <th style="width: 150px;">Year</th>
                        <th>Type</th>
                        <th style="width: 150px;">Amount</th>
                        <th style="width: 150px;">Penalty</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="tbody">
                        <tr id="temp_row">
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        {{-- @foreach ($bills as $bill)
                            <tr id="tr_{{ $bill->id }}">
                                <td>{{ $bill->CMonth }}</td>
                                <td>{{ $bill->CYear }}</td>
                                <td>{{ $classToNormal[$bill->CLASS_NAME] }}</td>
                                <td>{{ $bill->Amount }}</td>
                                <td>
                                    <input type="checkbox" class="checked_inputs" name="ids[]" value="{{ $bill->id }}">
                                    <input type="hidden" name="class_name[{{ $bill->id }}]" value="{{ $bill->CLASS_NAME }}">
                                    <input type="hidden" name="amount[{{ $bill->id }}]" id="amount_{{ $bill->id }}"
                                        value="{{ $bill->Amount }}">
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <span class="font-weight-bold float-right mt-2">Receive Date</span>
                            </td>
                            <td>
                                <input type="text" class="form-control" readonly value="{{ date('d-m-Y') }}"
                                    style="opacity: 1 !important;">
                                <input type="text" name="receive_date" class="form-control add_datepicker d-none">
                            </td>
                            <td>
                                <span class="font-weight-bold float-right mt-2">Total</span>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="total" readonly
                                    style="opacity: 1 !important;">
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </form>
    </div>


    <script>
        let addedIds = [];
        let rowTotalAmount = 0;

        function remove_row(id, barcode_value, billAmount) {
            $('#tr_' + id).remove();
            removeFromArrayByValue(addedIds, barcode_value);
            rowTotalAmount -= billAmount;
            $('#total').val(rowTotalAmount);

        }

        $(function() {
            $('#errorMessageEl').hide();
            let barcode_value = $('#barcode_code').val();


            // sanner to fetching code
            $('#barcode_code').on('keypress', function(e) {
                if (e.which == 13) {
                    $('#errorMessageEl').hide();

                    let barcode_value = $('#barcode_code').val();

                    if (addedIds.includes(barcode_value)) {
                        alert('Already Added');
                        return false;
                    }

                    fetchDataAndInsert();
                }
            });

            function fetchDataAndInsert() {
                let barcode_value = $('#barcode_code').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: "{{ route('collection.add.getbybarcode') }}",
                    data: {
                        barcode_value: barcode_value
                    },
                    success: function(response) {
                        insertRow(response, barcode_value);
                        $('#barcode_code').val('');
                    }
                });
            }

            function showError(response) {
                $('#errorMessageEl').text(response.message);
                $('#errorMessageEl').show();
            }

            function getRow(response, barcode_value) {
                $('#temp_row').hide();
                let tr = `
                    <tr id="tr_${response.bill.id}">
                        <td>${response.bill.Client_Code}</td>
                        <td>${response.tenant.Name}</td>
                        <td>${response.tenant.PositionNo}</td>
                        <td>${response.tenant.Unit}</td>
                        <td>${response.tenant.Floor}</td>
                        <td>${response.month}</td>
                        <td>${response.year}</td>
                        <td>${response.service}</td>
                        <td>${response.bill.Amount}</td>
                        <td>${response.panalty}</td>
                        <td>
                            <span class="text-danger" onclick="remove_row(${response.bill.id}, '${barcode_value}', ${response.bill.Amount})">X</span>
                            <input type="hidden" class="checked_inputs" name="ids[]" value="${response.bill.id}">
                            <input type="hidden" name="class_name[${response.bill.id}]" value="${response.service_class}">
                            <input type="hidden" name="amount[${response.bill.id}]"
                                value="${response.bill.Amount}">
                        </td>
                    </tr>`;

                rowTotalAmount += +response.bill.Amount + response.panalty;
                return tr;
            }

            function insertRow(response, barcode_value) {
                if (response.status == false) {
                    showError(response);
                } else {
                    let barcode_value = $('#barcode_code').val();
                    addedIds.push(barcode_value);

                    let row = getRow(response, barcode_value);
                    $('#tbody').append(row);

                    $('#total').val(rowTotalAmount);
                }
            }

            // checkbox and total
            let totalInputEl = $('#total');

            // Listen for click on toggle checkbox
            $('#all').click(function(event) {
                if (this.checked) {
                    // Iterate each checkbox
                    $('.checked_inputs:checkbox').each(function() {
                        this.checked = true;
                        checked();
                    });
                } else {
                    $('.checked_inputs:checkbox').each(function() {
                        this.checked = false;
                        checked();
                    });
                }
            });

            // on checkbox checked
            function checked(e) {
                let amount = 0;

                $('.checked_inputs:checkbox:checked').each(function() {
                    let valueEl = $('#amount_' + this.value);
                    amount += +valueEl.val();
                });

                totalInputEl.val(amount);
            }

            $('.checked_inputs').change(function(e) {
                e.preventDefault();
                checked(e);
            });


        });
    </script>
@endsection
