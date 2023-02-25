@extends('layouts/contentLayoutMaster')

@section('title', 'Profile')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-profile.css')) }}">
@endsection

@section('content')
<div id="user-profile">
  @include('content/components/company/profile/profile-header')
  <!-- profile info section -->
  <section id="profile-info">
    <div class="row">
      <div class="col-lg-12 col-12">
        <div class="card">
          <div class="card-body">
            <div class="row m-0 p-0">
              <div class="col-lg-3 col-12">
                @if(isset($data->logo_file) && !empty($data->logo_file))
                  <img src="{{'https://www.japanesecartrade.com/logo/'.$data->logo_file}}" class="rounded img-fluid" alt="Card image" />
                @else 
                  <img src="{{asset('images/portrait/small/avatar-s-2.jpg')}}" class="rounded img-fluid" alt="Card image" />
                @endif
              </div>
              <div class="col-lg-9 col-12">
                <h2 class="text-primary text-right">@isset($data->company_name) {{$data->company_name}} @endisset</h2>
              </div>
            </div> 
          </div>
        </div>  
      </div>   
    </div>

    <div class="row">
      <!-- left profile info section -->
      <div class="col-lg-3 col-12 order-2 order-lg-1">
        @include('content/components/company/profile/about-company')
      </div>
      <!--/ left profile info section -->

      <!-- center profile info section -->
      <div class="col-lg-6 col-12 order-1 order-lg-2">
        @include('content/components/company/profile/company-text')
        
      </div>
      <!--/ center profile info section -->

      <!-- right profile info section -->
      <div class="col-lg-3 col-12 order-3">
        @include('content/components/company/profile/latest-photos')
        @include('content/components/company/profile/contact-information')
        @if(Auth::user()->user_type == 'Company')
          @include('content/components/company/profile/staffs-block')
        @endif
      </div>
      <!--/ right profile info section -->
    </div>
    @include('content/components/company/profile/video-gallery')
    @include('content/components/company/profile/general-text')    
  </section>
</div>
@endsection
