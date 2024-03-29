@extends('dash/layouts/LayoutMaster')
@if(isset($user->id) && !empty($user->id))
@section('title', __('webCaption.user.title'). ' ' .__('webCaption.edit.title') )
@else
@section('title', __('webCaption.user.title'). ' ' .__('webCaption.add.title'))
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

{{-- @php
echo "<pre>"; print_r($user->companySalesTeam); echo "</pre>"; exit;
@endphp --}}

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
					<div class="col-md-8 col-12">
						<div class="row">
							<div class="col-md-3 col-4">
								<div class="form-group">
									<x-dash.form.inputs.name_prefix for="title" tooltip="{{__('webCaption.title.caption')}}"  label="{{__('webCaption.title.title')}}"   name="title"  placeholder="{{__('webCaption.title.title')}}" editSelected="{{ old('title', isset($user->companySalesTeam->title) ? $user->companySalesTeam->title :'') }}" required="required" />
								</div>
							</div>

							<div class="col-md-9 col-8 pl-0">
								<div class="form-group">
									<x-dash.form.inputs.text for="name"  maxlength="100" tooltip="{{__('webCaption.name.caption')}}"  label="{{__('webCaption.name.title')}}"  name="name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('name', isset($user->name)?$user->name:'' )}}"  required="required" />
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<x-dash.form.inputs.select  for="department" tooltip="{{__('webCaption.department.caption')}}"  label="{{__('webCaption.department.title')}}"   name="department_id"  placeholder="{{__('webCaption.department.title')}}" :optionData="$department" editSelected="{{ old('department', isset($user->companySalesTeam->department_id) ? $user->companySalesTeam->department_id :'') }}"  required="required" />
						</div>
					</div>
						
					<div class="col-md-4">
						<div class="form-group">
							<x-dash.form.inputs.email  for="email"  maxlength="50" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}"  name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($user->email)?$user->email:'' )}}"  required="required" />
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


					<div class="col-md-4">
						<div class="form-group">
							<x-dash.form.inputs.select for="designation" tooltip="{{__('webCaption.designation.caption')}}"  label="{{__('webCaption.designation.title')}}"   name="designation_id"  placeholder="{{__('webCaption.designation.title')}}" :optionData="$designation" editSelected="{{ old('designation', isset($user->companySalesTeam->designation_id) ? $user->companySalesTeam->designation_id :'') }}" required="required" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							@if(isset($user->companySalesTeam->roles_id))
								@php $editSelected = json_decode($user->companySalesTeam->roles_id); @endphp
							@else
								@php $editSelected = ''; @endphp
							@endif
							<x-dash.form.inputs.multiple_select label="{{__('webCaption.role.title')}}"  for="roles" name="roles[]" placeholder="{{__('webCaption.role.caption')}}" :oldValues="old('roles')" :editSelected="$editSelected"  required="" :optionData="$roles" />
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
								<x-dash.form.label for="" value="{{__('webCaption.user_status.title')}}" class=""  tooltip="{{__('webCaption.user_status.caption')}}" />
							<div>
								<div class="form-check-inline">
								<x-dash.form.inputs.radio for="Yes" tooltip="{{__('webCaption.yes.caption')}}"  class="border border-danger" name="status" label="{{__('webCaption.yes.title')}}" placeholder="" value="Yes"  required="required"  checked="{{ (isset($user->companySalesTeam->status) && $user->companySalesTeam->status == 'Yes') ? 'checked' : 'checked' }}" />&ensp;
									
								<x-dash.form.inputs.radio for="No" class="border border-danger" name="status" tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" placeholder="" value="No"  required="required"  checked="{{ (isset($user->companySalesTeam->status) && $user->companySalesTeam->status == 'No') ? 'checked' : '' }}" />&ensp;
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<x-dash.form.label for="" value="{{__('webCaption.2_step_verification.title')}}" class="" tooltip="{{__('webCaption.2_step_verification.caption')}}" />

							<x-dash.form.inputs.checkbox for="verification" tooltip="{{__('webCaption.allowed.caption')}}"  label="{{__('webCaption.allowed.title')}}" name="verification"  placeholder="{{__('webCaption.allowed.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />								
						</div>
					</div>

					<div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea  for="admin_memo" maxlength="500"  tooltip="{{__('webCaption.admin_memo.caption')}}" label="{{__('webCaption.admin_memo.title')}}"   name="admin_memo"  placeholder="{{__('webCaption.admin_memo.title')}}" value="{{old('admin_memo', isset($user->companySalesTeam->admin_memo)?$user->companySalesTeam->admin_memo:'' )}}"/>
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
							<x-dash.form.inputs.textarea for="company_address" maxlength="250" tooltip="{{__('webCaption.company_address.caption')}}"  label="{{__('webCaption.company_address.title')}}" name="company_address"  placeholder="{{__('webCaption.company_address.title')}}" value="{{ old('company_address', isset($user->companySalesTeam->company_address) ? $user->companySalesTeam->company_address :'') }}" required="" />
						</div>
					</div>	

					<div class="col-md-4 ">
						<div class="form-group">
							<x-dash.form.inputs.select  onChange="stateLists(this.id,'company_state')" for="company_country" tooltip="{{__('webCaption.country.caption')}}" label="{{__('webCaption.country.title')}}" name="company_country" placeholder="{{__('webCaption.country.title')}}" :optionData="$country" customClass="country" editSelected="{{ old('company_country', isset($user->companySalesTeam->company_country_id) ? $user->companySalesTeam->company_country_id :'') }}" required="" />
						</div>
					</div>

					<div class="col-md-4 ">
						<div class="form-group">
							<x-dash.form.inputs.select onChange="cityList('company_state','company_city')" for="company_state" tooltip="{{__('webCaption.state.caption')}}"  label="{{__('webCaption.state.title')}}" name="company_state"  placeholder="{{__('webCaption.state.title')}}" :optionData="[]" editSelected="{{ old('company_state', isset($user->companySalesTeam->company_state_id) ? $user->companySalesTeam->company_state_id :'') }}" required="" />
						</div>
					</div>

					<div class="col-md-4 col-6">
						<div class="form-group">
								<x-dash.form.inputs.select for="company_city" tooltip="{{__('webCaption.city.caption')}}"  label="{{__('webCaption.city.title')}}" name="company_city"  placeholder="{{__('webCaption.city.title')}}" :optionData="[]" editSelected="{{ old('company_city', isset($user->companySalesTeam->company_city_id) ? $user->companySalesTeam->company_city_id :'') }}" required="" />
						</div>
					</div>

					<div class="col-md-2 col-6">
						<div class="form-group">
							<x-dash.form.inputs.text for="company_zip_code" maxlength="15" tooltip="{{__('webCaption.zip_code.caption')}}"  label="{{__('webCaption.zip_code.title')}}" name="company_zip_code"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{ old('company_zip_code', isset($user->companySalesTeam->company_zip_code) ? $user->companySalesTeam->company_zip_code :'') }}" required="" />
						</div>
					</div>

					<div class="col-md-7 col-12">
						<div class="row">
							<div class="col-md-3 col-4 pr-50">
							@php 
							$company_telephone  = (isset($user->companySalesTeam->company_phone) && !empty($user->companySalesTeam->company_phone)) ? explode('_',$user->companySalesTeam->company_phone) : null;
        					$company_phone = ($company_telephone != null) ? $company_telephone[1] : null;
					        $company_country_code = (isset($company_telephone[0]))? $company_telephone[0] :null;  
							@endphp
								<div class="form-group">
									<x-dash.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="company_country_code" name="company_country_code"  required="" :optionData="$country_code"  editSelected="{{ old('company_country_code', isset($company_country_code) && !empty($company_country_code) ? $company_country_code : '') }}" />
								</div>
							</div>
							<div class="col-md-5 col-8 pl-50 pr-0">
								<div class="form-group">
									<x-dash.form.inputs.number id="" for="company_phone"  tooltip="{{__('webCaption.phone.caption')}}" label="{{__('webCaption.phone.title')}}" maxlength="20"  name="company_phone"  placeholder="{{__('webCaption.phone.title')}}" value="{{old('company_phone', isset($company_phone)?$company_phone:'' )}}"  required="" />
								</div>
							</div>
							{{-- Component of Messenger Field --}}
							<div class="col-md-4">
								<div class="form-group">
							@if(isset($user->companySalesTeam->company_messenger))
								@php $edit_company_messenger = json_decode($user->companySalesTeam->company_messenger);
								@endphp
							@else
								@php $edit_company_messenger = ''; @endphp
							@endif
								@include('components.dash.form.inputs.messenger_common', ['id' => 'company_messenger', 'name' => 'company_messenger', 'editSelected' => $edit_company_messenger])  
								</div>
							</div>	
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							@if(isset($user->companySalesTeam->language_id))
								@php $editSelected = json_decode($user->companySalesTeam->language_id); @endphp
							@else
								@php $editSelected = ''; @endphp
							@endif
							<x-dash.form.inputs.multiple_select label="{{__('webCaption.language.title')}}"  id="" for="language" name="language[]" placeholder="{{__('webCaption.language.title')}}" :oldValues="old('language')" :editSelected="$editSelected"  required="" :optionData="$language" />
						</div>
					</div>     			
				</div>
			</div>
		</div>

