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
$border ="";
    if($required == "required"){
        $border ="border:1px solid red;";
    }
    $charLength =  (isset($value))? strlen($value) : 0;
@endphp
@if (isset($label)) <label @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  for='{{ $for }}'>{{ $label }} </label> @endif
<input style="{{$border}}" 
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
