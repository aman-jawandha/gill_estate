@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Edit Role</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home" style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Roles</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('roles') }}" class="btn btn-primary btn-sm">Back</a>
    </div>

    <div class="card p-4">
        <form method="POST" action="{{ route('update-role', $role->id) }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="role_id" value="{{$role->id}}">
                    <label class="form-label">Role Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $role->name }}" maxlength="50" placeholder="Enter name for the role">
                </div>

                <label class="form-label mt-3">Permissions</label>
                @foreach ($permissions as $permission)
                    <div class="col-md-3">
                        <label>
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach

                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm mt-3" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')

@endsection
