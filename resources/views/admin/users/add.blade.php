@extends('admin.layouts.masterAddEdit')

@section('card_body')
    <div class="card-body">
        <div class="row">
            <div class="col-md-4"> 
                <div class="form-group {{ $errors->has('parent') ? ' has-danger' : '' }}">
                    <label for="role">User Role</label>
                    <select class="form-control" name="role" required>
                        <option value=""> Select Role</option>
                        @foreach($userRoles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('parent'))
                        @foreach($errors->get('parent') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>                                       
            </div>

            <div class="col-md-4">                 
                <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label for="name">Name</label>
                    <input type="text" class="form-control form-control-danger" name="name" value="{{ old('name') }}" required>
                    @if ($errors->has('name'))
                        @foreach($errors->get('name') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>                                       
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('username') ? ' has-danger' : '' }}">
                    <label for="user-name">User Name</label>
                    <input type="text" class="form-control form-control-danger" name="username" value="{{ old('username') }}" required>
                    @if ($errors->has('username'))
                        @foreach($errors->get('username') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"> 
                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                    <label for="email">Email</label>
                    <input type="email" class="form-control form-control-danger" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        @foreach($errors->get('email') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>                                       
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label for="password">Password</label>
                    <input type="password" class="form-control form-control-danger" name="password" value="" required>
                    @if ($errors->has('password'))
                        @foreach($errors->get('password') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>                                        
            </div>
            
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('userImage') ? ' has-danger' : '' }}">
                    <label for="user-image">User Image</label>
                    <input type="file" class="form-control-file border" name="userImage">
                    @if ($errors->has('userImage'))
                        @foreach($errors->get('userImage') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>            
    </div>
@endsection


