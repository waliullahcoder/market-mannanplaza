@extends('admin.layouts.masterIndex')

@section('card_body')
    <div class="card-body">
        {{-- <div align='center'>
            <font size='7' text-align='center' color='green' face='Comic sans MS'>This Page Is Now Under Construction</font>
        </div> --}}

        <div class="table-responsive">
            @php
            $sl = 0;
            @endphp

            <table id="order1" class="table table-bordered table-striped" name="areaTable">
                <thead>
                    <tr>
                        <th width="20px">SL</th>
                        <th width="80px">Client Code</th>
                        <th>Client Name</th>
                        <th>Mobile No</th>
                        <th width="75px">Unit Name</th>
                        <th width="75px">Floor Name</th>
                        <th>Position</th>
                        <th width="20px">Status</th>
                        <th width="80px">Action</th>
                    </tr>
                </thead>
                <tbody id="">
                    @php
                    $i = 1;
                    @endphp
                    @foreach ($positions as $position)
                        <tr class="row_{{ $position->id }}">
                            <td>{{ $i++ }}</td>
                            <td>
                                {{ $position->Code }}
                            </td>
                            <td>
                                {{ $position->Name }}
                            </td>
                            <td>
                                {{ $position->Mobile }}
                            </td>
                            <td>
                                {{ $position->Unit }}
                            </td>
                            <td>
                                {{ $position->Floor }}
                            </td>
                            <td>
                                {{ $position->PositionNo }}
                            </td>
                            <td>
                                @php
                                echo \App\Link::status($position->id,$position->status);
                                @endphp
                            </td>
                            <td>
                                @php
                                echo \App\Link::action($position->id);
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

            var dtb = $('#order1').DataTable({
                pageLength: 20,
                // "order": [
                //     [6, "asc"]
                // ]
            });

            var updateThis;

            //ajax delete code

            $('#order1 tbody').on('click', 'i.fa-trash', function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                position = $(this).parent().data('id');
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
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('positionInformation.delete') }}",
                                data: {
                                    position: position
                                },

                                success: function(response) {
                                    if(response.status){
                                        swal({
                                            title: "<small class='text-success'>Success!</small>",
                                            type: "success",
                                            text: "Deleted Successfully!",
                                            timer: 1000,
                                            html: true,
                                        });
                                        $('.row_' + position).remove();
                                    }else{
                                        error = "Failed.";
                                        swal({
                                            title: "<small class='text-danger'>Error!</small>",
                                            type: "error",
                                            text: error,
                                            timer: 1000,
                                            html: true,
                                        });
                                    }

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
                        } else {
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
        function statusChange(position) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('positionInformation.status') }}",
                data: {
                    position: position
                },
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
