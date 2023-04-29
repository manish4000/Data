@extends('dash/layouts/LayoutMaster')
@if(isset($user->id) && !empty($user->id))
@section('title', __('webCaption.edit_user.title') )
@else
@section('title', __('webCaption.add_user.title'))
@endif

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('fonts/font-awesome/css/font-awesome.min.css'))}}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css'))}}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-tree.css')) }}">
@endsection

@section('content')
@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif
@php	
$old_permissions = (session()->getOldInput('permissions') != null ) ? session()->getOldInput('permissions') : [] ;

@endphp

<div>

	<form action="{{ route('dashusers.store')}}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="card card-primary">
			<div class="card-header">
				<h4 class="card-title">
		
				<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
				</svg>
				@if(isset($user->id))  {{__('webCaption.edit_user.title')}}  @else {{__('webCaption.add_user.title')}} @endif 
				</h4>  
			</div>
			<hr class="m-0 p-0">
			<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-dash.form.inputs.text  for="name"  maxlength="100" tooltip="{{__('webCaption.name.caption')}}"  label="{{__('webCaption.name.title')}}"  name="name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('name', isset($user->name)?$user->name:'' )}}"  required="required" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<x-dash.form.inputs.email  for="email"  maxlength="45" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}"  name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($user->email)?$user->email:'' )}}"  required="required" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.password  maxlength="15" :passwordGenerator="true"   for="password" tooltip="{{__('webCaption.password.caption')}}" label="{{__('webCaption.password.title')}}"   name="password"  placeholder="{{__('webCaption.password.title')}}" value=""  required="<?php echo (!isset($user->id))? 'required' :''; ?>" />
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.password  maxlength="15" for="password_confirmation" tooltip="{{__('webCaption.password_confirm.caption')}}"  label="{{__('webCaption.password_confirm.title')}}"   name="password_confirmation"  placeholder="{{__('webCaption.password_confirm.title')}}" value=""  required="<?php echo (!isset($user->id))? 'required' :''; ?>" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.select  for="department" tooltip="{{__('webCaption.department.caption')}}"  label="{{__('webCaption.department.title')}}"   name="department"  placeholder="{{__('webCaption.department.title')}}" :optionData="$department" editSelected="{{(isset($user->companySalesTeam->department_id) && !empty($user->companySalesTeam->department_id)) ? $user->companySalesTeam->department_id :''; }}"  required="required" />
							</div>
						</div>

						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.select for="designation" tooltip="{{__('webCaption.designation.caption')}}"  label="{{__('webCaption.designation.title')}}"   name="designation"  placeholder="{{__('webCaption.designation.title')}}" :optionData="$designation" editSelected="{{(isset($user->designation_id) && !empty($user->designation_id)) ? $user->designation_id :''; }}" required="required" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4">
							<div class="form-group">
								<x-dash.form.inputs.radio for="status_act" tooltip="{{__('webCaption.active_status.caption')}}"  label="{{__('webCaption.active_status.title')}}" name="active_status"  placeholder="{{__('webCaption.active_status.title')}}" value="" checked="checked" required="required" />								
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<x-dash.form.inputs.radio for="status_act" tooltip="{{__('webCaption.blocked_status.caption')}}"  label="{{__('webCaption.blocked_status.title')}}" name="blocked_status"  placeholder="{{__('webCaption.blocked_status.title')}}" checked="" value="" required="required" />								
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<x-dash.form.inputs.checkbox for="verification" tooltip="{{__('webCaption.verification.caption')}}"  label="{{__('webCaption.verification.title')}}" name="two_step_verification"  placeholder="{{__('webCaption.verification.title')}}" value="" required="" />								
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.file for="image" tooltip="{{__('webCaption.upload_photo.caption')}}"  label="{{__('webCaption.upload_photo.title')}}" name="image"  placeholder="{{__('webCaption.upload_photo.title')}}" caption="" value="" required="" />
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.text for="local_address" maxlength="250" tooltip="{{__('webCaption.local_address.caption')}}"  label="{{__('webCaption.local_address.title')}}" name="local_address"  placeholder="{{__('webCaption.local_address.title')}}" value="{{(isset($user->local_address) && !empty($user->local_address)) ? $user->local_address :''; }}" required="" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.select for="local_country" tooltip="{{__('webCaption.country.caption')}}"  label="{{__('webCaption.country.title')}}" name="local_country"  placeholder="{{__('webCaption.country.title')}}" :optionData="$country" editSelected="{{(isset($user->local_country_id) && !empty($user->local_country_id)) ? $user->local_country_id :''; }}" required="" />
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.select for="local_state" tooltip="{{__('webCaption.state.caption')}}"  label="{{__('webCaption.state.title')}}" name="local_state"  placeholder="{{__('webCaption.state.title')}}" :optionData="[]" editSelected="{{(isset($user->local_state_id) && !empty($user->local_state_id)) ? $user->local_state_id :''; }}" required="" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.select for="local_city" tooltip="{{__('webCaption.city.caption')}}"  label="{{__('webCaption.city.title')}}" name="local_city"  placeholder="{{__('webCaption.city.title')}}" :optionData="[]" editSelected="{{(isset($user->local_city_id) && !empty($user->local_city_id)) ? $user->local_city_id :''; }}" required="" />
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.text for="local_zip_code" maxlength="15" tooltip="{{__('webCaption.zip_code.caption')}}"  label="{{__('webCaption.zip_code.title')}}" name="local_zip_code"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{(isset($user->local_zip_code) && !empty($user->local_zip_code)) ? $user->local_zip_code :''; }}" required="" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.checkbox for="same_as_local" tooltip="{{__('webCaption.same_as_local.caption')}}"  label="{{__('webCaption.same_as_local.title')}}" name="same_as_local"  placeholder="{{__('webCaption.same_as_local.title')}}" value="" required="" />
							</div>
						</div>
						<div class="col-6">
							<div class="form group">
								<x-dash.form.inputs.text for="permanent_address" maxlength="250" tooltip="{{__('webCaption.permanent_address.caption')}}"  label="{{__('webCaption.permanent_address.title')}}" name="permanent_address"  placeholder="{{__('webCaption.permanent_address.title')}}" value="{{(isset($user->permanent_address) && !empty($user->permanent_address)) ? $user->permanent_address :''; }}" required="" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.select for="permanent_country" tooltip="{{__('webCaption.country.caption')}}"  label="{{__('webCaption.country.title')}}" name="permanent_country"  placeholder="{{__('webCaption.country.title')}}" :optionData="$country" editSelected="{{(isset($user->permanent_country_id) && !empty($user->permanent_country_id)) ? $user->permanent_country_id :''; }}" required="" />
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.select for="permanent_state" tooltip="{{__('webCaption.state.caption')}}"  label="{{__('webCaption.state.title')}}" name="permanent_state"  placeholder="{{__('webCaption.state.title')}}" :optionData="[]" editSelected="{{(isset($user->permanent_state_id) && !empty($user->permanent_state_id)) ? $user->permanent_state_id :''; }}" required="" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.select for="permanent_city" tooltip="{{__('webCaption.city.caption')}}"  label="{{__('webCaption.city.title')}}" name="permanent_city"  placeholder="{{__('webCaption.city.title')}}" :optionData="[]" editSelected="{{(isset($user->permanent_city_id) && !empty($user->permanent_city_id)) ? $user->permanent_city_id :''; }}" required="" />
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.text for="permanent_zip_code" maxlength="15" tooltip="{{__('webCaption.zip_code.caption')}}"  label="{{__('webCaption.zip_code.title')}}" name="permanent_zip_code"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{(isset($user->permanent_zip_code) && !empty($user->permanent_zip_code)) ? $user->permanent_zip_code :''; }}" required="" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4">
							<div class="form-group">
								<x-dash.form.inputs.number for="phone_1" maxlength="20" tooltip="{{__('webCaption.phone_1.caption')}}"  label="{{__('webCaption.phone_1.title')}}" name="phone_1"  placeholder="{{__('webCaption.phone_1.title')}}" value="{{(isset($user->phone_1) && !empty($user->phone_1)) ? $user->phone_1 :''; }}" required="required" />
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<x-dash.form.inputs.number for="phone_2" maxlength="20" tooltip="{{__('webCaption.phone_2.caption')}}"  label="{{__('webCaption.phone_2.title')}}" name="phone_2"  placeholder="{{__('webCaption.phone_2.title')}}" value="{{(isset($user->phone_2) && !empty($user->phone_2)) ? $user->phone_2 :''; }}" required="" />
							</div>
						</div>

						<div class="col-4">
							<div class="form-group">
								<x-dash.form.inputs.text for="skype" maxlength="35" tooltip="{{__('webCaption.skype.caption')}}"  label="{{__('webCaption.skype.title')}}" name="skype"  placeholder="{{__('webCaption.skype.title')}}" value="{{(isset($user->skype) && !empty($user->skype)) ? $user->skype :''; }}" required="" />
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.multiple_select label="{{__('webCaption.language.title')}}"  id="" for="language" name="language[]" placeholder="{{__('webCaption.language.title')}}" :oldValues="old('language')" editSelected=""  required="" :optionData="$language" />
							</div>
						</div>

						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.select tooltip="{{__('webCaption.religion.caption')}}" label="{{__('webCaption.religion.title')}}"  id="" for="religion" name="religion" placeholder="{{ __('locale.religion.caption') }}" editSelected="{{(isset($user->religion_id) && !empty($user->religion_id)) ? $user->religion_id :''; }}"  required="" :optionData="$religion" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.date tooltip="{{__('webCaption.anniversary_date.caption')}}" label="{{__('webCaption.anniversary_date.title')}}"  id="" for="anniversary_date" name="anniversary_date" placeholder="{{ __('locale.anniversary_date.caption') }}" value="{{(isset($user->anniversary_date) && !empty($user->anniversary_date) && ($user->anniversary_date != '0000-00-00')) ? $user->anniversary_date :''; }}"  required="" />
							</div>
						</div>

						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.date tooltip="{{__('webCaption.dob.caption')}}" label="{{__('webCaption.dob.title')}}"  id="" for="dob" name="dob" placeholder="{{ __('locale.dob.caption') }}" value="{{(isset($user->dob) && !empty($user->dob) && ($user->dob != '0000-00-00')) ? $user->dob :''; }}"  required="" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.radio tooltip="{{__('webCaption.male.caption')}}" label="{{__('webCaption.male.title')}}"  id="" for="male" name="gender" placeholder="{{ __('locale.male.caption') }}" checked="" value=""  required="" />
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.radio tooltip="{{__('webCaption.female.caption')}}" label="{{__('webCaption.female.title')}}"  id="" for="female" name="gender" placeholder="{{ __('locale.female.caption') }}" checked="" value=""  required="" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.facebook.caption')}}" label="{{__('webCaption.facebook.title')}}"  id="" for="facebook" name="facebook" placeholder="{{ __('locale.facebook.caption') }}" value="{{(isset($user->facebook) && !empty($user->facebook)) ? $user->facebook :''; }}" required="" />
							</div>
						</div>

						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.instagram.caption')}}" label="{{__('webCaption.instagram.title')}}"  id="" for="instagram" name="instagram" placeholder="{{ __('locale.instagram.caption') }}" value="{{(isset($user->instagram) && !empty($user->instagram)) ? $user->instagram :''; }}" required="" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.twitter.caption')}}" label="{{__('webCaption.twitter.title')}}"  id="" for="twitter" name="twitter" placeholder="{{ __('locale.twitter.caption') }}" value="{{(isset($user->twitter) && !empty($user->twitter)) ? $user->twitter :''; }}" required="" />
							</div>	
						</div>

						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.linked_in.caption')}}" label="{{__('webCaption.linked_in.title')}}"  id="" for="linked_in" name="linked_in" placeholder="{{ __('locale.linked_in.caption') }}" value="{{(isset($user->linked_in) && !empty($user->linked_in)) ? $user->linked_in :''; }}" required="" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.youtube.caption')}}" label="{{__('webCaption.youtube.title')}}"  id="" for="youtube" name="youtube" placeholder="{{ __('locale.youtube.caption') }}" value="{{(isset($user->youtube) && !empty($user->youtube)) ? $user->youtube :''; }}" required="" />
							</div>
						</div>
						{{-- <div class="col-md-6">
							<div class="form-group">
								<x-dash.form.inputs.select tooltip="{{__('webCaption.status.caption')}}" label="{{__('webCaption.status.title')}}"  id="" for="status" name="status" placeholder="{{ __('locale.Parent.caption') }}" editSelected="{{(isset($user->status) && ($user->status != null))?$user->status :''; }}"  required="required" :optionData="$status" />
							</div>
						</div> --}}
					</div>

					<div class="row">
						<div class="col-md-12">
							<x-admin.form.label for="" value="{{__('webCaption.permission.title')}}" class="" />
							@if ($permissions)

							<div class="jstree-basic">
								<ul>
									@foreach ( $permissions as $permission )
										@if(count($permission->menuChild) > 0)
											<li class="jstree-open">

													<x-dash.form.inputs.checkbox  name="permissions[]"  for="{{$permission->id}}permission" label="{{$permission->title }}" checked="{{( isset($user) && (!empty($permission->permission_slug)) && $user->can($permission->permission_slug)) || in_array($permission->id,$old_permissions) ? 'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />	

												 @include('dash.content.users.child_list',['items' => $permission->menuChild ]) 												
											</li>
										@else
											<li>
												
													<x-dash.form.inputs.checkbox  name="permissions[]"  for="{{$permission->id}}permission" label="{{ $permission->title }}" checked="{{ ( isset($user) && (!empty($permission->permission_slug)) && $user->can($permission->permission_slug)) || in_array($permission->id,$old_permissions) ? 'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />
												
											</li>
										@endif
									@endforeach
								</ul>
							</div>
							@endif
						</div>
					</div>
						

					{{-- <div class="row">
						<div class="col-md-12">
							<x-dash.form.label for="" value="{{__('webCaption.permission.title')}}" class="" />
							@if ($permissions)
							<div class="jstree-basic">
								<ul>
									@foreach ( $permissions as $permission )
										@if(count($permission->menuChild) > 0)
											<li class="jstree-open">
												<label class="form-check-label">
													<x-dash.form.inputs.checkbox  name="permissions[]" label="{{ $permission->title }}" checked="{{( isset($user) && $user->can($permission->permission_slug)) ?'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />
													
												</label>
												 @include('content.admin.user.child_list',['items' => $permission->menuChild ]) 												
											 
											</li>
										@else
											<li>
												<label class="form-check-label">
													<x-dash.form.inputs.checkbox  name="permissions[]" label="{{ $permission->title }}" checked="{{ ( isset($user) && $user->can($permission->permission_slug)) ?'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />
												</label>
											</li>
										@endif
									@endforeach
								</ul>
							</div>
							@endif
						</div>
					</div> --}}
			</div>
		</div>
		<div class="form-group text-center">
			<input type="hidden" name="id" value="@if(isset($user->id) && !empty($user->id)){{$user->id}}@endif" />
			@if(isset($user->id)) 	<x-dash.form.buttons.update /> @else <x-dash.form.buttons.create/> @endif 
		</div>
    </form>
