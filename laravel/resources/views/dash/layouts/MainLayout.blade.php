<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">


    
  {{-- Include Navbar --}}
  @include('dash.panels.navbar')

  {{-- Include Navbar --}}
  @include('dash.panels.sidebar')


    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
            {{-- include success error common file --}}
            @include('components.dash.alerts.success-error-message-display')
            {{-- end include success-error --}}
        <div class="content-wrapper ">

            @if($configData['pageHeader'] === true && isset($configData['pageHeader']))
            @include('dash.panels.breadcrumb')
            @endif 
            <div class="content-body">
                @yield('content')
                @yield('extra-content')
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>


    {{-- include footer --}}
    @include('dash/panels/footer')    

    {{-- include default scripts --}}
    @include('dash/panels/scripts')


    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->