@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'checked',
    'required',
    'tooltip'
])

@php
$border ="";
    if($required == "required"){
        $border ="border-color:red";
    }
@endphp

<div class="custom-control custom-checkbox">
    <input style="{{$border}}"  type="radio" name='{{ $name }}' class="custom-control-input" id="{{ $for }}" value="{{ $value }}" {{$checked}} >
    <label style="{{$border}}"  @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  class="custom-control-label" for="{{ $for }}">
        {{ $label }}</label>
</div>