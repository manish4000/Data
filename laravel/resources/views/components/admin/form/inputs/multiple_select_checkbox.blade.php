@props([
    'label',
    'value',
    'customClass',
    'id'
])
@php 
$customClass = (isset($customClass)) ? $customClass : '';


@endphp

<div class="custom-control  custom-checkbox custom-control-inline">
    <input class="custom-control-input {{$customClass}}"  type="checkbox"  id="{{$id}}" value="{{$value}}">
    <label  class="custom-control-label" for="{{$id}}"></label>
</div>
