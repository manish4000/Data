@props([
    'iconClass',
    'value',
    'color',
    'id',
    'onClick'
])

@php
$color = (isset($color)) ? $color : '';
$value = (isset($value)) ? $value : '';
$iconClass = (isset($iconClass)) ? $iconClass : '';
@endphp
<button  type="button" class="btn {{$color}} mr-1"  @if(isset($id)) id="{{$id}}" @endif @if(isset($onClick)) onclick="{{$onClick}}" @endif> <i class="{{$iconClass}}"></i> {{$value}}  </button>