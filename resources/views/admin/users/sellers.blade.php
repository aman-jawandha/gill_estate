@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Sellers</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home" style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sellers</li>
                </ol>
            </nav>
        </div>
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
                            @can('delete-seller')
                            @if($user->status == 'Active')
                            <button class="btn btn-success btn-sm" onclick="updateStatus('{{ route('delete-seller', $user->id) }}', 'Seller')">{{$user->status}} <i class="fa fa-edit"></i></button>
                            @else
                            <button class="btn btn-danger btn-sm" onclick="updateStatus('{{ route('delete-seller', $user->id) }}', 'Seller')">{{$user->status}} <i class="fa fa-edit"></i></button>
                            @endif
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
