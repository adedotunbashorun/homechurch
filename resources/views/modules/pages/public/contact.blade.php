@extends('pages::public.master')
@section('page')
    @include('pages::public._page-banner-section')
    <section id="contact" class="contact section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <p>@include('pages::public._page-content-body')</p>
                    </div>
                </div>
            </div>
            <div class="contact-head">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="contact-map">
                            <!-- Map -->
                            <div id="map"></div>
                            <!--/ End Map -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        @include('core::public._partials.notify')
                        <div class="form-head">
                            <!-- Form -->
                            <form class="form" action="#" method="POST">
                                <div class="form-group">
                                    <input name="name" type="text" placeholder="Enter Name">
                                </div>
                                <div class="form-group">
                                    <input name="email" type="email" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <input name="subject" type="text" placeholder="Subject">
                                </div>
                                <div class="form-group">
                                    <input name="phone" type="text" placeholder="{!! config('myapp.phone')!!}">
                                </div>
                                <div class="form-group">
                                    <textarea name="message" placeholder="Comment"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="button">
                                        <button type="submit" class="btn primary">Post Comment</button>
                                    </div>
                                </div>
                            </form>
                            <!--/ End Form -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-bottom">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-12">
                        <!-- Contact-Info -->
                        <div class="contact-info">
                            <div class="icon"><i class="fa fa-map"></i></div>
                            <h3>Location</h3>
                            <p>{!! config('myapp.address')!!}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <!-- Contact-Info -->
                        <div class="contact-info">
                            <div class="icon"><i class="fa fa-envelope"></i></div>
                            <h3>Email Address</h3>
                            <a href="mailto:{!! config('myapp.contact_email')!!}">{!! config('myapp.contact_email')!!}</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <!-- Contact-Info -->
                        <div class="contact-info">
                            <div class="icon"><i class="fa fa-phone"></i></div>
                            <h3>Get in Touch</h3>
                            <p>{!! config('myapp.phone')!!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop