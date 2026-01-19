@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Appointments</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home" style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Appointments
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="data_table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Action</th>
                    <th>Status</th>
                    <th>Booking Time</th>
                    <th>Duration</th>
                    <th>Booked By</th>
                    <th>Type</th>
                    <th>Message</th>
                    @can('booking-payment-detail')
                    <th>Payments</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $key => $booking)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @if($booking->booking_date >= date('Y-m-d') && $booking->type == 'Online' && ($booking->status == 'Active' || $booking->status == 'Rescheduled'))
                            <a href="{{$booking->meeting_link}}" target="_blank" class="btn btn-success btn-sm">Join Meeting</a>
                            @endif
                            @can('reschedule-appointment')
                            @if ($booking->booking_date >= date('Y-m-d'))
                            <a href="{{route('reschedule-appointment',$booking->id)}}" class="btn btn-primary btn-sm">Reschedule Appointment</a>
                            @endif
                            @endcan
                        </td>
                        <td>
                            @if ($booking->booking_date < date('Y-m-d'))
                            Expired
                            @else
                            {{$booking->status}}
                            @endif
                        </td>
                        <td>
                          {{ changeDateFormat($booking->booking_date) }} | {{ convertToUserTime($booking->booking_time, auth()->user()->timezone) }} |
                            {{ date('l', strToTime($booking->booking_date)) }}
                          </td>
                        <td>{{ $booking->duration }}</td>
                        <td>
                            <small>Name : {{$booking->user->name}}</small><br>
                            <small>Email : {{$booking->user->email}}</small><br>
                            <small>Phone : {{$booking->user->phone}}</small>
                        </td>
                        <td>
                            {{ $booking->type }}
                        </td>
                        <td>
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed p-2" style="min-width:280px"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse_{{ $key }}" aria-expanded="false"
                                            aria-controls="collapse_{{ $key }}">
                                            View Message
                                        </button>
                                    </h2>
                                    <div id="collapse_{{ $key }}" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            {!! nl2br(e($booking->message)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        @can('booking-payment-detail')
                        <td>
                            @if($booking->payment_amount > 0)
                            <div class="accordion" id="payment_accordian">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed p-2" style="min-width:340px"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#payment_{{ $key }}" aria-expanded="false"
                                            aria-controls="payment_{{ $key }}">
                                            Payment Detail
                                        </button>
                                    </h2>
                                    <div id="payment_{{ $key }}" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#payment_accordian">
                                        <div class="accordion-body">
                                            <small class="mb-0">Stripe Payment Id : {{$booking->payment_id}}</small><br>
                                            <small class="mb-0">Payment Status : {{$booking->payment_status}}</small><br>
                                            <small class="mb-0">Payment Time : {{ convertToUserDateTime($booking->payment_time, auth()->user()->timezone) }}</small><br>
                                            <small class="mb-0">Payment Amount : CA$ {{$booking->payment_amount}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <p class="text-center">N\A</p>
                            @endif
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    
@endsection
