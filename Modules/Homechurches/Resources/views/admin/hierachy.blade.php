@extends('core::admin.master')

@section('title', $title)

@section('page-css')
<link href="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('page-js')
<script src="{{asset('assets/admin/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
     $(function() {
        const types = [
            // 'homechurch',
            'church',
            'area',
            'zone',
            'district',
            'state',
            'region',
        ] 
        let group = '';
        $('#groups').closest('div').hide();
        getSelectOnChange($("#church_id"),'/admin/homechurches/church/', $('#homechurches_id').closest('div'),$('#homechurches_id'),'Homechurches','homechurches');
        $("#type").on('change', function() {
            // if ($(this).val() === 'homechurch') {
            //     $('#homechurches_id').attr('multiple', false);
            // } else {
            //     $('#homechurches_id').attr('multiple', true);
            // }
            types.map((type, index) => {
                if($(this).val() === type){
                    group = types[index-1];
                }
            })
        })
        $("#church_id").on('change load', function(){
            var id = $(this).val();
            if(group) {
                $.ajax({
                    url: `/admin/homechurches/church/group/${id}/${group}`,
                    type: 'get',
                    dataType: 'json',
                    success:function(response){
                        $('#homechurches_id').closest('div').hide();
                        $('#groups').closest('div').show();
                        $('#groups').empty();
                        $('#groups').append(`<option value=''>-- Select Hierarchy --</option>`)
                        response['groups'].forEach((element, index) => {
                            $('#groups').append("<option value='"+element.id+"'>"+element.name+"</option>");
                        });
                    }
                });
            }
        });

        @if(!empty($model))
            $('#homechurches_id').closest('div').show();
        @endif
        $('#data-table').DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [50, 100, 200, -1],
                [ '50 rows', '100 rows', '200 rows', 'Show all' ]
            ],
            buttons: [
                'pageLength','print','excel','pdf'
            ],
            "paging": true,
            "lengthChange": true,
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
                @if(empty($model))
                    {!!generate_datatable(config($module.'.gth'))!!}
                @endif
            </div>
            <hr/>
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