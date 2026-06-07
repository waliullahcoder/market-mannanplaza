@extends('admin.layouts.master')

@section('custom_css')
    <style type="text/css">
        td{
            font-weight: bold;
        }
        .user-image{
            width: 120px;
            height: 120px;
            border: 1px solid #198206;
            border-radius: 3px;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
                <div class="col-md-6 text-right">
                    <a class="btn btn-outline-info btn-lg" href="{{ $link == 1 ? url('/admin') : route($goBackLink) }}">
                        <i class="fa fa-arrow-circle-left"></i> Go Back
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table color-bordered-table muted-bordered-table table-sm">
                    <thead class="thead-green">
                        <tr>
                            <th colspan="4" style="text-align: center;"><font size="5px">{{ $user->name }}</font></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td rowspan="3" width="125px" align="center">
                                <img src="{{ asset($user->image) }}" class="user-image">
                            </td>
                        </tr>

                        <tr>
                            <td width="140px">User Role</td>
                            <td width="10px">:</td>
                            <td>{{ $user->userRoleName }}</td>
                        </tr>

                        <tr>
                            <td width="140px">Email</td>
                            <td width="10px">:</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
