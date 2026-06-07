@extends('admin.layouts.masterAddEdit')

@section('card_body')
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <label for="parent">Parent</label>
                <div class="form-group {{ $errors->has('parent') ? ' has-danger' : '' }}">
                    <select class="form-control chosen-select" id="parentMenuId" name="parentMenu">
                        <option value=" ">Select Parent</option>
                        @foreach ($menus as $menu)
                            <option value="{{$menu->id}}">{{$menu->menu_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="menu-name">Menu Name</label>
                <div class="form-group {{ $errors->has('menuName') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Menu name" name="menuName" value="{{ old('menuName') }}" required>
                    @if ($errors->has('menuName'))
                        @foreach($errors->get('menuName') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="menu-link">Menu Link</label>
                <div class="form-group {{ $errors->has('menuLink') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Menu link" name="menuLink" value="{{ old('menuLink') }}" required>
                    @if ($errors->has('menuLink'))
                        @foreach($errors->get('menuLink') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <label for="order-by">Order By</label>
                <div class="form-group {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                    <input type="number" class="form-control" placeholder="Order By" id="orderBy" name="orderBy" value="{{ $orderBy }}" required>
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

@section('custom-js')
    <script type="text/javascript">
        $(document).on('change','#parentMenuId',function(){
            var parentMenuId = $('#parentMenuId').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('frontEndMenu.maxOrderBy') }}",
                data:{parentMenuId:parentMenuId},
                success: function(response) {
                    var orderBy = response.orderBy;

                    $('#orderBy').val(orderBy);
                },
            });
        });
    </script>
@endsection