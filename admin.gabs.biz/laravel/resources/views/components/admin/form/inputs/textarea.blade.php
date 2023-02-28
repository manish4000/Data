@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'attributes',
    'maxlength',
    'class',
    'required',
    'tooltip'
])
@php
$charLength =  (isset($value))? strlen($value) : 0;
@endphp

@if (isset($label) && isset($for)) <label @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  for='{{ $for }}'>{{ $label }} </label> @endif
<textarea 

    @if(isset($class)) class="{{$class}}"  @endif    
    @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif
    @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
    @if(isset($name)) name='{{ $name }}' @endif 

    @if(isset($attributes)) {{$attributes}}  @endif 
     rows="3" 
     @if(isset($placeholder )) placeholder='{{ $placeholder }}'  @endif  
  
     @if(isset($required)) {{ $required }}  @endif  >{{ old($name, $value) }}</textarea>
    @if (isset($maxlength) && isset($for) )(<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}}) @endif    

    @section('inner-script')
    <script>
        $(function() {
            let val = $("#{{$for}}").val();
            $('#count_{{$for}}').html(val.length);
        });

        function checkTextLimit(id){
            let totalCount = $('#'+id).val();
          
            let len = 0;
            if(totalCount.length>0) len = totalCount.length;
            $('#count_'+id).html(len);
        }  
    </script>
    
    @endsection