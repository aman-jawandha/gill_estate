@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-2">
        <div style="width:95%">
            <h3 class="fw-bold">Properties</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"
                                style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Properties</li>
                </ol>
            </nav>
        </div>
        @can('create-property')
            <a href="{{ route('create-property') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
        @endcan
    </div>
    <div class="row">
                <div class="col-12 card">
                        <form action="{{route('search-properties-list')}}" method="get">
                            <div class="row p-4">
                                <div class="col-md-3">
                                    <select class="form-control" name="state" id="state">
                                        <option value="" selected>Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->name }}" data-code="{{ $state->code }}" {{ request('state') == $state->name ? 'selected' : '' }}>
                                                {{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="city" name="city" class="form-control">
                                        @if(request('city'))
                                        <option value="">Select City</option>
                                        <option value="{{request('city')}}" selected>{{request('city')}}</option>
                                        @else
                                        <option value="" selected>Select City</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="type" id="type">
                                        <option value="" selected>Property Type</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->type }}" {{ request('type') == $type->type ? 'selected' : '' }}>{{ $type->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="max_price" id="max_price">
                                        <option value="" selected>Price Range Below</option>
                                        <option value="200000" {{ request('max_price') == '200000' ? 'selected' : '' }}>$200,000</option>
                                        <option value="500000" {{ request('max_price') == '500000' ? 'selected' : '' }}>$500,000</option>
                                        <option value="1000000" {{ request('max_price') == '1000000' ? 'selected' : '' }}>$1,000,000</option>
                                        <option value="2000000" {{ request('max_price') == '2000000' ? 'selected' : '' }}>$2,000,000</option>
                                        <option value="5000000" {{ request('max_price') == '5000000' ? 'selected' : '' }}>$5,000,000</option>
                                        <option value="5000000+" {{ request('max_price') == '5000000+' ? 'selected' : '' }}>$5,000,000 +</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mt-3">
                                    <select class="form-control" name="order_by" id="order_by">
                                        <option value="" selected>Order By</option>
                                        <option value="high_to_low" {{ request('order_by') == 'high_to_low' ? 'selected' : '' }}>High To Low</option>
                                        <option value="low_to_high" {{ request('order_by') == 'low_to_high' ? 'selected' : '' }}>Low To High</option>
                                        <option value="latest" {{ request('order_by') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    </select>
                                </div>
                                <div class="col-md-10 text-end mt-3">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Search</button>
                                    <a href="{{route('properties-list')}}" class="btn btn-primary btn-sm"><i class="fa fa-ban"></i> Reset</a>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
    <div class="row">
        @if($properties->count() > 0)
        @foreach ($properties as $property)
            <div class="col-md-4">
            <div class="card position-relative">
                @if($property->urgent_sell == 'Yes')
                    <span class="badge badge-danger position-absolute top-0 start-0 m-2" style="z-index: 10;">
                        <i class="fa fa-bolt me-1"></i> Urgent Sale
                    </span>
                @endif
                <div class="banner_img">
                    <img src="{{asset('uploads/properties/banner_images/'.$property->banner_image)}}" alt="Image" width="100%">
                </div>
                <div class="property_content m-3">
                    <div class="row">
                        <div class="col-6">
                            @if($property->status == 'Pending')
                            <span class="badge badge-warning">{{$property->status}}</span>
                            @elseif($property->status == 'Inactive' || $property->status == 'Rejected')
                            <span class="badge badge-danger">{{$property->status}}</span>
                            @elseif($property->status == 'For Sale' || $property->status == 'For Rent')
                            <span class="badge badge-success">{{$property->status}}</span>
                            @elseif($property->status == 'Sold' || $property->status == 'Rented')
                            <span class="badge badge-primary">{{$property->status}}</span>
                            @endif
                        </div>
                        <div class="col-6">
                            <h6 style="text-align:end"><b>CA$ {{number_format($property->price)}}</b></h6>
                        </div>
                    </div>
                    <h5>{{$property->title}}</h5>
                    <h6 style="color: #947054"><b><i class="fa fa-map-marker"></i> {{$property->street}}, {{$property->city}}, {{$property->state}}, {{$property->zip_code}}</b></h6>
                    <h6>Bedrooms - {{$property->bed_rooms}} | Bathrooms - {{$property->bath_rooms}}</h6>
                    <h6>Area - {{$property->area}} sq ft</h6>
                    <h6>Property Type - {{$property->type}}</h6>
                    <h6>Published At - {{ ($property->published_at) ? date('d-m-Y | h:i a', strtotime($property->published_at)) : 'N\A' }}</h6>
                    <div class="btn-group mt-3">
                        @can('view-property')
                        <a href="{{route('view-property',$property->id)}}" class="btn btn-success btn-sm m-1"><i class="fa fa-eye"></i></a>
                        @endcan
                        @can('edit-property')
                        <a href="{{route('edit-property',$property->id)}}" class="btn btn-success btn-sm m-1"><i class="fa fa-edit"></i></a>
                        @endcan
                        @can('delete-property')
                        <button class="btn btn-danger btn-sm m-1" onclick="confirmDelete('{{ route('delete-property', $property->id) }}', 'Property')"><i class="fa fa-trash"></i></button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <p class="text-center">No Data Found!</p>
        @endif
        <div class="text-center margin-top-20">
            {{$properties->links()}}
        </div>
    </div>
@endsection
@section('js')
@endsection
