@extends('layouts.store')
@section('content')

@php 
 $site = DB::table('sitesetting')->first();

@endphp 
<!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Contact US</h2>
                                <!-- <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.html">Home</a>
                                  <span class="brd-separetor">/</span>
                                  <span class="breadcrumb-item active">Contact US</span>
                                </nav> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
		<!-- Start Contact Area -->
        <section class="htc__contact__area ptb--120 bg__white">
            <div class="container">
                <div>
                    <div class="contact-section">
                        <div class="htc__contact__container">
                            <div class="htc__contact__address">
                                <h2 class="contact__title">contact info</h2>
                                <div class="contact__address__inner">
                                    <!-- Start Single Adress -->
                                    <div class="single__contact__address">
                                        <div class="contact__icon">
                                            <span class="ti-location-pin"></span>
                                        </div>
                                        <div class="contact__details">
                                            {{-- <p>Location : <br> {{ $site->company_address }}</p> --}}
                                        </div>
                                    </div>
                                    <!-- End Single Adress -->
                                </div>
                                <div class="contact__address__inner">
                                    <!-- Start Single Adress -->
                                    <div class="single__contact__address">
                                        <div class="contact__icon">
                                            <span class="ti-mobile"></span>
                                        </div>
                                        <div class="contact__details">
                                            {{-- <p> Phone : <br><a href="#">{{ $site->phone_one }} </a></p> --}}
                                        </div>
                                    </div>
                                    <!-- End Single Adress -->
                                    <!-- Start Single Adress -->
                                    <div class="single__contact__address">
                                        <div class="contact__icon">
                                            <span class="ti-email"></span>
                                        </div>
                                        <div class="contact__details">
                                            {{-- <p> Mail :<br><a href="#">{{ $site->email }}</a></p> --}}
                                        </div>
                                    </div>
                                    <!-- End Single Adress -->
                                </div>
                            </div>
                            <div class="contact-form-wrap">
                            <div class="contact-title">
                                <h2 class="contact__title">Get In Touch</h2>
                            </div>
                            <form method="post" action="{{ route('contact.form') }}" id="contact_form">
		 	                @csrf
                                <div class="single-contact-form">
                                    <div class="contact-box name">
                                        <input type="text" id="contact_form_name" class="contact_form_name input_field" placeholder="Name*" required="required" data-error="Name is required." name="name">
                                        <input type="email" id="contact_form_email" class="contact_form_email input_field" placeholder="Enter email*" required="required" data-error="Email is required." name="email">
                                    </div>
                                </div>
                                <div class="single-contact-form">
                                    <div class="contact-box subject">
                                        <input type="text" id="contact_form_phone" class="contact_form_phone input_field" placeholder="Phone number*" name="phone">
                                    </div>
                                </div>
                                <div class="single-contact-form">
                                    <div class="contact-box message">
                                        <textarea id="contact_form_message" class="text_field contact_form_message" name="message" rows="4" placeholder="Message*" required="required" data-error="Please, write us a message."></textarea>
                                    </div>
                                </div>
                                <div class="contact-btn">
                                    <button type="submit" class="fv-btn">SEND</button>
                                </div>
                            </form>
                        </div> 
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Contact Area -->
@endsection