@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.edit_city.title') )
@else
@section('title', __('webCaption.add_city.title'))
@endif


@section('content')
<form action="{{ route('common.city.store')}}" method="POST">
@csrf
<section >
  <div class="card">
    <div class="card-header">
			<h4 class="card-title">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			</svg>
			@if(isset($data->id))  {{__('webCaption.edit_city.title')}}  @else {{__('webCaption.add_city.title')}} @endif 
			</h4>  
		</div>
		<hr class="m-0 p-0">

    <div class="card-body">
      <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <x-admin.form.inputs.text tooltip="{{__('webCaption.name.caption')}}" label="{{__('webCaption.name.title')}}" maxlength="100" for="name" name="name"  placeholder="{{ __('webCaption.name.title') }}" value="{{old('name', isset($data->name)?$data->name:'' )}}"  required="required" />
            </div>    
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <x-admin.form.inputs.select label="{{__('webCaption.state.title')}}"  tooltip="{{__('webCaption.state.caption')}}"           for="state_id" name="state_id"   placeholder="{{ __('locale.state.caption') }}" customClass="state"  editSelected="{{(isset($data->state_id) && ($data->state_id != null)) ? $data->state_id :'' }}"  required="required" :optionData="$states" />
             </div>
        </div>
          
        <div class="col-md-4">
            <div class="form-group">
              <x-admin.form.label for="" value="{{__('webCaption.display.title')}}" class="" tooltip="{{__('webCaption.display.caption')}}" />
                   <div>
                      <div class="form-check form-check-inline">
                        <x-admin.form.inputs.radio for="Yes" tooltip="{{__('webCaption.yes.caption')}}"  class="border border-danger" name="display" label="{{__('webCaption.yes.title')}}" placeholder="{{ __('locale.Vehicle_Type.name') }}" value="Yes"  required="required" 
                        checked="{{ (old('display') == 'Yes') || (!isset($data->id))  ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'Yes' ? 'checked=checked' :'' :'' }} " required="required" />&ensp;
                          
                        <x-admin.form.inputs.radio for="No" class="border border-danger" name="display" tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" placeholder="{{ __('locale.Vehicle_Type.name') }}" value="No"  required="required"  checked="{{ old('display') == 'No' ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'No' ? 'checked=checked' :'' :'' }} " required="required" />&ensp;

                      </div>
                    </div>
            </div>
        </div>
      </div>  
 
    </div>
  </div>

  @if( isset($data->id) && $data->parent_id == null )

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

@push('script')

<script src="{{ asset('assets/js/gabs/master.js') }}"></script>
				

@endpush
