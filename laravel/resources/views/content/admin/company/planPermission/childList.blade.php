@foreach($items as $item)
    <ul>
        @if(count($item->menuChild) > 0)
            <li class="jstree-open">
                {{-- <label class="form-check-label">
                    <input class="form-check-input" value="{{ $item->id }}" type="checkbox" name="permissions[{{$plan_id}}][]" @php echo (isset($checked_permission) && in_array($item->id,$checked_permission))?'checked':'';  @endphp > {{ $item->title }}
                </label> --}}

                <x-admin.form.inputs.checkbox  for="{{$item->id}}{{$plan_id}}sub" name="permissions[{{$plan_id}}][]" label="{{ $item->title }}" checked="{{( isset($checked_permission) && in_array($item->id,$checked_permission) )?'checked' :''; }}"  value="{{ $item->id }}"  customClass="form-check-input"  />

                @if($checkedPermission) 
                    @include('content.admin.company.planPermission.childList',['items' => $item->menuChild, 'user' => $user,'plan_id'=> $plan_id ,'checked_permission' => $checkedPermission->permissions ])
                @else
                    @include('content.admin.company.planPermission.childList',['items' => $item->menuChild, 'user' => $user,'plan_id'=> $plan_id  ])
                @endif
            </li>
        @else
            <li>
                {{-- <label class="form-check-label">
                    <input class="form-check-input" value="{{ $item->id }}" type="checkbox" name="permissions[{{$plan_id}}][]"  @php echo (isset($checked_permission) && in_array($item->id,$checked_permission))?'checked':'';  @endphp > {{ $item->title }}
                </label> --}}
                <x-admin.form.inputs.checkbox  for="{{$item->id}}{{$plan_id}}sub" name="permissions[{{$plan_id}}][]" label="{{ $item->title }}" checked="{{( isset($checked_permission) && in_array($item->id,$checked_permission) )?'checked' :''; }}"  value="{{ $item->id }}"  customClass="form-check-input"  />
            </li>
        @endif
    </ul>
@endforeach

