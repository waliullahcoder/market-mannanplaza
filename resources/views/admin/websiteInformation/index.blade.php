@extends('admin.layouts.master')

@section('custom_css')
	<style type="text/css">
		.head_name {
			font-weight: bold;
			width: 170px;
		}

		.head_colon {
			font-weight: bold;
			width: 10px;
		}

		.image_title {
			font-weight: bold;
		}
	</style>
@endsection

@section('content')
    <div class="card">            
        <div class="card-header">
            <div class="row">
                <div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
                <div class="col-md-6">  
                    <span class="shortlink">
                        @if ($websiteInformationCount == 0)
                            <a style="font-size: 16px;" class="btn btn-outline-info btn-lg" href="{{ route('websiteInformation.add') }}">
                                <i class="fa fa-plus-circle"></i> Add New
                            </a>
                        @else
                            <a style="font-size: 16px;" class="btn btn-outline-info btn-lg" href="{{ route('websiteInformation.edit',$websiteInformation->id) }}">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        @endif
                    </span>                     
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-borderless table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="6">Website Information</th>
                    </tr>
                </thead>

                <tbody>
                	<tr>
                		<td class="head_name">Website Name</td>
                		<td class="head_colon">:</td>
                		<td>{{ $websiteInformation->website_name }}</td>
                	</tr>

                	<tr>
                		<td class="head_name">Website Prefix Title</td>
                		<td class="head_colon">:</td>
                		<td>{{ $websiteInformation->prefix_title }}</td>
                	</tr>

                	<tr>
                		<td class="head_name">Website Title</td>
                		<td class="head_colon">:</td>
                		<td>{{ $websiteInformation->website_title }}</td>
                	</tr>

                    <tr>
                        <td class="head_name">Website Link</td>
                        <td class="head_colon">:</td>
                        <td>{{ $websiteInformation->website_link }}</td>
                    </tr>

                    <tr>
                        <td class="head_name">Phone Number One</td>
                        <td class="head_colon">:</td>
                        <td>{{ $websiteInformation->phone_one }}</td>
                    </tr>

                    <tr>
                        <td class="head_name">Phone Number Two</td>
                        <td class="head_colon">:</td>
                        <td>{{ $websiteInformation->phone_two }}</td>
                    </tr>

                    <tr>
                        <td class="head_name">Phone Number Three</td>
                        <td class="head_colon">:</td>
                        <td>{{ $websiteInformation->phone_three }}</td>
                    </tr>

                	<tr>
                		<td class="head_name">Developed By</td>
                		<td class="head_colon">:</td>
                		<td>{{ $websiteInformation->developed_by }}</td>
                	</tr>

                    <tr>
                        <td class="head_name">Developer Website Link</td>
                        <td class="head_colon">:</td>
                        <td>{{ $websiteInformation->developer_website_link }}</td>
                    </tr>
                	
                	<tr>
                		<td class="head_name">Meta Title</td>
                		<td class="head_colon">:</td>
                		<td>{{ $websiteInformation->meta_title }}</td>
                	</tr>

                	<tr>
                		<td class="head_name">Meta Keyword</td>
                		<td class="head_colon">:</td>
                		<td>{{ $websiteInformation->meta_keyword }}</td>
                	</tr>

                	<tr>
                		<td class="head_name">Meta Description</td>
                		<td class="head_colon">:</td>
                		<td>{{ $websiteInformation->meta_description }}</td>
                	</tr>
                </tbody>
            </table>

            <table class="table table-bordered table-sm">
            	<thead class="thead-dark">
            		<tr>
            			<th colspan="3">Images</th>
            		</tr>
            	</thead>

            	<tbody align="center">
            		<tr>
            			<td>
            				<img src="{{ asset($websiteInformation->logo_one) }}" width="150px" height="150px">
            			</td>
            			<td>
            				<img src="{{ asset($websiteInformation->logo_two) }}" width="150px" height="150px">
            			</td>
            			<td>
            				<img src="{{ asset($websiteInformation->fav_icon) }}" width="150px" height="150px">
            			</td>
            		</tr>

            		<tr>
            			<td class="image_title">Logo - 1</td>
            			<td class="image_title">Logo - 2</td>
            			<td class="image_title">Fav Icon</td>
            		</tr>
            	</tbody>
            </table>
        </div>
    </div>
@endsection