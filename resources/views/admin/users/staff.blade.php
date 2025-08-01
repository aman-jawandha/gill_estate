@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Staff</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home" style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Staff</li>
                </ol>
            </nav>
        </div>
        @can('create-staff')
        <a href="{{route('create-staff')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
        @endcan
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="data_table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @if($user->status == "Active")
                            <button class="btn btn-success btn-sm">{{$user->status}}</button>
                            @else
                            <button class="btn btn-danger btn-sm">{{$user->status}}</button>
                            @endif
                            @can('edit-staff')
                            <a href="{{route('edit-staff',$user->id)}}" class="btn btn-success btn-sm m-1"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('delete-staff')
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-staff', $user->id) }}', 'Staff Member')"><i class="fa fa-trash"></i></button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    
@endsection
