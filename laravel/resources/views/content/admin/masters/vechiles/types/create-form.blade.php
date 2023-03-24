@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.type_edit.title') )
@else
@section('title', __('webCaption.type_add.title'))
@endif

@section('content')
<form action="{{ route('masters-vehicle-type-store')}}" method="POST">
@csrf
<section >
  <div class="card">
    <div class="card-header">
			<h4 class="card-title">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			</svg>
			@if(isset($data->id) && !empty($data->id))
			{{__('webCaption.type_edit.title')}}
			@else
			{{__('webCaption.type_add.title')}}
			@endif
			</h4>  
		</div>
		<hr class="m-0 p-0">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <x-admin.form.inputs.text tooltip="{{__('webCaption.name.caption')}}" label="{{__('webCaption.name.title')}}" maxlength="80" for="name" class="form-control" name="name"  placeholder="{{ __('webCaption.name.title') }}" value="{{old('name', isset($data->name)?$data->name:'' )}}"  required="required" />
            @if($errors->has('name'))
              <x-admin.form.form_error_messages message="{{ $errors->first('name') }}"  />
            @endif
          </div>    
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <x-admin.form.inputs.select  tooltip="{{__('webCaption.select_parent.caption')}}"  label="{{__('webCaption.select_parent.title')}}"  id="" for="parent_id" name="parent_id" placeholder="{{__('webCaption.select_parent.title')}}"  required="" :optionData="$parent_data" editSelected="{{(isset($data->parent_id) && ($data->parent_id != null))?$data->parent_id :''; }}" />
          </div>
        </div>

        <div class="col-md-4">
      
            {{-- <div class="form-group">
              <x-admin.form.label for="" tooltip="{{__('webCaption.display.caption')}}" value="{{__('webCaption.display.title')}}" class="" />
                <div class="form-check form-check-inline">
                

                  <x-admin.form.inputs.radio for="Yes" tooltip="{{__('webCaption.yes.caption')}}"  class="border border-danger" name="display" label="{{__('webCaption.yes.title')}}" placeholder="{{ __('locale.Vehicle_Type.name') }}" value="Yes"  required="required" checked="{{ old('display') == 'Yes' ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'Yes' ? 'checked=checked' :'' :'' }} " required="required" />

                  <x-admin.form.inputs.radio for="No" class="border border-danger" name="display" tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" placeholder="{{ __('locale.Vehicle_Type.name') }}" value="No"  required="required"  checked="{{ old('display') == 'No' ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'No' ? 'checked=checked' :'' :'' }} " required="required" />

                  @if($errors->has('display'))
                  <x-admin.form.form_error_messages message="{{ $errors->first('display') }}"  />
                  @endif
              
                </div>
            </div>   --}}

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
  
    @if((isset($data->parent_id)) && ($data->parent_id == 0) )
          @if ( isset($activeSiteLanguages) && count($activeSiteLanguages) > 0 )
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
                </svg>
                {{__('webCaption.site_languages.title')}}
              </h4>  
            </div>
            <hr class="m-0 p-0">

            <div class="card-body">
              <div class="row">
                    @foreach ( $activeSiteLanguages as $language )
                      @php 
                        $value = ""; 
                        if ( isset($data->title_languages[$language->id]) ) {
                          $value = $data->title_languages[$language->id]['title'];
                        }
                      @endphp

                      <div class="col-md-4">
                        <div class="form-group">
                          <x-admin.form.inputs.text label="{{ $language->language_en }} {{__('webCaption.title.title')}}" for="title_languages{{$language->id}}title"  maxlength="80" class="form-control"  name="title_languages[{{$language->id}}][title]"  placeholder="{{ $language->language_en }} {{__('webCaption.title.title')}}" value="{{old('title_languages.'.$language->id.'.title', $value)}}"  required="" readonly/>
                          @if ($errors->has('title_languages[{{$language->id}}][title]'))
                          <x-admin.form.form_error_messages message="{{ $errors->first('title_languages[$language->id][title]') }}"  />
                          @endif
                        </div>
                      </div>
                    @endforeach
              </div>
            </div>
          </div>    
          @endif
    @endif
  <div class="text-center">
    <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
      @if(isset($data->id))   <x-admin.form.buttons.update />  @else    <x-admin.form.buttons.create />   @endif
  </div>
</section>
</form>
@endsection