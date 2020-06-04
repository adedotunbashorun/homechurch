@if(has_access('homechurches.destroy'))
    {!! delete_btn(route('admin.homechurches.group.destroy',$id)) !!}
@endif