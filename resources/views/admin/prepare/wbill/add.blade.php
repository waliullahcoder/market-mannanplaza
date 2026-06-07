@extends('admin.layouts.master')

@section('content')

<div id="app">

    <form action="{{ route('wbill.prepare.add') }}" method="GET">

        <input type="hidden" name="searched" value="true">

        <div class="card noprint">
            <div class="custom-card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="custom-card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('wbill.prepare.index') }}"
                            class="btn btn-outline-info btn-lg waves-effect search float-right"><i
                                class="fa fa-arrow-circle-left"></i>
                            Go Back</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="unit">Unit</label>
                        <select name="unit" class="form-control select2" id="unit">
                            @foreach ($data->units as $unit)
                            <option value="{{ $unit->name }}" @if ($unit->name == $sunit)
                                selected
                                @endif
                                >{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="floor">Floor</label>
                        <select name="floor" class="form-control select2" id="floor">
                            @foreach ($data->floors as $floor)
                            <option value="{{ $floor->name }}" @if ($floor->name == $sfloor)
                                selected
                                @endif
                                >{{ $floor->name }}</option>
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
                            @for ($i = 2015; $i <= 2055; $i++) <option value="{{ $i }}" @if ($i==$data->
                                current_time->year)
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
            </div>


            <div class="custom-card-footer">
                <div class="row">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="search_code" class="float-left mt-2">Find By Code</label>
                            </div>
                            <div class="col-md-8">
                                {{-- <input type="text" class="form-control" id="search_code" name="search_code"> --}}
                                <select class="form-control select2" name="search_code" id="search_code">
                                    <option value="">Select a tenant</option>
                                    @foreach ($tenants as $tenant)
                                        <option value="{{ $tenant->Code }}">{{ $tenant->Code }} ({{ $tenant->Name }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 text-right">
                        <button type="submit" id="search" class="btn btn-outline-info btn-lg waves-effect search"><i
                                class="fa fa-search"></i> Search</button>

                        <button type="button" id="save" onclick="$('#wbillForm').submit()"
                            class="btn btn-outline-info btn-lg waves-effect ml-2"><i class="fa fa-save"></i>
                            Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if ($bills != "")
    <form action="{{ route('wbill.prepare.save') }}" method="POST" id="wbillForm">
        @csrf

        <input type="hidden" name="unit" value="{{ $sunit }}">
        <input type="hidden" name="floor" value="{{ $sfloor }}">
        <input type="hidden" name="CMonth" value="{{ $CMonth }}">
        <input type="hidden" name="CYear" value="{{ $CYear }}">
        <input type="hidden" name="PaidDate" value="{{ $PaidDate }}">

        <div class="mt-5 report_div">
            <table v-if="bills" class="table table-bordered table-striped table-custom">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Client Code</th>
                        <th>Client Name</th>
                        <th>Position</th>
                        <th style="width: 80px">Unit</th>
                        <th style="width: 130px">Floor</th>
                        <th>P. Unit</th>
                        <th>C. Unit</th>
                        <th>U. Unit</th>
                        <th>Amount</th>
                    </tr>

                </thead>
                <tbody>
                    <tr v-for="b in bills" :key="b.si">
                        <td v-text="b.si"></td>
                        <td>
                            <span v-text="b.Code"></span>
                            <input type="hidden" name="codes[]" :value="b.Code">
                        </td>
                        <td v-text="b.Name"></td>
                        <td v-text="b.PositionNo"></td>
                        <td>{{ $sunit }}</td>
                        <td>{{ $sfloor }}</td>
                        <td>
                            <input type="number" class="form-control" v-model="b.lu"
                                :name="`prev_unit[${b.Code}]`" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control" :name="`last_unit[${b.Code}]`" v-model="b.cUnit"
                                @keyup="updateUunit(b.lu, b.cUnit, `uUnit_${b.Code}`, `bill_${b.Code}`)">
                        </td>
                        <td>
                            <input type="number" class="form-control" :id="`uUnit[${b.Code}]`"
                                :name="`uUnit[${b.Code}]`" :value="b.cUnit - b.lu"
                                :ref="`uUnit_${b.Code}`" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control" :ref="`bill_${b.Code}`" :name="`bill[${b.Code}]`"
                                value="0" readonly>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
    @endif


</div>


@if ($bills != "")
{{--
        <!-- production version, optimized for size and speed --> --}}
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

<script>
    var app = new Vue({
                el: '#app',
                data: {
                    bills: {!! $bills !!},
                    rate: {!! $rate !!}
                },
                created() {
                    this.bills = this.cBills;
                },
                methods: {
                    updateUunit(last_bill, cBill, unitRef, billRef) {
                        let uUnit = cBill - last_bill;
                        this.$refs[unitRef][0].value = uUnit;
                        this.$refs[unitRef][0].value = uUnit;

                        let bill = uUnit * +this.rate;

                        // if (bill < 700) {
                        //     bill = 700
                        // }

                        this.$refs[billRef][0].value = bill;
                    }
                },
                computed: {
                    cBills() {

                        let i = 1;

                        let b = [];

                        for(const bill in this.bills){
                            this.bills[bill].si = i;
                            i++;

                            if (this.bills[bill].last_unit == null) {
                                this.bills[bill].lu = 0;
                            }else{
                                this.bills[bill].lu = this.bills[bill].last_unit.LastUnit;
                            }

                            this.bills[bill].cUnit = '';

                            b.push(this.bills[bill]);

                        }

                        b = _.orderBy(b, ['PositionNo'], ['asc']);

                        return b;
                    }
                }
            })

</script>

@endif


@endsection
