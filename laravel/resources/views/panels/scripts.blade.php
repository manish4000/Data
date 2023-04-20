{{-- Vendor Scripts --}}
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
{{-- <script src="{{ asset(mix('vendors/js/ui/prism.min.js')) }}"></script> --}}


<!-- <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script> -->
<!-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script> -->
<!-- <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script> -->
<!-- <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script> -->
<!-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script> -->
<!-- <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script> -->
<!-- <script src="{{ asset('dataTableRowGroup/js/dataTables.rowGroup.min.js') }}"></script> -->
{{-- <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script> --}}
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
{{-- <!-- <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script> --> --}}
{{-- <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>  --}}

<script src="{{ asset('assets/js/scripts/select2.min.js')}}"></script>

{{-- <script src="{{ asset('assets/js/scripts/lang/'.session()->get('locale').'/locale.js?v=2022005112') }}"></script> --}}
@yield('vendor-script')
{{-- Theme Scripts --}}
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>
{{-- <script src="{{ asset('assets/js/scripts/ui/ui-feather.js') }}"></script> --}}


@if($configData['blankPage'] === false)
{{-- <script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script> --}}
@endif

@isset($pageConfigs['baseUrl'])
<script>
    var baseUrl = "{{$pageConfigs['baseUrl']}}";
    var isAnyEnteredOrUpdated = false;
</script>
@endisset

@isset($pageConfigs['moduleName'])
<script>
    var moduleName = "{{$pageConfigs['moduleName']}}";
</script>
@endisset

@if(session()->has('locale'))
    {{-- <script src="{{ asset('assets/js/scripts/lang/'.session()->get('locale').'/locale.js') }}"></script> --}}
@else
    {{-- <script src="{{ asset('assets/js/scripts/lang/'.$configData['defaultLanguage'].'/locale.js') }}"></script> --}}
@endif

{{-- <script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js')) }}"></script> --}}
{{-- <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script> --}}

@isset($pageConfigs['jsFileName'])
    @if(!empty($pageConfigs['jsFileName']))
        <script src="{{ asset('assets/js/scripts/pages/masters/'.$pageConfigs['jsFileName'].'?v=202200554') }}"></script>
    @endif
@endisset 
{{-- <script src="{{ asset('assets/js/scripts/pages/common.js?v=202205314') }}"></script>  --}}
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

<script src="{{ asset('assets/js/gabs/common.js') }}"></script>
<script src="{{ asset('assets/js/gabs/master.js') }}"></script>
{{-- page script --}}
@yield('page-script')

@stack('script')
{{-- page script --}}

@yield('inner-script')
