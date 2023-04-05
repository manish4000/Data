<!-- BEGIN: Vendor JS-->
<script src="{{asset('assets/dash/assets/vendors/js/vendors.min.js')}}"></script>
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>

<!-- BEGIN Vendor JS-->
@yield('vendor-script')
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset('assets/js/scripts/select2.min.js')}}"></script>

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
{{-- <script src="{{asset('assets/dash/assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('assets/dash/assets/js/core/app.js')}}"></script> --}}


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>


<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>
<script src="{{ asset('assets/dash/assets/js/dash/common.js') }}"></script>
<!-- END: Theme JS-->

@stack('script')