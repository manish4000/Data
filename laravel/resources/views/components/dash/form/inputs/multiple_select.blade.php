

@props([
    'for',
    'label',
    'name',
    'placeholder',
    'data',
    'optionData',
    'oldValues',
    'required',
    'editSelected',
    'optionImg',
    'customClass',
    'onChange'
])

@php
$border ="";
    if($required == "required"){
        $border ="border:1px solid red;";
    }
    $customClass = (isset($customClass)) ? $customClass : '';
@endphp




<div class="form-group">

    @if (isset($label))
    <label 
         @if (isset($tooltip)) title="{{$tooltip}}"  @endif
         data-toggle="tooltip"    for='{{ $for }}'>{{ $label }}
         @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif 
    </label>
    @endif

    <select  class="select2 <?php echo  $customClass; ?>" data-autofill="true" multiple data-is-parent="false"  name="{{ $name }}" id="{{ $for }}" {{ $required }}
        @if(isset($onChange)) onchange="{{$onChange}}" @endif 
        >
        <option value="">Select</option>
        @if(isset($optionData) && count($optionData)>0)
            @foreach($optionData as $option)
                @php $sel = ''; @endphp
                @if(is_array($oldValues) && in_array( $option->value, $oldValues)) @php $sel = 'selected="selected"'; @endphp 
                @elseif(isset($editSelected) && is_array($editSelected) && in_array($option->value, $editSelected)) @php $sel = 'selected="selected"'; @endphp @endif
                <option value="{{$option->value}}" {{$sel}} title="@if(isset($optionImg)){{$optionImg}}/{{$option->logo}} @endif">{{$option->name}}</option>
            @endforeach
        @endif
    </select>
</div>

@push('script')
    <script>
        
    $(document ).ready(function() {
        $('.select2').select2({
            closeOnSelect: false,
        });
    });
        
    </script>
@endpush






{{-- <div class="form-group">
    @if (isset($label))
        <label 
             @if (isset($tooltip)) title="{{$tooltip}}"  @endif
             data-toggle="tooltip"    for='{{ $for }}'>{{ $label }}
             @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif 
        </label>
    @endif


    <select  class="select2"    name="{{ $name }}" id="{{ $for }}" {{ $required }} multiple="multiple" >
        @if(isset($optionData) && count($optionData) > 0)

            @foreach($optionData as $option)
            @php $sel = ''; @endphp

                @if(is_array($oldValues) && in_array( $option->value, $oldValues)) @php $sel = 'selected="selected"'; @endphp 
                @elseif( is_array($editSelected) && in_array($option->value, $editSelected)) @php $sel = 'selected="selected"'; @endphp @endif
                <option value="{{$option->value}}" {{$sel}} >{{$option->name}}</option>
            @endforeach
        @endif
    </select>
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
        
    $(document ).ready(function() {
        $('.select2').select2();
    });
        
    </script>
@endpush --}}