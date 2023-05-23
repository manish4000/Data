        
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
    'disabled',
    'modelData'
])

<?php  $customClass = (isset($customClass)) ? $customClass :''; 

    $disabled = isset($disabled) ? $disabled : '';

?>


<div>
    @if (isset($label))
       <label  @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip"  @if(isset($for)) for='{{ $for }}' @endif > {{ $label }}
         @if(isset($required) && !empty($required)) <span class="text-danger" style="font-weight: bolder"> * </span>  @endif  </label>
    @endif

    <div class="input-group">
        <div class="form-outline">
            <select  class=" <?php echo  $customClass ?> select2"  name="{{$name}}"
            
            @if(isset($for)) id="{{ $for }}" @endif   @if(isset($required)) {{ $required }} @endif
            @if(isset($onChange)) onchange="{{$onChange}}" @endif  {{$disabled}}
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
        <div class="float-right input-group-append" data-toggle="tooltip" data-placement="top" title="Click on + button to Add New Vehicle Type.">
            <button class="btn bg-primary text-white" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd"  type="button" onclick="___openRightPanelModal('Vehicle Type', 'Types', 'type_id', true);">+</button>
        </div>
    </div>

</div>

@if(isset($name)) 
<div class="m-0">
    @if($errors->has($name))
    <x-dash.form.form_error_messages message="{{ $errors->first($name) }}"  />
    @endif
</div>
@endif 


<!-- End Offcanvas -->
<div class="offcanvas-end-example">
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasEndLabel" class="offcanvas-title">@if(isset($modelData['heading'])) {{$modelData['heading']}}  @endif</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body  mx-0 flex-grow-0">

          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <x-dash.form.inputs.text tooltip="{{__('webCaption.rating.caption')}}" label="{{__('webCaption.rating.title')}}" maxlength="50" for="name"   name="name"  placeholder="{{ __('webCaption.rating.title') }}" value="{{old('name', isset($data->name)?$data->name:'' )}}"  required="required" />
                </div>    
              </div>
      
              
              <div class="col-12">
                <div class="form-group">
                  <x-dash.form.inputs.select  tooltip="{{__('webCaption.select_parent.caption')}}"  label="{{__('webCaption.select_parent.title')}}"  id="" for="parent_id" name="parent_id" placeholder="{{__('webCaption.select_parent.title')}}"  required="" :optionData="[]" editSelected="" />
                </div>
              </div>
      
              <div class="col-12">
                  <div class="form-group">
                      <x-dash.form.label for="" value="{{__('webCaption.display.title')}}" class="" tooltip="{{__('webCaption.display.caption')}}" />
                         <div>
                            <div class="form-check form-check-inline">
                              <x-dash.form.inputs.radio for="Yes" tooltip="{{__('webCaption.yes.caption')}}"  class="border border-danger" name="display" label="{{__('webCaption.yes.title')}}" value="Yes"  required="required" 
                              checked="{{ (old('display') == 'Yes') || (!isset($data->id))  ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'Yes' ? 'checked=checked' :'' :'' }} " required="required" />&ensp;
                                
                              <x-dash.form.inputs.radio for="No" class="border border-danger" name="display" tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" value="No"  required="required"  checked="{{ old('display') == 'No' ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'No' ? 'checked=checked' :'' :'' }} " required="required" />&ensp;
      
                            </div>
                          </div>
                  </div>
              </div>
            </div>       
          </div>

          <div class="row mb-2 text-center">
            <div class="col-12">
                  <div class="form-group ">
                  <input type="hidden" name="id" value="@if(isset($user->id) && !empty($user->id)){{$user->id}}@endif" />
                     <x-dash.form.buttons.create/>
                 </div>
                 
             </div>
          </div>

            
        </div>
    </div>
</div>
<!--/ End Offcanvas-->



@push('script')
<script>
    $(document ).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush
   