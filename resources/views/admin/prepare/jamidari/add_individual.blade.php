@extends('admin.layouts.master')

@section('content')
<form action="{{ route($formLink) }}" method="POST">
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
                <div class="col-md-4">
                    <label for="Client_Code">Client Code</label>
                    <select class="form-control select2" name="client_code" id="search_code">
                        <option value="">Select Client</option>

                        @foreach ($tenants as $tenant)
                        <option value="{{ $tenant->Code }}">{{ $tenant->Code }} ({{ $tenant->Name }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="month">Month</label>
                    <select class="form-control select2" id="CMonth" name="CMonth">
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

                <div class="col-md-4">
                    <label for="year">Year</label>
                    <select class="form-control select2" id="CYear" name="CYear">
						<option value="2026">2026</option>
                        @for ($i = 2000; $i <= 2055; $i++) <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                    </select>
                </div>

                <div class="col-md-4 mt-3">
                    <label for="year">Serial No</label>
                    <input type="text" class="form-control" name="serial_no" id="SerialNo" value="{{ $serial_no }}"
                        disabled>
                </div>

                <div class="col-md-4 mt-3">

                    <label for="year">Prepare Date</label>
                    <input type="text" class="form-control add_datepicker" id="paid_date" name="paid_date">
                </div>

                <div class="col-md-4 mt-3">
                    <label for="year">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" readonly>
                </div>

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
    $('#search_code').change(function (e) {
            e.preventDefault();

            $.ajax({
                type: "GET",
                url: "{{ route('jamidari.tenant.info.get.ajax') }}",
                data: {
                    client_code: $('#search_code').val()
                },
                success: function (response) {
                    $('#amount').val(response.Agg0ne);
                }
            });

        });
</script>

@endsection