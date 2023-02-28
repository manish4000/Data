

@props([
    'for',
    'label',
    'name',
    'placeholder',
    'data',
    'optionData',
    'oldValues',
    'required',
    'editSelected'
])

@php
$border ="";
    if($required == "required"){
        $border ="border:1px solid red;";
    }
@endphp

<div class="form-group">
    @if (isset($label)) <label for='{{ $for }}'>{{ $label }} </label> @endif 
    <select  class="select2-multiple" style="{{$border}}" data-autofill="true" multiple data-is-parent="false"  name="{{ $name }}" id="{{ $for }}" {{ $required }}>
        <option value="">Select</option>
        @if(isset($optionData) && count($optionData)>0)
            @foreach($optionData as $option)
                @php $sel = ''; @endphp
                @if(is_array($oldValues) && in_array( $option->value, $oldValues)) @php $sel = 'selected="selected"'; @endphp 
                @elseif(isset($editSelected) && is_array($editSelected) && in_array($option->value, $editSelected)) @php $sel = 'selected="selected"'; @endphp @endif
                <option value="{{$option->value}}" {{$sel}}>{{$option->name}}</option>
            @endforeach
        @endif
    </select>
</div>

@section('page-script')

<script>
    $('.select2-multiple').select2();
</script>
@endsection