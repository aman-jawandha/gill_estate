@extends('website_layout.app')
@section('content')
    <section class="breadcumb-area bg-img"
        style="background-image: url('{{ asset('assets/img/bg-img/hero1.jpg') }}');height:200px">
    </section>
    <section class="south-contact-area section-padding-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contact-heading">
                        <h6>Contact Us</h6>
                    </div>
                </div>
            </div>
            @include('website_layout.common')
            <div class="row">
                <div class="col-md-4">
                    <h3>Get In Touch</h3>
                    <div class="content-sidebar">
                        <!-- Address -->
                        <div class="address mt-30">
                            <h6><img src="{{ asset('assets/img/icons/phone-call.png') }}" alt=""> +1 (613) 663-9410</h6>
                            <h6><img src="{{ asset('assets/img/icons/envelope.png') }}" alt=""> office@template.com
                            </h6>
                            <h6><img src="{{ asset('assets/img/icons/location.png') }}" alt=""> Main Str. no 45-46,
                                b3, 56832,<br>Los Angeles, CA</h6>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Area -->
                <div class="col-md-8">
                    <p>Questions, ideas, or just curious? We're just a message away — reach out anytime.</p>
                    <form action="{{ route('store-contact-us') }}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="contact_us">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" maxlength="50"
                                placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" maxlength="50"
                                placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" id="phone" maxlength="10"
                                placeholder="Your Phone" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" style="height:200px" name="message" maxlength="1000" id="message" rows="10"
                                placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn south-btn">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @if($durations->available == 'Yes')
    <section class="south-contact-area section-padding-50 bg-light">
            <div class="container">
                <div class="contact-heading text-center">
                <h6>Make An Appointment</h6>
            </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3"><b>Availability</b></h5>
                                @foreach ($availabilities as $availability)
                                    <p><b>{{$availability->day}} : </b>{{($availability->punch_in && $availability->punch_out) ? convertToUserTime($availability->punch_in).' - '.convertToUserTime($availability->punch_out) : 'Not Available'}}</p>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3"><b>Leaves</b></h5>
                                @if($days_breaks->count() > 0)
                                @foreach ($days_breaks as $break)
                                    <p><b>{{changeDateFormat($break->from_date).' - '.changeDateFormat($break->to_date)}}</b></p>
                                @endforeach
                                @else
                                <p>No Data Found</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{route('store-appointment')}}" id="appointment_form" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Your Name" required maxlength="50" value="{{old('name')}}">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Your Email" required maxlength="50" value="{{old('email')}}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" id="phone"
                                        placeholder="Your Phone" required value="{{old('phone')}}" minlength="10" maxlength="10">
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="" selected disabled>Select Type</option>
                                        @if($durations->face_to_face == 'Yes')
                                        <option value="Face To Face" {{(old('type') == 'Face To Face') ? 'selected' : ''}}>Face To Face</option>
                                        @endif
                                        @if($durations->online_booking == 'Yes')
                                        <option value="Online" {{(old('type') == 'Online') ? 'selected' : ''}}>Online</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="duration" id="duration" required>
                                        <option value="" selected disabled>Select Duration</option>
                                        @if($durations->fifteen_minutes == 'Yes')
                                        <option value="15 minutes" {{(old('duration') == '15 minutes') ? 'selected' : ''}}>15 minutes - CAD {{ number_format($durations->{'15 minutes'}, 2) }}</option>
                                        @endif
                                        @if($durations->thiry_minutes == 'Yes')
                                        <option value="30 minutes" {{(old('duration') == '30 minutes') ? 'selected' : ''}}>30 minutes - CAD {{ number_format($durations->{'30 minutes'}, 2) }}</option>
                                        @endif
                                        @if($durations->fortyfive_minutes == 'Yes')
                                        <option value="45 minutes" {{(old('duration') == '45 minutes') ? 'selected' : ''}}>45 minutes - CAD {{ number_format($durations->{'45 minutes'}, 2) }}</option>
                                        @endif
                                        @if($durations->sixty_minutes == 'Yes')
                                        <option value="60 minutes" {{(old('duration') == '60 minutes') ? 'selected' : ''}}>60 minutes - CAD {{ number_format($durations->{'60 minutes'}, 2) }}</option>
                                        @endif
                                    </select>   
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="booking_date" class="form-control" min="{{date('Y-m-d')}}"
                                        id="booking_date" required value="{{old('booking_date')}}">
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="booking_time" id="booking_time" required>
                                        <option value="" selected disabled>Select Time</option>
                                        @if(old('booking_time'))
                                        <option value="{{old('booking_time')}}" selected>{{old('booking_time')}}</option>
                                        @endif
                                    </select>
                                </div>
                            <div class="col-md-12">
                                <span class="text-danger" id="error_msg"></span>
                                <textarea class="form-control" name="message" style="height:200px" placeholder="Write Something" required maxlength="1000">{{old('message')}}</textarea>
                                <span class="text-success" id="success_msg"></span>
                            </div>
                            </div>
                                <div class="text-center mt-2">
                                    <button type="submit" class="btn south-btn">Book Now</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </section><br>
        @endif
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="bg-light mt-4 mb-4 p-3">
                    <h4>Our Location</h4>
                    <hr>
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0159970952063!2d-122.39665348467992!3d37.78910597975757!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858064dcbf404d%3A0x7b07a99d8f9edc42!2s1234%20Elm%20St%2C%20San%20Francisco%2C%20CA%2094105%2C%20USA!5e0!3m2!1sen!2sus!4v1623888123456"
                        width="100%" height="500" style="border:0;" 
                        allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
            {{-- <div class="col-md-4">
                <div class="bg-light mt-4 mb-4 p-3">
                    <iframe src="https://calendly.com/amandeep00988/30min" width="100%" height="550"
                        frameborder="0"></iframe>
                </div>
            </div> --}}
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

$("#appointment_form").validate({
    errorElement: "span",
    errorPlacement: function (error, element) {
        error.addClass("text-danger");
        error.insertAfter(element);
    },
    rules: {
        phone: {
            digits: true,
        },
    },
    messages: {
        phone: {
            digits: "Phone should be a numeric value"
        },
    },
    submitHandler: function (form) {
        validateFileInput();
        if (isFileValid) {
            form.submit();
        }
    }
});
</script>
@endsection
