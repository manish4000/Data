@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'checked',
    'required',
    'customClass'
])

@php
    $customClass = (isset($customClass)) ? $customClass : '';
@endphp

<div class="custom-control custom-checkbox d-inline ">
    <input   type="radio" name='{{ $name }}' class="custom-control-input {{$customClass}}" id="{{ $for }}" value="{{ $value }}" {{$checked}} >
    <label  class="custom-control-label" for="{{ $for }}">{{ $label }}</label>
</div>