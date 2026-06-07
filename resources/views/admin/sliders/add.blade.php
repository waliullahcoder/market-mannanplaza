@extends('admin.layouts.masterAddEdit')

@section('card_body')
    <style type="text/css">
        .chosen-single{
            height: 35px !important;
        }
    </style>

    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('firstTitle') ? ' has-danger' : '' }}">
                    <label for="first-title">First Title</label>
                    <input type="text" class="form-control form-control-danger" placeholder="slider first title" name="firstTitle" value="{{ old('firstTitle') }}">
                    @if ($errors->has('firstTitle'))
                        @foreach($errors->get('firstTitle') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('secondTitle') ? ' has-danger' : '' }}">
                    <label for="second-title">Second Title</label>
                    <input type="text" class="form-control form-control-danger" placeholder="slider second title" name="secondTitle" value="{{ old('secondTitle') }}">
                    @if ($errors->has('secondTitle'))
                        @foreach($errors->get('secondTitle') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('thirdTitle') ? ' has-danger' : '' }}">
                    <label for="third-title">Thhird Title</label>
                    <input type="text" class="form-control form-control-danger" placeholder="slider second title" name="thirdTitle" value="{{ old('thirdTitle') }}">
                    @if ($errors->has('thirdTitle'))
                        @foreach($errors->get('thirdTitle') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
                    <label for="description">Slider Short Description</label>
                   <textarea id="summernote" name="description"></textarea>
                    @if ($errors->has('description'))
                        @foreach($errors->get('description') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('image') ? ' has-danger' : '' }}">
                    <label for="image">Slider Image</label>
                    <input type="file" class="form-control" placeholder="Category Image" name="image" value="{{ old('image') }}">
                     <span class="imageSizeInfo">/* Min Width: 410px, Min Height: 410px <br></span>
                    @if ($errors->has('image'))
                        @foreach($errors->get('image') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group {{ $errors->has('width') ? ' has-danger' : '' }}">
                    <label for="width">Width</label>
                    <input type="text" class="form-control" placeholder="Image Width" name="width" value="{{ old('width') }}">
                    @if ($errors->has('width'))
                        @foreach($errors->get('width') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>

            </div>

            <div class="col-md-3">
                <div class="form-group {{ $errors->has('height') ? ' has-danger' : '' }}">
                    <label for="height">Height</label>
                    <input type="text" class="form-control" placeholder="Image Height" name="height" value="{{ old('height') }}">
                    @if ($errors->has('height'))
                        @foreach($errors->get('height') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('link') ? ' has-danger' : '' }}">
                    <label for="link">Link</label>
                    <input type="text" class="form-control form-control-danger" placeholder="url link" name="link" value="{{ old('link') }}">
                    @if ($errors->has('link'))
                        @foreach($errors->get('link') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>

            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                    <label for="orderBy">Order By</label>
                    <input type="number"  name="orderBy" class="form-control" value="{{ old('orderBy') }}">
                    @if ($errors->has('orderBy'))
                        @foreach($errors->get('orderBy') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                    	<label for="meta-title">Meta Title</label>
                        <div class="form-group {{ $errors->has('metaTitle') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control form-control-danger" placeholder="Meta Title" name="metaTitle" value="">
                            @if ($errors->has('metaTitle'))
                                @foreach($errors->get('metaTitle') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                    	<label for="meta-keyword">Meta keyword</label>
                    	<div class="form-group {{ $errors->has('metaKeyword') ? ' has-danger' : '' }}">
                    		<input type="text" class="form-control form-control-danger" name="metaKeyword" value="" data-role="tagsinput">
                            @if ($errors->has('metaKeyword'))
                                @foreach($errors->get('metaKeyword') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

             <div class="col-md-6">
             	<label for="meta-description">Meta description</label>
                <div class="form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
                    <textarea class="form-control" name="metaDescription" rows="6"></textarea>
                    @if ($errors->has('metaDescription'))
                        @foreach($errors->get('metaDescription') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        $('#summernote').summernote({
            placeholder: 'Write Short Description For Slider Image',
            tabsize: 2,
            height: 200,
        });
    </script>
@endsection