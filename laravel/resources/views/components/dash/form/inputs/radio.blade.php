@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'checked',
    'required'
])

@php
$border ="";
    if($required == "required"){
        $border ="border-color:red";
    }
@endphp

<div class="form-check form-check-inline">
    <input style="{{$border}}"  type="radio" name='{{ $name }}' class="custom-control-input" id="{{ $for }}" value="{{ $value }}" {{$checked}} >
    <label style="{{$border}}"  class="custom-control-label" for="{{ $for }}">{{ $label }}</label>
</div>