@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.model_code.title'). ' ' .__('webCaption.edit.title')  )
@else
@section('title', __('webCaption.model_code.title').' '. __('webCaption.add.title') )
@endif

@section('content')
<form action="{{ route('masters.vehicle.model-code.store')}}" method="POST">
@csrf
<section >
  <div class="card">
    <div class="card-header">
			<h4 class="card-title">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			</svg>
			@if(isset($data->id) && !empty($data->id))
			{{__('webCaption.model_code.title'). ' ' .__('webCaption.edit.title')  }}
			@else
			{{  __('webCaption.model_code.title').' '. __('webCaption.add.title')}}
			@endif
			</h4>  
		</div>
		<hr class="m-0 p-0">
    <div class="card-body">
      <div class="row">
        
        <div class="col-lg-3 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.select  tooltip="{{__('webCaption.model.caption')}}"  label="{{__('webCaption.model.title')}}"  id="model_id" for="model_id" name="model_id" placeholder="{{__('webCaption.model.title')}}"  required="required" :optionData="$allmodel" editSelected="{{(isset($data->model_id) && ($data->model_id != null)) ? $data->model_id :''; }}" />
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.text tooltip="{{__('webCaption.model_code.caption')}}" label="{{__('webCaption.model_code.title')}}" maxlength="50" for="name"   name="name"  placeholder="{{ __('webCaption.model_code.title') }}" value="{{old('name', isset($data->name)?$data->name:'' )}}"  required="required" />
          </div>    
        </div>
        
        <div class="col-lg-3 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.select  tooltip="{{__('webCaption.select_parent.caption')}}"  label="{{__('webCaption.select_parent.title')}}"  id="" for="parent_id" name="parent_id" placeholder="{{__('webCaption.select_parent.title')}}"  required="" :optionData="$parent_data" editSelected="{{(isset($data->parent_id) && ($data->parent_id != null))?$data->parent_id : ''; }}" />
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.number tooltip="{{__('webCaption.length_cm.caption')}}" label="{{__('webCaption.length_cm.title')}}" maxlength="4" for="length" name="length"  placeholder="{{ __('webCaption.length_cm.title') }}" value="{{old('length', isset($data->length)?$data->length:'' )}}" required="" />
          </div>    
        </div>

      </div>
      <div class="row">
        
        <div class="col-lg-3 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.number tooltip="{{__('webCaption.width_cm.caption')}}" label="{{__('webCaption.width_cm.title')}}" maxlength="4" for="width" name="width"  placeholder="{{ __('webCaption.width_cm.title') }}" value="{{old('width', isset($data->width)?$data->width:'' )}}"  required="" />
          </div>    
        </div>
        
        <div class="col-lg-3 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.number tooltip="{{__('webCaption.height_cm.caption')}}" label="{{__('webCaption.height_cm.title')}}" maxlength="4" for="height" name="height"  placeholder="{{ __('webCaption.height_cm.title') }}" value="{{old('height', isset($data->height)?$data->height:'' )}}"  required="" />
          </div>    
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="form-group">
                <x-admin.form.label for="" value="{{__('webCaption.display.title')}}" class="" tooltip="{{__('webCaption.display.caption')}}" />
                  <div>
                      <div class="form-check form-check-inline">
                        <x-admin.form.inputs.radio for="Yes" tooltip="{{__('webCaption.yes.caption')}}"  class="border border-danger" name="display" label="{{__('webCaption.yes.title')}}" value="Yes"  required="required" 
                        checked="{{ (old('display') == 'Yes') || (!isset($data->id))  ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'Yes' ? 'checked=checked' :'' :'' }} " required="required" />&ensp;
                          
                        <x-admin.form.inputs.radio for="No" class="border border-danger" name="display" tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" value="No"  required="required"  checked="{{ old('display') == 'No' ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'No' ? 'checked=checked' :'' :'' }} " required="required" />&ensp;

                      </div>
                  </div>
            </div>
        </div>
      </div>       
    </div>
  </div>
  
    @if((isset($data->parent_id)) && ($data->parent_id == 0) )

          @php
           $activeSiteLanguages = (isset($activeSiteLanguages)) ? $activeSiteLanguages : null;
          @endphp
          {{-- //this is showing for data form master data translation  --}}
          <x-admin.site-language :activeSiteLanguages="$activeSiteLanguages" :data="$data->title_languages" name="title_languages" readonly="readonly" />
    @endif
  <div class="text-center">
    <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
      @if(isset($data->id))   <x-admin.form.buttons.update />  @else    <x-admin.form.buttons.create />   @endif
  </div>
</section>
</form>
@endsection

