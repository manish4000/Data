@props([
    'iconClass',
    'value',
    'color',
    'id'
])

@php
$color = (isset($color)) ? $color : '';
$value = (isset($value)) ? $value : '';
$iconClass = (isset($iconClass)) ? $iconClass : '';
@endphp
<button  type="submit" class="btn {{$color}} mr-1"  @if(isset($id)) id="{{$id}}" @endif  > <i class="{{$iconClass}}"></i> {{$value}}  </button>