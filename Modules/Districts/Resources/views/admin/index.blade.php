@extends('core::admin.master')

@section('title', $title)

@section('page-css')
<link href="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('page-js')
<script src="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script>
        $(function() {
            getSelectOnChange($("#country_id"),'/admin/regions/country/region/', $('#region_id').closest('div'),$('#region_id'),'Region','regions');
            getSelectOnChange($("#region_id"),'/admin/states/region/state/', $('#state_id').closest('div'),$('#state_id'),'State','states');
            getSelectOnChange($("#state_id"),'/admin/districts/state/district/', $('#district_id').closest('div'),$('#district_id'),'District','districts');
            getSelectOnChange($("#district_id"),'/admin/zones/district/zone/', $('#zone_id').closest('div'),$('#zone_id'),'Zone','zones');
            getSelectOnChange($("#zone_id"),'/admin/areas/zone/area/', $('#area_id').closest('div'),$('#area_id'),'Area','areas');
            getSelectOnChange($("#area_id"),'/admin/churches/area/church/', $('#church_id').closest('div'),$('#church_id'),'Church','churches');
            getDatatable();
            function getDatatable(data = '') {
                $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: `{{route('admin.'.$module.'.datatable')}}?${data}`,
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
            $('.search-modal-form').on('submit',function(e){
                e.preventDefault();
                $('#data-table').dataTable().fnClearTable();
                $('#data-table').dataTable().fnDestroy();
                // let country_id =  $('#country_id option:selected').toArray().map(item => `country_id=${item.value}&`).join();
                let country_id= $('#country_id').val();
                let region_id= $('#region_id').val();
                let state_id= $('#state_id').val();
                let district_id = $('#district_id').val();
                let zone_id = $('#zone_id').val();
                let area_id = $('#area_id').val();
                let church_id = $('#church_id').val();
                var button = $(this).find('button[type=submit]');
                var buttonInitialLabel = button.html();
                button.attr("disabled", true).html("<i class='fa fa-spinner fa-spin'></i>");
                getDatatable(`country_id=${country_id}&region_id=${region_id}&state_id=${state_id}&district_id=${district_id}&zone_id=${zone_id}&area_id=${area_id}&church_id=${church_id}`);
                button.attr("disabled", false).html(buttonInitialLabel);
                $('#searchModal .close').click();
                // $('#searchModal').modal('toggle'); 
            });
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
        @include('core::admin._porlet-title', ['module' => $module,'type'=>'create','caption'=>'index'])
        <div class="kt-portlet__body">
            {!!generate_datatable(config($module.'.th'))!!}
        </div>
    </div>
    @if(has_access($module.'.search') && (\Request::route()->getName() == 'admin.'.$module.'.index'))
        @include($module.'::admin._search_modal')
    @endif
@stop