@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required',
    'readonly'
])

@php
$readonly = isset($readonly) ? $readonly : '';
@endphp

<div class="form-group  ">
    @if (isset($label)) <label @if (isset($for)) for='{{ $for }}'  @endif >{{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px; font-weight:bolder"> * </span>  @endif  </label> @endif
    <input  
    @if (isset($for)) id='{{ $for }}' @endif 
    name='{{ $name }}'
    type="date" 
    class='form-control flatpickr-basic' 
    @if (isset($placeholder))   placeholder='{{ $placeholder }}' @endif  
    value='{{ old($name, $value) }}' {{$readonly}} >
</div>
@if(isset($name)) 

<div class="m-0">
    @if($errors->has($name))
    <x-admin.form.form_error_messages message="{{ $errors->first($name) }}"  />
    @endif
</div>

@endif 