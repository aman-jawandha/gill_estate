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
                        <h6><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i></a> / <a>My Appointments</a></h6>
                    </div>
                </div>
            </div>
            @include('website_layout.common')
            @if ($appointments->count() > 0)
                <div class="row g-4">
                    @foreach ($appointments as $key => $appointment)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-2">Appointment #{{ $appointment->id }}</h5>
                                    <p class="mb-1"><strong>Date & Time:</strong>
                                        @if ($appointment->booking_date)
                                            {{ changeDateFormat($appointment->booking_date) }} |
                                            {{ convertToUserTime($appointment->booking_time, auth()->user()->timezone) }} |
                                            {{ date('l', strToTime($appointment->booking_date)) }}
                                        @endif
                                    </p>
                                    <p class="mb-1"><strong>Duration:</strong> {{ $appointment->duration }}</p>
                                    <p class="mb-1"><strong>Type: </strong>{{ $appointment->type }}</p>
                                    @if ($appointment->booking_date < date('Y-m-d'))
                                        <p class="mb-1"><strong>Status:</strong> Expired</p>
                                    @else
                                        <p class="mb-1"><strong>Status:</strong> {{ $appointment->status }}</p>
                                    @endif
                                    <!-- Actions -->
                                        @if ($appointment->booking_date >= date('Y-m-d') && $appointment->type == 'Online' && ($appointment->status == 'Active' || $appointment->status == 'Rescheduled'))
                                            <a href="{{ $appointment->meeting_link }}" target="_blank"
                                                class="btn btn-primary btn-sm w-100">Join Meeting</a>
                                        @endif
                                    <div class="mt-2">
                                        <button class="btn btn-outline-secondary btn-sm w-100" type="button"
                                            data-toggle="collapse" data-target="#message_{{ $key }}"
                                            aria-expanded="false">
                                            Your Message
                                        </button>

                                        <div class="collapse mt-2" id="message_{{ $key }}">
                                            <div class="card card-body p-2">
                                                @if ($appointment->message)
                                                    <small>{!! nl2br(e($appointment->message)) !!}</small>
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if($appointment->payment_amount > 0)
                                    <div class="mt-2">
                                        <button class="btn btn-outline-secondary btn-sm w-100" type="button"
                                            data-toggle="collapse" data-target="#payment_{{ $key }}"
                                            aria-expanded="false">
                                            Payment Detail
                                        </button>
                                        <div class="collapse mt-2" id="payment_{{ $key }}">
                                            <div class="card card-body p-2">
                                                <p class="mb-0">Payment Status : {{$appointment->payment_status}}</p>
                                                <p class="mb-0">Payment Time : {{ convertToUserDateTime($appointment->payment_time, auth()->user()->timezone) }}</p>
                                                <p class="mb-0">Payment Amount : CA$ {{$appointment->payment_amount}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-end mt-3">
                    {{ $appointments->links() }}
                </div>
            @else
                <p>No Data Found!</p>
            @endif
        </div>
    </section>
@endsection
