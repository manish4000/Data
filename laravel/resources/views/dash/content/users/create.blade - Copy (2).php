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
				@if(isset($user->id))  {{__('webCaption.edit_user.title')}}  @else {{__('webCaption.account_details.title')}} @endif 
				</h4>  
			</div>
			<hr class="m-0 p-0">
			<div class="card-body">
			  <div class="row">
						<div class="col-md-4 col-12">
                           <div class="row">
						       <div class="col-md-4 col-4">
					                <div class="form-group">
								       <x-dash.form.inputs.name_prefix for="title" tooltip="{{__('webCaption.designation.caption')}}"  label="{{__('webCaption.title.title')}}"   name="designation"  placeholder="{{__('webCaption.designation.title')}}" :optionData="$designation" editSelected="{{ old('designation', isset($user->companySalesTeam->designation_id) ? $user->companySalesTeam->designation_id :'') }}" required="required" />
							       </div>
						       </div>

							   <div class="col-md-8 col-8">
							       <div class="form-group">
								      <x-dash.form.inputs.text  for="name"  maxlength="100" tooltip="{{__('webCaption.name.caption')}}"  label="{{__('webCaption.name.title')}}"  name="name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('name', isset($user->name)?$user->name:'' )}}"  required="required" />
							      </div>
						      </div>
						   </div>
						</div>


						<div class="col-md-4 col-6">
							<div class="form-group">
								<x-dash.form.inputs.select  for="department" tooltip="{{__('webCaption.department.caption')}}"  label="{{__('webCaption.department.title')}}"   name="department"  placeholder="{{__('webCaption.department.title')}}" :optionData="$department" editSelected="{{ old('department', isset($user->companySalesTeam->department_id) ? $user->companySalesTeam->department_id :'') }}"  required="required" />
							</div>
						</div>

						<div class="col-md-4 col-6">
							<div class="form-group">
								<x-dash.form.inputs.select for="designation" tooltip="{{__('webCaption.designation.caption')}}"  label="{{__('webCaption.designation.title')}}"   name="designation"  placeholder="{{__('webCaption.designation.title')}}" :optionData="$designation" editSelected="{{ old('designation', isset($user->companySalesTeam->designation_id) ? $user->companySalesTeam->designation_id :'') }}" required="required" />
							</div>
						</div>

					  
						
						<div class="col-md-4">
							<div class="form-group">
								<x-dash.form.inputs.email  for="email"  maxlength="45" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}"  name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($user->email)?$user->email:'' )}}"  required="required" />
							</div>
						</div>
				

					
						<div class="col-md-4 col-12 ">
							<div class="form-group">
								<x-dash.form.inputs.password  maxlength="15" :passwordGenerator="true"   for="password" tooltip="{{__('webCaption.password.caption')}}" label="{{__('webCaption.password.title')}}"   name="password"  placeholder="{{__('webCaption.password.title')}}" value=""  required="<?php echo (!isset($user->id))? 'required' :''; ?>" />
							</div>
						</div>

						<div class="col-md-4 col-12">
							<div class="form-group">
								<x-dash.form.inputs.password  maxlength="15" for="password_confirmation" tooltip="{{__('webCaption.password_confirm.caption')}}"  label="{{__('webCaption.password_confirm.title')}}"   name="password_confirmation"  placeholder="{{__('webCaption.password_confirm.title')}}" value=""  required="<?php echo (!isset($user->id))? 'required' :''; ?>" />
							</div>
						</div>

						
						<div class="col-md-3 col-12">
							<div class="form-group">
								<x-dash.form.label for="" value="{{__('webCaption.status.title')}}" class="" 
								tooltip="{{__('webCaption.status.caption')}}" />
								<div>
									<div class=" form-check-inline">
									<x-dash.form.inputs.radio for="Yes" tooltip="{{__('webCaption.active.caption')}}"  class="border border-danger" name="status" label="{{__('webCaption.active.title')}}" placeholder="" value="Active"  required="required"  checked="{{ (isset($user->companySalesTeam->status) && $user->companySalesTeam->status == 'Active') ? 'checked' : '' }}" />&ensp;
										
									<x-dash.form.inputs.radio for="No" class="border border-danger" name="status" tooltip="{{__('webCaption.blocked.caption')}}" label="{{__('webCaption.blocked.title')}}" placeholder="" value="Blocked"  required="required"  checked="{{ (isset($user->companySalesTeam->status) && $user->companySalesTeam->status == 'Blocked') ? 'checked' : '' }}" />&ensp;
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
							<x-dash.form.label for="" value="{{__('webCaption.2_step_verification.title')}}" class="" tooltip="{{__('webCaption.2_step_verification.caption')}}" />

								<x-dash.form.inputs.checkbox for="verification" tooltip="{{__('webCaption.verification.caption')}}"  label="{{__('webCaption.verification.title')}}" name="two_step_verification"  placeholder="{{__('webCaption.verification.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->two_step_verification) && $user->companySalesTeam->two_step_verification == '1') ? 'checked' : ''}}" required="" />								
							</div>
						</div>
					
						<div class="col-4">
							<div class="form-group">
								@php
								$editImageUrl = (isset($user->companySalesTeam->image)) ? "dash/sales_team/".$user->companySalesTeam->image : '';
							  	@endphp
								<x-dash.form.inputs.file for="image" caption="{{__('webCaption.upload_image.title')}}"  maxFileSize="5000" label="{{__('webCaption.upload_image.title')}}" name="image"  ImageId="image-preview"  editImageUrl="{{$editImageUrl}}" required="" />
							</div>
						</div>
					
			    </div>
	   		</div>
	 </div>

