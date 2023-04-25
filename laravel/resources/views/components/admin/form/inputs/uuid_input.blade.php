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
            value='' {{ $required }}
        >
        <div class="input-group-append">
            <button class="btn btn-outline-primary" title="{{__('webCaption.uuid.caption')}}"  data-toggle="tooltip" onclick="generateUuid('{{$for}}')"  type="button"><i class="fa fa-key" aria-hidden="true"></i></button>
            <button class="btn btn-outline-primary" title="{{__('webCaption.show_uuid.caption')}}" data-toggle="tooltip"  onclick="uuidToggle('{{$for}}')" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
        </div>
    </div>


@if(isset($name)) 

    <div class="m-0">
        @if($errors->has($name))
        <x-admin.form.form_error_messages message="{{ $errors->first($name) }}"  />
        @endif
    </div>

@endif 

@push('script')

<script>

function generateUuid(id){
    let gen_uuid = document.getElementById(id);
    let uuid = generateUuidValue();
    $.ajax({    
        type: "POST",
        url: "{{route('company.check-uuid-exist')}}",
        data: { uuid:uuid },
        success: function(data) {
                if(data.result.status == true){
                    generateUuid(id);
                }else{
                    gen_uuid.value = generateUuidValue();
                }
        }
    });
   
}

/* To Generate the password*/
function generateUuidValue() {
    let alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let symbols = "1234567890";
    let uuid = "";

    for (let i = 0; i < 3; i++) {
        let upperCaseLetter = alphabet.charAt(Math.random() * 26).toUpperCase();
        uuid +=  upperCaseLetter;
    }

    for (let i = 0; i < 3; i++) {
        let specialChar = symbols.charAt(Math.random() * symbols.length);
        uuid +=  specialChar;
    }

    return uuid;

}

</script>
@endpush