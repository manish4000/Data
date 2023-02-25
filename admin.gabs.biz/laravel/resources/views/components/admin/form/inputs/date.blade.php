@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value'
])

<div class="form-group">
    @if (isset($label)) <label @if (isset($for)) for='{{ $for }}'  @endif >{{ $label }} </label> @endif
    <input  
    @if (isset($for)) id='{{ $for }}' @endif 
    name='{{ $name }}'
    type="date" 
    class='form-control' 
    @if (isset($placeholder))   placeholder='{{ $placeholder }}' @endif  
    value='{{ old($name, $value) }}' >
</div>