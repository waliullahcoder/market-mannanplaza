@extends('admin.layouts.master')

@section('content')
    <form action="{{ route('service.charge.prepare.save.individual') }}" method="POST">
        @csrf

        <div class="card noprint">
            <div class="custom-card-header">
                <div class="row">
                    <div class="col-md-10">
                        <h4 class="custom-card-title">{{ $title }}</h4>
                    </div>

                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <label for="Client_Code">Client Code</label>
                        {{-- <input type="text" class="form-control" id="Client_Code" placeholder="Client Code"> --}}
                        <select class="form-control select2" name="search_code" id="Client_Code">
                            @foreach ($tenants as $tenant)
                                <option value="{{ $tenant->Code }}">{{ $tenant->Code }} ({{ $tenant->Name }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="month">Month</label>
                        <select class="form-control select2" id="CMonth">
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

                    <div class="col-md-3">
                        <label for="year">Year</label>
                        <select class="form-control select2" id="CYear">
                            <option value="2026">2026</option>
                            @for ($i = 2000; $i <= 2055; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="year">Serial No</label>
                        <input type="text" class="form-control" id="SerialNo" value="{{ $serial_no }}" disabled>
                    </div>
                </div>

                <div class="row mt-4">

                    <div class="col-md-3">
                        <label for="year">Prepare Date</label>
                        <input type="text" class="form-control add_datepicker" id="paid_date">
                    </div>


                    <div class="col-md-3">
                        <label for="year">Service Name</label>
                        <select class="form-control select2" id="service_name">
                            @foreach ($utilities as $utility)
                                <option value="{{ $utility->id }}">{{ $utility->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="year">Amount</label>
                        <input type="number" class="form-control" id="amount">
                    </div>

                    <div class="col-md-3">
                        <button type="button" class="btn-block btn-outline-info btn-lg buttonAddEdit float-right" style="margin-top: 25px; background: none;
                                                                    border: 1px solid;" id="AddBtn"><i
                                class="fas fa-arrow-circle-down"></i>
                            Add List</button>
                    </div>

                </div>


                <div class="table-div mt-5">
                    <table class="table table-bordered table-striped table-custom">
                        <thead>
                            <tr>
                                <th>SL#</th>
                                <th>Serial No</th>
                                <th>Code</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Prepare Date</th>
                                <th>Service Name</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>
                </div>

            </div>

            <div class="custom-card-footer">
                <div class="col-md-3 offset-md-9">
                    <button type="submit" class="btn btn-outline-info btn-lg buttonAddEdit float-right">Save</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        function deleteRow(id) {
            $('#tr_' + id).remove();
        }


        $(function() {

            // SL# init
            let sl = 1;

            let addedServices = [];

            // form el list
            let clientCodeEl = $('#Client_Code');
            let CMonthEl = $('#CMonth');
            let CYearEl = $('#CYear');
            let SerialNoEl = $('#SerialNo');
            let paid_dateEl = $('#paid_date');
            let service_nameEl = $('#service_name');
            let amountEl = $('#amount');
            let AddBtnEl = $('#AddBtn');

            // table el list
            let tbodyEl = $('#tbody');


            function getrow() {

                // validate inputs

                if (clientCodeEl.val() == '') {
                    alert('Please Type Client Code');
                    return false;
                }


                if (amountEl.val() == '') {
                    alert('Please Type Amount');
                    return false;
                }


                let row = `
                    <tr id="tr_${sl}">
                        <td>
                            ${sl}

                            <input type="hidden" name="sl[]" value="${sl}">
                        </td>

                        <td>
                            ${SerialNoEl.val()}

                            <input type="hidden" name="serial_no[${sl}]" value="${SerialNoEl.val()}">
                        </td>

                        <td>
                            ${clientCodeEl.val()}

                            <input type="hidden" name="client_code[${sl}]" value="${clientCodeEl.val()}">
                        </td>

                        <td>
                            ${CMonthEl.val()}

                            <input type="hidden" name="CMonth[${sl}]" value="${CMonthEl.val()}">
                        </td>

                        <td>
                            ${CYearEl.val()}

                            <input type="hidden" name="CYear[${sl}]" value="${CYearEl.val()}">
                        </td>

                        <td>
                            ${paid_dateEl.val()}

                            <input type="hidden" name="paid_date[${sl}]" value="${paid_dateEl.val()}">
                        </td>

                        <td>
                            ${$('#service_name option:selected').text()}

                            <input type="hidden" name="service[${sl}]" value="${service_nameEl.val()}">
                        </td>

                        <td>
                            ${amountEl.val()}

                            <input type="hidden" name="amount[${sl}]" value="${amountEl.val()}">
                        </td>

                        <td>
                            <span onclick="deleteRow(${sl})" class="text-danger">X</span>
                        </td>
                    </tr>
                    `;

                sl++;

                return row;

            }

            AddBtnEl.click(function(e) {
                e.preventDefault();

                // check if added before
                let serviceExists = addedServices.includes(service_nameEl.val());

                if (serviceExists) {
                    alert('service already added');
                    return true;
                }

                // push service array
                addedServices.push(service_nameEl.val());

                // get row
                let row = getrow();
                // append row
                tbodyEl.append(row);

                // clear some fields
                amountEl.val('');
                service_nameEl.select2('val', '1');

                // focus on service
                service_nameEl.select2('open');



            });

        });

    </script>

@endsection
