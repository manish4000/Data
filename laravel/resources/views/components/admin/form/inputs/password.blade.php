@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required',
    'maxlength',
    'class',
    'tooltip'
])
@php

    $charLength =  (isset($value))? strlen($value) : 0;
@endphp
@if (isset($label)) <label @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  for='{{ $for }}'>{{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 18px"> * </span>  @endif  </label> @endif
<input style=""
      name='{{ $name }}'  
      @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif
      @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
      type="password"  
      class='{{$class}}' 
      placeholder='{{ $placeholder }}' {{$attributes}}  
      value='' {{ $required }}
 >
 @if (isset($maxlength) && isset($for) )(<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}}) @endif

@section('inner-script')
    <script>
        function checkTextLimit(id){
            let totalCount = $('#'+id).val();
            let len = 0;
            if(totalCount.length>0) len = totalCount.length;
            $('#count_'+id).html(len);
        }  
    </script>

@endsection
