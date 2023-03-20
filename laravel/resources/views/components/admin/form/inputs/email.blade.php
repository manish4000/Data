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
    'tooltip'
  
])
@php

$charLength =  (isset($value))? strlen($value) : 0;
@endphp

@if (isset($label) && isset($for)) <label  @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip" for='{{ $for }}'>{{ $label }}  @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif </label> @endif


<div class="input-group">

    <input
    type="email" 
    @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif

    @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
    
    @if(isset($name)) name='{{ $name }}' @endif 
        
    @if(isset($class)) class="abc {{$class}} "  @endif    

    @if(isset($placeholder )) placeholder='{{ $placeholder }}'  @endif    
    @if(isset($required)) {{ $required }}  @endif    
    @if(isset($attributes)) {{$attributes}}  @endif            
    @if(isset($value))   value="{{$value}}"  @endif oninput="checker()"   >

    <div class="input-group-append">
      <span class="input-group-text" id="icon"></span>
    </div>
</div>




{{-- <input
    type="email" 
    @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif

    @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
    
    @if(isset($name)) name='{{ $name }}' @endif 
        
    @if(isset($class)) class="abc {{$class}} "  @endif    

    @if(isset($placeholder )) placeholder='{{ $placeholder }}'  @endif    
    @if(isset($required)) {{ $required }}  @endif    
    @if(isset($attributes)) {{$attributes}}  @endif            
    @if(isset($value))   value="{{$value}}"  @endif oninput="checker()"   > --}}

    {{-- <p id="error-msg">Please Enter A Valid Email Id</p> --}}

@if (isset($maxlength) && isset($for) )(<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}}) @endif

@push('script')
<script>
    function checkTextLimit(id){
        let totalCount = $('#'+id).val();
        let len = 0;
        if(totalCount.length>0) len = totalCount.length;
        $('#count_'+id).html(len);
    }  
</script>

<script type="text/javascript">

    let emailId = document.getElementById("{{$for}}");
    let errorMsg = document.getElementById("error-msg");
    let icon = document.getElementById("icon");
    let mailRegex = /^[a-zA-Z][a-zA-Z0-9\-\_\.]+@[a-zA-Z0-9]{2,}\.[a-zA-Z0-9]{2,}$/;
    
    function checker(){
        icon.style.display="inline-block";
        if(emailId.value.match(mailRegex)){
            icon.innerHTML = '<i class="fas fa-check-circle"></i>';
            icon.style.color = '#2ecc71';
            errorMsg.style.display = 'none';
            emailId.style.border = '2px solid #2ecc71';
        }
        else if(emailId.value == ""){
            icon.style.display = 'none';
            errorMsg.style.display = 'none';
            emailId.style.border = '2px solid #d1d3d4';
        }
        else{
            icon.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
            icon.style.color = '#ff2851';
            errorMsg.style.display = 'block';
            emailId.style.border = '2px solid #ff2851';
        }
    
    }
    </script>

@endpush