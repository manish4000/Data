@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])

@section('title', $pageConfigs['moduleName'])

@section('content')
<form action="{{ route('site-languages.store')}}" method="POST">
	@csrf
	<div class="card card-primary">
		<div class="card-header">
			<h4 class="card-title">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			</svg>
			@if(isset($data->id))  {{__('webCaption.edit_site_languages.title')}}  @else {{__('webCaption.add_site_languages.title')}} @endif 
			</h4>  
		</div>
		<hr class="m-0 p-0">
		<div class="card-body">		
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<x-admin.form.inputs.text for="language_en" tooltip="{{__('webCaption.title_english.caption')}}" label="{{__('webCaption.title_english.title')}}"  maxlength="50"  name="language_en" class="form-control" placeholder="{{__('webCaption.title_english.title')}}" id="language_en" value="{{ old('language_en',isset($data->language_en)?$data->language_en:'') }}" required="required"/>
							@if($errors->has('language_en'))
								<x-admin.form.form_error_messages message="{{ $errors->first('language_en') }}" />
							@endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<x-admin.form.inputs.text for="language_text" tooltip="{{__('webCaption.title_language.caption')}}" label="{{__('webCaption.title_language.title')}}" maxlength="50"  name="language_text" class="form-control" placeholder="{{__('webCaption.title_language.title')}}" id="language_en" value="{{ old('language_text',isset($data->language_text)?$data->language_text:'') }}" required="required"/>
							@if($errors->has('language_text'))
								<x-admin.form.form_error_messages message="{{ $errors->first('language_text') }}" />
							@endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							@php
								$status_options = [
									[
										"name" => "Active",
										"value" => "Active"
									],
									[
										"name" => "Inactive",
										"value" => "Inactive"
									],
								];
								$status_options = json_decode(json_encode($status_options), FALSE); 

							@endphp

							<x-admin.form.inputs.select  tooltip="{{__('webCaption.status.caption')}}" label="{{__('webCaption.status.title')}}"  for="status" name="status"  required="" :optionData="$status_options" editSelected="{{(isset($data->status) && ($data->status != null))?$data->status :''; }}" />
							@if($errors->has('status'))
								<x-admin.form.form_error_messages message="{{ $errors->first('status') }}" />
							@endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<x-admin.form.inputs.text for="alias" maxlength="5" tooltip="{{__('webCaption.alias.caption')}}" label="{{__('webCaption.alias.title')}}"   name="alias" class="form-control" placeholder="{{__('webCaption.alias.title')}}" id="alias" value="{{ old('alias',isset($data->alias)?$data->alias:'') }}" required="required"/>
								@if($errors->has('alias'))
								<x-admin.form.form_error_messages message="{{ $errors->first('alias') }}" />
								@endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-4">
								<div class="form-group">
									<x-admin.form.inputs.checkbox for="default_lang" tooltip="{{__('webCaption.use_as_default_language.caption')}}" name="default_lang" label="{{__('webCaption.use_as_default_language.title')}}" checked="{{ old('default_lang') == '1' ? 'checked' : '' }} {{ isset($data->default_lang) ? $data->default_lang == '1' ? 'checked=checked' :'' :'' }}"  value="1"  customClass="form-check-input"  />
										@if($errors->has('default_lang'))
										<x-admin.form.form_error_messages message="{{ $errors->first('default_lang') }}" />
										@endif		
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<x-admin.form.inputs.checkbox for="show_in_captions" name="show_in_captions" tooltip="{{__('webCaption.show_in_caption.caption')}}"  label="{{__('webCaption.show_in_caption.title')}}" checked="{{ old('show_in_captions') == '1' ? 'checked' : '' }} {{ isset($data->show_in_captions) ? $data->show_in_captions == '1' ? 'checked=checked' :'' :'' }}"  value="1"  customClass="form-check-input"  />
									@if($errors->has('show_in_captions'))
										<x-admin.form.form_error_messages message="{{ $errors->first('show_in_captions') }}" />
									@endif
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<x-admin.form.inputs.checkbox for="show_in_masters"  name="show_in_masters" checked="{{ old('show_in_masters') == '1' ? 'checked' : '' }} {{ isset($data->show_in_masters) ? $data->show_in_masters == '1' ? 'checked=checked' :'' :'' }}" label="{{__('webCaption.show_in_master.title')}}"  tooltip="{{__('webCaption.show_in_master.caption')}}"  value="1" customClass="form-check-input" />
									@if($errors->has('show_in_masters'))
										<x-admin.form.form_error_messages message="{{ $errors->first('show_in_masters') }}" />
									@endif
								</div>
							</div>
						</div>
						
					</div>
				</div>
		</div>
	</div>
	<div class="form-group text-center">
		<input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
			@if(isset($data->id)) <x-admin.form.buttons.update />  @else <x-admin.form.buttons.create />@endif 
	</div>
</form>
@endsection