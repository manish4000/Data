@props([
    'id',
    'customClass',
])

@php
$customClass = (isset($customClass)) ? $customClass :'';
@endphp


<button  @if(isset($id))  id="{{$id}}" @endif  type="submit" class="btn btn-success {{$customClass}} mr-1"> <i class="fa fa-add"></i> {{__('webCaption.create.title')}}  </button>


