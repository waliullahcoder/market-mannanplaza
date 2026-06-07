@extends('admin.layouts.master')

@section('custom_css')
    <style>
        table .form-control {
            min-height: auto;
            padding: 4px 10px;
            height: auto;
        }
    </style>
@endsection

@section('content')
    <div id="app">
        <form action="{{ route('ebill.prepare.add') }}" method="GET">
            <input type="hidden" name="searched" value="true">

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

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="unit">Unit</label>
                            <select name="unit" class="form-control select2" id="unit">
                                @foreach ($data->units as $unit)
                                    <option value="{{ $unit->name }}" @if ($unit->name == $sunit) selected @endif>
                                        {{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="floor">Floor</label>
                            <select name="floor" class="form-control select2" id="floor">
                                @foreach ($data->floors as $floor)
                                    <option value="{{ $floor->name }}" @if ($floor->name == $sfloor) selected @endif>
                                        {{ $floor->name }}</option>
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
                                <option value="January" @if (request('CMonth') == 'January' || $data->current_time->englishMonth == 'January') selected @endif>January</option>
                                <option value="February" @if (request('CMonth') == 'February' || $data->current_time->englishMonth == 'February') selected @endif>February</option>
                                <option value="March" @if (request('CMonth') == 'March' || $data->current_time->englishMonth == 'March') selected @endif>March</option>
                                <option value="April" @if (request('CMonth') == 'April' || $data->current_time->englishMonth == 'April') selected @endif>April</option>
                                <option value="May" @if (request('CMonth') == 'May' || $data->current_time->englishMonth == 'May') selected @endif>May</option>
                                <option value="June" @if (request('CMonth') == 'June' || $data->current_time->englishMonth == 'June') selected @endif>June</option>
                                <option value="July" @if (request('CMonth') == 'July' || $data->current_time->englishMonth == 'July') selected @endif>July</option>
                                <option value="August" @if (request('CMonth') == 'August' || $data->current_time->englishMonth == 'August') selected @endif>August</option>
                                <option value="September" @if (request('CMonth') == 'September' || $data->current_time->englishMonth == 'September') selected @endif>September
                                </option>
                                <option value="October" @if (request('CMonth') == 'October' || $data->current_time->englishMonth == 'October') selected @endif>October</option>
                                <option value="November" @if (request('CMonth') == 'November' || $data->current_time->englishMonth == 'November') selected @endif>November
                                </option>
                                <option value="December" @if (request('CMonth') == 'December' || $data->current_time->englishMonth == 'December') selected @endif>December
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="year">Year</label>
                            <select name="CYear" class="form-control select2" id="year">
                                @for ($i = 2015; $i <= 2055; $i++)
                                    <option value="{{ $i }}" @if (request('CYear') == $i || $i == $data->current_time->year) selected @endif>
                                        {{ $i }}</option>
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
                    <div class="row ">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="search_code" class="float-left mt-2">Find By Code</label>
                                </div>
                                <div class="col-md-8">
                                    {{-- <input type="text" class="form-control"
                                        id="search_code" name="search_code"> --}}
                                    <select class="form-control select2" name="search_code" id="search_code">
                                        <option value="">Select a tenant</option>
                                        @foreach ($tenants as $tenant)
                                            <option value="{{ $tenant->Code }}">{{ $tenant->Code }} ({{ $tenant->Name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 text-right">
                            <button type="submit" id="search" class="btn btn-outline-info btn-lg waves-effect search"><i
                                    class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if ($bills != '')
            <form action="{{ route('ebill.prepare.save') }}" method="POST" id="ebillForm">
                @csrf
                <div class="mt-5">
                    <div class="custom-card-header text-right">
                        <button type="submit" id="save" class="btn btn-outline-info btn-lg waves-effect">
                            <i class="fa fa-save"></i>
                            Save</button>
                    </div>
                    <input type="hidden" name="unit" value="{{ $sunit }}">
                    <input type="hidden" name="floor" value="{{ $sfloor }}">
                    <input type="hidden" name="CMonth" value="{{ $CMonth }}">
                    <input type="hidden" name="CYear" value="{{ $CYear }}">

                    <div class="report_div">
                        <table v-if="bills" class="table table-bordered table-striped table-custom">
                            <thead>
                                <tr>
                                    <th colspan="9"></th>
                                    <th>
                                        <input type="number" class="form-control" v-model="lossUnitGlobal"
                                            @input="applyGlobalLossUnit">
                                    </th>
                                    <th></th>
                                </tr>
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
                                    <th>L. Unit</th>
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
                                            :name="`prev_unit[${b.Code}]`">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" :name="`last_unit[${b.Code}]`"
                                            v-model="b.cUnit"
                                            @keyup="updateUunit(b.lu, b.cUnit, `uUnit_${b.Code}`, `bill_${b.Code}`)"
                                            :min="b.lu" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" :id="`uUnit[${b.Code}]`"
                                            :name="`uUnit[${b.Code}]`" :value="Math.max(b.cUnit - b.lu, 0)"
                                            :ref="`uUnit_${b.Code}`" readonly>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" :name="`loss_unit[${b.Code}]`"
                                            v-model="b.lossUnit"
                                            @input="updateUunit(b.lu, b.cUnit, `uUnit_${b.Code}`, `bill_${b.Code}`)"
                                            :min="0" readonly>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" :ref="`bill_${b.Code}`"
                                            :name="`bill[${b.Code}]`" value="0" readonly>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6">Total</th>
                                    <th><input type="number" class="form-control" id="totalPrevUnit" readonly></th>
                                    <th><input type="number" class="form-control" id="totalCurrUnit" readonly></th>
                                    <th><input type="number" class="form-control" id="totalUsedUnit" readonly></th>
                                    <th><input type="number" class="form-control" id="totalLossUnit" readonly></th>
                                    <th><input type="number" class="form-control" id="totalAmount" readonly></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>
        @endif
    </div>

    @if ($bills != '')
        {{-- production version, optimized for size and speed --}}
        <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

        <script>
            var app = new Vue({
                el: '#app',
                data: {
                    bills: {!! $bills !!},
                    rate: {!! $rate !!},
                    lossUnitGlobal: 0, // ✅ new property
                },
                created() {
                    this.bills = this.cBills;
                },
                methods: {
                    updateUunit(last_bill, cBill, unitRef, billRef) {
                        let uUnit = cBill - last_bill;
                        if (uUnit < 0) uUnit = 0;
                        this.$refs[unitRef][0].value = uUnit;

                        const code = billRef.replace('bill_', '');
                        const bill = this.bills.find(b => b.Code === code);
                        const loss = Number(bill.lossUnit || 0);

                        let totalUnits = uUnit + loss;
                        let amount = 0;

                        // ✅ Only calculate if used unit > 0
                        if (uUnit > 0) {
                            amount = totalUnits * +this.rate;
                            if (amount < 700) {
                                amount = 700;
                            }
                        }

                        if(uUnit <= 0 && loss > 0){
                            amount = loss * +this.rate;
                        }

                        this.$refs[billRef][0].value = amount;
                        this.calculateTotals();
                    },

                    applyGlobalLossUnit() {
                        this.bills.forEach(bill => {
                            bill.lossUnit = this.lossUnitGlobal;
                        });
                        // Recalculate amounts for all bills
                        this.bills.forEach(b => {
                            this.updateUunit(b.lu, b.cUnit, `uUnit_${b.Code}`, `bill_${b.Code}`);
                        });
                    },

                    calculateTotals() {
                        let totalPrev = 0;
                        let totalCurr = 0;
                        let totalUsed = 0;
                        let totalLoss = 0;
                        let totalAmount = 0;

                        this.bills.forEach(bill => {
                            let prev = Number(bill.lu || 0);
                            let curr = Number(bill.cUnit || 0);
                            let used = curr - prev;
                            if (used < 0) used = 0;

                            let loss = Number(bill.lossUnit || 0);
                            let totalUnits = used + loss;
                            let amount = 0;

                            // ✅ Only calculate amount if used unit > 0
                            if (used > 0) {
                                amount = totalUnits * +this.rate;
                                if (amount < 700) {
                                    amount = 700;
                                }
                            }

                            if(used <= 0 && loss > 0){
                                amount = loss * +this.rate;
                            }

                            totalPrev += prev;
                            totalCurr += curr;
                            totalUsed += used;
                            totalLoss += loss;
                            totalAmount += amount;
                        });

                        document.getElementById('totalPrevUnit').value = totalPrev;
                        document.getElementById('totalCurrUnit').value = totalCurr;
                        document.getElementById('totalUsedUnit').value = totalUsed;
                        document.getElementById('totalLossUnit').value = totalLoss;
                        document.getElementById('totalAmount').value = totalAmount;
                    },
                },
                computed: {
                    cBills() {
                        let i = 1;
                        let b = [];
                        let bills = this.bills;
                        for (const bill in bills) {
                            this.bills[bill].si = i;
                            i++;

                            if (this.bills[bill].last_unit == null) {
                                this.bills[bill].lu = 0;
                            } else {
                                this.bills[bill].lu = this.bills[bill].last_unit.LastUnit;
                            }

                            this.bills[bill].cUnit = '';
                            this.bills[bill].lossUnit = 0; // ✅ Set default loss unit

                            b.push(this.bills[bill]);
                        }

                        b = _.orderBy(b, ['PositionNo'], ['asc']);
                        return b;
                    }
                }
            });
        </script>
    @endif
@endsection
