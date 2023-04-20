@props([
    'for',
    'label',
    'name',
    'value',
    'customClass',
    'checked',
    'tooltip'
])

<div class="custom-control custom-checkbox  custom-control-inline ">
    <input  type="checkbox" name="{{ $name }}" class="custom-control-input" @if(isset($for)) id="{{ $for }}" @endif  value="{{ $value }}" {{$checked}} >
    @if(isset($label))  <label @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"   class="custom-control-label" for="{{ $for }}" >{{ $label }} </label> @endif 
</div>