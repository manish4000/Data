@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.discount.title'). ' ' .__('webCaption.edit.title')  )
@else
@section('title', __('webCaption.discount.title').' '. __('webCaption.add.title') )
@endif

@section('content')
<form action="{{ route('masters.billing.discount.store')}}" method="POST">
@csrf
<section >
  <div class="card">
    <div class="card-header">
			<h4 class="card-title">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			</svg>
			@if(isset($data->id) && !empty($data->id))
			{{__('webCaption.discount.title'). ' ' .__('webCaption.edit.title')  }}
			@else
			{{  __('webCaption.discount.title').' '. __('webCaption.add.title')}}
			@endif
			</h4>  
		</div>
		<hr class="m-0 p-0">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.text tooltip="{{__('webCaption.name.caption')}}" label="{{__('webCaption.name.title')}}" maxlength="50" for="name"   name="name"  placeholder="{{ __('webCaption.name.title') }}" value="{{isset($data->name)?$data->name:'';}}"  required="required" />
          </div>    
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.text tooltip="{{__('webCaption.amount.caption')}}" label="{{__('webCaption.amount.title')}}" maxlength="50" for="amount"   name="amount"  placeholder="{{ __('webCaption.amount.title') }}" value="{{isset($data->amount)?$data->amount:'';}}"  required="required" />
          </div>    
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="form-group">
            <x-admin.form.inputs.select label="{{__('webCaption.currency.title')}}"  tooltip="{{__('webCaption.currency.caption')}}"  customClass="currency" for="currency" name="currency_id" placeholder="{{ __('locale.currency.caption') }}" editSelected=""  required="" :optionData="[]" />
          </div>
        </div>
        <div class="col-7 col-sm-3 col-md-4 col-lg-3 col-xl-3">
          <div class="form-group">
            <x-admin.form.label for="" value="{{__('webCaption.display.title')}}" class="" tooltip="{{__('webCaption.display.caption')}}" />
                <div>
                  <div class="form-check form-check-inline">
                    <x-admin.form.inputs.radio for="yes" tooltip="{{__('webCaption.yes.caption')}}"  class="border border-danger" name="display" label="{{__('webCaption.yes.title')}}" value="Yes"  required="required" 
                    checked="{{ (old('display') == 'Yes') || (!isset($data->id))  ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'Yes' ? 'checked=checked' :'' :'' }} " required="required" />&ensp;
                      
                    <x-admin.form.inputs.radio for="deactive" class="border border-danger" name="display" tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" value="No"  required="required"  checked="{{ old('display') == 'No' ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'No' ? 'checked=checked' :'' :'' }} " required="required" />&ensp;
                  </div>
                </div>
          </div>
        </div>
      </div>       
    </div>
  </div>
  
  <div class="text-center">
    <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
      @if(isset($data->id))   <x-admin.form.buttons.update />  @else    <x-admin.form.buttons.create />   @endif
  </div>
</section>
</form>
@endsection

