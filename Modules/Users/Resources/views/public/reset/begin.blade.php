@extends('core::public.master')

@section('title', 'Reset Password' . $metaTitle)
@section('ogTitle', 'Reset Password')
@section('description', 'Reset Password')

@section('css')

@stop

@section('js')

@stop

@section('main')

    <style>
        .notify {
            text-align: center;
        }
    </style>
    <section class="about-us section register">
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <div class="alert alert-info">
                        {{trans('users::global.reset_info')}}
                    </div>
                    @include('core::public._partials.notify')
                    {!! form_start($form,['class'=>'']) !!}

                    {!! form_row($form->email,['attr'=>['placeholder'=>'','required']]) !!}
                    {{-- <div class="button"> --}}
                        <button type="submit" class="btn btn-primary border-radius">Reset</button>
                    {{-- </div> --}}
                    {!! form_end($form,false) !!}
                </div>
            </div>
        </div>
    </section>

@stop
