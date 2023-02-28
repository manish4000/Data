@props([
    'url',
])

<button type="button" @if(isset($url)) onclick="deleteMultiple('{{$url}}')" @endif data-toggle="tooltip"  data-placement="left" title="{{__('webCaption.delete_multiple.caption')}}"  class="btn btn-outline-danger" > <i class="fa fa-trash"></i> {{__('webCaption.delete_multiple.title')}}</button>