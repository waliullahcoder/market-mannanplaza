@extends('admin.layouts.masterAddEdit')

@section('card_body')
    <style type="text/css">
        .chosen-single{
            height: 35px !important;
        }
    </style>

    <div class="card-body">
    	<div class="row">
    		<div class="col-md-12">
    			<input class="form-control" type="hidden" name="websiteInformationId" value="{{ $adminInformation->id }}">
    		</div>
    	</div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('siteName') ? ' has-danger' : '' }}">
                    <label for="siteName">Website Name</label>
                        <input type="text" class="form-control form-control-danger" name="siteName" value="{{ $adminInformation->website_name }}" required>
                </div>
            </div>

            <div class="col-md-4">
            	<label for="titlePrefix">Prefix of Title</label>
                <div class="form-group {{ $errors->has('titlePrefix') ? ' has-danger' : '' }}">
                	<input type="text" class="form-control form-control-danger" name="titlePrefix" value="{{ $adminInformation->prefix_title }}" required>
                </div>
            </div>

            <div class="col-md-4">
                <label for="siteTitle">Website Title</label>
                <div class="form-group {{ $errors->has('siteTitle') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" name="siteTitle" value="{{ $adminInformation->website_title }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
            	<label for="develpoed-by">Developed By</label>
                <div class="form-group {{ $errors->has('developedBy') ? ' has-danger' : '' }}">
                	<input type="text" class="form-control" name="developedBy" value="{{ $adminInformation->developed_by }}" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <label for="developer-website-link">Developer Website Link</label>
                <div class="form-group {{ $errors->has('developerWebsiteLink') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" name="developerWebsiteLink" value="{{ $adminInformation->developer_website_link }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
            	<label for="website-logo">Website Logo - 1</label>
                <div class="form-group {{ $errors->has('siteLogo1') ? ' has-danger' : '' }}">
                    <input type="hidden" class="form-control" id="previousSiteLogo1" name="previousSiteLogo1" value="{{ $adminInformation->logo_one }}">
                    <input type="file" class="form-control" id="siteLogo1" aria-describedby="fileHelp" name="siteLogo1">
                    <span class="imageSizeInfo">Standard Image Size : 195px * 55px</span>
                    <img src="{{ asset($adminInformation->logo_one) }}" width="100px" height="50px" style="margin-top: 5px;">
                    @if ($errors->has('siteLogo1'))
                        @foreach($errors->get('siteLogo1') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group {{ $errors->has('siteLogo1Width') ? ' has-danger' : '' }}">
                    <label for="width">Width</label>
                    <input type="text" class="form-control" placeholder="Image Width" name="siteLogo1Width" value="{{ old('siteLogo1Width') }}">
                    <input type="hidden" class="form-control" placeholder="Image Width" name="previousSiteLogo1Width" value="{{ $adminInformation->logo_one_width }}">
                    @if ($errors->has('siteLogo1Width'))
                        @foreach($errors->get('siteLogo1Width') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>

            </div>

            <div class="col-md-3">
                <div class="form-group {{ $errors->has('siteLogo1Height') ? ' has-danger' : '' }}">
                    <label for="height">Height</label>
                    <input type="text" class="form-control" placeholder="Image Height" name="siteLogo1Height" value="{{ old('siteLogo1Height') }}">
                    <input type="hidden" class="form-control" placeholder="Image Height" name="previousSiteLogo1Height" value="{{ $adminInformation->logo_one_height }}">
                    @if ($errors->has('siteLogo1Height'))
                        @foreach($errors->get('siteLogo1Height') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
            	<label for="website-logo">Website Logo - 2</label>
                <div class="form-group {{ $errors->has('siteLogo2') ? ' has-danger' : '' }}">
                    <input type="hidden" class="form-control" id="previousSiteLogo2" name="previousSiteLogo2" value="{{ $adminInformation->logo_two }}">
                    <input type="file" class="form-control" id="siteLogo2" aria-describedby="fileHelp" name="siteLogo2">
                    <span class="imageSizeInfo">Standard Image Size : 273px * 97px</span>
                    <img src="{{ asset($adminInformation->logo_two) }}" width="100px" height="50px" style="margin-top: 5px;">
                    @if ($errors->has('siteLogo2'))
                        @foreach($errors->get('siteLogo2') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group {{ $errors->has('siteLogo2Width') ? ' has-danger' : '' }}">
                    <label for="site-logo-2-width">Width</label>
                    <input type="text" class="form-control" placeholder="Image Width" name="siteLogo2Width" value="{{ old('siteLogo2Width') }}">
                    <input type="hidden" class="form-control" placeholder="Image Width" name="previousSiteLogo2Width" value="{{ $adminInformation->logo_two_width }}">
                    @if ($errors->has('siteLogo2Width'))
                        @foreach($errors->get('siteLogo2Width') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>

            </div>

            <div class="col-md-3">
                <div class="form-group {{ $errors->has('siteLogo2Height') ? ' has-danger' : '' }}">
                    <label for="site-logo-2-height">Height</label>
                    <input type="text" class="form-control" placeholder="Image Height" name="siteLogo2Height" value="{{ old('siteLogo2Height') }}">
                    <input type="hidden" class="form-control" placeholder="Image Height" name="previousSiteLogo2Height" value="{{ $adminInformation->logo_two_height }}">
                    @if ($errors->has('siteLogo2Height'))
                        @foreach($errors->get('siteLogo2Height') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
            	<label for="website-fav-icon">Website Fav Icon</label>
                <div class="form-group {{ $errors->has('sitefavIcon') ? ' has-danger' : '' }}">
                    <input type="hidden" class="form-control" id="previousSitefavIcon" name="previousSitefavIcon" value="{{ $adminInformation->fav_icon }}">
                    <input type="file" class="form-control" id="sfavIconogo" aria-describedby="fileHelp" name="sitefavIcon">
                    <span class="imageSizeInfo">Standard Image Size : 50px * 100px</span>
                    <img src="{{ asset($adminInformation->fav_icon) }}" width="100px" height="50px" style="margin-top: 5px;">
                    @if ($errors->has('sitefavIcon'))
                        @foreach($errors->get('sitefavIcon') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group {{ $errors->has('sitefavIconWidth') ? ' has-danger' : '' }}">
                    <label for="site-logo-2-width">Width</label>
                    <input type="text" class="form-control" placeholder="Image Width" name="sitefavIconWidth" value="{{ old('sitefavIconWidth') }}">
                    <input type="hidden" class="form-control" placeholder="Image Width" name="previousSitefavIconWidth" value="{{ $adminInformation->fav_icon_width }}">
                    @if ($errors->has('sitefavIconWidth'))
                        @foreach($errors->get('sitefavIconWidth') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>

            </div>

            <div class="col-md-3">
                <div class="form-group {{ $errors->has('sitefavIconHeight') ? ' has-danger' : '' }}">
                    <label for="site-logo-2-height">Height</label>
                    <input type="text" class="form-control" placeholder="Image Height" name="sitefavIconHeight" value="{{ old('sitefavIconHeight') }}">
                    <input type="hidden" class="form-control" placeholder="Image Height" name="previousSitefavIconHeight" value="{{ $adminInformation->fav_icon_height }}">
                    @if ($errors->has('sitefavIconHeight'))
                        @foreach($errors->get('sitefavIconHeight') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection