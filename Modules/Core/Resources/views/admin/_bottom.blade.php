<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#2c77f4",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin:: Global Mandatory Vendors -->
<script src="{{asset('assets/admin/vendors/general/jquery/dist/jquery.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/popper.js/dist/umd/popper.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/bootstrap/dist/js/bootstrap.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/js-cookie/src/js.cookie.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/moment/min/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/tooltip.js/dist/umd/tooltip.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/sticky-js/dist/sticky.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/wnumb/wNumb.js')}}" type="text/javascript"></script>

<!--end:: Global Mandatory Vendors -->

<!--begin:: Global Optional Vendors -->
<script src="{{asset('assets/admin/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/custom/js/vendors/bootstrap-datepicker.init.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/custom/js/vendors/bootstrap-timepicker.init.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/select2/dist/js/select2.full.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/admin/vendors/general/dropzone/dist/dropzone.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/summernote/dist/summernote.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/jquery-validation/dist/jquery.validate.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/jquery-validation/dist/additional-methods.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/custom/js/vendors/jquery-validation.init.js')}}"
        type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/general/toastr/build/toastr.min.js')}}" type="text/javascript"></script>

<!--end:: Global Optional Vendors -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{asset('assets/admin/js/scripts.bundle.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/public/js/jquery/jquery-ui-1.9.1.custom.min.js') }}"></script>
<script src="{{ asset('assets/public/js/jquery/jquery.autocomplete.min.js') }}"></script>
<script src="{{ asset('assets/public/js/autocomplete.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<!--end::Global Theme Bundle -->
<script src="{{asset('assets/admin/js/custom.js')}}" type="text/javascript"></script>
<script src="//js.pusher.com/4.1/pusher.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
    window.Laravel = {!! json_encode([
            'csrfToken'=> csrf_token(),
            'user' => current_user()
        ])
    !!};
</script>
@yield('page-js')
<script>
    $(function () {
        $('#form-validate').validate();
        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-bottom-right"
        };

        @if (!empty($errors) && count($errors) > 0)
            toastr.error('{!! \HTML::ul($errors->all()) !!}')
        @endif


        @if (session()->has('success'))
        toastr.success('{!! session('success') !!}');
        @endif

        @if (session()->has('error'))
        toastr.error('{!! session('error') !!}');
        @endif


        $('.date-picker').datepicker({format: 'yyyy-mm-dd', 'autoclose': true});

        $('.time-picker').timepicker();

        $('.jsSelectAllInGroup').on('click', function (event) {
            event.preventDefault();
            $(this).closest('.permissionGroup').find('input[type=checkbox]').each(function (index, value) {
                $(this).prop('checked', true);
            });
        });
        $('.jsDeselectAllInGroup').on('click', function (event) {
            event.preventDefault();
            $(this).closest('.permissionGroup').find('input[type=checkbox]').each(function (index, value) {
                $(this).prop('checked', false);
            });

        });

    });
</script>
