@props([
    'name',
    'value',
])


<input type="hidden"  
@if(isset($name)) name='{{ $name }}' @endif            
    @if(isset($value))   value="{{$value}}"  @endif >
 
