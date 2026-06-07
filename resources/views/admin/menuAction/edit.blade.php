@extends('admin.layouts.master')

@section('content')
    <form class="form-horizontal" action="{{ route($formLink) }}" id="formAddEdit" method="POST" enctype="multipart/form-data" name="form">
        {{ csrf_field() }}

        <div class="card">
            <div class="custom-card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="custom-card-title">{{ $title }}</h4></div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-outline-info btn-lg" href="{{ route('menuAction.index',$menuAction->parent_menu_id) }}">
                            <i class="fa fa-arrow-circle-left"></i> Go Back
                        </a>
                        <button type="submit" class="btn btn-outline-info btn-lg waves-effect buttonAddEdit" name="buttonAddEdit"><i class="fa fa-save"></i> {{ $buttonName }}</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <input class="form-control" type="hidden" name="parentMenuId" value="{{ $menuAction->parent_menu_id }}">
                    </div>

                    <div class="col-md-6">
                        <input class="form-control" type="hidden" name="menuActionId" value="{{ $menuAction->id }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="Menu-type">Menu Type</label>
                        <div class="form-group {{ $errors->has('menuType') ? ' has-danger' : '' }}">
                            <select class="form-control select2" name="menuType">
                                <option value=" ">Select Menu Type</option>
                                @foreach ($menuActionTypes as $menuActionType)
                                	@php
                                		if ($menuActionType->action_id == $menuAction->menu_type)
                                		{
                                			$select = "selected";
                                		}
                                		else
                                		{
                                			$select = "";
                                		}
                                		
                                	@endphp
                                    <option value="{{ $menuActionType->action_id }}" {{ $select }}>{{ $menuActionType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="name">Name</label>
                        <div class="form-group {{ $errors->has('actionName') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control form-control-danger" placeholder="Add" name="actionName" value="{{ $menuAction->action_name }}" required>
                            @if ($errors->has('actionName'))
                                @foreach($errors->get('actionName') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="link">Link</label>
                        <div class="form-group {{ $errors->has('actionLink') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control form-control-danger" placeholder="menu.add" name="actionLink" value="{{ $menuAction->action_link }}" required>
                            @if ($errors->has('actionLink'))
                                @foreach($errors->get('actionLink') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="order-by">Order By</label>
                        <div class="form-group {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                            <input type="number" class="form-control form-control-danger" placeholder="order by" name="orderBy" value="{{ $menuAction->order_by }}" required>
                            @if ($errors->has('orderBy'))
                                @foreach($errors->get('orderBy') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="custom-card-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-outline-info btn-lg waves-effect buttonAddEdit" name="buttonAddEdit" value="Save"><i class="fa fa-save"></i> {{ $buttonName }}</button>
                    </div>
                </div>              
            </div>
        </div>
    </form>
@endsection