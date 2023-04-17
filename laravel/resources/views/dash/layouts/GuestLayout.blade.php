<!DOCTYPE html>
<html class="loading" lang="en" >
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title> @yield('title') Home - Vuexy - Bootstrap HTML admin template</title>
    <link rel="apple-touch-icon" href="{{asset('assets/dash/assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/dash/assets/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     {{-- Include core + vendor Styles --}}
     @include('dash/panels/styles')

</head>
<!-- END: Head-->
<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  blank-page bg-full-screen-image light " data-open="click" data-menu="vertical-menu-modern" data-col="">

       <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-wrapper">
            <div class="content-body">
                {{-- Include Startkit Content --}}
                @yield('content')
            </div>
            </div>
        </div>
        <!-- End: Content-->
  
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
</html>