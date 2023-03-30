
@props([
    'for',
    'label',
    'name',
    'placeholder',
    'data',
    'tooltip',
    'optionData',
    'oldValues',
    'required',
    'editSelected'
])



<div class="form-group">
    @if (isset($label))
        <label 
             @if (isset($tooltip)) title="{{$tooltip}}"  @endif
             data-toggle="tooltip"    for='{{ $for }}'>{{ $label }}
             @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif 
        </label>
    @endif


    <select  class="select2"    name="{{ $name }}" id="{{ $for }}" {{ $required }} multiple="multiple">

   
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
@endpush