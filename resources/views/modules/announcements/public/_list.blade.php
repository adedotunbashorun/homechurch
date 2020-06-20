@foreach ($models as $model)
    <div class="col-4">
        @include('announcements::public._list-item')
    </div>
@endforeach

