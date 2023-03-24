@props([
    'iconClass',
    'value',
    'color'
])

@php
$color = (isset($color)) ? $color : '';
$value = (isset($value)) ? $value : '';
$iconClass = (isset($iconClass)) ? $iconClass : '';
@endphp
<button  type="submit" class="btn {{$color}} mr-1"> <i class="{{$iconClass}}"></i> {{$value}}  </button>