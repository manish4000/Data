
@props([
    'for',
    'label',
    'name',
    'placeholder',
    'data',
    'optionData',
    'required',
    'id',
    'editSelected',
    'tooltip',
    'customClass',
    'onChange',
    'data_attr',
])

<?php  $customClass = (isset($customClass)) ? $customClass :''; 

    /* if(isset($editSelected)){
        echo $editSelected;
    } */

?>


<div class="form-label">
    @if (isset($label))
       <label  @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  @if(isset($for)) for='{{ $for }}' @endif > {{ $label }}
         @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif  </label>
    @endif

    <select  class=" <?php echo  $customClass ?> select2"  name="{{$name}}"
    
       @if(isset($for)) id="{{ $for }}" @endif   @if(isset($required)) {{ $required }} @endif
       @if(isset($onChange)) onchange="{{$onChange}}" @endif 
       >

            <option value="" data_attr=""> Select </option>
            @if(isset($optionData) && count($optionData) > 0)
            @foreach($optionData as $option)
                @php $sel = ''; @endphp
                @if( old($name) == $option->value) @php $sel = 'selected="selected"';  @endphp 
                @elseif( isset($editSelected) && $editSelected == $option->value ) @php $sel = 'selected="selected"'; @endphp @endif
               
                <option value="{{$option->value}}" {{$sel}}  @if(isset($data_attr)) data_attr="{{$option->$data_attr}}" @endif> {{$option->name}} </option>
            @endforeach
       @endif
    </select>
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
    $(document ).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush