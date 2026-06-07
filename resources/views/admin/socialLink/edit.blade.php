@extends('admin.layouts.masterAddEdit')

@section('card_body')
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <input class="form-control" type="hidden" name="socialLinkId" value="{{ $socialLink->id }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="social-link-name">Name</label>
                <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Menu name" name="name" value="{{ $socialLink->name }}" required>
                    @if ($errors->has('name'))
                        @foreach($errors->get('name') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <label for="social-link-icon">Icon</label>
                <div class="form-group {{ $errors->has('socialLinkIcon') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="fa fa-icon" name="socialLinkIcon" value="{{ $socialLink->icon }}">
                    @if ($errors->has('socialLinkIcon'))
                        @foreach($errors->get('socialLinkIcon') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="social-link">Link</label>
                <div class="form-group {{ $errors->has('socialLink') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Menu link" name="socialLink" value="{{ $socialLink->link }}" required>
                    @if ($errors->has('socialLink'))
                        @foreach($errors->get('socialLink') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <label for="order-by">Order By</label>
                <div class="form-group {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                    <input type="number" class="form-control" placeholder="Order By" id="orderBy" name="orderBy" value="{{ $socialLink->order_by }}" required>
                    @if ($errors->has('orderBy'))
                        @foreach($errors->get('orderBy') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>              
    </div>
@endsection