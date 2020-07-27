@extends('core::admin.master')

@section('title', $title)

@section('page-css')
<link href="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
<style>
    tr.group,
    tr.group:hover {
        background-color: #b45678 !important;
    }
</style>
@stop

@section('page-js')
<script src="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script>
        const type = "{{ current_user()->churchtype }}";
        const second = {!! json_encode(config($module.'.second_columns')) !!};
        const column = (type && second) ? {!! json_encode(config($module.'.second_columns')) !!} : {!! json_encode(config($module.'.columns')) !!}
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
                    columns: column,
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
                var groupColumn = 6;
            $('#datatable1').DataTable({
                "columnDefs": [
                    { "visible": false, "targets": groupColumn }
                ],
                "order": [[ groupColumn, 'asc' ]],
                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;
        
                    api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                            );
        
                            last = group;
                        }
                    } );
                }
            });
            $('#datatable1 tbody').on( 'click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
                    table.order( [ groupColumn, 'desc' ] ).draw();
                }
                else {
                    table.order( [ groupColumn, 'asc' ] ).draw();
                }
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
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__body">
            <table class="table display table-striped- table-bordered table-hover table-checkable" id="datatable1" style="width:100%">
                <thead>
                    <tr>
                        <th>Home Church Name</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Children</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($g_attendance as $key => $attendance)
                    @foreach ($attendance as $att)
                        <tr>
                            <td>{{ $att->homechurches->name }}</td>
                            <td>{{ $att->male }}</td>
                            <td>{{ $att->female }}</td>
                            <td>{{ $att->children }}</td>
                            <td> {{(int) $att->male + $att->female + $att->children }}</td>
                            <td>{{ date('Y-M-D d', strtotime($att->date)) }}</td>
                            <td>{{ $key }}: You have {{ $attendance->count() }} attendance records.</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop