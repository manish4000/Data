@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required',
    'class'
])
@php
$border ="";
    if($required == "required"){
        $border ="border:1px solid red;";
    }
@endphp

@if (isset($label)) <label for='{{ $for }}'>{{ $label }} </label> @endif
 <input style="{{$border}}"  name='{{ $name }}' type="email" class='form-control' placeholder='{{ $placeholder }}' {{$attributes}} value='{{ old($name, $value) }}' {{ $required }}>
