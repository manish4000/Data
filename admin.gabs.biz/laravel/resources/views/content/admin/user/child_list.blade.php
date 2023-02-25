
@foreach($items as $item)
    <ul>
        @if(count($item->menuChild) > 0)
            <li class="jstree-open">
                <label class="form-check-label">
                    <x-admin.form.inputs.checkbox  for="{{$item->id}}permission" name="permissions[]" label="{{ $item->title }}" checked="{{ ( isset($user) && (!empty($item->permission_slug)) && $user->can($item->permission_slug)) ?'checked' :''; }}"  value="{{ $item->id }}"  customClass="form-check-input"  />
                </label>
                      @include('content.admin.user.child_list',['items' => $item->menuChild ])  
            </li>
        @else
            <li>
                <label class="form-check-label">
                    <x-admin.form.inputs.checkbox for="{{$item->id}}permission"  name="permissions[]" label="{{ $item->title }}" checked="{{ ( isset($user) && (!empty($item->permission_slug)) && $user->can($item->permission_slug)) ?'checked' :''; }}"  value="{{ $item->id }}"  customClass="form-check-input"  />
                </label>
            </li>
        @endif
    </ul>
@endforeach

