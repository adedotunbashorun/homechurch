@if($test_block = Blocks::bySlug('testimonials'))
    <section class="testimonials section no-bg">
        <div class="container">
            <div class="row">
                <div class="col-12 wow zoomIn">
                    <div class="section-title">
                        <h2>{!! $test_block->present()->styledTitle !!}</h2>
                        <p>{!! $test_block->present()->content !!}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-slider">
                        @if($testimonials = Testimonials::latest(10))
                            @foreach ($testimonials as $model)
                                @include('testimonials::public._list-item')
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif