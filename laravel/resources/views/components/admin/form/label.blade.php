@props([
    'for',
    'value',
    'class',
    'tooltip'
])
<label class="{{ $class }}" style="height:20px" for='{{ $for }}' data-toggle="tooltip"  @if (isset($tooltip)) title="{{$tooltip}}" @endif >{{ ucwords($value)}} </label>
 