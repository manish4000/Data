@props([
    'for',
    'label',
    'name',
    'placeholder',
    'value',
    'required',
    'maxlength',
    'class',
    'tooltip',
    'passwordGenerator'
])
@php

    $charLength =  (isset($value))? strlen($value) : 0;
    $passwordGenerator =  (isset($passwordGenerator) && $passwordGenerator == "true"  ) ? "true" : "false";
@endphp
@if (isset($label)) <label @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  for='{{ $for }}'>{{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif  </label> @endif

@if($passwordGenerator == 'true')
    <div class="input-group">
        <input style=""
            name='{{ $name }}'  
            @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif
            @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
            type="password"  
            class='{{$class}}' 
            placeholder='{{ $placeholder }}' {{$attributes}}  
            value='' {{ $required }}
        >
        <div class="input-group-append">
            <button class="btn btn-outline-primary" title="{{__('webCaption.generate_password.caption')}}"  data-toggle="tooltip"  id="gen" type="button"><i class="fa fa-key" aria-hidden="true"></i></button>
            <button class="btn btn-outline-primary" title="{{__('webCaption.show_password.caption')}}" data-toggle="tooltip"  onclick="pwdToggle('{{$for}}')" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
        </div>
    </div>
@else
    <div class="input-group">
        <input style=""
            name='{{ $name }}'  
            @if (isset($for)) id="{{$for}}" onkeyup="checkTextLimit('{{$for}}');"  @endif
            @if (isset($maxlength))  maxlength="{{$maxlength}}" @endif 
            type="password"  
            class='{{$class}}' 
            placeholder='{{ $placeholder }}' {{$attributes}}  
            value='' {{ $required }}
            >
            <div class="input-group-append">
                <button class="btn btn-outline-primary" title="{{__('webCaption.show_password.caption')}}" data-toggle="tooltip"  onclick="pwdToggle('{{$for}}')" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
            </div>
    </div>        
@endif

 @if (isset($maxlength) && isset($for) )(<span class="text-right" id="count_{{$for}}">{{$charLength}}</span>/{{$maxlength}}) @endif


 {{-- <div class="input-group">
    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
    <div class="input-group-append">
      <button class="btn btn-outline-secondary" type="button">Button</button>
      <button class="btn btn-outline-secondary" type="button">Button</button>
    </div>
</div> --}}







@push('script')
    <script>
        function checkTextLimit(id){
            let totalCount = $('#'+id).val();
            let len = 0;
            if(totalCount.length>0) len = totalCount.length;
            $('#count_'+id).html(len);
        }  
    </script>

    <script>

       
        let gen = document.getElementById("gen");


        /* To toggle password visibility*/
        function pwdToggle(id) {
            let pwd = document.getElementById(id);
                if (pwd.type == "text") pwd.type = "password";
                else pwd.type = "text";
            }



        gen.addEventListener("click", getPassword);

                    function handleSubmit() {
                    if (
                        pwd.value == "" ||
                        fname.value == "" ||
                        lname.value == "" ||
                        email.value == ""
                    ) {
                        formAlert.style.display = "block";
                        formAlert.innerHTML = "All fields are required";
                        return false;
                    } else if (validatePassword(pwd.value, fname.value, lname.value) == false) {
                        return false;
                    }
                    return true;
                    }

                function getPassword() {
                pwd.value = generatePassword();
                }

            
            /* To Generate the password*/
            function generatePassword() {
            let alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            let symbols = "%!@#$^&*-+=|\\(){}:\"';,?";
            let password = "";

            for (let i = 0; i < 3; i++) {
                let randomNumber = Math.floor(Math.random() * 10);
                let lowerCaseLetter = alphabet.charAt(Math.random() * 26).toLowerCase();
                let upperCaseLetter = alphabet.charAt(Math.random() * 26).toUpperCase();
                let specialChar = symbols.charAt(Math.random() * symbols.length);

                password += randomNumber + lowerCaseLetter + upperCaseLetter + specialChar;
            }
            return shuffle(password);
            }

            /* To shuffle the password string*/
            function shuffle(str) {
            let arr = str.split("");
            let n = arr.length;

            for (let i = 0; i < n; i++) {
                let j = Math.floor(Math.random() * n);

                let temp = arr[i];
                arr[i] = arr[j];
                arr[j] = temp;
            }
            return arr.join("");
            }

    </script>

@endpush
