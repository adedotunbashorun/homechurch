@extends('core::admin.master')

@section('title', $title)

@section('page-css')
<link href="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('page-js')
<script src="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
    const id = "{{ !empty($id) ? $id : ''}}";
    const type = "{{ !empty($type) ? $type : 'zone'}}";
    const data= `id=${id}&type=${type}`
     $(function() {
        $('#data-table').DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [50, 100, 200, -1],
                [ '50 rows', '100 rows', '200 rows', 'Show all' ]
            ],
            buttons: [
                'pageLength','print','excel','pdf'
            ],
            processing: true,
            serverSide: true,
            ajax: `{{route('admin.'.$module.'.group_datatable')}}?${data}`,
            columns: {!! json_encode(config($module.'.group_columns')) !!},
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
        @include('core::admin._porlet-title', ['module' => $module,'type'=>'back','caption'=>'homechurches_role'])
        <div class="kt-portlet__body mb-4" style="margin-bottom: 10em;">
            <div class="table-scrollable">
                {!!generate_datatable(config($module.'.gth'))!!}
            </div>
            <hr/>
        </div>
    </div>
@stop