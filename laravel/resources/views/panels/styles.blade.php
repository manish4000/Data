<link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/css/gabs/custom.css')}}" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('vendors/css/ui/prism.min.css')) }}" />
{{-- Vendor Styles --}}
<!-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}"> -->
<!-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}"> -->
<!-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}"> -->
{{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}"> --}}
{{-- <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}"> --}}
{{-- <!-- <link rel="stylesheet" href="{{ asset('dataTableRowGroup/css/rowGroup.dataTables.min.css') }}"> --> --}}

@yield('vendor-style')
{{-- Theme Styles --}}

<link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />

{{-- {!! Helper::applClasses() !!} --}}
@php $configData = Helper::applClasses(); @endphp

{{-- Page Styles --}}
@if($configData['mainLayoutType'] === 'horizontal')
<link rel="stylesheet" href="{{ asset(mix('css/base/core/menu/menu-types/horizontal-menu.css')) }}" />
@endif
<link rel="stylesheet" href="{{ asset(mix('css/base/core/menu/menu-types/vertical-menu.css')) }}" />
<!-- <link rel="stylesheet" href="{{ asset(mix('css/base/core/colors/palette-gradient.css')) }}"> -->

{{-- Page Styles --}}
@yield('page-style')

{{-- Laravel Style --}}

<link rel="stylesheet" href="{{ asset(mix('css/overrides.css')) }}" />

{{-- Custom RTL Styles --}}

@if($configData['direction'] === 'rtl' && isset($configData['direction']))
<link rel="stylesheet" href="{{ asset(mix('css/custom-rtl.css')) }}" />
@endif

{{-- user custom styles --}}
<link rel="stylesheet" href="{{ asset(mix('css/style.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('css/style-rtl.css')) }}" />

