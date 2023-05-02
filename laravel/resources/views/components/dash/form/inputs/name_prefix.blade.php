
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

<div class="form-label">
    @if (isset($label))
       <label  @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  @if(isset($for)) for='{{ $for }}' @endif > {{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif  </label>
    @endif
    <select  class="select2"  name="{{$name}}"
    
       @if(isset($for)) id="{{ $for }}" @endif  {{ $required }}>

            <option value=""> Select </option>
     
            <option value="mr" @if(( old($name) == 'mr') || ($editSelected) == 'mr' ) selected @endif> {{__('webCaption.mr.title')}} </option>
            <option value="ms" @if( (old($name) == 'ms') || ($editSelected) == 'ms' ) selected @endif> {{__('webCaption.ms.title')}}</option>
            <option value="mrs" @if( (old($name) == 'mrs') || ($editSelected) == 'mrs' )  selected @endif > {{__('webCaption.mrs.title')}} </option>
      
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