<!----------Company-Contact-Details-------->

		<div class="card card-primary">
		    <div class="card-header">
			    <h4 class="card-title">		
			        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"   stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			        </svg>
			        @if(isset($user->id))  {{__('webCaption.edit_user.title')}}  @else {{__('webCaption.company_contact_details.title')}} @endif 
				</h4>  
		  	</div>
			<hr class="m-0 p-0">

			<div class="card-body">
                <div class="row">
			            <div class="col-md-12">
							    <div class="form-group">
						     	   <x-dash.form.inputs.textarea for="local_address" maxlength="250" tooltip="{{__('webCaption.local_address.caption')}}"  label="{{__('webCaption.local_address.title')}}" name="local_address"  placeholder="{{__('webCaption.local_address.title')}}" value="{{ old('local_address', isset($user->companySalesTeam->local_address) ? $user->companySalesTeam->local_address :'') }}" required="" />
							   </div>
						   </div>	

					       <div class="col-md-4 ">
							     <div class="form-group">
								    <x-dash.form.inputs.select for="local_country" tooltip="{{__('webCaption.country.caption')}}" label="{{__('webCaption.country.title')}}" name="local_country" placeholder="{{__('webCaption.country.title')}}" :optionData="$country" editSelected="{{ old('local_country', isset($user->companySalesTeam->local_country_id) ? $user->companySalesTeam->local_country_id :'') }}" required="" />
							   </div>
						   </div>

					            <div class="col-md-4 ">
							       <div class="form-group">
								      <x-dash.form.inputs.select for="local_state" tooltip="{{__('webCaption.state.caption')}}"  label="{{__('webCaption.state.title')}}" name="local_state"  placeholder="{{__('webCaption.state.title')}}" :optionData="[]" editSelected="{{ old('local_state', isset($user->companySalesTeam->local_state_id) ? $user->companySalesTeam->local_state_id :'') }}" required="" />
							      </div>
						       </div>

						             <div class="col-md-4 col-6">
							             <div class="form-group">
								              <x-dash.form.inputs.select for="local_city" tooltip="{{__('webCaption.city.caption')}}"  label="{{__('webCaption.city.title')}}" name="local_city"  placeholder="{{__('webCaption.city.title')}}" :optionData="[]" editSelected="{{ old('local_city', isset($user->companySalesTeam->local_city_id) ? $user->companySalesTeam->local_city_id :'') }}" required="" />
							             </div>
						             </div>


					                  <div class="col-md-4 col-6">
							               <div class="form-group">
								               <x-dash.form.inputs.text for="local_zip_code" maxlength="15" tooltip="{{__('webCaption.zip_code.caption')}}"  label="{{__('webCaption.zip_code.title')}}" name="local_zip_code"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{ old('local_zip_code',isset($user->companySalesTeam->local_zip_code) ? $user->companySalesTeam->local_zip_code :'') }}" required="" />
							              </div>
						               </div>

						            <div class="col-md-4 col-12">
                                       <div class="row">
						                    <div class="col-md-4 col-6">
                                                <div class="form-group">
                                                    <x-dash.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="company_country_code" name="company_country_code"  required="" :optionData="[]"  editSelected="{{(isset($country_code) && ($company_country_code != null)) ? $company_country_code : ''; }}" />
                                               </div>
                                          </div>
                                               <div class="col-md-8 col-6">
                                                  <div class="form-group">
                                                     <x-dash.form.inputs.number id="" for="phone"  tooltip="{{__('webCaption.phone.caption')}}" label="{{__('webCaption.phone.title')}}" maxlength="20"  name="phone"  placeholder="{{__('webCaption.phone.title')}}" value="{{old('phone', isset($data->phone)?$data->phone:'' )}}"  required="" />
                                                  </div>
                                              </div>
							          </div>
						         </div>

						           <div class="col-md-4">
                                        <x-dash.form.label for="" 
										tooltip="{{__('webCaption.phone_1_contact_options.caption')}}" 
										value="{{__('webCaption.phone_1_contact_options.title')}}" class="" />
                                       <div class="form-group">
                                          <x-admin.form.inputs.checkbox for="whatsapp" tooltip="{{__('webCaption.whatsapp.caption')}}" name="whatsapp" label="{{__('webCaption.whatsapp.title')}}" checked="{{ old('whatsapp') == '1' ? 'checked' : '' }} {{ isset($data->whatsapp) ? $data->whatsapp == '1' ? 'checked=checked' :'' :'' }}"  value="1"  customClass="form-check-input"  />
                                          @if($errors->has('whatsapp'))
                                             <x-admin.form.form_error_messages message="{{ $errors->first('whatsapp') }}" />
                                           @endif	
                                            <x-admin.form.inputs.checkbox for="viber" tooltip="{{__('webCaption.viber.caption')}}" name="viber" label="{{__('webCaption.viber.title')}}" checked="{{ old('viber') == '1' ? 'checked' : '' }} {{ isset($data->viber) ? $data->viber == '1' ? 'checked=checked' :'' :'' }}"  value="1"  customClass="form-check-input"  />
                                          @if($errors->has('viber'))
                                             <x-admin.form.form_error_messages message="{{ $errors->first('viber') }}" />
                                          @endif		
                                            <x-admin.form.inputs.checkbox for="line" tooltip="{{__('webCaption.line.caption')}}" name="line" label="{{__('webCaption.line.title')}}" checked="{{ old('line') == '1' ? 'checked' : '' }} {{ isset($data->line) ? $data->line == '1' ? 'checked=checked' :'' :'' }}"  value="1"  customClass="form-check-input"  />
                                            @if($errors->has('line'))
                                              <x-admin.form.form_error_messages message="{{ $errors->first('line') }}" />
                                           @endif		
                                     </div>
                                 </div>
                                         <div class="col-md-4 ">
												@php if(isset($user->companySalesTeam->language_id)){
													$editSelected = json_decode($user->companySalesTeam->language_id);
												} else{
													$editSelected = '';
												}
												@endphp
							                  <div class="form-group">
								                  <x-dash.form.inputs.multiple_select label="{{__('webCaption.language.title')}}"  id="" for="language" name="language[]" placeholder="{{__('webCaption.language.title')}}" :oldValues="old('language')" :editSelected="$editSelected"  required="" :optionData="$language" />
							                   </div>
						                 </div>

					             			
			      </div>
		      </div>
		</div>




