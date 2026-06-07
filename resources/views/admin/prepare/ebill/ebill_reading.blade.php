@extends('admin.layouts.master')

@section('content')

    <div id="app">

        <form action="{{ route('ebill.reading.sheet') }}" method="GET">

            <input type="hidden" name="searched" value="true">

            <div class="card noprint">
                <div class="custom-card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="custom-card-title">{{ $title }}</h4>
                        </div>
                        {{-- <div class="col-md-4">
                            <a href="{{ route('ebill.prepare.index') }}"
                                class="btn btn-outline-info btn-lg waves-effect search float-right"><i
                                    class="fa fa-arrow-circle-left"></i>
                                Go Back</a>
                        </div> --}}
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="unit">Unit</label>
                            <select name="unit" class="form-control select2" id="unit">
                                @foreach ($data->units as $unit)
                                    <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="floor">Floor</label>
                            <select name="floor" class="form-control select2" id="floor">
                                @foreach ($data->floors as $floor)
                                    <option value="{{ $floor->name }}">{{ $floor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>


                <div class="custom-card-footer">
                    <div class="row text-right">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" id="search" class="btn btn-outline-info btn-lg waves-effect search"><i
                                    class="fa fa-search"></i> Search</button>

                            <button onclick="print()" type="button" class="btn btn-outline-info btn-lg waves-effect ml-2"><i
                                    class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if ($bills != '')
            <form action="{{ route('ebill.prepare.save') }}" method="POST" id="ebillForm">
                @csrf

                <input type="hidden" name="unit" value="{{ $sunit }}">
                <input type="hidden" name="floor" value="{{ $sfloor }}">
                <input type="hidden" name="CMonth" value="{{ $CMonth }}">
                <input type="hidden" name="CYear" value="{{ $CYear }}">
                <input type="hidden" name="PaidDate" value="{{ $PaidDate }}">

                <div class="mt-5 report_div table-responsive">
                    <table v-if="bills" class="table table-bordered table-striped table-custom">
                        <thead>
                            <tr>
                                <th>SL</th>
                                {{-- <th style="width: 80px">Unit</th> --}}
                                {{-- <th style="width: 130px">Floor</th> --}}
                                <th style="width: 80px">Client Code</th>
                                <th style="width: 80px">Position</th>
                                <th style="width: 200px">Client Name</th>
                                <th style="width: 150px">P. Unit</th>
                                <th>C. Unit</th>
                            </tr>

                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($bills as $bill)

                                <tr>
                                    <td>{{ $i++ }}</td>
                                    {{-- <td>{{ $sunit }}</td> --}}
                                    {{-- <td>{{ $sfloor }}</td> --}}
                                    <td>
                                        <span>{{ $bill->Code }}</span>
                                        <input type="hidden" name="codes[]" value="{{ $bill->Code }}">
                                    </td>
                                    <td>
                                        {{ $bill->PositionNo }}
                                    </td>
                                    <td>
                                        {{ $bill->Name }}
                                    </td>

                                    <td>
                                        @if ($bill->last_unit)
                                            <input type="number" class="form-control" name="prev_unit[{{ $bill->Code }}]"
                                                value="{{ $bill->last_unit->LastUnit }}" readonly>
                                        @else

                                            <input type="number" class="form-control" name="prev_unit[{{ $bill->Code }}]"
                                                value="0" readonly>
                                        @endif
                                    </td>

                                    <td>
                                        <input type="number" class="form-control" :name="last_unit[{{ $bill->Code }}]">
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        @endif


    </div>


    {{-- @if ($bills != '')

        <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

        <script>
            var app = new Vue({
                el: '#app',
                data: {
                    bills: {
                        !!$bills!!
                    },
                    rate: {
                        !!$rate!!
                    }
                },
                created() {
                    // console.log(this.bills);
                    this.bills = this.bills;
                },
                methods: {
                    updateUunit(last_bill, cBill, unitRef, billRef) {
                        let uUnit = cBill - last_bill;
                        this.$refs[unitRef][0].value = uUnit;
                        this.$refs[unitRef][0].value = uUnit;

                        let bill = uUnit * +this.rate;

                        if (bill < 700) {
                            bill = 700
                        }

                        this.$refs[billRef][0].value = bill;
                    }
                },
                computed: {
                    cBills() {

                        let i = 1;
                        let b = [];

                        for (const bill in this.bills) {
                            this.bills[bill].si = i;
                            i++;

                            if (this.bills[bill].last_unit == null) {
                                this.bills[bill].lu = 0;
                            } else {
                                this.bills[bill].lu = this.bills[bill].last_unit.LastUnit;
                            }

                            this.bills[bill].cUnit = '';

                            b.push(this.bills[bill]);

                        }

                        return b;
                    }
                }
            })

        </script>

    @endif --}}


@endsection