<!-----personal_details------->

		<div class="card card-primary">
		    <div class="card-header">
			  	<h4 class="card-title">		
			  		<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
					@if(isset($user->id))  {{__('webCaption.edit_user.title')}}  @else {{__('webCaption.personal_details.title')}} @endif 
				</h4>  
		  	</div>
			<hr class="m-0 p-0">

			<div class="card-body">
                 <div class="row">

					<div class="col-md-12">
						<div class="form-group">
							<x-dash.form.inputs.textarea id="" for="current_address" tooltip="{{__('webCaption.current_address.caption')}}"  label="{{__('webCaption.current_address.title')}}" maxlength="250"  name="current_address"  placeholder="{{__('webCaption.current_address.title')}}" value="{{old('current_address', isset($user->companySalesTeam->current_address) ? $user->companySalesTeam->current_address : '' )}}"  required="" />
						</div>
					</div> 		      

					<div class="col-md-4">
						<div class="form-group">
							<x-dash.form.inputs.select  onChange="stateLists(this.id,'current_state')" for="current_country" tooltip="{{__('webCaption.country.caption')}}"  label="{{__('webCaption.country.title')}}" name="current_country"  placeholder="{{__('webCaption.country.title')}}" :optionData="$country" customClass="country" editSelected="{{ old('current_country', isset($user->companySalesTeam->current_country_id) ? $user->companySalesTeam->current_country_id :'') }}" required="" />
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<x-dash.form.inputs.select onChange="cityList('current_state','current_city')" for="current_state" tooltip="{{__('webCaption.state.caption')}}"  label="{{__('webCaption.state.title')}}" name="current_state"  placeholder="{{__('webCaption.state.title')}}" :optionData="[]" editSelected="{{ old('current_state', isset($user->companySalesTeam->current_state_id) ? $user->companySalesTeam->current_state_id :'') }}" required="" />
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<x-dash.form.inputs.select for="current_city" tooltip="{{__('webCaption.city.caption')}}"  label="{{__('webCaption.city.title')}}" name="current_city"  placeholder="{{__('webCaption.city.title')}}" :optionData="[]"  editSelected="{{ old('current_city', isset($user->companySalesTeam->current_city_id) ? $user->companySalesTeam->current_city_id :'') }}" required="" />
						</div>
					</div>				
			
					<div class="col-md-4">
						<div class="form-group">
							<x-dash.form.inputs.text for="current_zip_code" maxlength="15" tooltip="{{__('webCaption.zip_code.caption')}}"  label="{{__('webCaption.zip_code.title')}}" name="current_zip_code"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{ old('current_zip_code', isset($user->companySalesTeam->current_zip_code) ? $user->companySalesTeam->current_zip_code :'' ) }}" required="" />
						</div>
					</div>

					<div class="col-md-12">
						<x-dash.form.label for="" tooltip="{{__('webCaption.same_as_current_address_title.caption')}}" value="{{__('webCaption.same_as_current_address_title.title')}}" class="mb-1" />
						<div class="form-group">
							<x-dash.form.inputs.checkbox for="same_as_current" tooltip="{{__('webCaption.same_as_current_address.caption')}}"  label="{{__('webCaption.same_as_current_address.title')}}" name="same_as_current"  placeholder="{{__('webCaption.same_as_current_address.title')}}" value="1" checked="{{(isset($user->companySalesTeam->same_as_current) && $user->companySalesTeam->same_as_current == '1') ? 'checked' : '' }}" required="" />
						</div>
					</div>

					<div class="col-12">
						<div class="form-group">
							<x-dash.form.inputs.textarea id="" for="permanent_address" tooltip="{{__('webCaption.permanent_address.caption')}}"  label="{{__('webCaption.permanent_address.title')}}" maxlength="250"  name="permanent_address"  placeholder="{{__('webCaption.permanent_address.title')}}" value="{{old('permanent_address', isset($user->companySalesTeam->permanent_address)?$user->companySalesTeam->permanent_address:'' )}}"  required="" />
						</div>
					</div>                     

					<div class="col-md-4 ">
						<div class="form-group">
							<x-dash.form.inputs.select onChange="stateLists(this.id,'permanent_state')" for="permanent_country" tooltip="{{__('webCaption.country.caption')}}"  label="{{__('webCaption.country.title')}}" name="permanent_country"  placeholder="{{__('webCaption.country.title')}}" :optionData="$country" customClass="country" editSelected="{{ old('permanent_country', isset($user->companySalesTeam->permanent_country_id) ? $user->companySalesTeam->permanent_country_id :'') }}" required="" />
						</div>
					</div>

					<div class="col-md-4 ">
						<div class="form-group">
							<x-dash.form.inputs.select onChange="cityList('permanent_state','permanent_city')" for="permanent_state" tooltip="{{__('webCaption.state.caption')}}"  label="{{__('webCaption.state.title')}}" name="permanent_state"  placeholder="{{__('webCaption.state.title')}}" :optionData="[]" editSelected="{{ old('permanent_state', isset($user->companySalesTeam->permanent_state_id) ? $user->companySalesTeam->permanent_state_id :'') }}" required="" />
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<x-dash.form.inputs.select for="permanent_city" tooltip="{{__('webCaption.city.caption')}}"  label="{{__('webCaption.city.title')}}" name="permanent_city"  placeholder="{{__('webCaption.city.title')}}" :optionData="[]" editSelected="{{ old('permanent_city', isset($user->companySalesTeam->permanent_city_id) ? $user->companySalesTeam->permanent_city_id :'') }}" required="" />
						</div>
					</div>
										 			 
					<div class="col-md-2">
						<div class="form-group">
							<x-dash.form.inputs.text for="permanent_zip_code" maxlength="15" tooltip="{{__   ('webCaption.zip_code.caption')}}"  label="{{__('webCaption.zip_code.title')}}" name="permanent_zip_code"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{ old('permanent_zip_code', isset($user->companySalesTeam->permanent_zip_code) ? $user->companySalesTeam->permanent_zip_code :'' ) }}" required="" />
						</div>
					</div>

					<div class="col-md-7">
						<div class="row">
							@php 
							$telephone  = (isset($user->companySalesTeam->personal_phone) && !empty($user->companySalesTeam->personal_phone)) ? explode('_',$user->companySalesTeam->personal_phone) : null;
        					$personal_phone = ($telephone != null) ? $telephone[1] : null;
					        $personal_country_code = (isset($telephone[0]))? $telephone[0] :null;  
							@endphp
							<div class="col-md-3 col-6">
								<div class="form-group">
								<x-dash.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="personal_country_code" name="personal_country_code"  required="" :optionData="$country_code"  editSelected="{{ old('personal_country_code' ,isset($personal_country_code) && !empty($personal_country_code) ? $personal_country_code : '') }}" />
								</div>
							</div>
							<div class="col-md-5 col-6 pl-0 pr-0">
								<div class="form-group">
									<x-dash.form.inputs.number id="" for="personal_phone"  tooltip="{{__('webCaption.phone.caption')}}" label="{{__('webCaption.phone.title')}}" maxlength="20"  name="personal_phone"  placeholder="{{__('webCaption.phone.title')}}" value="{{old('personal_phone', isset($personal_phone)?$personal_phone:'' )}}"  required="" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
								@if(isset($user->companySalesTeam->personal_messenger))
									@php $edit_personal_messenger = json_decode($user->companySalesTeam->personal_messenger); @endphp
								@else
									@php $edit_personal_messenger = ''; @endphp
								@endif
									@include('components.dash.form.inputs.messenger_common', ['id' => 'personal_messenger', 'name' => 'personal_messenger', 'editSelected' => $edit_personal_messenger])
								</div>
							</div>
						</div>
					</div>

					@php	
						$modelData = [
								'heading' => __('webCaption.add.title').' '.__('webCaption.religion.title'),
								'route' => '',
								'fields' => [
												[
													'type' =>'text',
													'name' => 'name',
													'id'   => 'name',
													'label' => 'name',
													'required' => 'required'
												],
												[
													'type' =>'select',
													'name' => 'parent_id',
													'id'   => 'religion_parent',
													'label' => 'name',
													'required' => 'required'
												],
							]
				];
