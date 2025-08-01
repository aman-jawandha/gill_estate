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
                        <h6><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i></a> / <a>Find A Property</a></h6>
                    </div>
                </div>
            </div>
            @include('website_layout.common')
            <div class="row">
                <div class="col-md-8">
                    <div class="card p-4">
                        <form action="{{ route('store-property-requirements') }}" id="password_update" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <h6>Let us help you to find the perfect property</h6>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Property Type</label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="" selected disabled>Select Property Type</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->type }}">{{ $type->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Minimum Bed Rooms</label>
                                    <select id="bed_rooms" name="bed_rooms" required class="form-control">
                                        <option value="" selected disabled>Select A Number</option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5+">5+</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Max Budget (CA$)</label>
                                    <input type="number" class="form-control" step="0.01" name="budget" id="budget"
                                        required min="1" max="10000000">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Area (in square feet)</label>
                                    <input type="number" class="form-control" step="0.01" name="area" id="area"
                                        required min="1" max="20000">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Urgent Buy ?</label>
                                    <select id="urgent_buy" name="urgent_buy" required class="form-control">
                                        <option value="" selected disabled>Select An Option</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <textarea name="location" maxlength="500" rows="3" id="location" class="form-control"
                                        placeholder="Enter Preferred Location" style="min-height: 70px" required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <textarea name="description" maxlength="1000" rows="7" id="description" class="form-control"
                                        placeholder="Description" style="min-height: 150px" required></textarea>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    @if($requirements->count() > 0)
                    <h5>Properties Preferences</h5>
                    @foreach ($requirements as $key => $requirement)
                        <div class="card p-4">
                            <div class="text-right">
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-property-requirement', $requirement->id) }}', 'Property Preference')"><i class="fa fa-trash"></i></button>
                            </div>
                            <p style="color: #947054;margin-bottom: 0px"><i class="fa fa-map-marker"></i> {!! nl2br(e($requirement->location)) !!}</p>
                            <p style="margin-bottom: 0px">{{ $requirement->type }} | Max Budget : CA$
                                {{ number_format($requirement->budget) }}</p>
                            <p style="margin-bottom: 0px">Area : {{ $requirement->area }} sq ft | Bed Rooms : {{ $requirement->bed_rooms }} | @if($requirement->urgent_buy == 'Yes')
                                <span class="badge badge-danger">Urgent Buy</span>
                                @endif</p>
                            <div id="accordion" class="mt-2">
                                <div class="card">
                                    <div class="card-header" style="padding:0px" id="heading_{{ $key }}">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link btn-sm collapsed" data-toggle="collapse"
                                                data-target="#collapse_{{ $key }}" aria-expanded="false"
                                                aria-controls="collapse_{{ $key }}">
                                                <p style="margin-bottom: 0px">View Description</p>
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapse_{{ $key }}" class="collapse"
                                        aria-labelledby="heading_{{ $key }}" data-parent="#accordion">
                                        <div class="card-body">
                                            {!! nl2br(e($requirement->description)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                    <div class="text-end mt-4">
                {{ $requirements->links() }}
            </div>
            @else
            <p>No Data Found!</p>
            @endif
                </div>
            </div>
        </div>
    </section>
@endsection
