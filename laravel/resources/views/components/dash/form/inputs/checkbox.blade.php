@props([
    'for',
    'label',
    'name',
    'value',
    'customClass',
    'checked',
    'labelClass'
])


<div class="form-check form-check-inline">
    <input  type="checkbox" name='{{ $name }}' class="form-check-input " @if(isset($for)) id="{{ $for }}" @endif
         @if(isset($value)) value="{{$value}}" @endif @if(isset($checked)) {{$checked}} @endif >
         @if(isset($label))  <label class="form-check-label  @if(isset($labelClass)) {{$labelClass}} @endif " @if(isset($for)) for="" @endif > {{ $label }} </label>   @endif 
</div>
