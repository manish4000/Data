@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
@endsection

@section('content')
{{-- <div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner py-2">
   
    <div class="card mb-0">
      <div class="card-body">
        <a href="javascript:void(0);" class="brand-logo ">
          <img src="{{asset('assets/images/logo/logo.png')}}" height="50" alt="GABS Logo"> 
        </a>

        <h4 class="card-title mb-1">Welcome to GABS! 👋</h4>
        <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
        @if (session('error'))
          <x-admin.form.form_error_messages message="{{ session('error') }}" />
        @endif
        <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group">
            <x-admin.form.inputs.email for="email" tooltip="{{__('webCaption.email.caption')}}"   label="{{__('webCaption.email.title')}}"  class="form-control" name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email')}}"  required="required" />
              @if ($errors->has('email'))
                <x-admin.form.form_error_messages message="{{ $errors->first('email') }}"  />
              @endif
          </div>

          <div class="form-group">
            <div class="form-group">
              <x-admin.form.inputs.password    for="login-password" tooltip="{{__('webCaption.password.caption')}}"   label="{{__('webCaption.password.title')}}"  class="form-control" name="password"  placeholder="{{__('webCaption.password.title')}}" value=""  required="" />
              @if ($errors->has('password'))
              <x-admin.form.form_error_messages message="{{ $errors->first('password') }}"  />
                @endif
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
                  <div class="form-group">
                      <div class="g-recaptcha" data-sitekey="{{ env('ADMIN_GOOGLE_RECAPTCHA_KEY') }}"></div>
                      @if ($errors->has('g-recaptcha-response'))
                          <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                      @endif
                  </div>  
              </div>
            </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" id="remember" value="1" name="remember" tabindex="3" {{ old('remember') ? 'checked' : '' }} />
              <label class="custom-control-label" for="remember"> Remember Me </label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block my-3" tabindex="4">Sign in</button>
        </form>
      </div>
    </div>

  </div>
</div> --}}

<div class="auth-wrapper auth-v2 px-2">
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
        @if (session('error'))
          <x-admin.form.form_error_messages message="{{ session('error') }}" />
        @endif
        <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group">
            <x-admin.form.inputs.email for="email" tooltip="{{__('webCaption.email.caption')}}"   label="{{__('webCaption.email.title')}}"  class="form-control" name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email')}}"  required="required" />
              
          </div>

          <div class="form-group">
            <div class="form-group">
              <x-admin.form.inputs.password    for="login-password" tooltip="{{__('webCaption.password.caption')}}"   label="{{__('webCaption.password.title')}}"  class="form-control" name="password"  placeholder="{{__('webCaption.password.title')}}" value=""  required="" />
              
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
                  <div class="form-group">
                      <div class="g-recaptcha" data-sitekey="{{ env('ADMIN_GOOGLE_RECAPTCHA_KEY') }}"></div>
                      @if ($errors->has('g-recaptcha-response'))
                          <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                      @endif
                  </div>  
              </div>
            </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" id="remember" value="1" name="remember" tabindex="3" {{ old('remember') ? 'checked' : '' }} />
              <label class="custom-control-label" for="remember"> Remember Me </label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block my-3" tabindex="4">Sign in</button>
        </form>
        <!-- /Login Form-->
        <div class="divider my-2">
          
        </div>
        {{-- <div class="auth-footer-btn d-flex justify-content-center">
          <a class="btn btn-facebook" href="https://www.facebook.com/JCTJapan/" target="_blank">
            <i data-feather="facebook"></i>
          </a>
          <a class="btn btn-twitter white" href="https://twitter.com/JapanUsedCars" target="_blank">
            <i data-feather="twitter"></i>
          </a>
          <a class="btn btn-google" href="https://www.youtube.com/japanusedcars" target="_blank">
            <i data-feather="youtube"></i>
          </a>
          <a class="btn btn-instagram red" href="https://www.instagram.com/japanese_used_cars/" target="_blank">
            <i data-feather="instagram"></i>
          </a>
          <a class="btn btn-google" href="https://blog.japanesecartrade.com/" target="_blank">
            <i data-feather="globe"></i>
          </a>
        </div> --}}
        <div class="my-2 text-center">Powered by <a href="https://www.japanesecartrade.com" target="_blank">JapaneseCarTrade.com</a></div>
    </div>
  </div>
  <!-- /Login-->
  </div>
</div>

<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
