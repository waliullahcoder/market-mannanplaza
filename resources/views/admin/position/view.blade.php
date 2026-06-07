@extends('admin.layouts.master')

@section('content')

    <div class="card">
        <div class="custom-card-header">
            <a class="btn btn-outline-info btn-lg float-right" href="{{ route('positionInformation.index') }}">
                <i class="fa fa-arrow-circle-left"></i> Go Back
            </a>

        </div>
        <div class="card-body">

            <input type="hidden" name="id" value="{{ $data->position->ID }}">

            <fieldset>
                <legend>Basic Information</legend>

                <div class="row">
                    <div class="col-md-4">
                        @if (isset($data->position->tenant_image))
                            <img src="{{ asset($data->position->tenant_image) }}" class="w-75   " height="150px" alt="Profile Image">
                        @else
                            <img src="{{ asset('/public/elite-admin/assets/images/noImage.jpg') }}" class="w-75 " height="150px" alt="Profile Image">
                        @endif
                        <input type="hidden" name="previousUserImage" value="{{ $data->position->tenant_image }}">
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-md-4">
                        <label for="Code">Client Code</label>
                        <div class="form-group {{ $errors->has('Code') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="Code" value="{{ $data->position->Code }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="Name">Client Name</label>
                        <div class="form-group {{ $errors->has('Name') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="Name" value="{{ $data->position->Name }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="FName">Father Name</label>
                        <div class="form-group {{ $errors->has('FName') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="FName" value="{{ $data->position->FName }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="MName">Mother Name</label>
                        <div class="form-group {{ $errors->has('MName') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="MName" value="{{ $data->position->MName }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="SName">Spouse Name</label>
                        <div class="form-group {{ $errors->has('SName') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="SName" value="{{ $data->position->SName }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="Mobile">Mobile</label>
                        <div class="form-group {{ $errors->has('Mobile') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="Mobile" value="{{ $data->position->Mobile }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="NationalID">National ID</label>
                        <div class="form-group {{ $errors->has('NationalID') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="NationalID"
                                value="{{ $data->position->NationalID }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <label for="PassportNo">Remarks</label>
                        <div class="form-group {{ $errors->has('PassportNo') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="PassportNo"
                                value="{{ $data->position->PassportNo }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="ebillMeterno">Electric Bill Meter No</label>
                        <div class="form-group {{ $errors->has('ebillMeterno') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" placeholder="Electric Bill Meter No" name="ebillMeterno"
                            value="{{ $data->position->ebill_meter_no }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="wbillMeterno">Water Bill Meter No</label>
                        <div class="form-group {{ $errors->has('wbillMeterno') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" placeholder="Water Bill Meter No" name="wbillMeterno"
                            value="{{ $data->position->wbill_meter_no }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="timage">Stamps</label>
                        <div class="form-group">
                            <a href="{{ route('positionInformation.index.stamp', $data->position->ID) }}" class="btn btn-info btn-lg btn-block">Stamps</a>
                        </div>
                    </div>

                </div>
            </fieldset>

            <div class="row">
                <div class="col-md-4">
                    <label for="for">Position Type</label>
                    <div class="form-group {{ $errors->has('EntryReason') ? ' has-danger' : '' }}">
                        <select class="form-control" name="EntryReason" id="EntryReason" name="EntryReason" readonly>
                            <option value="Sale" @if ($data->position->EntryReson == 'Sale')
                                selected
                                @endif
                                >Sale</option>
                            <option value="Rent" @if ($data->position->EntryReson == 'Rent')
                                selected
                                @endif
                                >Rent</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="Floor">Floor Number</label>
                    <div class="form-group {{ $errors->has('Floor') ? ' has-danger' : '' }}">
                        <select class="form-control" name="Floor" id="Floor" name="Floor" readonly>
                            @foreach ($data->floors as $floor)
                                <option value="{{ $floor->name }}" @if ($data->position->Floor == $floor->name)
                                    selected
                            @endif
                            >{{ $floor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="Unit">Unit Name</label>
                    <div class="form-group {{ $errors->has('Unit') ? ' has-danger' : '' }}">
                        <select class="form-control" name="Unit" id="Unit" name="Unit" readonly>
                            @foreach ($data->units as $unit)
                                <option value="{{ $unit->name }}" @if ($data->position->Unit == $unit->name)
                                    selected
                            @endif

                            >{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


            </div>

            <fieldset>
                <legend>Position Information</legend>
                <div class="row">


                    <div class="col-md-4">
                        <label for="PositionNo">Position</label>
                        <div class="form-group {{ $errors->has('PositionNo') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="PositionNo"
                                value="{{ $data->position->PositionNo }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="PositionSize">Size</label>
                        <div class="form-group {{ $errors->has('PositionSize') ? ' has-danger' : '' }}">
                            <input type="number" class="form-control" name="PositionSize"
                                value="{{ $data->position->PositionSize }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="EndDate">Agreement Date</label>
                        <div class="form-group {{ $errors->has('EndDate') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control add_datepicker" name="EndDate"
                                value="{{ $data->position->EndDate }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="DepositeAmount" id="1stSale">1st sales amount</label>
                        <div class="form-group {{ $errors->has('DepositeAmount') ? ' has-danger' : '' }}">
                            <input type="number" class="form-control" name="DepositeAmount"
                                value="{{ $data->position->DepositeAmount }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4 sale_rows rent_rows">
                        <label for="LastSalesAmount">Last sale amount</label>
                        <div class="form-group {{ $errors->has('LastSalesAmount') ? ' has-danger' : '' }}">
                            <input type="number" class="form-control" name="LastSalesAmount"
                                value="{{ $data->position->LastSalesAmount }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="RentRate rent_rate">Rent Rate (per square ft)</label>
                        <div class="form-group {{ $errors->has('RentRate') ? ' has-danger' : '' }}">
                            <input type="number" class="form-control" name="RentRate"
                                value="{{ $data->position->RentRate }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4 sale_rows">
                        <label for="Agg0ne">Rent Amount</label>
                        <div class="form-group {{ $errors->has('Agg0ne') ? ' has-danger' : '' }}">
                            <input type="number" class="form-control" name="Agg0ne" value="{{ $data->position->Agg0ne }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-4 sale_rows">
                        <label for="AggTwo">Incr Year Duration</label>
                        <div class="form-group {{ $errors->has('AggTwo') ? ' has-danger' : '' }}">
                            <input type="number" class="form-control" name="AggTwo" value="{{ $data->position->AggTwo }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-4 sale_rows rent_rows">
                        <label for="incrRate">Increment Ratio</label>
                        <div class="form-group {{ $errors->has('incrRate') ? ' has-danger' : '' }}">
                            <input type="number" class="form-control" name="incrRate"
                                value="{{ $data->position->incrRate }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4 rent_rows">
                        <label for="MonthlyDeduct">Monthly Deduct</label>
                        <div class="form-group {{ $errors->has('MonthlyDeduct') ? ' has-danger' : '' }}">
                            <input type="number" class="form-control" name="MonthlyDeduct"
                                value="{{ $data->position->MonthlyDeduct }}" readonly>
                        </div>
                    </div>

                </div>
            </fieldset>

        </div>
    </div>


    <script>
        $(document).ready(function() {

            let entryReasonforEditPage = "{{ $data->position->EntryReson }}";

            console.log(entryReasonforEditPage);

            let entry_reason_el = $('#EntryReason');
            let sale_rows = $('.sale_rows');
            let rent_rows = $('.rent_rows');

            if (entryReasonforEditPage == "Rent") {
                sale_rows.hide();
                rent_rows.show();
            } else {
                rent_rows.hide();
                sale_rows.show();
            }



            $(entry_reason_el).change(function(e) {
                e.preventDefault();

                let entry_reason = entry_reason_el.val();
                if (entry_reason == 'Sale') {
                    $('#1stSale').text('1st sales amount');
                    $('#rent_rate').text('Rent Rate');
                    rent_rows.hide();
                    sale_rows.show();

                } else {
                    $('#rent_rate').text('Shop rent');
                    $('#1stSale').text('Advance Deposite');
                    sale_rows.hide();
                    rent_rows.show();
                }

            });

        });

    </script>
@endsection
