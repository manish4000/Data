{{-- For submenu --}}
<ul class="menu-content">
  @if(isset($menu))

 
  @foreach($menu as $submenu)

  @php $sub_menu_url = (isset($submenu->url)) ? $submenu->url : '' ;  @endphp
  
     @if( Auth::user()->checkPermissions( $submenu->permissions ) )
     {{-- @if($submenu->show_in_sidebar) --}}
      @if( Auth::user()->checkPermissions( $submenu->id ) )
        <li  class="{{ ( ( $sub_menu_url === Request::path()) ||  (isset($activeUrl) && $activeUrl === $sub_menu_url) ) ? 'active' : '' }}" >
          <a href="{{isset($submenu->url) ? url($submenu->url):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'}}">
            @if(isset($submenu->icon))
            <i data-feather="{{$submenu->icon}}"> </i>
            @endif
            <span class="menu-item text-truncate"> {{__('webCaption.'.$submenu->slug.'.title')}}  </span>
          </a>
          @if (isset($submenu->submenu))
          @include('panels/submenu', ['menu' => $submenu->submenu])
          @endif
        </li>
      @endif 
     @endif  
  @endforeach
  @endif
</ul>
