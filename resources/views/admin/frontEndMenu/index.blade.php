@extends('admin.layouts.masterIndex')

@section('card_body')
    <div class="card-body">
        <div class="table-responsive">
            @php
                $sl = 0;
            @endphp

            <table id="dataTable" class="table table-bordered table-striped"  name="areaTable">
                <thead>
                    <tr>
                        <th width="20px">SL</th>
                        <th width="210px">Name</th>
                        <th width="210px">Parent</th>
                        <th width="210px">Link</th>
                        <th width="20px">Order</th>
                        <th width="20px">Status</th>
                        <th width="20px">Menu</th>
                        <th width="100px">Footer Menu</th>
                        <th width="80px">Action</th>
                    </tr>
                </thead>
                <tbody id="">
                	@php
                		$sl = 1;
                	@endphp
                	@foreach ($menus as $menu)
                		<tr class="row_{{ $menu->id }}">
                			<td>{{ $sl++ }}</td>
                			<td>{{ $menu->menu_name }}</td>
                			<td>{{ $menu->parentName }}</td>
                            <td>{{ $menu->menu_link }}</td>
                            <td>{{ $menu->order_by }}</td>
                			<td>
                                @php
                                    echo \App\Link::status($menu->id,$menu->status);
                                @endphp
                			</td>
                            <td>
                                <span class="switchery-demo m-b-30" onclick="menuStatusChange({{ $menu->id }})">
                                    <input type="checkbox" {{ $menu->menu_status == 1 ? 'checked' : '' }} class="js-switch" data-color="#00c292" data-switchery="true" style="display: none;">
                                </span>
                            </td>
                            <td>
                                <span class="switchery-demo m-b-30" onclick="footerMenuStatusChange({{ $menu->id }})">
                                    <input type="checkbox" {{ $menu->footer_menu_status == 1 ? 'checked' : '' }} class="js-switch" data-color="#00c292" data-switchery="true" style="display: none;">
                                </span>
                            </td>
                            <td>
                                @php
                                    echo \App\Link::action($menu->id);
                                @endphp                             
                            </td>
                		</tr>
                	@endforeach
                </tbody>
            </table>
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

                menuId = $(this).parent().data('id');
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
                            url : "{{ route('frontEndMenu.delete') }}",
                            data : {menuId:menuId},
                           
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>", 
                                    type: "success",
                                    text: "Deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                $('.row_'+menuId).remove();
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
                
        //ajax status change code
        function statusChange(menuId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('frontEndMenu.status') }}",
                data: {menuId:menuId},
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

        function menuStatusChange(menuId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('frontEndMenu.menuStatus') }}",
                data: {menuId:menuId},
                success: function(response) {
                    swal({
                        title: "<small class='text-success'>Success!</small>", 
                        type: "success",
                        text: "Menu Status Successfully Updated!",
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

        function footerMenuStatusChange(menuId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('frontEndMenu.footerMenuStatus') }}",
                data: {menuId:menuId},
                success: function(response) {
                    swal({
                        title: "<small class='text-success'>Success!</small>", 
                        type: "success",
                        text: "Footer Menu Status Successfully Updated!",
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