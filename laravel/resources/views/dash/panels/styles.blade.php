    <link href="{{asset('assets/dash/assets/css/custom.css')}}" rel="stylesheet" />
    <!-- BEGIN: Vendor CSS-->
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/dash/assets/vendors/css/vendors.min.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/ui/prism.min.css')) }}" />
    <!-- END: Vendor CSS-->
    @yield('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />

    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" />
    <!-- BEGIN: Theme CSS-->
     <link rel="stylesheet" type="text/css" href="{{asset('assets/dash/assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dash/assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dash/assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dash/assets/css/components.css')}}"> 

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dash/assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <!-- END: Page CSS-->
    @yield('page-style')


    
    {{-- testing purpose only --}}
{{-- Laravel Style --}}