// to be continue
					@endphp


					<div class="col-md-3 col-12">
						<div class="form-group">
							<x-dash.form.inputs.select_with_plus_icon  :modelData="$modelData" tooltip="{{__('webCaption.religion.caption')}}" label="{{__('webCaption.religion.title')}}"  id="" for="religion" name="religion" placeholder="{{ __('locale.religion.caption') }}" editSelected="{{ old('religion', isset($user->companySalesTeam->religion_id) ? $user->companySalesTeam->religion_id :'') }}"  required="" :optionData="$religion" />
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

				</div>
			</div>
		</div>



		<div class="card card-primary">
			<div class="card-header">
			<h4 class="card-title">		
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			</svg>
			@if(isset($user->id))  {{__('webCaption.edit_user.title')}}  @else {{__('webCaption.image_&_document_upload.title')}} @endif 
				</h4>  
			</div>
			<hr class="m-0 p-0">
			<div class="card-body">
				<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<x-dash.form.inputs.file id="" caption="{{__('webCaption.upload_image.title')}}" ImageId="user-image-preview" for="image"   name="image" editImageUrl="{{ isset($user->companySalesTeam->image)? asset('dash/sales_team/'.$user->companySalesTeam->image) :''}}" maxFileSize="5000" placeholder="{{__('webCaption.upload_image.title')}}" required="" />
						@if($errors->has('upload_image'))
						<x-dash.form.form_error_messages message="{{ $errors->first('upload_image') }}"  />
						@endif
					</div>
				</div>

				
			    </div>
		    </div>
       </div>
	   
		<!-----Personal---Social---details------->
		<div class="card card-primary">
		    <div class="card-header">
			  	<h4 class="card-title">		
			  		<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
					@if(isset($user->id))  {{__('webCaption.edit_user.title')}}  @else {{__('webCaption.personal_social_details.title')}} @endif 
				</h4>  
		  	</div>
			<hr class="m-0 p-0">

			<div class="card-body">
				{{-- Social Media Section  --}}
				<div class="row">
					@if(isset($user->companySalesTeam->company_social_media))
						@php $company_social_media = json_decode($user->companySalesTeam->company_social_media);
						@endphp
					@else
						@php $company_social_media = ''; @endphp
					@endif
					@include('components.dash.form.inputs.social_media', ['id' => 'social_media_company', 'name' => 'social_media', 'social_media' => $company_social_media])
			 	</div>

				<div class="row mt-3">
					<div class="col-md-12">
						<x-dash.form.label for="" value="{{__('webCaption.permission.title')}}" class="" />
						@if ($permissions)
						<div class="jstree-basic">
							<ul>
								@foreach ( $permissions as $permission )
									@if(count($permission->menuChild) > 0)
										<li class="jstree-open">
											<x-dash.form.inputs.checkbox  name="permissions[]"  for="{{$permission->id}}permission" label="{{$permission->title }}" checked="{{( isset($user) && (!empty($permission->permission_slug)) && $user->can($permission->permission_slug)) || in_array($permission->id,$old_permissions) ? 'checked' :''; }}"  value="{{ $permission->id }}" permisssionClass="form-check-inline"  customClass="form-check-input"  />	
												@include('dash.content.users.child_list',['items' => $permission->menuChild ]) 												
										</li>
									@else
										<li>
											<x-dash.form.inputs.checkbox  name="permissions[]"  for="{{$permission->id}}permission" label="{{ $permission->title }}" checked="{{ ( isset($user) && (!empty($permission->permission_slug)) && $user->can($permission->permission_slug)) || in_array($permission->id,$old_permissions) ? 'checked' :''; }}" permisssionClass="form-check-inline"  value="{{ $permission->id }}"  customClass="form-check-input"  />
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

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
@endsection

