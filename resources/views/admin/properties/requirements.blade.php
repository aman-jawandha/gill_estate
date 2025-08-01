@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Buyer Requirements</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"
                                style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Buyer Requirements</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        @if ($requirements->count() > 0)
            @foreach ($requirements as $key => $requirement)
                <div class="col-md-4">
                    <div class="card p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            @if ($requirement->urgent_buy == 'Yes')
                                <h6><span class="badge badge-danger">Urgent Buy</span></h6>
                                @else
                                <h6></h6>
                            @endif
                            @can('delete-requirement')
                            <div class="text-end">
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-requirement', $requirement->id) }}', 'Requirement')"><i class="fa fa-trash"></i></button>
                            </div>
                            @endcan
                        </div>
                        <hr>
                        @php
                            $user = App\Models\User::where('id',$requirement->user_id)->first();
                        @endphp
                        <small>Name : {{$user->name}}</small>
                        <small>Email : {{$user->email}}</small>
                        <small>Phone :   {{$user->phone}}</small>
                        <hr>
                        <small style="color: #947054;margin-bottom: 0px"><i class="fa fa-map-marker"></i>
                            {!! nl2br(e($requirement->location)) !!}
                        </small>
                        <small style="margin-bottom: 0px">{{ $requirement->type }} | Max Budget : CA$
                            {{ number_format($requirement->budget) }}</small>
                        <small style="margin-bottom: 0px">Area : {{ $requirement->area }} sq ft | Bed Rooms :
                            {{ $requirement->bed_rooms }}
                        </small>
                        <small style="margin-bottom: 0px">Published At - {{ ($requirement->created_at) ? date('d-m-Y | h:i a', strtotime($requirement->created_at)) : 'N\A' }}</small>
                        <div class="accordion mt-3" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse_{{ $key }}" aria-expanded="false"
                                        aria-controls="collapse_{{ $key }}">
                                        Description
                                    </button>
                                </h2>
                                <div id="collapse_{{ $key }}" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {!! nl2br(e($requirement->description)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="text-center margin-top-20">
                {{ $requirements->links() }}
            </div>
        @else
            <p class="text-center">No Data Found!</p>
        @endif
    </div>
@endsection
@section('js')
@endsection
