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
                        <a href="{{ route('jamidari.prepare.index') }}" class="btn btn-outline-info btn-lg waves-effect search float-right"><i class="fa fa-arrow-circle-left"></i>
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

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="serial_no">Current Serial No</label>
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
                            @for ($i = 2015; $i <= 2055; $i++)
                                <option value="{{ $i }}" @if ($i == $data->current_time->year)
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
                <div class="row ">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="search_code" class="float-left mt-2 text-rights">Find By Code</label>
                            </div>
                            <div class="col-md-5">
                                <select class="form-control select2" name="search_code" id="search_code">
                                    <option value="">Select An tenant</option>
                                    @foreach ($tenants as $tenant)
                                        <option value="{{ $tenant->Code }}">{{ $tenant->Code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 text-right">
                        <button type="button" id="search" class="btn btn-outline-info btn-lg waves-effect search"><i
                                class="fa fa-search"></i> Search</button>

                        <button type="submit" id="save" class="btn btn-outline-info btn-lg waves-effect ml-2"><i
                                class="fa fa-save"></i> Save</button>
                        {{--
                        <button type="button" id="print" onclick="printTable()"
                            class="btn btn-outline-info btn-lg waves-effect search ml-2"><i class="fa fa-print"></i>
                            Print</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </form>


    <div class="mt-5 report_div">

    </div>


    <script>
        function fetchReport(unit, floor, search_code) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('jamidari.prepare.search') }}",
                data: {
                    unit: unit,
                    floor: floor,
                    search_code: search_code
                },
                success: function(response) {
                    showReport(response);
                },
                error: function(response) {
                    console.log(response);
                }
            });

        }

        function showReport(response) {
            // console.log(response);
            let i = 0;

            for (const [unit, floor] of Object.entries(response)) {
                let UnitRent = 0;
                for (const [floor, tenants] of Object.entries(response[unit])) {
                    addTableSkeleton(i, unit, floor);
                    let FloorRent = addTenants(i, tenants);
                    UnitRent += +FloorRent;
                    i++;
                }
                addUnitTotal(UnitRent);
                console.log(UnitRent);
            }

        }

        function addTableSkeleton(i, unit, floor) {
            let table = `
                    <div class="d-flex justify-content-between font-weight-bold">
                        <span>Unit: ${unit}</span>
                        <span class="float-right">Floor: ${floor}</span>
                    </div>

                        <table class="table table-bordered table-striped table-custom">
                            <thead>
                                <tr>
                                    <th style="width:20px;">SL</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Mobile No</th>
                                    <th>Unit</th>
                                    <th>Floor</th>
                                    <th>PositionNo</th>
                                    <th>Size</th>
                                    <th style="width:100px;">Rent</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_${i}">

                            </tbody>
                        </table>
                        `;

            $('.report_div').append(table);
        }

        function addTenants(i, tenants) {
            let trs = ``;
            let serial = 1;

            let FloorRent = 0;

            tenants.forEach(tenant => {
                trs += `
                    <tr>
                        <td>${serial}</td>
                        <td>${tenant.Code}</td>
                        <td>${tenant.Name}</td>
                        <td>${tenant.Mobile}</td>
                        <td>${tenant.Unit}</td>
                        <td>${tenant.Floor}</td>
                        <td>${tenant.PositionNo}</td>
                        <td>${tenant.PositionSize}</td>
                        <td>${tenant.Agg0ne}</td>
                    </tr>
                    `;

                FloorRent += +tenant.Agg0ne;
                serial++;
            });

            let tfoot = `
                    <tr>
                        <td colspan="8" class="text-right font-weight-bold">Total Floor Rent</td>
                        <td>${FloorRent}</td>
                    </tr>
                `;

            $(`#tbody_${i}`).append(trs);
            $(`#tbody_${i}`).append(tfoot);

            return FloorRent;

        }

        function addUnitTotal(ut) {
            let unitTotal = `
                <table class="table table-bordered border-dark">
                    <tr>
                        <td class="text-right font-weight-bold">Total Unit Rent</td>
                        <td style="width:100px;">${ut}</td>
                    </tr>
                </table>
                `;

            $('.report_div').append(unitTotal);
        }

        $('#search').click(function(e) {
            e.preventDefault();
            $('.report_div').html('');

            let units = $('#unit').val();
            let floors = $('#floor').val();
            let search_code = $('#search_code').val();

            fetchReport(units, floors, search_code);

        });

        function printTable() {
            print();
        }

    </script>

@endsection
