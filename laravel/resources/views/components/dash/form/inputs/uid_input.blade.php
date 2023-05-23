@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required',
    'maxlength',
    'customClass',
    'tooltip'

])
@php
    $charLength =  (isset($value))? strlen($value) : 0;
    $value =  (isset($value))? $value : 0;
    $customClass = (isset($customClass))? $customClass : '';
   
    
@endphp

@if (isset($label)) <label @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  for='{{ $for }}'>{{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif  </label> @endif

@if (isset($maxlength) && isset($for) )
        <div class="character-counter-div">
        (<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}})
        </div>
@endif

    <div class="input-group">
        
        <input style=""
            name='{{ $name }}'  
            @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif
            @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
            type="password"  
            class='form-control {{$customClass}}' 
            placeholder='{{ $placeholder }}' {{$attributes}}  
            value='{{$value}}' {{ $required }}
        >
        <div class="input-group-append">
            <button class="btn btn-outline-primary"   data-toggle="tooltip" onclick="generateUid('{{$for}}')"  type="button"><i class="fa fa-key" aria-hidden="true"></i></button>
            <button class="btn btn-outline-primary" title="{{__('webCaption.show_uid.caption')}}" data-toggle="tooltip"  onclick="uidToggle('{{$for}}', this.id)" id="eye_main_{{$for}}" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
        </div>
    </div>


@if(isset($name)) 

    <div class="m-0">
        @if($errors->has($name))
        <x-dash.form.form_error_messages message="{{ $errors->first($name) }}"  />
        @endif
    </div>

@endif 

@push('script')

<script>

function generateUid(id){
    let gen_uid = document.getElementById(id);
    let uid = generateUidValue();
    $.ajax({    
        type: "POST",
        url: "{{route('dashmembers.check-uid-exist')}}",
        data: { uid:uid },
        success: function(data) {
                if(data.result.status == true){
                    generateUid(id);
                }else{
                    gen_uid.value = generateUidValue();
                }
        }
    });  
}

/* To Generate the password*/
function generateUidValue() {
    let alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let symbols = "1234567890";
    let uid = "";

    for (let i = 0; i < 3; i++) {
        let upperCaseLetter = alphabet.charAt(Math.random() * 26).toUpperCase();
        uid +=  upperCaseLetter;
    }

    for (let i = 0; i < 3; i++) {
        let specialChar = symbols.charAt(Math.random() * symbols.length);
        uid +=  specialChar;
    }

    return uid;

}

</script>
@endpush