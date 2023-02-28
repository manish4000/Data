@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required',
    'class',
    'maxlength',
    'attributes',
    'iconClass',
    'iconColorClass'
  
])
@php

$border ="";
if($required == "required"){
    $border ="border:1px solid red;";
}

$iconClass = (isset($iconClass))? $iconClass : '';
$iconColorClass = (isset($iconColorClass))? $iconColorClass : '';
$charLength =  (isset($value))? strlen($value) : 0;
@endphp

{{-- @if (isset($label) && isset($for)) <label for='{{ $for }}'>{{ $label }} </label> @endif --}}
<div class="input-group">

    <div class="input-group-prepend">
      <span class="input-group-text {{$iconColorClass}}"><i class="{{$iconClass}} "></i></span>
    </div>

    <input 
    style="{{$border}}" 
    type="text" 
    @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif

    @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
    
    @if(isset($name)) name='{{ $name }}' @endif 
        
    @if(isset($class)) class="form-control"  @endif    

    @if(isset($placeholder )) placeholder='{{ $placeholder }}'  @endif    
    @if(isset($required)) {{ $required }}  @endif    
    @if(isset($attributes)) {{$attributes}}  @endif            
    @if(isset($value))   value="{{$value}}"  @endif   />
</div>
@if (isset($maxlength) && isset($for) )(<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}}) @endif



{{-- 


@if (isset($label) && isset($for)) <label for='{{ $for }}'>{{ $label }} </label> @endif
<input 
    style="{{$border}}" 
    type="text" 
    @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif

    @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
    
    @if(isset($name)) name='{{ $name }}' @endif 
        
    @if(isset($class)) class="abc {{$class}} "  @endif    

    @if(isset($placeholder )) placeholder='{{ $placeholder }}'  @endif    
    @if(isset($required)) {{ $required }}  @endif    
    @if(isset($attributes)) {{$attributes}}  @endif            
    @if(isset($value))   value="{{$value}}"  @endif   >

@if (isset($maxlength) && isset($for) )(<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}}) @endif --}}

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