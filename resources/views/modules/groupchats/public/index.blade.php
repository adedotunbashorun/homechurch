@extends('pages::public.master')
@section('page')
    @include('pages::public._page-banner-section')
    <section class="events archives section">
        <div class="container">
            <div class="row">
                @include('pages::public._page-content-body')
                @if(empty($groups[0]))
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <h4>Select Groupchat</h4><br/>
                        <form class="church-form-user" method="POST" action="{{ route('groupchats.adduser') }}">
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
                                <div class="col ml-4">{!! form_row($register_form->groupchat_id) !!}</div>
                            </div>
                            <button type="submit" class="btn btn-primary assign-church">Submit</button>
                        </form>
                    </div>
                @else
                <div class="col-lg-12 col-md-12 col-sm-12" id="app">
                    <groups :initial-groups="{{ $groups }}" :user="{{ current_user() }}" :initial-group-members="{{ $group_members }}" :is-admin="false"></groups>  
                </div>
                @endif
            </div>
        </div>
    </section>
@stop
@section('js')
<script>
    $(function() {
        $("#church").on('change', function(){
            if($(this).val() === 'no'){
                $('#country_id').closest('div.col').show();
                $('#state_id').closest('div.col').show();
                $('#church_id').closest('div.col').hide();
                getSelectOnChange($("#state_id"),'/api/state/groupchats/', $('#groupchat_id').closest('div'),$('#groupchat_id'),'HomeChurch','groupchats');
            }
            if($(this).val() === 'yes'){
                $('#church_id').closest('div.col').show();
                getSelectOnChange($("#state_id"),'/api/state/churches/', $('#church_id').closest('div'),$('#church_id'),'Church','churches');
            }
        })
        $('.assign-church').hide();
        getSelectOnChange($("#country_id"),'/api/country/states/', $('#state_id').closest('div'),$('#state_id'),'State','states');
        getSelectOnChange($("#state_id"),'/api/state/churches/', $('#church_id').closest('div'),$('#church_id'),'Church','churches');
        if($("#church").val() === 'no') getSelectOnChange($("#state_id"),'/api/state/groupchats/', $('#groupchat_id').closest('div'),$('#groupchat_id'),'HomeChurch','groupchats');
        getSelectOnChange($("#church_id"),'/api/church/groupchats/', $('#groupchat_id').closest('div'),$('#groupchat_id'),'HomeChurch','groupchats');
        getSelectOnChange($("#country_id1"),'/api/country/states/', $('#state_id1').closest('div'),$('#state_id1'),'State','states');
        getSelectOnChange($("#state_id1"),'/api/state/churches/', $('#church_id1').closest('div'),$('#church_id1'),'Church','churches');
        getSelectOnChange($("#church_id1"),'/api/church/groupchats/', $('#groupchat_id1').closest('div'),$('#groupchat_id1'),'HomeChurch','groupchats');

        // $('.add-modal-form').on('submit',function(e){
        //     e.preventDefault();
        // });
        $('#church_id, #groupchat_id').on('change', function() {
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
@if(!empty($groups[0]))
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
@endif
@endsection