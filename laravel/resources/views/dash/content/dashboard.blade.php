@extends('dash/layouts/LayoutMaster')
 
    @section('content')
           <!-- Kick start -->
            <div class="card">

                @php
                   // dd(Auth::guard('dash')->user());    
                @endphp

                <div class="card-header">
                    <h4 class="card-title">Kick start your next project 🚀</h4>
                </div>

                <div class="card-body">
                    <div class="card-text">
                        <p>
                            Getting start with your project custom requirements using a ready template which is quite difficult and time
                            taking process, Vuexy Admin provides useful features to kick start your project development with no efforts !
                        </p>
                        <ul>
                            <li>
                                Vuexy Admin provides you getting start pages with different layouts, use the layout as per your custom
                                requirements and just change the branding, menu &amp; content.
                            </li>
                            <li>
                                Every components in Vuexy Admin are decoupled, it means use use only components you actually need! Remove
                                unnecessary and extra code easily just by excluding the path to specific SCSS, JS file.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Kick start -->


    @endsection        