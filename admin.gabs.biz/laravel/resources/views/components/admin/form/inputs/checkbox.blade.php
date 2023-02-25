@props([
    'for',
    'label',
    'name',
    'value',
    'customClass',
    'checked'
   
])

{{-- <div class="custom-control custom-checkbox {{ $customClass }}">
    <label class="custom-control-label" for="{{ $for }}">{{ $lable }}</label>
    <input type="checkbox" name='{{ $name }}' class="custom-control-input" id="{{ $for }}"  @if(isset($value)) value="{{$value}}" @endif checked>
</div> --}}

{{-- <label class="form-control-label" 
 @if(isset($for)) for="{{ $for }}"  @endif > 
 @if(isset($label)) {{ $label }}   @endif </label> --}}

{{-- <div class="custom-control  custom-control-inline"> --}}
    {{-- <input type="checkbox" class="" name="{{$name}}" @if(isset($for)) id="{{ $for }}" @endif @if(isset($value)) value="{{$value}}" @endif  @if(isset($checked)) {{$checked}} @endif>
    <label class="" for="{{$label}}">{{$label}}</label> --}}
    {{-- <input type="checkbox" name="{{ $name }}" @if(isset($for)) id="{{ $for }}" @endif @if(isset($value)) value="{{$value}}" @endif @if(isset($checked)) {{$checked}} @endif > @if(isset($label)) {{ $label }}   @endif  --}}
{{-- </div> --}}

<div class="custom-control custom-checkbox  custom-control-inline">
    <input  type="checkbox" name='{{ $name }}' class="custom-control-input" @if(isset($for)) id="{{ $for }}" @endif  value="{{ $value }}" {{$checked}} >
    @if(isset($label))  <label  class="custom-control-label" for="{{ $for }}" >{{ $label }} </label> @endif 
</div>