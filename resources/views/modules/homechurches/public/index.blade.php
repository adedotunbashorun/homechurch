@extends('pages::public.master')
@section('css')
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet"/>
@endsection
@section('page')
    @include('pages::public._page-banner-section')
    <section class="events archives section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-brand btn-sm pull-right" data-toggle="modal" data-target="#searchModal">
                        <i class="fa fa-plus"></i>
                        Add Home Church
                    </button>
                    <br/><br/>
                    <div class="row">
                        <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                            @include('pages::public._page-content-body')
                            @if(count(current_user()->homechurches) > 0)
                                <h4>Your Homechurch</h4><br/>
                                <ul class="list-group">
                                    <li class="list-group-item">Name
                                        <span class="pull-right"><i class="fa fa-home"></i> {{ current_user()->homechurches[0]['name'] }}</span>
                                    </li>
                                    <li class="list-group-item"> Address
                                        <span class="pull-right"><i class="fa fa-map"></i> 
                                        <a href="https://www.google.com/maps/place/{{ current_user()->homechurches[0]['address'] }}" target="_blank">
                                            {{ current_user()['homechurches'][0]['address'] }}</a></span>
                                    </li>
                                    <li class="list-group-item">Church Name
                                        <span class="pull-right"><span class="badge badge-success"></i> {{ current_user()->homechurches[0]['church']['name'] }}</span>
                                    </li>
                                    <li class="list-group-item">No of Members
                                        <span class="pull-right"><span class="badge badge-success"></i> {{ count(current_user()->homechurches[0]['users']) }}</span>
                                    </li>
                                </ul>
                                
                            @else
                                <h4>Select Homechurch</h4><br/>
                                <form class="church-form-user" method="POST" action="{{ route('homechurches.adduser') }}">
                                    {{ csrf_field() }}
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                            <label>Any dunamis church around you? </label>
                                            <select name="church" id="church" class="form-control required">
                                                <option value="">--- Select ---</option>
                                                <option value="no">No</option>
                                                <option value="yes">Yes</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Country </label>
                                                @if($countries = Countries::getAll())
                                                    <select name="country_id" id="country_id" class="form-control required">
                                                        <option value=""> -- Select Country--</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }} </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col ml-4">{!! form_row($register_form->state_id) !!}</div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col ml-4">{!! form_row($register_form->church_id) !!}</div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col ml-4">{!! form_row($register_form->homechurch_id) !!}</div>
                                    </div>
                                    <button type="submit" class="btn btn-primary assign-church">Submit</button>
                                </form>
                            @endif
                        </div>
                        <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                            @if(count($models) > 0)
                            <table id="data-table" class="table table-striped table-hover table-bordered table-responsive">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th> Country</th>
                                    <th> State</th>
                                    <th> Church</th>
                                    <th>Created On</th>
                                    <th>Address</th>
                                    <th> Status</th>
                                    {{-- <th> Action</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($models as $key => $cell)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $cell->name }}</td>
                                        <td>
                                            @if(!empty($cell->country))
                                                {{ $cell->country->name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($cell->state))
                                                {{ $cell->state->name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($cell->church))
                                                {{ $cell->church->name }}
                                            @endif
                                        </td>
                                        <td>{{ date('D d M Y',strtotime($cell->created_at)) }} </td>
                                        <td>{{ $cell->address }}</td>
                                        <td><span class="btn btn-sm btn-{{ ($cell->status === 1) ? 'success' : 'warning'}}">{{ ($cell->status === 1) ? 'Approved' : 'Not Approved'}}</span></td>
                                        {{-- <td>@include('offering::admin._table-action',['id'=> $cell->id])</td> --}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('modules.homechurches.public.partials._homechurch_create')
@stop
@section('js')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $("#church").on('change', function(){
                if($(this).val() === 'no'){
                    $('#country_id').closest('div.col').show();
                    $('#state_id').closest('div.col').show();
                    $('#church_id').closest('div.col').hide();
                    // if($('#state_id').val()) {
                        getSelectOnChange($("#state_id"),'/api/state/homechurches/', $('#homechurch_id').closest('div'),$('#homechurch_id'),'HomeChurch','homechurches');
                    // }
                }
                if($(this).val() === 'yes'){
                    $('#church_id').closest('div.col').show();
                    // if($('#state_id').val()) {
                        getSelectOnChange($("#state_id"),'/api/state/churches/', $('#church_id').closest('div'),$('#church_id'),'Church','churches');
                    // }
                }
            })
            $('.assign-church').hide();
            $('#data-table').DataTable();
            getSelectOnChange($("#country_id"),'/api/country/states/', $('#state_id').closest('div'),$('#state_id'),'State','states');
            getSelectOnChange($("#state_id"),'/api/state/churches/', $('#church_id').closest('div'),$('#church_id'),'Church','churches');
            if($("#church").val() === 'no') getSelectOnChange($("#state_id"),'/api/state/homechurches/', $('#homechurch_id').closest('div'),$('#homechurch_id'),'HomeChurch','homechurches');
            getSelectOnChange($("#church_id"),'/api/church/homechurches/', $('#homechurch_id').closest('div'),$('#homechurch_id'),'HomeChurch','homechurches');
            getSelectOnChange($("#country_id1"),'/api/country/states/', $('#state_id1').closest('div'),$('#state_id1'),'State','states');
            getSelectOnChange($("#state_id1"),'/api/state/churches/', $('#church_id1').closest('div'),$('#church_id1'),'Church','churches');
            getSelectOnChange($("#church_id1"),'/api/church/homechurches/', $('#homechurch_id1').closest('div'),$('#homechurch_id1'),'HomeChurch','homechurches');

            // $('.add-modal-form').on('submit',function(e){
            //     e.preventDefault();
            // });
            $('#church_id, #homechurch_id').on('change', function() {
                $('.assign-church').show();
            })

            $('.church-form-user').on('submit', function(e){
                e.preventDefault()
                $(this).ajaxSubmit({
                    success: function (response, statusText, xhr, $form) {
                        swal({
                            /*title: "Success",*/
                            title: response.message,
                            icon: "success"
                        }).then((value) => {
                            location.reload();
                        });
                    },
                    error: function (response, statusText, xhr, $form) {
                        swal({
                            title: "Oops!",
                            text: response.responseText,
                            icon: "error",
                            dangerMode: true,
                        });
                    }
                });
            })
        });
    </script>
@endsection