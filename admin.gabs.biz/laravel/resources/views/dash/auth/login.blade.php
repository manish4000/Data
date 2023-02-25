@extends('dash/layouts/GuestLayout')

@section('title', $title)

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner py-2">
    <!-- Login v1 -->
    <div class="card mb-0">
      <div class="card-body">
     
        <a href="javascript:void(0);" class="brand-logo ">
          <img src="{{asset('assets/images/logo/logo.png')}}" height="50" alt="GABS Logo"> 
        </a>

        <h4 class="card-title mb-1">Welcome to DASH 👋</h4>
        <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
        @if (session('error'))
          <div class="alert alert-danger py-1 text-center">
              {{ session('error') }}
          </div>
        @endif

        <form class=" mt-2" method="POST" action="{{route('dashlogin')}}">
          @csrf
          <div class="form-group">
            <label for="login-email" class="form-label">Email</label>
            {{-- <input type="text" class="form-control @error('email') is-invalid @enderror" id="login-email" name="email" placeholder="john@example.com" aria-describedby="login-email" tabindex="1" autofocus value="{{ old('email') }}" /> --}}
            <input type="text" class="form-control " id="login-email" name="email" placeholder="john@example.com" aria-describedby="login-email" tabindex="1" autofocus value="{{ old('email') }}" />           
            @if ($errors->has('email'))
              <span class="text-danger">
                  {{ $errors->first('email') }}
              </span>
            @endif
          </div>

          <div class="form-group">
            <div class="d-flex justify-content-between">
              <label for="login-password">Password</label>
              @if (Route::has('password.request'))
              <a href="{{ route('dashpassword.request') }}">
                <small>Forgot Password?</small>
              </a>
              @endif
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input type="password" class="form-control form-control-merge" id="login-password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
              <div class="input-group-append">
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
              </div>
            </div>
            @if ($errors->has('password'))
              <span class="text-danger">
                {{ $errors->first('password') }}
              </span>
            @endif
          </div>
          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" id="remember-me" name="remember" tabindex="3" {{ old('remember') ? 'checked' : '' }} />
              <label class="custom-control-label" for="remember-me"> Remember Me </label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block my-2" tabindex="4">Sign in</button>
        </form>


        {{-- <div class="divider my-2">
          <div class="divider-text">or</div>
        </div> --}}

        {{-- <div class="auth-footer-btn d-flex justify-content-center">
          <a href="javascript:void(0)" class="btn btn-facebook">
            <i data-feather="facebook"></i>
          </a>
          <a href="javascript:void(0)" class="btn btn-twitter white">
            <i data-feather="twitter"></i>
          </a>
          <a href="javascript:void(0)" class="btn btn-google">
            <i data-feather="mail"></i>
          </a>
          <a href="javascript:void(0)" class="btn btn-github">
            <i data-feather="github"></i>
          </a>
        </div> --}}
      </div>
    </div>
    <!-- /Login v1 -->
  </div>
</div>
@endsection
