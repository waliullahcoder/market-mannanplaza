@extends('admin.layouts.master')

@section('content')
    <form class="form-horizontal" action="{{ route($formLink) }}" id="formAddEdit" method="POST" enctype="multipart/form-data" name="form">
        {{ csrf_field() }}

        <div class="card">
            <div class="custom-card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="custom-card-title">{{ $title }}</h4></div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-outline-info btn-lg" href="{{ route('post.index',$post->page_id) }}">
                            <i class="fa fa-arrow-circle-left"></i> Go Back
                        </a>
                        <button type="submit" class="btn btn-outline-info btn-lg waves-effect buttonAddEdit" name="buttonAddEdit"><i class="fa fa-save"></i> {{ $buttonName }}</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <input class="form-control" type="hidden" name="pageId" value="{{ $post->page_id }}">
                    </div>

                    <div class="col-md-6">
                        <input class="form-control" type="hidden" name="postId" value="{{ $post->id }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('postName') ? ' has-danger' : '' }}">
                            <label for="post-name">Post Name</label>
                            <input type="text" class="form-control" placeholder="Post Name" name="postName" value="{{ $post->post_name }}">
                            @if ($errors->has('postName'))
                                @foreach($errors->get('postName') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                            <label for="orderBy">Order By</label>
                            <input type="number" class="form-control" placeholder="Order By" name="orderBy" value="{{ $post->order_by }}">
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
                        <div class="form-group {{ $errors->has('title') ? ' has-danger' : '' }}">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" placeholder="Write Title" name="title" value="{{ $post->title }}">
                            @if ($errors->has('title'))
                                @foreach($errors->get('title') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('innerTitle') ? ' has-danger' : '' }}">
                            <label for="inner-title">Inner Title</label>
                            <input type="text" class="form-control" placeholder="Write Inner title" name="innerTitle" value="{{ $post->inner_title }}">
                            @if ($errors->has('innerTitle'))
                                @foreach($errors->get('innerTitle') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
                            <label for="description">Description</label>
                           <textarea id="summernote" name="description">{{ $post->description }}</textarea>
                            @if ($errors->has('description'))
                                @foreach($errors->get('description') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('image') ? ' has-danger' : '' }}">
                                    <label for="image">Image</label>
                                    <input type="hidden" class="form-control" name="previousImage" value="{{ $post->image }}">
                                    <input type="file" class="form-control" name="image" value="{{ old('image') }}">
                                     <span class="imageSizeInfo">/* Min Width: 410px, Min Height: 410px <br></span>
                                    @if ($errors->has('image'))
                                        @foreach($errors->get('image') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('width') ? ' has-danger' : '' }}">
                                    <label for="width">Width</label>
                                    <input type="text" class="form-control" placeholder="Image Width" name="width" value="{{ old('width') }}">
                                    <input type="hidden" class="form-control" name="previousWidth" value="{{ $post->width }}">
                                    @if ($errors->has('width'))
                                        @foreach($errors->get('width') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('height') ? ' has-danger' : '' }}">
                                    <label for="height">Height</label>
                                    <input type="text" class="form-control" placeholder="Image Height" name="height" value="{{ old('height') }}">
                                    <input type="hidden" class="form-control"name="previousHeight" value="{{ $post->height }}">
                                    @if ($errors->has('height'))
                                        @foreach($errors->get('height') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label>Width: {{ $post->width }}px, Height: {{ $post->height }}px</label>
                        <div class="form-group">
                            <img src="{{ asset($post->image) }}" width="230px" height="140px">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('innerImage') ? ' has-danger' : '' }}">
                                    <label for="inner-image">Inner Image</label>
                                    <input type="hidden" class="form-control" name="previousInnerImage" value="{{ $post->inner_image }}">
                                    <input type="file" class="form-control" name="innerImage" value="{{ old('innerImage') }}">
                                     <span class="imageSizeInfo">/* Min Width: 410px, Min Height: 410px <br></span>
                                    @if ($errors->has('innerImage'))
                                        @foreach($errors->get('innerImage') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('innerWidth') ? ' has-danger' : '' }}">
                                    <label for="inner-width">Width</label>
                                    <input type="text" class="form-control" placeholder="Image Width" name="innerWidth" value="{{ old('innerWidth') }}">
                                    <input type="hidden" class="form-control" name="previousInnerWidth" value="{{ $post->inner_width }}">
                                    @if ($errors->has('innerWidth'))
                                        @foreach($errors->get('innerWidth') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('innerHeight') ? ' has-danger' : '' }}">
                                    <label for="inner-height">Height</label>
                                    <input type="text" class="form-control" placeholder="Image Height" name="innerHeight" value="{{ old('innerHeight') }}">
                                    <input type="hidden" class="form-control" name="previousInnerHeight" value="{{ $post->inner_height }}">
                                    @if ($errors->has('innerHeight'))
                                        @foreach($errors->get('innerHeight') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label>Width: {{ $post->inner_width }}px, Height: {{ $post->inner_height }}px</label>
                        <div class="form-group">
                            <img src="{{ asset($post->inner_image) }}" width="230px" height="140px">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('link') ? ' has-danger' : '' }}">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" placeholder="Write URL Link" name="link" value="{{ $post->link }}">
                            @if ($errors->has('link'))
                                @foreach($errors->get('link') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('icon') ? ' has-danger' : '' }}">
                            <label for="icon">Icon</label>
                            <input type="text" class="form-control" placeholder="Write Icon" name="icon" value="{{ $post->icon }}">
                            @if ($errors->has('icon'))
                                @foreach($errors->get('icon') as $error)
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
                                    <input type="text" class="form-control" placeholder="Meta Title" name="metaTitle" value="{{ $post->meta_title }}">
                                    @if ($errors->has('metaTitle'))
                                        @foreach($errors->get('metaTitle') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="meta-keyword">Meta Keyword</label>
                                <div class="form-group {{ $errors->has('metaKeyword') ? ' has-danger' : '' }}">
                                    <input type="text" class="form-control" placeholder="Meta Keyword" name="metaKeyword" value="{{ $post->meta_keyword }}" data-role="tagsinput">
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
                            <textarea class="form-control" placeholder="Meta Description" name="metaDescription" rows="6">{{ $post->meta_description }}</textarea>
                            @if ($errors->has('metaDescription'))
                                @foreach($errors->get('metaDescription') as $error)
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

@section('custom-js')
    <script>
        $('#summernote').summernote({
            placeholder: 'Write Description',
            tabsize: 2,
            height: 200,
        });
    </script>
@endsection