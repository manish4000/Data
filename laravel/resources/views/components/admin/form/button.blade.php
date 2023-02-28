@props([
    'type',
    'class',
    'value',
    'icon'

]);

<button  type="submit" class="btn btn-success mr-1"> @if(isset($data->id)) {{__('webCaption.update.title')}}  @else {{__('webCaption.create.title')}}   @endif </button>