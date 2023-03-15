@props([
    'id',
    'name',
    'url',
    'action'
])

<span type="submit" class="text-info" onclick="deleteSingleData('{{$id}}','{{$name}}' ,'{{$url}}')"><i class="fa fa-key " title="{{__('webCaption.login.title')}}"  data-toggle="tooltip"  ></i></span>
<form method="post" action="{{$action}}" id="delete_form_{{$id}}" >
    @csrf
</form>