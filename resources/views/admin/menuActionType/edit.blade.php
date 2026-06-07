@extends('admin.layouts.masterAddEdit')

@section('card_body')
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <input class="form-control" type="text" name="typeId" value="{{ $menuActionType->id }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="menu-name">Menu Action Name</label>
                <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Menu Action name" name="name" value="{{ $menuActionType->name }}" required>
                    @if ($errors->has('name'))
                        @foreach($errors->get('name') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <label for="order-by">Order By</label>
                <div class="form-group {{ $errors->has('actionId') ? ' has-danger' : '' }}">
                    <input type="number" class="form-control" placeholder="Menu Action Type Id" id="actionId" name="actionId" value="{{ $menuActionType->action_id }}" required>
                    @if ($errors->has('actionId'))
                        @foreach($errors->get('actionId') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection