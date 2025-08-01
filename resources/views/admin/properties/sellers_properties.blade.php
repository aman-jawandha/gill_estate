@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Sellers Properties</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"
                                style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sellers Properties</li>
                </ol>
            </nav>
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
                        <a href="{{route('view-seller-property',$property->id)}}" class="btn btn-success btn-sm m-1"><i class="fa fa-eye"></i></a>
                        @endcan
                        @can('edit-property')
                        <a href="{{route('edit-seller-property',$property->id)}}" class="btn btn-success btn-sm m-1"><i class="fa fa-edit"></i></a>
                        @endcan
                        @can('delete-property')
                        <button class="btn btn-danger btn-sm m-1" onclick="confirmDelete('{{ route('delete-property', $property->id) }}', 'Property')"><i class="fa fa-trash"></i></button>
                        @endcan
                        @if($property->status == 'Rejected')
                        <button class="btn btn-dark btn-sm m-1"  data-reason="{{ $property->reason }}" onclick="view_reason(this)">Rejected Reason</button>
                        @else
                        @can('reject-property')
                        <button class="btn btn-danger btn-sm m-1"  onclick="reject_property('{{ $property->id }}')">Reject Property</button>
                        @endcan
                        @endif
                        
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
    <div class="modal fade" id="change_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reject Property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#change_status_modal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('reject-property') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="seller_property_id" id="seller_property_id">
                        <label class="form-label">Reason</label>
                        <textarea rows="5" class="form-control" placeholder="Write Something" name="reason" required id="reason" maxlength="1000"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
    function reject_property(property_id){
        $('#seller_property_id').val(property_id);
        $('#reason').val('');
        $('#change_status_modal').modal('show');
    }

function view_reason(button) {
    var reason = $(button).data('reason');
    reason = reason.replace(/\n/g, '<br>');
    $('#rejected_reason').html(reason);
    $('#view_reason_modal').modal('show');
}

</script>
@endsection
