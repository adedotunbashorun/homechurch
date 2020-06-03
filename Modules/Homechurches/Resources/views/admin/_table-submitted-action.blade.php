{{-- @if(has_access('homechurches.show'))
    {!! edit_btn(route('admin.homechurches.show',$id)) !!}
@endif --}}
@if(has_access('homechurches.approveSubmittedHomechurches'))
    {!! approve_btn(route('admin.homechurches.approveSubmittedHomechurches',$id), "") !!}
@endif