@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required',
    'maxlength',
    'class',
    'tooltip',
    'passwordGenerator'
])
@php

    $charLength =  (isset($value))? strlen($value) : 0;
    $passwordGenerator =  (isset($passwordGenerator) && $passwordGenerator == "true"  ) ? "true" : "false";
@endphp
@if (isset($label)) <label @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  for='{{ $for }}'>{{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif  </label> @endif

@if($passwordGenerator == 'true')
    <div class="input-group">
        <input style=""
            name='{{ $name }}'  
            @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif
            @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
            type="password"  
            class='{{$class}}' 
            placeholder='{{ $placeholder }}' {{$attributes}}  
            value='' {{ $required }}
        >
        <div class="input-group-append">
            <button class="btn btn-outline-primary" title="{{__('webCaption.generate_password.caption')}}"  data-toggle="tooltip" onclick="generate('{{$for}}')"  type="button"><i class="fa fa-key" aria-hidden="true"></i></button>
            <button class="btn btn-outline-primary" title="{{__('webCaption.show_password.caption')}}" data-toggle="tooltip"  onclick="pwdToggle('{{$for}}')" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
        </div>
    </div>
@else
    <div class="input-group">
        <input style=""
            name='{{ $name }}'  
            @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif
            @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
            type="password"  
            class='{{$class}}' 
            placeholder='{{ $placeholder }}' {{$attributes}}  
            value='' {{ $required }}
            >
            <div class="input-group-append">
                <button class="btn btn-outline-primary" title="{{__('webCaption.show_password.caption')}}" data-toggle="tooltip"  onclick="pwdToggle('{{$for}}')" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
            </div>
    </div>        
@endif

 @if (isset($maxlength) && isset($for) )(<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}}) @endif

