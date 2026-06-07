@extends('admin.layouts.masterIndex')

@section('card_body')
    <div class="card-body">
        <div class="table-responsive">
            @php
                $message = Session::get('msg');
                if (isset($message))
                {
                    echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                }

                Session::forget('msg');
            @endphp
            <table id="dataTable" class="table table-bordered table-striped"  name="usersTable">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>User Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @php
                        $sl = 0;
                    @endphp
                	@foreach($users as $user)
                        @php
                            $sl++;
                        @endphp
                    	<tr class="row_{{ $user->id }}">
                            <td>{{ $sl }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->userRoleName }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <?php echo \App\Link::status($user->id,$user->status)?>
                            </td>
                            <td class="text-nowrap">
                            <?php echo \App\Link::action($user->id)?>
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

                userId = $(this).parent().data('id');
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
                            url : "{{ route('user.delete') }}",
                            data : {userId:userId},

                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "User Deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                $('.row_'+userId).remove();
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
                            text: "Your User is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

        });

        //ajax status change code
        function statusChange(user_id,status) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('user.status') }}",
                data: {userId:user_id,status:status},
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
