@extends('core::admin.master')

@section('title', $title)

@section('page-css')
<link href="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('page-js')
<script src="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script>
    $(function() {
        getDatatable();
        function getDatatable() {
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{route('admin.'.$module.'.datatable')}}`,
                columns: {!! json_encode(config($module.'.columns')) !!},
                drawCallback:function(){
                    $(".delete-me").click(function () {
                        if(confirm($(this).attr('data-confirm'))){
                            $.ajax({
                                url: $(this).attr('href'),
                                type: 'DELETE',
                                success: function(data){
                                    document.location.href = '{{route('admin.'.$module.'.index')}}';
                                },
                                data: {_token: '{{csrf_token()}}'}
                            })
                        }
                        return false;
                    });

                    $('.tooltips').tooltip();

                }
            });
        }
    });
</script>
@stop

@section('page-group-title')
    {{trans($module . '::global.group_name')}}
@stop
@section('page-breadcrumbs')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="javascript:;" class="kt-subheader__breadcrumbs-link">@Lang($module . '::global.name')</a>
@stop


@section('main')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-signs-1"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    @if(isset($caption))
                        @Lang($module . '::global.'.$caption)
                    @else
                        @Lang($module . '::global.index')
                    @endif
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    @if(empty(config($module.'.hide_add_btn')))
                        <div class="kt-portlet__head-actions">
                            <a href="{{route('admin.'.$module. '.create')}}" class="btn btn-brand btn-sm">
                                <i class="fa fa-pen"></i>
                                Add User
                            </a>
                        </div>
                    @endif
                    {{-- @include('core::admin._button-fullscreen') --}}
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            {!!generate_datatable(config($module.'.th'))!!}
        </div>
    </div>
    @if(has_access($module.'.search') && (\Request::route()->getName() == 'admin.'.$module.'.index'))
        @include($module.'::admin._search_modal')
    @endif
@stop