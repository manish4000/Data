@props([
    'for',
    'value',
    'class',
    'tooltip'
])

<label class="{{ $class }}" for='{{ $for }}'  data-toggle="tooltip"  @if (isset($tooltip)) title="{{$tooltip}}" @endif >{{ ucwords($value)}} </label>
 