<!-----Social_details------->


		<div class="card card-primary">
		    <div class="card-header">
			  <h4 class="card-title">		
			  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			 </svg>
			@if(isset($user->id))  {{__('webCaption.edit_user.title')}}  @else {{__('webCaption.company_social_media_details.title')}} @endif 
				</h4>  
		  	</div>
			<hr class="m-0 p-0">

			<div class="card-body">

			   <div class="row">
						<div class="col-md-6 ">
							<div class="form-group">
								<x-dash.form.inputs.select tooltip="{{__('webCaption.social_media.caption')}}" label="{{__('webCaption.social_media.title')}}"  id="" for="company_social_media1" name="social_media[]" placeholder="{{ __('locale.social_media.caption') }}" editSelected="{{ isset($socialMedia->salesSocialMedia[0]->social_media_id) ? $socialMedia->salesSocialMedia[0]->social_media_id : '' }}"  required="" :optionData="$social_media" />
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.value.caption')}}" label="{{__('webCaption.value.title')}}"  id="" for="value1" name="social_value[]" placeholder="{{ __('locale.value.caption') }}" value="{{ old('social_value', (isset($socialMedia->salesSocialMedia[0]->value)) ?$socialMedia->salesSocialMedia[0]->value : '') }}" required="" />

							</div>
						</div>
						<div class="col-md-1 col-3 mt-2">
						<x-dash.form.buttons.custom color="bg-dark" id="rowAdder" value="" iconClass="fa fa-add"/>
							<!-- <button id="rowAdder" type="button" class="btn btn-dark">ADD</button> -->
						</div>
					</div>
				@if(isset($user->id)) 
				<div class="row">
					@php $i = 2; @endphp	
					@foreach($socialMedia->salesSocialMedia as $key => $values)
					@if($key>0)
						<div class="col-md-6">
							<div class="form-group">
								<x-dash.form.inputs.select tooltip="{{__('webCaption.social_media.caption')}}" label="{{__('webCaption.social_media.title')}}"  id="" for="social_media{{$i}}" name="social_media[]" placeholder="{{ __('locale.social_media.caption') }}" editSelected="{{$values->social_media_id}}" required="" :optionData="$social_media" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.value.caption')}}" label="{{__('webCaption.value.title')}}"  id="" for="value{{$i}}" name="social_value[]" placeholder="{{ __('locale.value.caption') }}" value="{{$values->value}}" required="" />
							</div>
						</div>
						@php $i++; @endphp	
						@endif
						@endforeach
					</div>
					@endif  
					<div id="socialInput"></div>


			</div>
	    </div>







