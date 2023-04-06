@props([
    'for',
    'lable',
    'name',
    'placeholder',
    'value'
])

<div class="form-group">
    <label for='{{ $for }}'>{{ $lable }} </label>
    <input id='{{ $for }}' name='{{ $name }}' type="file" class='form-control' placeholder='{{ $placeholder }}' {{$attributes}} value='{{ old($name) }}' multiple>
</div>