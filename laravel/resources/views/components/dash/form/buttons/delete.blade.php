@props([
    'id',
    'name',
    'url',
    'action'
])

<span type="submit" onclick="deleteSingleData('{{$id}}','{{$name}}' ,'{{$url}}')"><i class="text-danger fa fa-archive" title="{{__('webCaption.delete.title')}}"  data-toggle="tooltip"  ></i></span>
<form method="post" action="{{$action}}" id="delete_form_{{$id}}" >
@csrf
</form>