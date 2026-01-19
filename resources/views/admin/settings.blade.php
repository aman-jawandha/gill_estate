@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold">Update Settings</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home" style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container">
        <div class="card p-5">
            <form action="{{ route('store-settings') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <h5>Select Available Durations For Consultancy Appointments</h5>
                    <label>Select "No" if you don't want to support any duration.</label>
                    <div class="col-md-3">
                        <label class="form-label">For 15 minutes</label>
                        <select class="form-control" name="fifteen_minutes" required>
                            <option value="Yes" {{($durations->fifteen_minutes == 'Yes') ? 'selected' : ''}}>Yes</option>
                            <option value="No" {{($durations->fifteen_minutes == 'No') ? 'selected' : ''}}>No</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">For 30 minutes</label>
                        <select class="form-control" name="thiry_minutes" required>
                            <option value="Yes" {{($durations->thiry_minutes == 'Yes') ? 'selected' : ''}}>Yes</option>
                            <option value="No" {{($durations->thiry_minutes == 'No') ? 'selected' : ''}}>No</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">For 45 minutes</label>
                        <select class="form-control" name="fortyfive_minutes" required>
                            <option value="Yes" {{($durations->fortyfive_minutes == 'Yes') ? 'selected' : ''}}>Yes</option>
                            <option value="No" {{($durations->fortyfive_minutes == 'No') ? 'selected' : ''}}>No</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">For 60 minutes</label>
                        <select class="form-control" name="sixty_minutes" required>
                            <option value="Yes" {{($durations->sixty_minutes == 'Yes') ? 'selected' : ''}}>Yes</option>
                            <option value="No" {{($durations->sixty_minutes == 'No') ? 'selected' : ''}}>No</option>
                        </select>
                    </div>
                    <h5 class="mt-3 mb-3">Consultation Fees (CA$)</h5>
                    <label>Set price as 0 to make a duration free. Note - Price does not matter for unselected durations. </label>
                    <div class="col-md-3">
                        <label class="form-label">For 15 minutes</label>
                        <input type="number" step="0.01" name="fifteen_mints" class="form-control" placeholder="For 15 minutes" value="{{$durations->{'15 minutes'} ?? ''}}" min="0" required> 
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">For 30 minutes</label>
                        <input type="number" step="0.01" name="thirty_mints" class="form-control" placeholder="For 30 minutes" value="{{$durations->{'30 minutes'} ?? ''}}" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">For 45 minutes</label>
                        <input type="number" step="0.01" name="forty_five_mints" class="form-control" placeholder="For 45 minutes" value="{{$durations->{'45 minutes'} ?? ''}}" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">For 60 minutes</label>
                        <input type="number" step="0.01" name="sixty_mints" class="form-control" placeholder="For 60 minutes" value="{{$durations->{'60 minutes'} ?? ''}}" min="0" required>
                    </div>
                    <label class="form-label">Available for appointments? Select no if you want to take a break.</label>
                    <div class="col-md-2">
                        <select class="form-control" name="available" required>
                            <option value="Yes" {{($durations->available == 'Yes') ? 'selected' : ''}}>Yes</option>
                            <option value="No" {{($durations->available == 'No') ? 'selected' : ''}}>No</option>
                        </select>
                    </div>
                    <div class="col-md-10"></div>
                    <label class="form-label">Do you want to accept online appointments?</label>
                    <div class="col-md-2">
                        <select class="form-control" name="online_booking" required>
                            <option value="Yes" {{($durations->online_booking == 'Yes') ? 'selected' : ''}}>Yes</option>
                            <option value="No" {{($durations->online_booking == 'No') ? 'selected' : ''}}>No</option>
                        </select>
                    </div>
                    <div class="col-md-10"></div>
                    <label class="form-label">Do you want to accept face to face appointments?</label>
                    <div class="col-md-2">
                        <select class="form-control" name="face_to_face" required>
                            <option value="Yes" {{($durations->face_to_face == 'Yes') ? 'selected' : ''}}>Yes</option>
                            <option value="No" {{($durations->face_to_face == 'No') ? 'selected' : ''}}>No</option>
                        </select>
                    </div>
                    <div class="col-md-10"></div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn gradient-btn">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