<!-----personal_details------->



		<div class="card card-primary">
		    <div class="card-header">
			  <h4 class="card-title">		
			  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			 </svg>
				@if(isset($user->id))  {{__('webCaption.edit_user.title')}}  @else {{__('webCaption.personal_details.title')}} @endif 
				</h4>  
		  	</div>
			<hr class="m-0 p-0">

			<div class="card-body">

                 <div class="row">
					           <div class="col-md-12">
								  <div class="form-group">
									 <x-dash.form.inputs.textarea id="" for="permanent_address" tooltip="{{__('webCaption.permanent_address.caption')}}"  label="{{__('webCaption.permanent_address.title')}}" maxlength="250"  name="permanent_address"  placeholder="{{__('webCaption.permanent_address.title')}}" value="{{old('permanent_address', isset($data->permanent_address)?$data->permanent_address:'' )}}"  required="required" />
								
								   </div>
							  </div> 		      

					       <div class="col-md-4">
							   <div class="form-group">
								   <x-dash.form.inputs.select for="company_permanent_country" tooltip="{{__('webCaption.country.caption')}}"  label="{{__('webCaption.country.title')}}" name="permanent_country"  placeholder="{{__('webCaption.country.title')}}" :optionData="$country" editSelected="{{ old('permanent_country', isset($user->companySalesTeam->company_permanent_country_id) ? $user->companySalesTeam->company_permanent_country_id :'') }}" required="" />
							   </div>
						   </div>


						      <div class="col-md-4">
							     <div class="form-group">
								      <x-dash.form.inputs.select for="company_permanent_state" tooltip="{{__('webCaption.state.caption')}}"  label="{{__('webCaption.state.title')}}" name="permanent_state"  placeholder="{{__('webCaption.state.title')}}" :optionData="[]" editSelected="{{ old('company_permanent_state', isset($user->companySalesTeam->company_permanent_state_id) ? $user->companySalesTeam->company_permanent_state_id :'') }}" required="" />
							      </div>
						     </div>

						      <div class="col-md-4">
							      <div class="form-group">
								        <x-dash.form.inputs.select for="company_permanent_city" tooltip="{{__('webCaption.city.caption')}}"  label="{{__('webCaption.city.title')}}" name="permanent_city"  placeholder="{{__('webCaption.city.title')}}" :optionData="[]" editSelected="{{ old('permanent_city', isset($user->companySalesTeam->company_permanent_city_id) ? $user->companySalesTeam->company_permanent_city_id :'') }}" required="" />
							      </div>
						     </div>				
			

					
						         <div class="col-md-4">
							           <div class="form-group">
								           <x-dash.form.inputs.text for="permanent_zip_code" maxlength="15" tooltip="{{__('webCaption.zip_code.caption')}}"  label="{{__('webCaption.zip_code.title')}}" name="permanent_zip_code"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{ old('permanent_zip_code', isset($user->companySalesTeam->permanent_zip_code) ? $user->companySalesTeam->permanent_zip_code :'' ) }}" required="" />
							         </div>
						         </div>

						               <div class="col-md-4">
							               <x-dash.form.label for="" tooltip="{{__('webCaption.same_as_local_title.caption')}}" value="{{__('webCaption.same_as_local_title.title')}}" class="mb-1" />
								          <div class="form-group">
									           <x-dash.form.inputs.checkbox for="same_as_local" tooltip="{{__('webCaption.same_as_local.caption')}}"  label="{{__('webCaption.same_as_local.title')}}" name="same_as_local"  placeholder="{{__('webCaption.same_as_local.title')}}" value="1" checked="{{(isset($user->companySalesTeam->same_as_local) && $user->companySalesTeam->same_as_local == '1') ? 'checked' : '' }}" required="" />
											</div>
							           </div>

							                 <div class="col-12">
							                     <div class="form-group">
									                 <x-dash.form.inputs.textarea id="" for="local_address" tooltip="{{__('webCaption.local_address.caption')}}"  label="{{__('webCaption.local_address.title')}}" maxlength="250"  name="description"  placeholder="{{__('webCaption.local_address.title')}}" value="{{old('local_address', isset($data->local_address)?$data->local_address:'' )}}"  required="required" />
								
							                      </div>
							                  </div>                     


					       
					                      <div class="col-md-4 ">
							                  <div class="form-group">
								                  <x-dash.form.inputs.select for="permanent_country" tooltip="{{__('webCaption.country.caption')}}"  label="{{__('webCaption.country.title')}}" name="permanent_country"  placeholder="{{__('webCaption.country.title')}}" :optionData="$country" editSelected="{{ old('permanent_country', isset($user->companySalesTeam->permanent_country_id) ? $user->companySalesTeam->permanent_country_id :'') }}" required="" />
							                  </div>
										  </div>


						                <div class="col-md-4 ">
							                  <div class="form-group">
								                   <x-dash.form.inputs.select for="permanent_state" tooltip="{{__('webCaption.state.caption')}}"  label="{{__('webCaption.state.title')}}" name="permanent_state"  placeholder="{{__('webCaption.state.title')}}" :optionData="[]" editSelected="{{ old('permanent_state', isset($user->companySalesTeam->permanent_state_id) ? $user->companySalesTeam->permanent_state_id :'') }}" required="" />
							                 </div>
						                 </div>

								            <div class="col-md-4">
									           <div class="form-group">
									            	<x-dash.form.inputs.select for="permanent_city" tooltip="{{__('webCaption.city.caption')}}"  label="{{__('webCaption.city.title')}}" name="permanent_city"  placeholder="{{__('webCaption.city.title')}}" :optionData="[]" editSelected="{{ old('permanent_city', isset($user->companySalesTeam->permanent_city_id) ? $user->companySalesTeam->permanent_city_id :'') }}" required="" />
									         	</div>
								         	</div>
										 
										 
					        	     <div class="col-md-4">
							             <div class="form-group">
							    	          <x-dash.form.inputs.text for="permanent_zip_code" maxlength="15" tooltip="{{__   ('webCaption.zip_code.caption')}}"  label="{{__('webCaption.zip_code.title')}}" name="permanent_zip_code"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{ old('permanent_zip_code', isset($user->companySalesTeam->permanent_zip_code) ? $user->companySalesTeam->permanent_zip_code :'' ) }}" required="" />
							              </div>
						              </div>


							               <div class="col-md-4">
                                               <div class="row">
						                           <div class="col-md-4 col-6">
                                                       <div class="form-group">
                                                          <x-dash.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="country_code" name="country_code"  required="" :optionData="[]"  editSelected="{{(isset($country_code) && ($country_code != null)) ? $country_code : ''; }}" />
                                                      </div>
                                                  </div>
                                                     <div class="col-md-8 col-6">
                                                           <div class="form-group">
                                                              <x-dash.form.inputs.number id="" for="phone"  tooltip="{{__('webCaption.phone.caption')}}" label="{{__('webCaption.phone.title')}}" maxlength="20"  name="phone"  placeholder="{{__('webCaption.phone.title')}}" value="{{old('phone', isset($data->phone)?$data->phone:'' )}}"  required="" />
                                                          </div>
                                                      </div>
							                 </div>
						                 </div>


								          <div class="col-md-4 col-12">
							                   <div class="form-group">
								                  <x-dash.form.inputs.select tooltip="{{__('webCaption.religion.caption')}}" label="{{__('webCaption.religion.title')}}"  id="" for="religion" name="religion" placeholder="{{ __('locale.religion.caption') }}" editSelected="{{ old('religion', isset($user->companySalesTeam->religion_id) ? $user->companySalesTeam->religion_id :'') }}"  required="" :optionData="$religion" />
							                  </div>
						                  </div>
										  
									

						                 <div class="col-md-2 col-6">
							                  <div class="form-group">
								                   <x-dash.form.inputs.date tooltip="{{__('webCaption.anniversary_date.caption')}}" label="{{__('webCaption.anniversary_date.title')}}"  id="" for="anniversary_date" name="anniversary_date" placeholder="{{ __('locale.anniversary_date.caption') }}" value="{{old('anniversary_date', (isset($user->companySalesTeam->anniversary_date) && $user->companySalesTeam->anniversary_date != '0000-00-00') ?$user->companySalesTeam->anniversary_date : '' ) }}"  required="" />
							                 </div>
						                  </div>


							                <div class="col-md-2 col-6">
							                    <div class="form-group">
								                   <x-dash.form.inputs.date tooltip="{{__('webCaption.dob.caption')}}" label="{{__('webCaption.dob.title')}}"  id="" for="dob" name="dob" placeholder="{{ __('locale.dob.caption') }}" value="{{old('dob', (isset($user->companySalesTeam->dob) && $user->companySalesTeam->dob != '0000-00-00') ?$user->companySalesTeam->dob : '')}}"  required="" />
							                   </div>
						                  </div>

                                          <div class="col-md-3">
								              <x-dash.form.label for="" tooltip="{{__('webCaption.gender.caption')}}" value="{{__('webCaption.gender.title')}}" class="" />
                                              <div class="row">
									               <div class="col-6">
							                          <div class="form-group">
								                           <x-dash.form.inputs.radio tooltip="{{__('webCaption.male.caption')}}" label="{{__('webCaption.male.title')}}"  id="" for="male" name="gender" placeholder="{{ __('locale.male.caption') }}" checked="{{ (isset($user->companySalesTeam->gender) && $user->companySalesTeam->gender == 'male') ? 'checked' : '' }}" value="male"  required="" />
							                         </div>
						                          </div>
										               <div class="col-6">
							                               <div class="form-group">
								                              <x-dash.form.inputs.radio tooltip="{{__('webCaption.female.caption')}}" label="{{__('webCaption.female.title')}}"  id="" for="female" name="gender" placeholder="{{ __('locale.female.caption') }}" checked="{{(isset($user->companySalesTeam->gender) && $user->companySalesTeam->gender == 'female') ? 'checked' : '' }}" value="female"  required="" />
							                              </div>
						                             </div>
									          </div>
   								          </div>

				</div>
		  </div>
	 </div>



		<!-----Personal---Social---details------->


		<div class="card card-primary">
		    <div class="card-header">
			  <h4 class="card-title">		
			  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			 </svg>
			@if(isset($user->id))  {{__('webCaption.edit_user.title')}}  @else {{__('webCaption.personal_social_details.title')}} @endif 
				</h4>  
		  	</div>
			<hr class="m-0 p-0">

			<div class="card-body">

			      <div class="row">
                       <div class="col-md-6">
                         <div class="row">
						       <div class="col-md-6 ">
							      <div class="form-group">
								      <x-dash.form.inputs.select tooltip="{{__('webCaption.social_media.caption')}}" label="{{__('webCaption.social_media.title')}}"  id="" for="social_media1" name="social_media[]" placeholder="{{ __('locale.social_media.caption') }}" editSelected="{{ isset($socialMedia->salesSocialMedia[0]->social_media_id) ? $socialMedia->salesSocialMedia[0]->social_media_id : '' }}"  required="" :optionData="$social_media" />
							       </div>
						       </div>
						              <div class="col-md-5">
							              <div class="form-group">
								              <x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.value.caption')}}" label="{{__('webCaption.value.title')}}"  id="" for="value1" name="social_value[]" placeholder="{{ __('locale.value.caption') }}" value="{{ old('social_value', (isset($socialMedia->salesSocialMedia[0]->value)) ?$socialMedia->salesSocialMedia[0]->value : '') }}" required="" />
							              </div>
						               </div>
						              <div class="col-md-1 col-3 mt-2">
						                   <x-dash.form.buttons.custom color="bg-dark" id="rowAdder" value="" iconClass="fa fa-add"/>
							               <!-- <button id="rowAdder" type="button" class="btn btn-dark">ADD</button> -->
						             </div>
						   </div>
					   </div>
					          <div class="col-md-6"></div>
						
				 </div>
				@if(isset($user->id)) 
				<div class="row">
					@php $i = 2; @endphp	
					@foreach($socialMedia->salesSocialMedia as $key => $values)
					@if($key>0)
					
						        <div class="col-md-6">
							           <div class="form-group">
								          <x-dash.form.inputs.select tooltip="{{__('webCaption.social_media.caption')}}" label="{{__('webCaption.social_media.title')}}"  id="" for="social_media{{$i}}" name="social_media[]" placeholder="{{ __('locale.social_media.caption') }}" editSelected="{{$values->social_media_id}}" required="" :optionData="$social_media" />
							         </div>
						      </div>
						       <div class="col-md-6">
							        <div class="form-group">
								       <x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.value.caption')}}" label="{{__('webCaption.value.title')}}"  id="" for="value{{$i}}" name="social_value[]" placeholder="{{ __('locale.value.caption') }}" value="{{$values->value}}" required="" />
							     </div>
						      </div>				
						
						@php $i++; @endphp	
						@endif
						@endforeach
					</div>
					@endif  
					<div id="socialInput"></div>


					<div class="row mt-3">
						<div class="col-md-12">
							<x-dash.form.label for="" value="{{__('webCaption.permission.title')}}" class="" />
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
			</div>
	 </div>


		<div class="form-group text-center">
			<input type="hidden" name="id" value="@if(isset($user->id) && !empty($user->id)){{$user->id}}@endif" />
			@if(isset($user->id)) 	<x-dash.form.buttons.update /> @else <x-dash.form.buttons.create/> @endif 
		</div>
    </form>
