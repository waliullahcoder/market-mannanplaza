@extends('admin.layouts.master')

@section('content')
    <form class="form-horizontal" action="{{ route($formLink) }}" id="formAddEdit" method="POST" enctype="multipart/form-data" name="form">
        {{ csrf_field() }}

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-outline-info btn-lg" href="{{ route($goBackLink) }}">
                            <i class="fa fa-arrow-circle-left"></i> Go Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <input class="form-control" type="hidden" name="userRoleId" value="{{ $userRole->id }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label for="parent-role">Parent Role</label>
                        <div class="form-group {{ $errors->has('parentRole') ? ' has-danger' : '' }}">
                            <select class="form-control chosen-select" name="parentRole">
                                <option value="">Select Parent Role</option>
                                @foreach ($userRoleLists as $userRoleList)
                                    @if ($userRoleList->id != $userRole->id)
                                        @php
                                            if ($userRoleList->id == $userRole->parent_role && $userRoleList->id != $userRole->id)
                                            {
                                                $select = "selected";
                                            }
                                            else
                                            {
                                                $select = "";
                                            }
                                        @endphp
                                        <option value="{{ $userRoleList->id }}" {{ $select }}>{{ $userRoleList->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <label for="name">Name</label>
                        <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control form-control-danger" placeholder="Name" name="name" value="{{ $userRole->name }}" required>
                            @if ($errors->has('name'))
                                @foreach($errors->get('name') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="col-md-1">
                        <label for=""></label>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-info btn-md buttonAddEdit" name="buttonAddEdit" value="Update"><i class="fa fa-save"></i> {{ $buttonName }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection