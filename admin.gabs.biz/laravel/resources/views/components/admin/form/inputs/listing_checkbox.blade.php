{{-- this checkbox for listing with onclick method  --}}

@props([
    'label',
    'value',
    'customClass',
    'id',
    'onclick',
    'dataItemId',
    'dataUrl',
    'checked'
])

<div class="custom-control custom-checkbox custom-control-inline">
    <input class="custom-control-input" onclick="{{$onclick}}" id="{{$id}}"  data-itemId="{{$dataItemId}}" data-url="{{$dataUrl}}" type="checkbox" 
     value="{{$value}}"   {{$checked}}>
    <label  class="custom-control-label" for="{{$id}}"></label>
</div>