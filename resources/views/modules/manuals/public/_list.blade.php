@foreach ($models as $model)
    <div class="col-lg-4 col-md-6 col-sm-12">
        @include('manuals::public._list-item')
    </div>
@endforeach

