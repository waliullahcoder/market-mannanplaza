@extends('admin.layouts.master')

@section('content')

<div class="card noprint">
    <div class="custom-card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="custom-card-title">{{ $title }}</h4>
            </div>
            {{-- <div class="col-md-6 text-right">
                <button type="submit" class="btn btn-outline-info btn-lg waves-effect"><i class="fa fa-search"></i>
                    Search</button>
            </div> --}}
        </div>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-md-4">
                <label for="unit">Unit</label>
                <select name="units[]" class="form-control select2" id="units" multiple>
                    @foreach ($data->units as $unit)
                    <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="floor">Floor</label>
                <select name="floors[]" class="form-control select2" id="floors" multiple>
                    @foreach ($data->floors as $floor)
                    <option value="{{ $floor->name }}">{{ $floor->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="type">Type</label>
                <select name="type[]" class="form-control select2" id="type">
                    <option value="">Select an Option</option>
                    <option value="Rent">Rent</option>
                    <option value="Sale">Sale</option>
                </select>
            </div>

        </div>
    </div>

    <div class="custom-card-footer">
        <div class="row  text-right">
            <div class="col-md-12">
                <button type="button" id="search" class="btn btn-outline-info btn-lg waves-effect search"><i
                        class="fa fa-search"></i> Search</button>

                <button type="button" id="print" onclick="printTable()"
                    class="btn btn-outline-info btn-lg waves-effect search ml-2"><i class="fa fa-print"></i>
                    Print</button>
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-5">
    <h3 class="font-weight-bold">{{ $data->project->name }}</h3>
    <p>{{ $data->project->address }}</p>
    <p>{{ $data->project->contact }}</p>
    <hr style="border:none; border-bottom: 1px solid black;">
    <h4 class="font-weight-bold mt-2">Client List</h4>
    <hr style="border:none; border-bottom: 1px solid black;">
</div>

<div class="mt-2 report_div">
</div>

<div class="mt-2 total_div">
</div>

<script>
    let totalRent = 0;
    let totalSize = 0;

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    function fetchReport(units, floors, type) {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "{{ route('tenant.report.search') }}",
            data: {
                units: units,
                floors: floors,
                type: type,
            },
            success: function(response) {
                showReport(response);

                sleep(2000);

                let total = `
                    <table class="table table-bordered border-dark">
                        <tr>
                            <td class="text-right font-weight-bold">Total</td>
                            <td style="width:130px;">Rent: ${totalRent}</td>
                            <td style="width:130px;">Size: ${totalSize}</td>
                        </tr>
                    </table>
                    `;

                $('.total_div').append(total);

            },
            error: function(response) {
                // console.log(response);
            }
        });

    }

    function showReport(response) {
        // console.log(response);
        let i = 0;

        for (const [unit, floor] of Object.entries(response)) {

            let TotalUnitRent = 0;
            let TotalUnitSize = 0;

            for (const [floor, tenants] of Object.entries(response[unit])) {
                // console.log(floor, tenants);

                if(tenants.length == 0){
                    continue;
                }

                addTableSkeleton(i, unit, floor);

                let FloorTotals = addTenants(i, tenants);

                TotalUnitRent += +FloorTotals.floorRent;
                TotalUnitSize += +FloorTotals.floorSize;

                i++;
            }
            addUnitTotal(TotalUnitRent, TotalUnitSize);
        }

    }

    function addTableSkeleton(i, unit, floor) {
        let table = `
        <div class="d-flex justify-content-between font-weight-bold">
            <span>Unit: ${unit}</span>
            <span class="float-right">Floor: ${floor}</span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-custom">
                <thead>
                    <tr>
                        <th style="width:20px;">SL</th>
                        <th style="width:100px;">Code</th>
                        <th style="width:100px;">Name</th>
                        <th style="width:100px;">Mobile No</th>
                        <th style="width:100px;">Size</th>
                        <th style="width:100px;">Type</th>
                        <th style="width:100px;">Rent</th>
                    </tr>
                </thead>
                <tbody id="tbody_${i}">
                </tbody>
                <tfoot id="tfoot_${i}">
                </tfoot>
            </table>
        </div>
            `;

        $('.report_div').append(table);
    }

    function addTenants(i, tenants) {
        let trs = ``;
        let serial = 1;

        let FloorRent = 0;
        let FloorSize = 0;

        tenants.forEach(tenant => {

            let positionSize = tenant.PositionSize == null ? "" : tenant.PositionSize;
            let positionRent = tenant.Agg0ne == null ? "" : tenant.Agg0ne;

            trs += `
                <tr>
                    <td>${serial}</td>
                    <td>${tenant.Code}</td>
                    <td>${tenant.Name}</td>
                    <td>${tenant.Mobile == null ? "" : tenant.Mobile}</td>
                    <td>${positionSize}</td>
                    <td>${tenant.EntryReson}</td>
                    <td>${positionRent}</td>
                </tr>
                `;

            FloorRent += +positionRent;
            FloorSize += +positionSize;

            serial++;
        });

        let tfoot = `
                <tr>
                    <th colspan="4" class="text-right font-weight-bold">Total</th>
                    <th>${FloorSize}</th>
                    <th></th>
                    <th>${FloorRent}</th>
                </tr>
            `;

        $(`#tbody_${i}`).append(trs);
        $(`#tfoot_${i}`).append(tfoot);

        return {
            floorRent: FloorRent,
            floorSize: FloorSize
        };

    }

    function addUnitTotal(TotalUnitRent, TotalUnitSize) {

        totalRent += +TotalUnitRent;
        totalSize += +TotalUnitSize;

        let unitTotal = `
            <table class="table table-bordered border-dark">
                <tr>
                    <td class="text-right font-weight-bold">Total Unit</td>
                    <td style="width:130px;">Rent: ${TotalUnitRent}</td>
                    <td style="width:130px;">Size: ${TotalUnitSize}</td>
                </tr>
            </table>
            `;

        $('.report_div').append(unitTotal);
    }

    $('#search').click(function(e) {
        e.preventDefault();
        $('.report_div').html('');

        let units = $('#units').val();
        let floors = $('#floors').val();
        let type = $('#type').val();

        fetchReport(units, floors, type);

    });

    function printTable() {
        print();
    }

</script>

@endsection
