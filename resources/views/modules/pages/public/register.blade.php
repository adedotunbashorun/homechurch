@extends('pages::public.master')
@section('page')
    @include('pages::public._page-banner-section')
    <section class="about-us section register">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    @include('core::public._partials.notify')

                        <div class="auth-form">
                            {!! form_start($register_form,['class'=>'ajax-form','data-redirect'=>url('/account/dashboard')]) !!}
                            <div class="form-row">
                                <div class="col">{!! form_row($register_form->first_name) !!}</div>
                                <div class="col">{!! form_row($register_form->last_name) !!}</div>
                            </div>
                            <div class="form-row">
                                <div class="col">{!! form_row($register_form->username) !!}</div>
                                <div class="col"> {!! form_row($register_form->email) !!}</div>
                            </div>
                            <div class="form-row">
                                <div class="col">{!! form_row($register_form->phone) !!}</div>
                                <div class="col"> {!! form_row($register_form->gender) !!}</div>
                            </div>
                            <div class="form-row">
                                <div class="col">{!! form_row($register_form->birthday) !!}</div>
                                <div class="col">
                                    <div class="form-group">
                                    <label>Any dunamis church around you? </label>
                                    <select name="church" id="church" class="form-control required">
                                        <option value="">--- Select ---</option>
                                        <option value="no">No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Country </label>
                                        @if($countries = Countries::getAll())
                                            <select name="country_id" id="country_id" class="form-control required">
                                                <option value=""> -- Select Country--</option>
                                                @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }} </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">{!! form_row($register_form->state_id) !!}</div>
                                <div class="col">{!! form_row($register_form->church_id) !!}</div>
                            </div>
                            <div class="form-row">
                                <div class="col">{!! form_row($register_form->address) !!}</div>
                            </div>
                            <div class="form-row">
                                <div class="col">{!! form_row($register_form->password) !!}</div>
                                <div class="col">{!! form_row($register_form->confirm_password) !!}</div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="terms" required>
                                        <label class="form-check-label" for="terms">I have read the <a
                                                    href="{{url('terms-and-conditions')}}">Terms and
                                                Conditions</a></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group auth-form-action">
                                <div class="button">
                                    <button type="submit" class="btn btn-primary border-radius">Register</button>
                                </div>
                            </div>
                            <p>Already registered? click <a href="{{url('auth/login')}}">here </a> to login</p>
                            {!! form_end($register_form,false) !!}
                        </div>
                </div>
                <div class="col-md-5 col-sm-12">
                    <figure class="figure">
                        <img src="{{$page->present()->thumbSrc()}}" class="figure-img img-fluid rounded"
                             alt="{{$page->title}}">
                    </figure>
                    <div class="single-widget posts">
                        <h3>{!! $page->tagline !!}</h3>
                        <div class="content mt-3">
                            {!! $page->body !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('js')
    <script>
        $(function() {
            // $('#country_id').closest('div.col').hide();
            // $('#state_id').closest('div.col').hide();
            $('#church_id').closest('div.col').hide();
            $("#church").on('change', function(){
                if($(this).val() == 'yes'){
                    $('#church').closest('div.col').hide();
                    $('#country_id').closest('div.col').show();
                    $('#state_id').closest('div.col').show();
                    $('#church_id').closest('div.col').show();
                }
            })
            getSelectOnChange($("#country_id"),'/api/country/states/', $('#state_id').closest('div'),$('#state_id'),'State','states');
            getSelectOnChange($("#state_id"),'/api/state/churches/', $('#church_id').closest('div'),$('#church_id'),'Church','churches');
        });
    </script>
@endsection