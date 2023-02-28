{{-- For submenu --}}
<ul class="menu-content">

  @if(isset($menu))

    @foreach($menu as $submenu)

    @php $sub_menu_url = (isset($submenu->url)) ? $submenu->url :''; @endphp
    
      @if( Auth::guard('dash')->user()->checkPermissions( $submenu->id ) )
          <li class="{{ $sub_menu_url === Request::path() ? 'active' : '' }}" >
            <a href="{{isset($submenu->url) ? url($submenu->url):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'}}">
              @if(isset($submenu->icon))
              <i data-feather="{{$submenu->icon}}"></i>
              @endif
              <span class="menu-item text-truncate"> {{__('webCaption.'.$submenu->slug.'.title')}} </span>
            </a>
            @if (isset($submenu->submenu))
            @include('dash/panels/submenu', ['menu' => $submenu->submenu])
            @endif
          </li>
      @endif   
    @endforeach
  @endif
</ul>
