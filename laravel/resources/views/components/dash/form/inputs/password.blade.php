@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required',
    'maxlength',
    'customClass',
    'tooltip',
    'passwordGenerator'
])
@php

    $charLength =  (isset($value))? strlen($value) : 0;
    $passwordGenerator =  (isset($passwordGenerator) && $passwordGenerator == "true"  ) ? "true" : "false";
    $customClass = (isset($customClass))? $customClass : '';
@endphp
@if (isset($label)) <label @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  for='{{ $for }}'>{{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif  </label> @endif

@if (isset($maxlength) && isset($for) )
<div class="character-counter-div">
(<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}})
</div>
@endif


@if($passwordGenerator == 'true')
    <div class="input-group">
        <input style=""
            name='{{ $name }}'  
            @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif
            @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
            type="password"  
            class='form-control {{$customClass}}' 
            placeholder='{{ $placeholder }}' {{$attributes}}  
            value='' {{ $required }}
        >
        <div class="input-group-append">
            <button class="btn btn-outline-primary" title="{{__('webCaption.generate_password.caption')}}"  data-toggle="tooltip" onclick="generate('{{$for}}')"  type="button"><i class="fa fa-key" aria-hidden="true"></i></button>
            <button class="btn btn-outline-primary" title="{{__('webCaption.show_password.caption')}}" data-toggle="tooltip"  onclick="pwdToggle('{{$for}}', this.id)" id="eye_main_{{$for}}" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
        </div>
    </div>
@else
    <div class="input-group">
        <input style=""
            name='{{ $name }}'  
            @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif
            @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
            type="password"  
            class='form-control {{$customClass}}' 
            placeholder='{{ $placeholder }}' {{$attributes}}  
            value='' {{ $required }}
            >
            <div class="input-group-append">
                <button class="btn btn-outline-primary" title="{{__('webCaption.show_password.caption')}}" data-toggle="tooltip"  onclick="pwdToggle('{{$for}}', this.id)" id="eye_confirm_{{$for}}" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
            </div>
    </div>        
@endif



@if(isset($name)) 

    <div class="m-0">
        @if($errors->has($name))
        <x-admin.form.form_error_messages message="{{ $errors->first($name) }}"  />
        @endif
    </div>

@endif 

