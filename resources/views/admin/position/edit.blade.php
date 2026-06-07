@extends('admin.layouts.masterAddEdit')

@section('card_body')
<div class="card-body">

    <input type="hidden" name="id" value="{{ $data->position->ID }}">

    <fieldset>
        <legend>Basic Information</legend>
        <div class="row mt-3">

            <div class="col-md-4">
                <label for="Code">Client Code</label>
                <div class="form-group {{ $errors->has('Code') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Code" name="Code"
                        value="{{ $data->position->Code }}" required>
                </div>
            </div>

            <div class="col-md-4">
                <label for="Name">Client Name</label>
                <div class="form-group {{ $errors->has('Name') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Name" name="Name"
                        value="{{ $data->position->Name }}" required>
                </div>
            </div>

            <div class="col-md-4">
                <label for="FName">Father Name</label>
                <div class="form-group {{ $errors->has('FName') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Father Name" name="FName"
                        value="{{ $data->position->FName }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="MName">Mother Name</label>
                <div class="form-group {{ $errors->has('MName') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Mother Name" name="MName"
                        value="{{ $data->position->MName }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="SName">Spouse Name</label>
                <div class="form-group {{ $errors->has('SName') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Spouse Name" name="SName"
                        value="{{ $data->position->SName }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="Mobile">Mobile</label>
                <div class="form-group {{ $errors->has('Mobile') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Mobile" name="Mobile"
                        value="{{ $data->position->Mobile }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="NationalID">National ID</label>
                <div class="form-group {{ $errors->has('NationalID') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="National ID" name="NationalID"
                        value="{{ $data->position->NationalID }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="PassportNo">Remarks</label>
                <div class="form-group {{ $errors->has('PassportNo') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Remarks" name="PassportNo"
                        value="{{ $data->position->PassportNo }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="timage">Stamps</label>
                <div class="form-group">
                    <a href="{{ route('positionInformation.index.stamp', $data->position->ID) }}"
                        class="btn btn-info btn-lg btn-block">Stamps</a>
                </div>
            </div>

            <div class="col-md-4">
                <label for="ebillMeterno">Electric Bill Meter No</label>
                <div class="form-group {{ $errors->has('ebillMeterno') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Electric Bill Meter No" name="ebillMeterno"
                        value="{{ $data->position->ebill_meter_no }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="wbillMeterno">Water Bill Meter No</label>
                <div class="form-group {{ $errors->has('wbillMeterno') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Water Bill Meter No" name="wbillMeterno"
                        value="{{ $data->position->wbill_meter_no }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="timage">Tenant Image</label>
                <div class="form-group {{ $errors->has('tenant_image') ? ' has-danger' : '' }}">
                    <input type="file" class="form-control" placeholder="Tenant Image" name="tenant_image"
                        value="{{ $data->position->tenant_image }}">
                </div>
            </div>

        </div>

    </fieldset>


    <div class="row">
        <div class="col-md-4">
            <label for="for">Position Type</label>
            <div class="form-group {{ $errors->has('EntryReason') ? ' has-danger' : '' }}">
                <select class="form-control" name="EntryReason" id="EntryReason" name="EntryReason">
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
                <select class="form-control" name="Floor" id="Floor" name="Floor">
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
                <select class="form-control" name="Unit" id="Unit" name="Unit">
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


    <div class="row">
        <div class="col-md-12">
            <label for="address">Address</label>
            <div class="form-group {{ $errors->has('address') ? ' has-danger' : '' }}">
                <textarea name="address" class="form-control" id="address" rows="6">{{ $data->position->address }}</textarea>
            </div>
        </div>
    </div>

    <fieldset>
        <legend>Position Information</legend>
        <div class="row">


            <div class="col-md-4">
                <label for="PositionNo">Position</label>
                <div class="form-group {{ $errors->has('PositionNo') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Position No" name="PositionNo"
                        value="{{ $data->position->PositionNo }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="PositionSize">Size</label>
                <div class="form-group {{ $errors->has('PositionSize') ? ' has-danger' : '' }}">
                    <input id="sizeInput" type="number" class="form-control" placeholder="Size" name="PositionSize"
                        value="{{ $data->position->PositionSize }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="EndDate">Agreement Date</label>
                <div class="form-group {{ $errors->has('EndDate') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control datepicker" placeholder="Agreement Date" name="EndDate"
                        value="{{ date('d-m-Y', strtotime($data->position->EndDate)) }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="DepositeAmount" id="1stSale">1st sales amount</label>
                <div class="form-group {{ $errors->has('DepositeAmount') ? ' has-danger' : '' }}">
                    <input type="number" class="form-control" name="DepositeAmount"
                        value="{{ $data->position->DepositeAmount }}">
                </div>
            </div>

            <div class="col-md-4 sale_rows rent_rows">
                <label for="LastSalesAmount">Last sale amount</label>
                <div class="form-group {{ $errors->has('LastSalesAmount') ? ' has-danger' : '' }}">
                    <input type="number" class="form-control" placeholder="last sale amount" name="LastSalesAmount"
                        value="{{ $data->position->LastSalesAmount }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="RentRate rent_rate">Rent Rate (per square ft)</label>
                <div class="form-group {{ $errors->has('RentRate') ? ' has-danger' : '' }}">
                    <input id="RentRateInput" type="number" class="form-control" placeholder="Rent Rate" step="any"
                        name="RentRate" value="{{ $data->position->RentRate }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="Agg0ne">Rent Amount</label>
                <div class="form-group {{ $errors->has('Agg0ne') ? ' has-danger' : '' }}">
                    <input id="rentAmount" type="number" class="form-control" step="any" placeholder="Jamidari Fixed" name="Agg0ne"
                        value="{{ $data->position->Agg0ne }}">
                </div>
            </div>

            <div class="col-md-4 sale_rows">
                <label for="AggTwo">Incr Year Duration</label>
                <div class="form-group {{ $errors->has('AggTwo') ? ' has-danger' : '' }}">
                    <input type="number" class="form-control" placeholder="Increment Year Duration" name="AggTwo"
                        value="{{ $data->position->AggTwo }}">
                </div>
            </div>

            <div class="col-md-4 sale_rows rent_rows">
                <label for="incrRate">Increment Ratio</label>
                <div class="form-group {{ $errors->has('incrRate') ? ' has-danger' : '' }}">
                    <input type="number" class="form-control" placeholder="Increment Ratio" name="incrRate"
                        value="{{ $data->position->incrRate }}">
                </div>
            </div>

            <div class="col-md-4 rent_rows">
                <label for="MonthlyDeduct">Monthly Deduct</label>
                <div class="form-group {{ $errors->has('MonthlyDeduct') ? ' has-danger' : '' }}">
                    <input type="number" class="form-control" placeholder="Monthly Deduct" name="MonthlyDeduct"
                        value="{{ $data->position->MonthlyDeduct }}">
                </div>
            </div>


            {{-- <div class="col-md-4 rent_rows">
                    <label for="MonthlyPayable">Monthly Payable</label>
                    <div class="form-group {{ $errors->has('MonthlyPayable') ? ' has-danger' : '' }}">
            <input type="number" class="form-control" placeholder="Monthly Payable" name="MonthlyPayable"
                value="{{ old('MonthlyPayable') }}">
        </div>
</div> --}}

