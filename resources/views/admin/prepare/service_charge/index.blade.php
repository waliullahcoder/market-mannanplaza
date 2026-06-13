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
                                        <a style="font-size: 16px;background: none;border: 1px solid;"
                                            class="text-center btn-block btn-outline-info bg-none btn-lg buttonAddEdit "
                                            href="{{ route('service.charge.prepare.add.individual') }}">
                                            <i class="fa fa-plus-circle"></i> Individual Posting
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <a style="font-size: 16px;background: none;border: 1px solid;"
                                            class="text-center btn-block btn-outline-info bg-none btn-lg buttonAddEdit "
                                            href="{{ route('service.charge.prepare.add.auto') }}">
                                            <i class="fa fa-plus-circle"></i> Auto Generate
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body Content -->
                    <div class="card-body">
                        {{-- <div align='center'>
                            <font size='7' text-align='center' color='green' face='Comic sans MS'>This Page Is Now Under
                                Construction</font>
                        </div> --}}

                        <div class="table-responsive">
                            @php
                                $sl = 0;
                            @endphp

                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Serial No</th>
                                        <th>Code</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Unit</th>
                                        <th>Floor</th>
                                        <th>Prepare Date</th>
                                        <th>Prepare By</th>
                                        <th width="80px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($data->wbill_list as $wbill)
                                        <tr class="row_{{ $wbill->SerialNo }}">
                                            <td>{{ $wbill->SerialNo }}</td>
                                            <td>{{ $wbill->Client_Code }}</td>
                                            <td>{{ $wbill->CMonth }}</td>
                                            <td>{{ $wbill->CYear }}</td>
                                            <td>
                                                @if (isset($wbill->position_holder))
                                                    {{ $wbill->position_holder->Unit }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($wbill->position_holder))
                                                    {{ $wbill->position_holder->Floor }}
                                                @endif
                                            </td>
                                            <td>{{ Carbon\Carbon::parse($wbill->PaidDate)->format('d-m-Y') }}
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{ Carbon\Carbon::parse($wbill->PaidDate)->format('(l)') }}
                                            </td>
                                            <td>{{ $wbill->CreateBy }}</td>
                                            <td>
                                                @php
                                                    echo \App\Link::action($wbill->SerialNo);
                                                @endphp
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

                let wbill = $(this).parent().data('id');
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
                                url: "{{ route('wbill.prepare.delete') }}",
                                data: {
                                    wbill: wbill
                                },

                                success: function(response) {
                                    swal({
                                        title: "<small class='text-success'>Success!</small>",
                                        type: "success",
                                        text: "Deleted Successfully!",
                                        timer: 1000,
                                        html: true,
                                    });
                                    $('.row_' + wbill).remove();
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
