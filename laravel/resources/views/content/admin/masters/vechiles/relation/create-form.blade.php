@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.relation.title'). ' ' .__('webCaption.edit.title')  )
@else
@section('title', __('webCaption.relation.title').' '. __('webCaption.add.title') )
@endif

@section('content')
<form action="{{ route('masters.vehicle.relation.store')}}" method="POST">
@csrf
<section >
  <div class="card">
    <div class="card-header">
			<h4 class="card-title">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			</svg>
			@if(isset($data->id) && !empty($data->id))
			{{__('webCaption.relation.title'). ' ' .__('webCaption.edit.title')  }}
			@else
			{{  __('webCaption.relation.title').' '. __('webCaption.add.title')}}
			@endif
			</h4>  
		</div>
		<hr class="m-0 p-0">
    <div class="card-body">
      <div class="row">
     

        <div class="col-lg-4 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.select  tooltip="{{__('webCaption.type.caption')}}"  label="{{__('webCaption.type.title')}}"  id="" for="type_id" name="type_id" required="" :optionData="$types" editSelected="{{(isset($data->type_id) && ($data->type_id != null))?$data->type_id :''; }}" />
           </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.select  tooltip="{{__('webCaption.subtype.caption')}}"  label="{{__('webCaption.subtype.title')}}"  id="" for="subtype_id" name="subtype_id"  required="" :optionData="$subtypes" editSelected="{{(isset($data->subtype_id) && ($data->subtype_id != null))?$data->subtype_id :''; }}" />
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.select  tooltip="{{__('webCaption.make.caption')}}"  label="{{__('webCaption.make.title')}}"  id="" for="make_id" name="make_id"  required="" :optionData="$makes" editSelected="{{(isset($data->make_id) && ($data->make_id != null))?$data->make_id :''; }}" />
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.select  tooltip="{{__('webCaption.model.caption')}}"  label="{{__('webCaption.model.title')}}"  id="" for="model_id" name="model_id"  required="" :optionData="$models" editSelected="{{(isset($data->model_id) && ($data->model_id != null))?$data->model_id :''; }}" />
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
        <x-admin.form.label for="" tooltip="{{__('webCaption.confirmed.caption')}}" value="{{__('webCaption.confirmed.title')}}" class="" />
          <div class="form-group">
          <?php
               $check = "";
                if(isset($data)){
                 $check =   ($data->is_confirmed == 1) ? "checked":"" ;
                }
          ?>
          <x-admin.form.inputs.checkbox tooltip="{{__('webCaption.confirmed.caption')}}"  label="{{__('webCaption.confirmed.title')}}"  id="" for="is_confirmed" name="is_confirmed" value="1" customClass="custom-control-inline" required="required"       checked="{{$check}}"/>
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

