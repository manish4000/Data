@extends('dash/layouts/LayoutMaster')
 
    @section('content')
           <!-- Kick start -->
            <div class="card">

                @php
                   // dd(Auth::guard('dash')->user());    
                @endphp

                <div class="card-header text-center">
                    <h4 class="card-title  my-3 ">{{$message}}</h4>
                </div>

                <div class="card-body">
                </div>
            </div>
            <!--/ Kick start -->


    @endsection        