
@extends('layouts/fullLayoutMaster')
@section('title', 'Login Page')
@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
@endsection

@section('content')
{{-- <div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner py-2">
    <!-- Login v1 -->
    <div class="card mb-0">
      <div class="card-body">
        <a href="javascript:void(0);" class="brand-logo ">
          <img src="{{asset('assets/images/logo/logo.png')}}" height="50" alt="GABS Logo"> 
        </a> 
        @if ($errors->any())
          <x-admin.form.form_error_messages message="{{$errors->first()}}" />
        @endif
        <form class="auth-login-form" method="POST" action="{{ route('2fa') }}">
          {{ csrf_field() }}
            <div class="form-group">
                <p>Please enter the  <strong>OTP</strong> generated on your Authenticator App.</p>
                <label for="one_time_password" class="col-md-12 control-label">One Time Password</label>

                <div class="col-md-12">
                    <input id="one_time_password" type="number" class="form-control" name="one_time_password" required autofocus>
                </div>
            </div>
          <button type="submit" class="btn btn-primary btn-block my-3" tabindex="4">Verify</button>
        </form>

      </div>
    </div>
    <!-- /Login v1 -->
  </div>
</div> --}}

<div class="auth-wrapper auth-v2 ">
  <div class="auth-inner row m-0">
    <!-- Brand logo-->
    <a class="brand-logo d-inline-block" href="javascript:void(0);">
      <img class="w-5 float-left" src="{{asset('assets/images/logo/logo.png')}}" alt="Login V2"/>
      <h3 class="brand-text text-primary d-lg-block float-left pb-0">GLOBAL AUTOMOBILE BUSINESS SOLUTION</h3>
    </a>
    {{-- <div class="col-lg-11 col-12"> <h2 class="brand-text text-primary  mt-lg-2 mt-2 mb-3">GLOBAL AUTOMOBILE BUSINESS SOLUTION</h2></div> --}}

    <!-- /Brand logo-->

    <!-- Left Text-->
    <div class="d-none d-lg-flex col-lg-8 align-items-center">
     <div class="w-100 d-lg-flex align-items-center justify-content-center">
        {{-- @if($configData['theme'] === 'dark')
        <img class="img-fluid" src="{{asset('images/pages/login-v2-dark.svg')}}" alt="Login V2" />
        @else --}}
        <img class="img-fluid" src="{{asset('assets/images/logo/login-v2.svg')}}" alt="Login V2" />
        {{-- @endif --}}
      </div>
    </div>
    <!-- /Left Text-->

    <!-- Login-->
    <div class="d-flex col-lg-4 align-items-center auth-bg px-2">
      <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
        <h2 class="card-title font-weight-bold mb-1 pt-2">Welcome to GABS! &#x1F44B;</h2>
        <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
        <!-- Login Form-->
        @if ($errors->any())
          <x-admin.form.form_error_messages message="{{$errors->first()}}" />
        @endif
        <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
          
          {{ csrf_field() }}
          <div class="form-group">
              <p>Please enter the  <strong>OTP</strong> generated on your Authenticator App.</p>
              <label for="one_time_password" class="col-md-12 control-label">One Time Password</label>

              <div class="col-md-12">
                  <input id="one_time_password" type="number" class="form-control" name="one_time_password" required autofocus>
              </div>
          </div>
        <button type="submit" class="btn btn-primary btn-block my-3" tabindex="4">Verify</button>
  

        </form>
        <!-- /Login Form-->
        <div class="divider my-2">
          
        </div>


    </div>
  </div>
  <!-- /Login-->
  </div>
</div>
@endsection
