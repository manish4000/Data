
@extends('layouts/fullLayoutMaster')
@section('title', 'Login Page')
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
</div>
@endsection
