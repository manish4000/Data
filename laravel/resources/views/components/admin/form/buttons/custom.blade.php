@props([
    'iconClass',
    'value',
    'color'
])

<button  type="button" class="btn {{$color}} mr-1"> <i class="{{$iconClass}}"></i> {{$value}}  </button>