@php
$company_state_id = session()->getOldInput('company_state');
$company_city_id = session()->getOldInput('company_city');

$company_country_id =  (isset($company_country_id)) ? $company_country_id : ( (isset($user->companySalesTeam->company_country_id)) ? $user->companySalesTeam->company_country_id : old('company_country'));

$company_state_id =  (isset($company_state_id)) ? $company_state_id : ( (isset($user->companySalesTeam->company_state_id)) ? $user->companySalesTeam->company_state_id : old('company_state'));

$company_city_id =  (isset($company_city_id)) ? $company_city_id : ( (isset($user->companySalesTeam->company_city_id)) ? $user->companySalesTeam->company_city_id : old('company_city'));


$current_state_id = session()->getOldInput('current_state');
$current_city_id = session()->getOldInput('current_city');

$current_country_id =  (isset($current_country_id)) ? $current_country_id : ( (isset($user->companySalesTeam->current_country_id)) ? $user->companySalesTeam->current_country_id : old('current_country'));

$current_state_id =  (isset($current_state_id)) ? $current_state_id : ( (isset($user->companySalesTeam->current_state_id)) ? $user->companySalesTeam->current_state_id : old('current_state'));

$current_city_id =  (isset($current_city_id)) ? $current_city_id : ( (isset($user->companySalesTeam->current_city_id)) ? $user->companySalesTeam->current_city_id : old('current_city'));


