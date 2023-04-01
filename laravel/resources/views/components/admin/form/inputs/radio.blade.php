@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'checked',
    'required',
    'tooltip',
    'customClass'
])

@php
$customClass = (isset($customClass)) ? $customClass : '';
@endphp


<div class="custom-control custom-checkbox">
    <input   type="radio" name='{{ $name }}' class="custom-control-input {{$customClass}}" id="{{ $for }}" value="{{ $value }}" {{$checked}} >
    <label   @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  class="custom-control-label" for="{{ $for }}">
        {{ $label }}</label>
</div>