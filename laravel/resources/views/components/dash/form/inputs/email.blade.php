@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required',
    'class'
])



@if (isset($label)) <label for='{{ $for }}'>{{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size:14px;font-weight:bolder"> * </span>  @endif  </label> @endif
 <input style=""  name='{{ $name }}' type="email" class='form-control' placeholder='{{ $placeholder }}' {{$attributes}} value='{{ old($name, $value) }}' {{ $required }}>
