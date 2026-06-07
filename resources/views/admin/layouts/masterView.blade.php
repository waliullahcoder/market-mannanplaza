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
        
        @include('admin.partials.header-assets')

        @yield('custom_css')
    </head>

    <body class="skin-default fixed-layout">
        <!-- Preloader -->
        @include('admin.partials.preloader')

        <!-- Main wrapper - style you can find in pages.scss -->
        <div id="main-wrapper">
            <!-- Topbar header - style you can find in pages.scss -->
            @include('admin.partials.top-navbar')
            <!-- End Topbar header -->

            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            @include('admin.partials.menu')
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->

            <!-- Page wrapper  -->
            <div class="page-wrapper">
                <!-- Container fluid  -->
                <div class="container-fluid">
                    <!-- Bread crumb and right sidebar toggle -->
                    <div class="row page-titles">
                        <div class="col-md-5 align-self-center">
                            <h4 class="text-themecolor">Fix Header Sidebar</h4>
                        </div>
                        <div class="col-md-7 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                    <li class="breadcrumb-item active">Fix Header Sidebar</li>
                                </ol>
                                <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Bread crumb and right sidebar toggle -->

                    @php
                        $message = Session::get('msg');
                        $error = Session::get('error');
                    @endphp

                    @if (isset($message))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success!</strong> {{ $message }}
                        </div>
                    @endif

                    @if (isset($error))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Oops!</strong> {{ $error }}
                        </div>
                    @endif

                    @php
                        Session::forget('msg');
                        Session::forget('error');
                    @endphp

                    @if( count($errors) > 0 )
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Oops!</strong> {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Start Page Content -->
                    <div class="card">
                        <div class="custom-card-header">
                            <div class="row">
                                <div class="col-md-6"><h4 class="custom-card-title">{{ $title }}</h4></div>
                                <div class="col-md-6 text-right">
                                    <a class="btn btn-outline-info btn-lg" href="{{ route($goBackLink) }}">
                                        <i class="fa fa-arrow-circle-left"></i> Go Back
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body Content -->
                        @yield('card_body')
                        <!-- End Card Body Content -->
                    </div>
                    <!-- End PAge Content -->

                    <!-- Right sidebar -->
                    @include('admin.partials.right-sidebar')
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
        @yield('custom-js')
    </body>
</html>