$permanent_state_id = session()->getOldInput('permanent_state');
$permanent_city_id = session()->getOldInput('permanent_city');

$permanent_country_id =  (isset($permanent_country_id)) ? $permanent_country_id : ( (isset($user->companySalesTeam->permanent_country_id)) ? $user->companySalesTeam->permanent_country_id : old('permanent_country'));

$permanent_state_id =  (isset($permanent_state_id)) ? $permanent_state_id : ( (isset($user->companySalesTeam->permanent_state_id)) ? $user->companySalesTeam->permanent_state_id : old('permanent_state'));

$permanent_city_id =  (isset($permanent_city_id)) ? $permanent_city_id : ( (isset($user->companySalesTeam->permanent_city_id)) ? $user->companySalesTeam->permanent_city_id : old('permanent_city'));

@endphp

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

		//For MESSENGER
		messengerImageCode();
		$(".messenger").each(function() {
			messengerSelect(this.id);
		});
	});

	let company_country_id =  "{{$company_country_id}}";
    let company_state_id = "{{$company_state_id}}";
    let company_city_id = "{{$company_city_id}}";

    if(company_country_id != ''){
      stateLists('company_country','company_state', company_state_id);
    }
    if(company_city_id != ''){
      cityList('company_state','company_city', company_city_id, company_state_id);
    }

	let current_country_id =  "{{$current_country_id}}";
    let current_state_id = "{{$current_state_id}}";
    let current_city_id = "{{$current_city_id}}";

    if(current_country_id != ''){
      stateLists('current_country','current_state', current_state_id);
    }
    if(current_city_id != ''){
      cityList('current_state','current_city', current_city_id, current_state_id);
    }


	let permanent_country_id =  "{{$permanent_country_id}}";
    let permanent_state_id = "{{$permanent_state_id}}";
    let permanent_city_id = "{{$permanent_city_id}}";

    if(permanent_country_id != ''){
      stateLists('permanent_country','permanent_state', permanent_state_id);
    }
    if(permanent_city_id != ''){
      cityList('permanent_state','permanent_city', permanent_city_id, permanent_state_id);
    }
</script>
@endpush
@include('components.dash.form.country_state_city')