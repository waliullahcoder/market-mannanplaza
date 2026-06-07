@extends('admin.layouts.masterAddEdit')

@section('card_body')
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" class="form-control" name="utilityId" value="{{ $utility->id }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="Utility-code">Utility Code</label>
                <div class="form-group {{ $errors->has('code') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Code" name="code" value="{{ $utility->code }}" required>
                    @if ($errors->has('code'))
                        @foreach($errors->get('code') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <label for="Utility-name">Utility Name</label>
                <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Floor Name" name="name" value="{{ $utility->name }}" required>
                    @if ($errors->has('name'))
                        @foreach($errors->get('name') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection