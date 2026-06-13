<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('/') }}public/uploads/admin_logo/logo_small.png">
    <link rel="icon" type="image/png" sizes="20x20"
        href="{{ asset('/') }}public/uploads/admin_logo/logo_small.png">

    @include('admin.partials.header-assets')

    <style type="text/css">
        .card-pad {
            padding-bottom: 10px;
        }
    </style>
    @yield('custom_css')
</head>

<body class="skin-default fixed-layout">
    <!-- Preloader - style you can find in spinners.css -->
    @include('admin.partials.preloader')

    <!-- Main wrapper - style you can find in pages.scss -->
    <div id="main-wrapper">
        <!-- Topbar header - style you can find in pages.scss -->
        <header class="topbar">
            @include('admin.partials.top-navbar')
        </header>
        <!-- End Topbar header -->

        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        @include('admin.partials.menu')
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Bread crumb and right sidebar toggle -->
                @yield('bread-crumb')
                <!-- End Bread crumb and right sidebar toggle -->

                <div style="padding-bottom: 10px;"></div>

                @php
                    $message = Session::get('msg');
                    $message = Session::get('success');
                @endphp

                @if (isset($message))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success!</strong> {{ $message }}
                    </div>
                @endif

                @php
                    Session::forget('msg');
                @endphp

                <div class="card">
                    <div class="custom-card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="custom-card-title">{{ $title }}</h4>
                            </div>
                            <div class="col-md-8 text-right">
                                <div class="row">
                                    <div class="col-md-4 col-6 offset-md-4">
                                       
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <a style="font-size: 16px;background: none;border: 1px solid;"
                                            class="text-center btn-block btn-outline-info bg-none btn-lg buttonAddEdit "
                                             href="{{ route('banglalink.add') }}">
                                            <i class="fa fa-plus-circle"></i>Add New
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body Content -->
                    <div class="card-body">

                        <div class="table-responsive">
                            @php
                                $sl = 0;
                            @endphp

                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Bill No</th>
                                        <th>Consumer Name</th>
                                        <th>Bill Month</th>
                                        <th>Year</th>
                                        <th>Meter No</th>
                                        <th>Peak Unit</th>
                                        <th>Off Peak Unit</th>
                                        <th>Unit Rate</th>
                                        <th>Electricity Charge</th>
                                        <th>Demand Charge</th>
                                        <th>Service Charge</th>
                                        <th>VAT</th>
                                        <th>Grand Total</th>
                                        <th>Prepare Date</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                    @php
                                        $i = 1;
                                    @endphp
                                @foreach($bills as $bill)
                                    <tr class="row_{{ $bill->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $bill->bill_no }}</td>
                                        <td>{{ $bill->consumer_name }}</td>
                                        <td>{{ $bill->bill_month }}</td>
                                        <td>{{ $bill->bill_year }}</td>
                                        <td>{{ $bill->meter_no }}</td>
                                        <td>{{ $bill->peak_unit }}</td>
                                        <td>{{ $bill->off_peak_unit }}</td>
                                        <td>{{ number_format($bill->unit_rate, 2) }}</td>
                                        <td>{{ number_format($bill->electricity_charge, 2) }}</td>
                                        <td>{{ number_format($bill->demand_charge, 2) }}</td>
                                        <td>{{ number_format($bill->service_charge, 2) }}</td>
                                        <td>{{ number_format($bill->vat_amount, 2) }}</td>
                                        <td>{{ number_format($bill->grand_total, 2) }}</td>
                                        <td>{{ $bill->prepare_date }}</td>

                                        <td>
                                            <a href="{{ route('banglalink.edit', $bill->id) }}">
                                                <i class="fa fa-edit text-info"></i>
                                            </a>
                                            <!-- <a href="{{ route('banglalink.edit', $bill->id) }}">
                                                <i class="fa fa-print text-success m-r-10"></i>
                                            </a> -->
                                             <button type="button" class="btn btn-sm" onclick="printBill({{ $bill->id }})">
                                                <i class="fa fa-print text-success m-r-10"></i></button>

                                            <a href="javascript:void(0)" data-id="{{ $bill->id }}">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- End Card Body Content -->
                </div>

                <!-- Right sidebar -->
                @include('admin.partials.right-sidebar')
                <!-- End Right sidebar -->
            </div>
            <!-- End Container fluid  -->
        </div>
        <!-- End Page wrapper  -->

        <!-- footer -->
        @include('admin.partials.footer')
        <!-- End footer -->

    </div>
    <!-- End Wrapper -->


 @include('admin.prepare.banglalink.print')
    @include('admin.partials.footer-assets')

    <script>
        $(document).ready(function() {
            var updateThis;

            var table = $('#datatable').DataTable({
                "order": []
            });

            //ajax delete code
            $('#datatable tbody').on('click', 'i.fa-trash', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let ebill = $(this).parent().data('id');
                var tableRow = this;
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this information!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('ebill.prepare.delete') }}",
                                data: {
                                    ebill: ebill
                                },

                                success: function(response) {
                                    swal({
                                        title: "<small class='text-success'>Success!</small>",
                                        type: "success",
                                        text: "Deleted Successfully!",
                                        timer: 1000,
                                        html: true,
                                    });
                                    $('.row_' + ebill).remove();
                                },
                                error: function(response) {
                                    error = "Failed.";
                                    swal({
                                        title: "<small class='text-danger'>Error!</small>",
                                        type: "error",
                                        text: error,
                                        timer: 1000,
                                        html: true,
                                    });
                                }
                            });
                        } else {
                            swal({
                                title: "Cancelled",
                                type: "error",
                                text: "This Data Is Safe :)",
                                timer: 1000,
                                html: true,
                            });
                        }
                    });
            });
        });
    </script>

    <!-- This page plugins -->
    @yield('custom-js')

</body>

</html>