</div>
</fieldset>

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
                $('#RentRateInput').attr('readonly', true);
            } else {
                rent_rows.hide();
                sale_rows.show();
                $('#RentRateInput').attr('readonly', false);
            }



            $(entry_reason_el).change(function(e) {
                e.preventDefault();

                let entry_reason = entry_reason_el.val();
                if (entry_reason == 'Sale') {
                    $('#RentRateInput').attr('readonly', false);
                    $('#1stSale').text('1st sales amount');
                    $('#rent_rate').text('Rent Rate');
                    rent_rows.hide();
                    sale_rows.show();

                } else {
                    $('#RentRateInput').attr('readonly', true);
                    $('#RentRateInput').val('');
                    $('#rent_rate').text('Shop rent');
                    $('#1stSale').text('Advance Deposite');
                    sale_rows.hide();
                    rent_rows.show();
                }

            });

        });

        $('#RentRateInput, #sizeInput').keyup(function (e) {

            let entry_reason = $('#EntryReason').val();

            if (entry_reason == 'Sale') {

            let sizeVal = 1;

            if ($('#sizeInput').val() != "") {
            sizeVal = $('#sizeInput').val();
            }

            let rentRateVal = 1;

            if ($('#RentRateInput').val() != "") {
            rentRateVal = $('#RentRateInput').val();
            }

            $('#rentAmount').val(sizeVal * rentRateVal);

            }

        });

</script>
@endsection
