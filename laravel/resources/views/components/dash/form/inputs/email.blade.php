@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required',
    'maxlength',
    'class',
    'tooltip'
])

@php
$charLength =  (isset($value))? strlen($value) : 0;
@endphp


@if (isset($label)) <label for='{{ $for }}'>{{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size:14px;font-weight:bolder"> * </span>  @endif  </label> @endif

<div class="input-group">

    <input style=""   @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif  name='{{ $name }}' type="email"
    @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
    @if(isset($placeholder )) placeholder='{{ $placeholder }}'  @endif    
    @if(isset($required)) {{ $required }}  @endif 
    class='form-control'  {{$attributes}} value='{{ old($name, $value) }}' {{ $required }} oninput="emailValidationChecker('{{$for}}')">

    <div class="input-group-append">
      <span class="input-group-text" id="{{$for}}icon"></span>
    </div>

</div>
@if (isset($maxlength) && isset($for) )(<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}}) @endif

