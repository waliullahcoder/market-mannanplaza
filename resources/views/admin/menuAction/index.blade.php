@extends('admin.layouts.master')

@section('content')
    <div class="card">            
        <div class="custom-card-header">
            <div class="row">
                <div class="col-md-6"><h4 class="custom-card-title">{{ $title }}</h4></div>
                <div class="col-md-6 text-right">
                	<a class="btn btn-outline-info btn-lg" href="{{ route($goBackLink) }}">
                		<i class="fa fa-arrow-circle-left"></i> Go Back
                	</a>
                    <a style="font-size: 16px;" class="btn btn-outline-info btn-lg" href="{{ route('menuAction.add',$menuId) }}">
                        <i class="fa fa-plus-circle"></i> Add New
                    </a>                  
                </div>
            </div>
        </div>
    
	    <div class="card-body">
	        <div class="table-responsive">
	            @php
	                $sl = 0;
	            @endphp

	            <table id="dataTable" class="table table-bordered table-striped"  name="areaTable">
	                <thead>
	                    <tr>
	                        <th width="20px">SL</th>
	                        <th>Name</th>
	                        <th>Parent</th>
	                        <th>Link</th>
	                        <th width="20px">Order</th>
	                        <th width="20px">Status</th>
	                        <th width="80px">Action</th>
	                    </tr>
	                </thead>
	                <tbody id="">
	                	@php
	                		$sl = 1;
	                	@endphp
	                	@foreach ($menuActions as $menuAction)
	                		<tr class="row_{{ $menuAction->id }}">
	                			<td>{{ $sl++ }}</td>
	                			<td>{{ $menuAction->action_name }}</td>
	                			<td>{{ $menuAction->parentMenuName }}</td>
	                            <td>{{ $menuAction->action_link }}</td>
	                            <td>{{ $menuAction->order_by }}</td>
	                			<td>
                                    <span class="switchery-demo m-b-30" onclick="statusChange({{ $menuAction->id }})">
                                        <input type="checkbox" {{ $menuAction->status ? 'checked':'' }} class="js-switch" data-color="#00c292" data-switchery="true" style="display: none;" >
                                    </span>
	                			</td>
	                			<td>
                                    <a href="{{ route('menuAction.edit',$menuAction->id) }}" data-toggle="tooltip" data-original-title="Edit" data-id="{{ $menuAction->id }}"> <i class="fas fa-edit text-inverse m-r-10"></i> </a>

                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="{{ $menuAction->id }}"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>                				
	                			</td>
	                		</tr>
	                	@endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
    </div>	
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {
            var updateThis ;       

            //ajax delete code
            $('#dataTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                menuActionId = $(this).parent().data('id');
                var tableRow = this;
                swal({   
                    title: "Are you sure?",   
                    text: "You will not be able to recover this information!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Yes, delete it!",   
                    cancelButtonText: "No, cancel plx!",   
                    closeOnConfirm: false,   
                    closeOnCancel: false 
                },
                function(isConfirm){   
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            url : "{{ route('menuAction.delete') }}",
                            data : {menuActionId:menuActionId},
                           
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>", 
                                    type: "success",
                                    text: "Deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                $('.row_'+menuActionId).remove();
                            },
                            error: function(response) {
                                error = "Failed.";
                                swal({
                                    title: "<small class='text-danger'>Error!</small>", 
                                    type: "error",
                                    text: error,
                                    timer: 1000,
                                    html: true,
                                });
                            }
                        });    
                    }
                    else
                    { 
                        swal({
                            title: "Cancelled", 
                            type: "error",
                            text: "This Data Is Safe :)",
                            timer: 1000,
                            html: true,
                        });    
                    } 
                });
            });
        });
                
        // ajax status change code
        function statusChange(menuActionId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('menuAction.status') }}",
                data: {menuActionId:menuActionId},
                success: function(response) {
                    swal({
                        title: "<small class='text-success'>Success!</small>", 
                        type: "success",
                        text: "Status Successfully Updated!",
                        timer: 1000,
                        html: true,
                    });
                },
                error: function(response) {
                    error = "Failed.";
                    swal({
                        title: "<small class='text-danger'>Error!</small>", 
                        type: "error",
                        text: error,
                        timer: 2000,
                        html: true,
                    });
                }
            });
        }
    </script>
@endsection