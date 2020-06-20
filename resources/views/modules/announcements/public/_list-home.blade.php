@if($test_block = Blocks::bySlug('announcements'))
    <section class="events archives section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>{!! $test_block->present()->styledTitle !!}</h2>
                        <p>{!! $test_block->present()->content !!}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($announcements = Announcements::latest(5))
                    @foreach ($announcements as $model)
                        <div class="col-lg-4">
                            @include('announcements::public._list-item')
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endif