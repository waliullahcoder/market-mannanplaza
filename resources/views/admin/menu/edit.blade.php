@extends('admin.layouts.masterAddEdit')

@section('card_body')
    @php
        use App\Menu;
        $menuOrderBy = Menu::whereNull('parent_menu')->max('order_by');

        if (@$menuOrderBy)
        {
            $orderBy = $menuOrderBy+1;
        }
        else
        {
            $orderBy = 1;
        }
    @endphp

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <input class="form-control" type="hidden" name="menuId" value="{{ $menuInfo->id }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="parent">Parent</label>
                <div class="form-group {{ $errors->has('parent') ? ' has-danger' : '' }}">
                    <select class="form-control chosen-select" id="parentMenuId" name="parentMenu">
                        <option value=" ">Select Parent</option>
                        @foreach ($menus as $menu)
                            @php
                                if ($menu->id == $menuInfo->parent_menu)
                                {
                                    $select = "Selected";
                                }
                                else
                                {
                                    $select = "";
                                }
                                
                            @endphp
                            <option value="{{ $menu->id }}" {{ $select }}>{{ $menu->menu_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="menu-name">Menu Name</label>
                <div class="form-group {{ $errors->has('menuName') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Menu name" name="menuName" value="{{ $menuInfo->menu_name }}" required>
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
                    <input type="text" class="form-control" placeholder="Menu link" name="menuLink" value="{{ $menuInfo->menu_link }}" required>
                    @if ($errors->has('menuLink'))
                        @foreach($errors->get('menuLink') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-3">
                <label for="menu-icon">Menu Icon</label>
                <div class="form-group {{ $errors->has('menuIcon') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="fa fa-icon" name="menuIcon" value="{{ $menuInfo->menu_icon }}">
                    @if ($errors->has('menuIcon'))
                        @foreach($errors->get('menuIcon') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-3">
                <label for="order-by">Order By</label>
                <div class="form-group {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                    <input type="number" class="form-control" placeholder="Order By" id="orderBy" name="orderBy" value="{{ $menuInfo->order_by }}" required>
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
                url: "{{ route('menu.maxOrderBy') }}",
                data:{parentMenuId:parentMenuId},
                success: function(response) {
                    var orderBy = response.orderBy;

                    $('#orderBy').val(orderBy);
                },
            });
        });
    </script>
@endsection