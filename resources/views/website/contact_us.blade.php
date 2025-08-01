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
    <div class="container">
        <div class="row">
            <div class="col-md-8">
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
            <div class="col-md-4">
                <div class="bg-light mt-4 mb-4 p-3">
                    <iframe src="https://calendly.com/amandeep00988/30min" width="100%" height="550"
                        frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
