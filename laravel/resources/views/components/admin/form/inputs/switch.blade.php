@props([
    'for',
    'lable',
    'name',
    'value'
])
<div class="custom-control custom-control-primary custom-switch">
    <p class="mb-50">Primary</p>
    <input type="checkbox" name='{{ $name }}' value="{{ $value }}" class="custom-control-input" id="{{ $for }}" checked="">
    <label class="custom-control-label" for="{{ $for }}"></label>
</div>

@if(isset($name)) 

<div class="m-0">
    @if($errors->has($name))
    <x-admin.form.form_error_messages message="{{ $errors->first($name) }}"  />
    @endif
</div>

@endif 