</div>

@endsection



@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
@endsection

@push('script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>
  <script src="{{ asset('assets/dash/assets/js/dash/master.js') }}"></script>
  <script type="text/javascript">
  	$(document).ready(function() {
  		$(".jstree-basic ul li a, .jstree-basic ul li ul li a").each(function() {
  		  var attributes = $.map(this.attributes, function(item) {
		    return item.name;
		  });
		  var img = $(this);
		  $.each(attributes, function(i, item) {
		    img.removeAttr(item);
		  });
		});
  	})



	  $(document).ready(function() {
		var  local_country  = $('#local_country').find(":selected").val();
		var  local_state  = "{{old('local_state_id')}}";
		var  local_city  = "{{old('local_city_id')}}";

		if(local_country){
		   stateList(local_country,local_state);
		}

		if(local_state){
		   $.ajax ({
			  type: 'POST',
			  url: "{{route('dashcity-list')}}",
			  data: { id : local_state },
			  success : function(result) {
				 $('#local_city').html('<option value="">Select City</option>');
				 $.each(result.cities, function (key, value) {
					if(value.id == local_city){
					   var selected_c = 'selected';
					}else{
					   var selected_c = '';
					}
					$("#local_city").append('<option value="' + value.id + '" '+ selected_c +'>' + value.name + '</option>');
				 });
			  }
		   });
		}

		$('#local_country').on('change', function(){
		   var selectCountry  = $(this).val();
		   stateList(selectCountry);
		});
		$('#local_state').on('change', function () {
		   var selectState  = $(this).val();
		   cityList(selectState);
		});
	 });
	 function stateList(country , selected_state = ''){
		$.ajax ({
		   type: 'POST',
		   url: "{{route('dashstate-list')}}",
		   data: { id : country },
		   success : function(result) {
			  $('#local_state').html('<option value="">Select State</option>');
			  $.each(result.states, function (key, value) {
				 if(value.id == selected_state){
					var selected_s = 'selected';
				 }else{
					var selected_s = '';
				 }
				 $("#local_state").append('<option value="' + value.id + '" '+ selected_s + '>' + value.name + '</option>');
			  });
			  $('#local_city').html('<option value="">Select City</option>');
		   }
		});
	 }
	 function cityList(state, selected_city =''){
		$.ajax ({
		   type: 'POST',
		   url: "{{route('dashcity-list')}}",
		   data: { id : state },
		   success : function(result) {
			  $('#local_city').html('<option value="">Select City</option>');
			  $.each(result.cities, function (key, value) {
				 if(value.id == selected_city){
					var selected_c = 'selected';
				 }else{
					var selected_c = '';
				 }
				 $("#local_city").append('<option value="' + value.id + '" '+ selected_c +'>' + value.name + '</option>');
			  });
		   }
		});
	 }
  </script>
@endpush