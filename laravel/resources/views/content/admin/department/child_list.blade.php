@foreach($items as $item)
    <?php   $child_checked_permission =  ( isset($data->permissions) &&  in_array($item->id ,$data->permissions))? 'checked' : '';  ?> 
    <ul>
        @if(count($item->menuChild) > 0)
            <li class="jstree-open">
                <label class="form-check-label">
                    <x-admin.form.inputs.checkbox  for="{{$item->id}}permission" name="permissions[]" label="{{ $item->title }}" 
                        checked="{{$child_checked_permission}}"  value="{{ $item->id }}"  customClass="form-check-input"  />
                </label>
                      @include('content.admin.department.child_list',['items' => $item->menuChild ])  
            </li>
        @else
            <li>
                <label class="form-check-label">
                    <x-admin.form.inputs.checkbox for="{{$item->id}}permission"  name="permissions[]" label="{{ $item->title }}" 
                        checked="{{$child_checked_permission}}"  value="{{ $item->id }}"  customClass="form-check-input"  />
                </label>
            </li>
        @endif
    </ul>
@endforeach

