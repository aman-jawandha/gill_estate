@extends('website_layout.app')
@section('content')
    <section class="breadcumb-area bg-img"
        style="background-image: url('{{ asset('assets/img/bg-img/hero1.jpg') }}');height:200px">
    </section>
    <section class="south-contact-area section-padding-25">
        <div class="container-fluid p-4 p-md-5">
            <div class="row">
                <div class="col-12">
                    <div class="contact-heading" style="margin-bottom: 20px">
                        <h6><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i></a> / <a>My Properties</a></h6>
                    </div>
                </div>
            </div>
            @include('website_layout.common')
            @if($properties->count() > 0)
            <div class="row">
                @foreach ($properties as $property)
                    <div class="col-md-6">
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
                    <h6>{{$property->title}}</h6>
                    <p style="color: #947054;margin-bottom:0px"><b><i class="fa fa-map-marker"></i> {{$property->street}}, {{$property->city}}, {{$property->state}}, {{$property->zip_code}}</b></p>
                    <p style="margin-bottom:0px">Bedrooms - {{$property->bed_rooms}} | Bathrooms - {{$property->bath_rooms}}</p>
                    <p style="margin-bottom:0px">Area - {{$property->area}} sq ft</p>
                    <p style="margin-bottom:0px">Property Type - {{$property->type}}</p>
                    <p style="margin-bottom:0px">Published At - {{ ($property->published_at) ? date('d-m-Y | h:i a', strtotime($property->published_at)) : 'N\A' }}</p>
                    <div class="btn-group mt-3">
                        <a href="{{route('view-my-property',$property->id)}}" class="btn btn-success m-1"><i class="fa fa-eye"></i></a>
                        @if($property->status == 'Pending' || $property->status == 'Rejected') 
                        <a href="{{route('edit-my-property',$property->id)}}" class="btn btn-success m-1"><i class="fa fa-edit"></i></a>
                        @endif
                        <button class="btn btn-danger m-1" onclick="confirmDelete('{{ route('delete-my-property', $property->id) }}', 'Property')"><i class="fa fa-trash"></i></button>
                        @if($property->status == 'Rejected')
                        <button class="btn btn-dark btn-sm m-1"  data-reason="{{ $property->reason }}" onclick="view_reason(this)">Rejected Reason</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
                @endforeach
            </div>
            <div class="text-end">
                {{ $properties->links() }}
            </div>
            @else
            <p>No Data Found!</p>
            @endif
        </div>
    </section>
       <div class="modal fade" id="view_reason_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rejected Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#view_reason_modal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div id="rejected_reason"></div>
                    </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
function view_reason(button) {
    var reason = $(button).data('reason');
    reason = reason.replace(/\n/g, '<br>');
    $('#rejected_reason').html(reason);
    $('#view_reason_modal').modal('show');
}

</script>
@endsection