</div>

@endsection

@php
  $local_state = session()->getOldInput('local_state');
  $local_city = session()->getOldInput('local_city');
  $local_state_id =  (isset($local_state)) ? $local_state : ( (isset($user->companySalesTeam->local_state_id)) ? $user->companySalesTeam->local_state_id :'' );
  $local_city_id =  (isset($local_city)) ? $local_city : ( (isset($user->companySalesTeam->local_city_id)) ? $user->companySalesTeam->local_city_id :'' );

  $permanent_state = session()->getOldInput('permanent_state');
  $permanent_city = session()->getOldInput('permanent_city');
  $permanent_state_id =  (isset($permanent_state)) ? $permanent_state : ( (isset($user->companySalesTeam->permanent_state_id)) ? $user->companySalesTeam->permanent_state_id :'' );
  $permanent_city_id =  (isset($permanent_city)) ? $permanent_city : ( (isset($user->companySalesTeam->permanent_city_id)) ? $user->companySalesTeam->permanent_city_id :'' );
@endphp 

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

	  $('#same_as_local').on('click', function () {
		
		var  local_add  = $('#local_address').val();
		$('#permanent_address').val(local_add);

		var  local_zip_code  = $('#local_zip_code').val();
		$('#permanent_zip_code').val(local_zip_code);

		var  loc_country  = $('#local_country').val();
		var  loc_state  = $('#local_state').val();
		var  loc_city = $('#local_city').val();
		//countryListtwo(loc_country,loc_country);
		stateListtwo(loc_country,loc_state);
		cityListtwo(loc_state,loc_city);

	});

	$(document).ready(function() {
		var  local_country  = $('#local_country').find(":selected").val();
		var  local_state  = "<?php echo $local_state_id; ?>";
		var  local_city  = "<?php  echo $local_city_id; ?>";

		if(local_country){
		   stateList(local_country, local_state);
		}

		if(local_state){
			cityList(local_state, local_city);
		}

		$('#local_country').on('change', function(){
		   var selectCountry  = $(this).val();
		   stateList(selectCountry);
		});
		
		$('#local_state').on('change', function () {
		   var selectState  = $(this).val();
		   cityList(selectState);
		});

		var  permanent_country  = $('#permanent_country').find(":selected").val();
		var  permanent_state  = "<?php echo $permanent_state_id; ?>";
		var  permanent_city  = "<?php  echo $permanent_city_id; ?>";

		if(permanent_country){
		   stateListtwo(permanent_country, permanent_state);
		}

		if(permanent_state){
			cityListtwo(permanent_state, permanent_city);
		}

		$('#permanent_country').on('change', function(){
		   var selectCountrytwo  = $(this).val();
		   stateListtwo(selectCountrytwo);
		});
		
		$('#permanent_state').on('change', function () {
		   var selectStatetwo  = $(this).val();
		   cityListtwo(selectStatetwo);
		});
	});
	 
	function stateList(country, selected_state = ''){
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

	/*  function countryListtwo(country, selected_state = ''){
		$.ajax ({
		   type: 'POST',
		   url: "{{route('dashcountry-list')}}",
		   data: { id : country },
		   success : function(result) {
			  $('#permanent_country').html('<option value="">Select Country</option>');
			  $.each(result.countries, function (key, value) {
				 if(value.id == selected_state){
					var selected_s = 'selected';
				 }else{
					var selected_s = '';
				 }
				 $("#permanent_country").append('<option value="' + value.id + '" '+ selected_s + '>' + value.name + '</option>');
			  });
			  $('#permanent_state').html('<option value="">Select State</option>');
		   }
		});
	 } */

	 function stateListtwo(country, selected_state = ''){
		$.ajax ({
		   type: 'POST',
		   url: "{{route('dashstate-list')}}",
		   data: { id : country },
		   success : function(result) {
			  $('#permanent_state').html('<option value="">Select State</option>');
			  $.each(result.states, function (key, value) {
				 if(value.id == selected_state){
					var selected_s = 'selected';
				 }else{
					var selected_s = '';
				 }
				 $("#permanent_state").append('<option value="' + value.id + '" '+ selected_s + '>' + value.name + '</option>');
			  });
			  $('#permanent_city').html('<option value="">Select City</option>');
		   }
		});
	 }
	 function cityListtwo(state, selected_city =''){
		$.ajax ({
		   type: 'POST',
		   url: "{{route('dashcity-list')}}",
		   data: { id : state },
		   success : function(result) {
			  $('#permanent_city').html('<option value="">Select City</option>');
			  $.each(result.cities, function (key, value) {
				 if(value.id == selected_city){
					var selected_c = 'selected';
				 }else{
					var selected_c = '';
				 }
				 $("#permanent_city").append('<option value="' + value.id + '" '+ selected_c +'>' + value.name + '</option>');
			  });
		   }
		});
	 }

	$("#rowAdder").click(function () {
		var allowedNumber = 10;
  if($('#socialInput .row').length < allowedNumber){
		let randx = Math.floor((Math.random() * 100) + 1);
		$.ajax ({
		type: 'POST',
		url: "{{route('dashsocial-media-action')}}",
		data: {id:randx},
		success : function(result) {
			$('#socialInput').append(result);
			$(document).ready(function() { $('.select2').select2(); });
		}
		});
	}else{
		alert("You can not add any more");
	}
    });
 
	function delete_social(id){
		$('.delete_social'+id).remove();
	}
  </script>
@endpush