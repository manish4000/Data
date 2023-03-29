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
    'iconClass',
    'iconColorClass'
  
])
@php

$border ="";
if($required == "required"){
    $border ="border:1px solid red;";
}

$iconClass = (isset($iconClass))? $iconClass : '';
$customClass = (isset($customClass))? $customClass : '';
$iconColorClass = (isset($iconColorClass))? $iconColorClass : '';
$charLength =  (isset($value))? strlen($value) : 0;

@endphp

{{-- @if (isset($label) && isset($for)) <label for='{{ $for }}'>{{ $label }} </label> @endif --}}
<div class="input-group">

    <div class="input-group-prepend">
      <span class="input-group-text {{$iconColorClass}}"><i class="{{$iconClass}} "></i></span>
    </div>

    <input 
    style="{{$border}}" 
    type="text" 
    @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif

    @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
    
    @if(isset($name)) name='{{ $name }}' @endif 
        
    class="form-control {{$customClass}}" 

    @if(isset($placeholder )) placeholder='{{ $placeholder }}'  @endif    
    @if(isset($required)) {{ $required }}  @endif    
    @if(isset($attributes)) {{$attributes}}  @endif            
    @if(isset($value))   value="{{$value}}"  @endif   />
</div>
@if (isset($maxlength) && isset($for) )(<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}}) @endif

    @if(isset($name)) 

        <div class="m-0">
            @if($errors->has($name))
            <x-admin.form.form_error_messages message="{{ $errors->first($name) }}"  />
            @endif
        </div>

    @endif 

