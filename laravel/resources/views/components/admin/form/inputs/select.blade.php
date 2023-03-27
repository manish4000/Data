
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
    'customClass'
])

<?php  $customClass = (isset($customClass)) ? $customClass :''; ?>

<div class="form-label">
    @if (isset($label))
       <label  @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  @if(isset($for)) for='{{ $for }}' @endif > {{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif  </label>
    @endif

    <select  class=" <?php echo  $customClass ?> select2"  name="{{$name}}"
    
       @if(isset($for)) id="{{ $for }}" @endif  {{ $required }}>

              <option value=""> Select </option>
          @if(isset($optionData) && count($optionData) > 0)
            @foreach($optionData as $option)
                @php $sel = ''; @endphp
                @if( old($name) == $option->value ) @php $sel = 'selected="selected"';  @endphp 
                @elseif( isset($editSelected) && $editSelected == $option->value ) @php $sel = 'selected="selected"'; @endphp @endif
                <option value="{{$option->value}}" {{$sel}}  > {{$option->name}} </option>
            @endforeach
       @endif
    </select>
</div>


@push('script')

<script>
    $(document ).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush