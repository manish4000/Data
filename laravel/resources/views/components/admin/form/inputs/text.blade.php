@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required',
    'customClass',
    'maxlength',
    'attributes',
    'tooltip',
    'readonly'
  
])
@php

$charLength =  (isset($value))? strlen($value) : 0;
$customClass = isset($customClass) ? $customClass : '';
$readonly = isset($readonly) ? $readonly : '';
@endphp

@if (isset($label) && isset($for)) 
  <label  @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip" for='{{ $for }}'>{{ $label }}  @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif </label>
@endif
<input
    type="text" 
    @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif

    @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
    
    @if(isset($name)) name='{{ $name }}' @endif 
        
     class="form-control abc {{$customClass}}"     

    @if(isset($placeholder )) placeholder='{{ $placeholder }}'  @endif    
    @if(isset($required)) {{ $required }}  @endif    
    @if(isset($attributes)) {{$attributes}}  @endif            
    @if(isset($value))   value="{{$value}}"  @endif {{$readonly}}  >

@if (isset($maxlength) && isset($for) )(<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}}) @endif

@if(isset($name)) 

<div class="m-0">
    @if($errors->has($name))
    <x-admin.form.form_error_messages message="{{ $errors->first($name) }}"  />
    @endif
</div>

@endif 
