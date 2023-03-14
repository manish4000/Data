@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required'
])

<div class="form-group">
    @if (isset($label)) <label @if (isset($for)) for='{{ $for }}'  @endif >{{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px; font-weight:bolder"> * </span>  @endif  </label> @endif
    <input  
    @if (isset($for)) id='{{ $for }}' @endif 
    name='{{ $name }}'
    type="date" 
    class='form-control' 
    @if (isset($placeholder))   placeholder='{{ $placeholder }}' @endif  
    value='{{ old($name, $value) }}' >
</div>