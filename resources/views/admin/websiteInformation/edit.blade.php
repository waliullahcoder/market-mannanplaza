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
    			<input class="form-control" type="hidden" name="websiteInformationId" value="{{ $websiteInformation->id }}">
    		</div>
    	</div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('siteName') ? ' has-danger' : '' }}">
                    <label for="siteName">Website Name</label>
                        <input type="text" class="form-control form-control-danger" name="siteName" value="{{ $websiteInformation->website_name }}" required>
                </div>
            </div>

            <div class="col-md-4">
            	<label for="titlePrefix">Prefix of Title</label>
                <div class="form-group {{ $errors->has('titlePrefix') ? ' has-danger' : '' }}">
                	<input type="text" class="form-control form-control-danger" name="titlePrefix" value="{{ $websiteInformation->prefix_title }}" required>
                </div>
            </div>

            <div class="col-md-4">
                <label for="siteTitle">Website Title</label>
                <div class="form-group {{ $errors->has('siteTitle') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" name="siteTitle" value="{{ $websiteInformation->website_title }}" required>
                </div>
            </div>
        </div>

        <div class="row">            
            <div class="col-md-4">
                <label for="website-link">Website Link</label>
                <div class="form-group {{ $errors->has('websiteLink') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" name="websiteLink" value="{{ $websiteInformation->developer_website_link }}" required>
                </div>
            </div>

            <div class="col-md-4">
            	<label for="develpoed-by">Developed By</label>
                <div class="form-group {{ $errors->has('developedBy') ? ' has-danger' : '' }}">
                	<input type="text" class="form-control" name="developedBy" value="{{ $websiteInformation->developed_by }}" required>
                </div>
            </div>
            
            <div class="col-md-4">
                <label for="developer-website-link">Developer Website Link</label>
                <div class="form-group {{ $errors->has('developerWebsiteLink') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" name="developerWebsiteLink" value="{{ $websiteInformation->developer_website_link }}" required>
                </div>
            </div>            
        </div>

        <div class="row">
            <div class="col-md-4">
                <label for="phone-number-one">Phone Number One</label>
                <div class="form-group {{ $errors->has('phoneNumberOne') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" name="phoneNumberOne" value="{{ $websiteInformation->phone_one }}">
                </div>
            </div>
            <div class="col-md-4">
                <label for="phone-number-two">Phone Number Two</label>
                <div class="form-group {{ $errors->has('phoneNumberOne') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" name="phoneNumberTwo" value="{{ $websiteInformation->phone_two }}">
                </div>
            </div>
            <div class="col-md-4">
                <label for="phone-number-three">Phone Number Three</label>
                <div class="form-group {{ $errors->has('phoneNumberOne') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" name="phoneNumberThree" value="{{ $websiteInformation->phone_three }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
            	<label for="website-logo">Website Logo - 1</label>
                <div class="form-group {{ $errors->has('siteLogo1') ? ' has-danger' : '' }}">
                    <input type="hidden" class="form-control" id="previousSiteLogo1" name="previousSiteLogo1" value="{{ $websiteInformation->logo_one }}">
                    <input type="file" class="form-control" id="siteLogo1" aria-describedby="fileHelp" name="siteLogo1">
                    <span class="imageSizeInfo">Standard Image Size : 195px * 55px</span>
                    @if ($errors->has('siteLogo1'))
                        @foreach($errors->get('siteLogo1') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-4">
            	<label for="website-logo">Website Logo - 2</label>
                <div class="form-group {{ $errors->has('siteLogo2') ? ' has-danger' : '' }}">
                    <input type="hidden" class="form-control" id="previousSiteLogo2" name="previousSiteLogo2" value="{{ $websiteInformation->logo_two }}">
                    <input type="file" class="form-control" id="siteLogo2" aria-describedby="fileHelp" name="siteLogo2">
                    <span class="imageSizeInfo">Standard Image Size : 273px * 97px</span>
                    @if ($errors->has('siteLogo2'))
                        @foreach($errors->get('siteLogo2') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-4">
            	<label for="website-fav-icon">Website Fav Icon</label>
                <div class="form-group {{ $errors->has('sitefavIcon') ? ' has-danger' : '' }}">
                    <input type="hidden" class="form-control" id="previousSitefavIcon" name="previousSitefavIcon" value="{{ $websiteInformation->fav_icon }}">
                    <input type="file" class="form-control" id="sfavIconogo" aria-describedby="fileHelp" name="sitefavIcon">
                    <span class="imageSizeInfo">Standard Image Size : 50px * 100px</span>
                    @if ($errors->has('sitefavIcon'))
                        @foreach($errors->get('sitefavIcon') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
        	<div class="col-md-4">
        		<div class="form-group">
        			<img src="{{ asset($websiteInformation->logo_one) }}" width="100px" height="50px">
        		</div>
        	</div>
        	<div class="col-md-4">
        		<div class="form-group">
        			<img src="{{ asset($websiteInformation->logo_two) }}" width="100px" height="50px">
        		</div>
        	</div>
        	<div class="col-md-4">
        		<div class="form-group">
        			<img src="{{ asset($websiteInformation->fav_icon) }}" width="100px" height="50px">
        		</div>
        	</div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                    	<label for="meta-title">Meta Title</label>
                        <div class="form-group {{ $errors->has('metaTitle') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control form-control-danger" placeholder="Meta Title" name="metaTitle" value="{{ $websiteInformation->meta_title }}">
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
                    		<input type="text" class="form-control form-control-danger" name="metaKeyword" value="" data-role="tagsinput" value="{{ $websiteInformation->meta_keyword }}">
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
                    <textarea class="form-control" name="metaDescription" rows="6">{{ $websiteInformation->meta_description }}</textarea>
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