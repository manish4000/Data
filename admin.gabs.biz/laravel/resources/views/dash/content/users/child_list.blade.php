
@foreach($items as $item)
    @if (Auth::guard('dash')->user()->can($item->permission_slug))
        <ul>
            @if(count($item->menuChild) > 0)
                <li class="jstree-open">
                   
                        <x-dash.form.inputs.checkbox name="permissions[]"  for="{{$item->id}}permission"   label="{{ $item->title }}" value="{{ $item->id }}" checked="{{( isset($user) && (!empty($permission->permission_slug)) && $user->can($item->permission_slug)) ? 'checked' :''; }}"     customClass="form-check-input"    />													
                    
                        @include('dash.content.users.child_list',['items' => $item->menuChild ])  
                </li>
            @else
                <li class="jstree-open">
                    
                        <x-dash.form.inputs.checkbox name="permissions[]"  for="{{$item->id}}permission" label="{{ $item->title }}" value="{{ $item->id }}"  checked="{{( isset($user) && (!empty($permission->permission_slug)) && $user->can($item->permission_slug)) ? 'checked' :''; }}"  customClass="form-check-input"  />													
                    
                </li>
            @endif
        </ul>
    @endif
@endforeach

