
    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow ">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">
                <li class="nav-item dropdown dropdown-language">
                    <a class="nav-link dropdown-toggle" id="dropdown-language" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="selected-language" id="default-lang"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-language" id="language-dropdown">
                      @if ($activeLanguageData)
                        @foreach ( $activeLanguageData as $language )
                          <a class="dropdown-item @php echo (app()->getLocale() == $language->alias ) ? 'active':''; @endphp" href="{{url('/lang/'.$language->alias)}}" data-language="{{ $language->alias }}">{{ $language->language_en }}</a>
                        @endforeach
                      @endif
                    </div>
                  </li>
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none">
                          <span class="user-name fw-bolder">{{Auth::guard('dash')->user()->name}}</span>
                          <span class="company-name">{{Auth::guard('dash')->user()->company->company_name}}</span>
                          <span class="user-status">{{Auth::guard('dash')->user()->role}}</span></div>
                          <span class="avatar"><img class="round" src="{{asset('assets/dash/assets/images/portrait/small/avatar-s-11.jpg')}}" alt="avatar" height="40" width="40">
                            <span class="avatar-status-online"></span>
                          </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        {{-- <a class="dropdown-item" href="#"><i class="me-50" data-feather="user"></i> Profile</a>
                        <a class="dropdown-item" href="#"><i class="me-50" data-feather="mail"></i> Inbox</a>
                        <a class="dropdown-item" href="#"><i class="me-50" data-feather="check-square"></i> Task</a>
                        <a class="dropdown-item" href="#"><i class="me-50" data-feather="message-square"></i> Chats</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="me-50" data-feather="settings"></i> Settings</a>
                        <a class="dropdown-item" href="#"><i class="me-50" data-feather="credit-card"></i> Pricing</a>
                        <a class="dropdown-item" href="#"><i class="me-50" data-feather="help-circle"></i> FAQ</a> --}}
                        <a class="dropdown-item" href="{{route('dashlogout')}}"><i class="me-50" data-feather="power"></i> Logout</a>
                        @if (Auth::guard('dash')->user()->can('company-gabs-billing-info'))	
                        <a class="dropdown-item" href="{{route('dashbilling-info')}}"> Billing info </a>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END: Header-->
<script type="text/javascript">  
    let Lang = document.getElementsByClassName("dropdown-item active");
    for (var i = 0; i < Lang.length; i++) {
      var activeLang = Lang[i].innerText;
    }
    document.getElementById('default-lang').innerHTML =activeLang;
</script>