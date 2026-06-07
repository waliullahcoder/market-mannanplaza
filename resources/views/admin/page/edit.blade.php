@extends('admin.layouts.masterAddEdit')

@section('card_body')
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <input class="form-control" type="hidden" name="pageId" value="{{ $page->id }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="parent">Parent</label>
                <div class="form-group {{ $errors->has('parent') ? ' has-danger' : '' }}">
                    <select class="form-control chosen-select" id="parentMenuId" name="parentMenu">
                        <option value=" ">Select Parent</option>
                        @foreach ($frontendMenus as $frontendMenu)
                            @php
                                if ($frontendMenu->id == $page->frontend_menu_id)
                                {
                                    $select = "selected";
                                }
                                else
                                {
                                    $select = "";
                                }
                                
                            @endphp
                            <option value="{{$frontendMenu->id}}" {{ $select }}>{{$frontendMenu->menu_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="menu-name">Page Name</label>
                <div class="form-group {{ $errors->has('pageName') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Page name" name="pageName" value="{{ $page->page_name }}" required>
                    @if ($errors->has('pageName'))
                        @foreach($errors->get('pageName') as $error)
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
    </script>
@endsection