@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Reschedule Appointment</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home" style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Reschedule Appointment
                    </li>
                </ol>
            </nav>
        </div>
        <a href="{{route('my-bookings')}}" class="btn btn-primary btn-sm">Back</a>
    </div>
    <div class="container">
                <div class="card p-4">
                        <form action="{{route('store-reschedule-appointment')}}" id="appointment_form" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" name="booking_id" value="{{$booking->id}}">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Your Name" required maxlength="50" value="{{$booking->user->name}}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Your Email" required maxlength="50" value="{{$booking->user->email}}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone"
                                        placeholder="Your Phone" required value="{{$booking->user->phone}}" minlength="10" maxlength="10" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Appointment Type</label>
                                    <select class="form-control" name="type" id="type" required disabled>
                                        <option value="" selected disabled>Select Type</option>
                                        <option value="Face To Face" {{($booking->type == 'Face To Face') ? 'selected' : ''}}>Face To Face</option>
                                        <option value="Online" {{($booking->type == 'Online') ? 'selected' : ''}}>Online</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Duration</label>
                                    <select class="form-control" name="duration" id="duration" required disabled>
                                        <option value="" selected disabled>Select Duration</option>
                                        <option value="15 minutes" {{($booking->duration == '15 minutes') ? 'selected' : ''}}>15 minutes - CAD {{ number_format($durations->{'15 minutes'}, 2) }}</option>
                                        <option value="30 minutes" {{($booking->duration == '30 minutes') ? 'selected' : ''}}>30 minutes - CAD {{ number_format($durations->{'30 minutes'}, 2) }}</option>
                                        <option value="45 minutes" {{($booking->duration == '45 minutes') ? 'selected' : ''}}>45 minutes - CAD {{ number_format($durations->{'45 minutes'}, 2) }}</option>
                                        <option value="60 minutes" {{($booking->duration == '60 minutes') ? 'selected' : ''}}>60 minutes - CAD {{ number_format($durations->{'60 minutes'}, 2) }}</option>
                                    </select>   
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Booking Date</label>
                                    <input type="date" name="booking_date" class="form-control"
                                        id="booking_date" required value="{{date('Y-m-d',strToTime($booking->booking_date))}}" min="{{date('Y-m-d')}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Booking Time</label>
                                    <select class="form-control" name="booking_time" id="booking_time" required>
                                        <option value="" disabled>Select Time</option>
                                        <option value="{{convertToUserTime($booking->booking_time, auth()->user()->timezone)}}">{{convertToUserTime($booking->booking_time, auth()->user()->timezone)}}</option>
                                    </select>
                                </div>
                            <div class="col-md-12">
                                <span class="text-danger" id="error_msg"></span>
                                <span class="text-success" id="success_msg"></span>
                            </div>
                            </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-sm">Reschedule Now</button>
                                </div>
                        </form>
                </div>
            </div>
@endsection
@section('js')
<script>
$(document).on("change","#booking_date",function() {
        var booking_date = $(this).val();
        $.ajax({
            url: "{{route('get-time-slots')}}",
            type: 'GET',
            data: { 
                booking_date : booking_date,
             },
            success: function (data) {
                $('#success_msg').text('');
                $('#error_msg').text('');
                if(data.status == 'error'){
                    $('#error_msg').text(data.msg);
                }
                var $timeDropdown = $('#booking_time');
                $timeDropdown.empty();
                $timeDropdown.append('<option value="" selected disabled>Select time</option>');
                $.each(data.slots, function (index, time) {
                    $timeDropdown.append('<option value="' + time + '">' + time + '</option>');
                });
            }
        });
    });
</script>
@endsection
