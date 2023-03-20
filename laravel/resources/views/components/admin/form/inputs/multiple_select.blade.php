

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
    @if (isset($label)) <label  @if (isset($tooltip)) title="{{$tooltip}}"  @endif data-toggle="tooltip"    for='{{ $for }}'>{{ $label }} @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif  </label> @endif
    <select  class="select2-multiple"  data-autofill="true" multiple data-is-parent="false"  name="{{ $name }}" id="{{ $for }}" {{ $required }}>
        @if(isset($optionData) && count($optionData) > 0)
            @foreach($optionData as $option)
                @php $sel = ''; @endphp
                @if(is_array($oldValues) && in_array( $option->value, $oldValues)) @php $sel = 'selected="selected"'; @endphp 
                @elseif(isset($editSelected) && is_array($editSelected) && in_array($option->value, $editSelected)) @php $sel = 'selected="selected"'; @endphp @endif
                <option value="{{$option->value}}" {{$sel}}>{{$option->name}}</option>
            @endforeach
        @endif
    </select>
</div>

@push('script')
    <script>
        $('.select2-multiple').select2();
    </script>
@endpush