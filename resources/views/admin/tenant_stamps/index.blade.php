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
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/') }}public/uploads/admin_logo/logo_small.png">
    <link rel="icon" type="image/png" sizes="20x20" href="{{ asset('/') }}public/uploads/admin_logo/logo_small.png">

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
                            <div class="col-md-6">
                                <h4 class="custom-card-title">{{ $title }}</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <a style="font-size: 16px;" class="btn btn-outline-info btn-lg"
                                    href="{{ route('positionInformation.add', $tenantId) }}">
                                    <i class="fa fa-arrow-circle-left"></i>Go Back
                                </a>

                                <a style="font-size: 16px;" class="btn btn-outline-info btn-lg"
                                    href="{{ route('positionInformation.add.stamps', $tenantId) }}">
                                    <i class="fa fa-plus-circle"></i> Add New
                                </a>
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

                            <table id="dataTable" class="table table-bordered table-striped" name="areaTable">
                                <thead>
                                    <tr>
                                        <th width="20px">SL</th>
                                        <th>Stamp NO</th>
                                        <th width="110px">Stamp Image</th>
                                        <th width="80px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="" class="bod-modal" data-title="center" data-interval="3">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($stamps as $stamp)
                                        <tr class="row_{{ $stamp->id }}">
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                {{ $stamp->stamp_no }}
                                            </td>
                                            <td>
                                                <a href="{{ asset($stamp->stamp_image) }}">
                                                    <img src="{{ asset($stamp->stamp_image) }}" width="100px" height="100px" alt="Stamp Image">
                                                </a>
                                            </td>
                                            <td data-id="{{ $stamp->id }}">
                                                <button class="btn btn-info" onclick="window.location='{{ route('positionInformation.edit.stamp', $stamp->id) }}'"><i class="fas fa-edit text-inverse m-r-10"></i> Edit</button>
                                                <button class="btn btn-danger mt-1" > <i class="fa fa-trash text-white"></i> Delete</button>
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

    <!-- This page plugins -->
    <script>
        $(document).ready(function() {
            var updateThis;

            //ajax delete code
            $('#dataTable tbody').on('click', 'button.btn-danger', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                stamp = $(this).parent().data('id');

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
                                url: "{{ route('positionInformation.delete.stamp') }}",
                                data: {
                                    stamp: stamp
                                },

                                success: function(response) {
                                    swal({
                                        title: "<small class='text-success'>Success!</small>",
                                        type: "success",
                                        text: "Deleted Successfully!",
                                        timer: 1000,
                                        html: true,
                                    });
                                    $('.row_' + stamp).remove();
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

</body>

</html>
