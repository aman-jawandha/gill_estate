@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">{{$type}}s</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home" style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$type}}</li>
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
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feedbacks as $key => $feedback)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $feedback->name }}</td>
                        <td>{{ $feedback->email }}</td>
                        <td>{{ $feedback->phone }}</td>
                        <td>
                            <div class="accordion" style="min-width: 300px" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse_{{$key}}" aria-expanded="false"
                                            aria-controls="collapse_{{$key}}">
                                            View Message
                                        </button>
                                    </h2>
                                    <div id="collapse_{{$key}}" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            {!! nl2br(e($feedback->message)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($type = 'Querie')
                            @can('delete-query')
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-feedback', $feedback->id) }}', '{{$type}}')"><i class="fa fa-trash"></i></button>
                            @endcan
                            @elseif($type = 'Contact Us Message')
                            @can('delete-contact-msg')
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-feedback', $feedback->id) }}', '{{$type}}')"><i class="fa fa-trash"></i></button>
                            @endcan
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    
@endsection
