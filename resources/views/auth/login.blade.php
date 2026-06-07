<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/elite-admin/assets/images/favicon.png') }}">
    <title>Admin | Login</title>

    <!-- toast CSS -->
    <link href="{{ asset('public/elite-admin/assets/node_modules/toast-master/css/jquery.toast.css') }}"
        rel="stylesheet">

    <!-- page css -->
    <link href="{{ asset('public/elite-admin/dist/css/pages/login-register-lock.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('public/elite-admin/dist/css/style.min.css') }}" rel="stylesheet">

    <!-- Font Awsome -->
    <link href="{{ asset('public/elite-admin/fontawesome/css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('public/elite-admin/fontawesome/css/brands.css') }}" rel="stylesheet">
    <link href="{{ asset('public/elite-admin/fontawesome/css/solid.css') }}" rel="stylesheet">
    <!-- Custom Style For CSS -->
    <link href="{{ asset('public/elite-admin/dist/css/custom_style.css') }}" rel="stylesheet">
</head>

<body class="skin-default card-no-border">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Elite admin</p>
        </div>
    </div>

    <!-- Main wrapper - style you can find in pages.scss -->
    <section id="wrapper">
        <div class="login-register"
            style="background-image:url({{ asset('public/elite-admin/assets/images/background/bg-6.jpg') }});">
            <h1 class="text-center text-roboto" style="font-size: 60px">Mannan Plaza</h1>

            <div class="overlay">
            </div>


            <div class="login-box card">
                @php
                $message = Session::get('passwordMessage');
                @endphp

                @if (isset($message))
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                                aria-hidden="true">&times;</span> </button>
                        <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Warning</h3>
                        {{ $message }}
                    </div>
                @endif

                @php
                Session::forget('passwordMessage');
                @endphp

                <div class="row">
                    <div class="col-md-5">
                        <div class="d-flex logo">
                            <img class="img-fluid w-50"
                                src="{{ asset('public/elite-admin/assets/images/ksc_logo.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-md-7" style="border-left: 1px solid black">
                        <div class="card-body">
                            <form class="form-horizontal form-material" id="loginform" method="POST"
                                action="{{ route('admin.login') }}">
                                @csrf


                                <h3 class="text-center m-b-20">System Login</h3>

                                <div class="form-group ">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" required="" placeholder="Email"
                                            name="email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="password" required="" placeholder="Password"
                                            name="password">
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <div class="col-xs-12 p-b-20">
                                        <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit">Log
                                            In</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



            </div>

        </div>
    </section>
    <!-- End Wrapper -->

    <!-- All Jquery -->
    <script src="{{ asset('public/elite-admin/assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>

    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('public/elite-admin/assets/node_modules/popper/popper.min.js') }}"></script>
    <script src="{{ asset('public/elite-admin/assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!--Custom JavaScript -->
    <script src="{{ asset('public/elite-admin/assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('public/elite-admin/dist/js/pages/toastr.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

        // Login and Recover Password
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });

    </script>
    <style>
        .card-body {
            width: 400px;
        }

        .login-box {
            margin: 150px auto !important;
            padding: 30px 0 30px 0;
            width: 830px;
        }

        .login-register {
            background-repeat: no-repeat;
            background-size: cover;
        }

        .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: .5;
            transition: .5s ease;
            background-color: #000;
        }

        .logo {
            justify-content: center;
            align-items: center;
            margin-top: 70px;
        }

    </style>

</body>

</html>
