@extends('pages::public.master')
@section('page')
    @include('pages::public._page-banner-section')
    <section class="events archives section">
        <div class="container">
            <div class="row">
                @include('pages::public._page-content-body')
                @include('manuals::public._list')
            </div>
        </div>
    </section>
@stop