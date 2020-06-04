@extends('core::admin.master')

@section('title', $title)

@section('page-css')
<link href="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('page-js')
<script src="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
     $(function() {
        getSelectOnChange($("#church_id"),'/admin/homechurches/church/', $('#homechurches_id').closest('div'),$('#homechurches_id'),'Homechurches','homechurches');
        $("#group").on('change', function() {
            if ($(this).val() === 'homechurch') {
                $('#homechurches_id').attr('multiple', false);
            } else {
                $('#homechurches_id').attr('multiple', true);
            }
        })
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: `{{route('admin.'.$module.'.group_datatable')}}`,
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
            <hr>
            {!! form_start($form,['id'=>'form-validate']) !!}
            @include('core::admin._buttons-form',['top'=>true])
            <div class="form-body">
                {!! form_rest($form) !!}
            </div>
            @include('core::admin._buttons-form')
            {!! form_end($form,false) !!}
        </div>
    </div>
@stop