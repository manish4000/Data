@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.company.title') )
@else
@section('title', __('webCaption.company.title'))
@endif
@section('content')
<div>
   <form action="" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card card-primary">
         <div class="card-header">
            <h4 class="card-title">
               <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check font-medium-3 mr-1">
                  <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="8.5" cy="7" r="4"></circle>
                  <polyline points="17 11 19 13 23 9"></polyline>
               </svg>
               {{__('webCaption.account_details.title')}}
            </h4>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-8">
                  <div class="form-group">
                     <x-dash.form.inputs.text id="" for="company_name" tooltip="{{__('webCaption.company_name.caption')}}" label="{{__('webCaption.company_name.title')}}" maxlength="100" class="form-control" name="company_name"  placeholder="{{__('webCaption.company_name.title')}}" value="{{old('company_name', isset($data->company_name)?$data->company_name:'' )}}"  required="required" />
                     @if($errors->has('company_name'))
                     <x-admin.form.form_error_messages message="{{ $errors->first('company_name') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.text id="" label="{{__('webCaption.dealer_type.title')}}" tooltip="{{__('webCaption.dealer_type.caption')}}" for="dealer_type" class="form-control" maxlength="6" name="dealer_type"  placeholder="{{__('webCaption.dealer_type.title')}}" value="{{old('dealer_type', isset($data->gabs_uuid)?$data->dealer_type:'' )}}"  required="required" />
                     @if($errors->has('gabs_uuid'))
                     <x-admin.form.form_error_messages message="{{ $errors->first('dealer_type') }}"  />
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.text  for="short_name"  maxlength="20" tooltip="{{__('webCaption.short_name.caption')}}" label="{{__('webCaption.short_name.title')}}"  class="form-control" name="short_name"  placeholder="{{__('webCaption.short_name.title')}}" value="{{old('short_name', isset($data->title)?$data->short_name:'' )}}"  required="required" />
                     @if ($errors->has('title'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.text  for="login_id"  maxlength="20" tooltip="{{__('webCaption.login_id.caption')}}" label="{{__('webCaption.login_id.title')}}"  class="form-control" name="login_id"  placeholder="{{__('webCaption.login_id.title')}}" value="{{old('login_id', isset($data->title)?$data->login_id:'' )}}"  required="required" />
                     @if ($errors->has('title'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('login_id') }}" />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.password id="" tooltip="{{__('webCaption.password.caption')}}"    label="{{__('webCaption.password.title')}}" for="password" class="form-control"    maxlength="15" name="password"  placeholder="{{__('webCaption.password.title')}}"    value=""  required="required" />
                     @if($errors->has('password'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('password') }}"  />
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.status.title')}}" 
                        tooltip="{{__('webCaption.status.caption')}}" for="status" name="status"
                        placeholder="{{ __('locale.country.caption') }}" customClass="status"  editSelected="{{(isset($data->status) && ($data->status != null)) ? $data->status :'' }}"  required="required"  />
                     @if($errors->has('status'))
                     <x-admin.form.form_error_messages message="{{ $errors->first('status') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.email id="" for="email_1" tooltip="{{__('webCaption.email_1.caption')}}" label="{{__('webCaption.email_1.title')}}" maxlength="45" class="form-control" name="email_1"  placeholder="{{__('webCaption.email_1.title')}}" value="{{old('email_1_1', isset($data->email)?$data->email_1:'' )}}"  required="required" />
                     @if($errors->has('email_1'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('email_1') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.email id="" for="email_2" tooltip="{{__('webCaption.email_2.caption')}}" label="{{__('webCaption.email_2.title')}}" maxlength="45" class="form-control" name="email_1"  placeholder="{{__('webCaption.email_2.title')}}" value="{{old('email_2', isset($data->email_2)?$data->email_2:'' )}}"  required="required" />
                     @if($errors->has('email_1'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('email_2') }}"  />
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.membership.title')}}" 
                        tooltip="{{__('webCaption.membership.caption')}}" for="membership" name="membership"
                        placeholder="{{ __('locale.country.caption') }}" customClass="membership"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->membership :'' }}"  required="required"  />
                     @if($errors->has('membership'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.file id="" caption="{{__('webCaption.user_image.title')}}" ImageId="user-image-preview" for="image"  class="form-control" name="image" editImageUrl="{{ isset($data->image)? asset('company_data/'.$imageFolder.'/testimonials/'.$data->image) :''}}"  placeholder="{{__('webCaption.user_image.title')}}" required="required" />
                     @if($errors->has('user_image'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('user_image') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.file id="" caption="{{__('webCaption.vehicle_image.title')}}" ImageId="vehicle-image-preview" for="vehicle_image" editImageUrl="{{ isset($data->vehicle_image)? asset('company_data/'.$imageFolder.'/testimonials/'.$data->vehicle_image) :''}}"  class="form-control"  name="vehicle_image"  placeholder="{{__('webCaption.vehicle_image.title')}}" required="required" />
                     @if($errors->has('vehicle_image'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_image') }}"  />
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card card-primary">
         <div class="card-header">
            <h4 class="card-title">
               <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1">
                  <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                  <line x1="8" y1="2" x2="8" y2="18"></line>
                  <line x1="16" y1="6" x2="16" y2="22"></line>
               </svg>
               {{__('webCaption.contact_details.title')}}
            </h4>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-8">
                  <div class="form-group">
                     <x-dash.form.inputs.text id="" for="address" tooltip="{{__('webCaption.address.caption')}}" label="{{__('webCaption.address.title')}}" maxlength="100"  class="form-control" name="address"  placeholder="{{__('webCaption.address.title')}}" value="{{old('address', isset($data->address)? $data->address:'' )}}"  required="required" />
                     @if($errors->has('address'))
                     <x-admin.form.form_error_messages message="{{ $errors->first('address') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.text id="" for="post_code" tooltip="{{__('webCaption.post_code.caption')}}" label="{{__('webCaption.post_code.title')}}" maxlength="100"  class="form-control" name="post_code"  placeholder="{{__('webCaption.post_code.title')}}" value="{{old('post_code', isset($data->post_code)? $data->post_code:'' )}}"  required="required" />
                     @if($errors->has('post_code'))
                     <x-admin.form.form_error_messages message="{{ $errors->first('post_code') }}"  />
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.country.title')}}" 
                        tooltip="{{__('webCaption.country.caption')}}" for="country" name="country"
                        placeholder="{{ __('locale.country.caption') }}" customClass="country"  editSelected="{{(isset($data->country) && ($data->country != null)) ? $data->country :'' }}"  required="required"  />
                     @if($errors->has('country'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('country') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.state.title')}}" 
                        tooltip="{{__('webCaption.state.caption')}}" for="state" name="state"
                        placeholder="{{ __('locale.state.caption') }}" customClass="state"  editSelected="{{(isset($data->state) && ($data->state != null)) ? $data->state :'' }}"  required="required"  />
                     @if($errors->has('state'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('state') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.city.title')}}" 
                        tooltip="{{__('webCaption.city.caption')}}" for="city" name="city"
                        placeholder="{{ __('locale.city.caption') }}" customClass="city"  editSelected="{{(isset($data->city) && ($data->city != null)) ? $data->city :'' }}"  required="required"  />
                     @if($errors->has('city'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('city') }}"  />
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.text  for="skype"  maxlength="20" tooltip="{{__('webCaption.skype.caption')}}" label="{{__('webCaption.skype.title')}}"  class="form-control" name="skype"  placeholder="{{__('webCaption.skype.title')}}" value="{{old('skype', isset($data->title)?$data->skype:'' )}}"  required="required" />
                     @if ($errors->has('title'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('skype') }}" />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <fieldset>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group">
                              <x-dash.form.inputs.select label="{{__('webCaption.country_code.title')}}" 
                                 tooltip="{{__('webCaption.country_code.caption')}}" for="country_code" name="country_code"
                                 placeholder="{{ __('locale.country_code.caption') }}" customClass="country_code"  editSelected="{{(isset($data->country_code) && ($data->country_code != null)) ? $data->country_code :'' }}"  required="required"  />
                              @if($errors->has('country_code'))
                              <x-dash.form.form_error_messages message="{{ $errors->first('country_code') }}"  />
                              @endif
                           </div>
                        </div>
                        <div class="col-md-7">
                           <div class="form-group">
                              <x-dash.form.inputs.text  for="phone_1"  maxlength="20" tooltip="{{__('webCaption.phone_1.caption')}}" label="{{__('webCaption.phone_1.title')}}"  class="form-control" name="phone_1"  placeholder="{{__('webCaption.phone_1.title')}}" value="{{old('phone_1', isset($data->title)?$data->Phone_1:'' )}}"  required="required" />
                              @if ($errors->has('phone_1'))
                              <x-dash.form.form_error_messages message="{{ $errors->first('phone_1') }}" />
                              @endif
                           </div>
                        </div>
                     </div>
                  </fieldset>
               </div>
               <div class="col-md-4">
                  <x-dash.form.label for="" tooltip="{{__('webCaption.phone_1_contact_options.caption')}}" value="{{__('webCaption.phone_1_contact_options.title')}}" class="" />
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
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.text  for="skype"  maxlength="20" tooltip="{{__('webCaption.skype.caption')}}" label="{{__('webCaption.skype.title')}}"  class="form-control" name="skype"  placeholder="{{__('webCaption.skype.title')}}" value="{{old('skype', isset($data->title)?$data->skype:'' )}}"  required="required" />
                     @if ($errors->has('title'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('skype') }}" />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <fieldset>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group">
                              <x-dash.form.inputs.select label="{{__('webCaption.country_code.title')}}" 
                                 tooltip="{{__('webCaption.country_code.caption')}}" for="country_code_2" name="country_code"
                                 placeholder="{{ __('locale.country_code.caption') }}" customClass="country_code"  editSelected="{{(isset($data->country_code) && ($data->country_code != null)) ? $data->country_code :'' }}"  required="required"  />
                              @if($errors->has('country_code'))
                              <x-dash.form.form_error_messages message="{{ $errors->first('country_code') }}"  />
                              @endif
                           </div>
                        </div>
                        <div class="col-md-7">
                           <div class="form-group">
                              <x-dash.form.inputs.text  for="phone_2"  maxlength="20" tooltip="{{__('webCaption.phone_2.caption')}}" label="{{__('webCaption.phone_2.title')}}"  class="form-control" name="phone_2"  placeholder="{{__('webCaption.phone_2.title')}}" value="{{old('phone_2', isset($data->title)?$data->Phone_2:'' )}}"  required="required" />
                              @if ($errors->has('phone_2'))
                              <x-dash.form.form_error_messages message="{{ $errors->first('phone_2') }}" />
                              @endif
                           </div>
                        </div>
                     </div>
                  </fieldset>
               </div>
               <div class="col-md-4">
                  <x-dash.form.label for="" tooltip="{{__('webCaption.phone_2_contact_options.caption')}}" value="{{__('webCaption.phone_2_contact_options.title')}}" class="" />
                  <div class="form-group">
                     <x-admin.form.inputs.checkbox for="whatsapp_2" tooltip="{{__('webCaption.whatsapp.caption')}}" name="whatsapp" label="{{__('webCaption.whatsapp.title')}}" checked="{{ old('whatsapp') == '1' ? 'checked' : '' }} {{ isset($data->whatsapp) ? $data->whatsapp == '1' ? 'checked=checked' :'' :'' }}"  value="1"  customClass="form-check-input"  />
                     @if($errors->has('whatsapp'))
                     <x-admin.form.form_error_messages message="{{ $errors->first('whatsapp') }}" />
                     @endif	
                     <x-admin.form.inputs.checkbox for="viber_2" tooltip="{{__('webCaption.viber.caption')}}" name="viber" label="{{__('webCaption.viber.title')}}" checked="{{ old('viber') == '1' ? 'checked' : '' }} {{ isset($data->viber) ? $data->viber == '1' ? 'checked=checked' :'' :'' }}"  value="1"  customClass="form-check-input"  />
                     @if($errors->has('viber'))
                     <x-admin.form.form_error_messages message="{{ $errors->first('viber') }}" />
                     @endif		
                     <x-admin.form.inputs.checkbox for="line_2" tooltip="{{__('webCaption.line.caption')}}" name="line" label="{{__('webCaption.line.title')}}" checked="{{ old('line') == '1' ? 'checked' : '' }} {{ isset($data->line) ? $data->line == '1' ? 'checked=checked' :'' :'' }}"  value="1"  customClass="form-check-input"  />
                     @if($errors->has('line'))
                     <x-admin.form.form_error_messages message="{{ $errors->first('line') }}" />
                     @endif		
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card card-primary">
         <div class="card-header">
            <h4 class="card-title">
               <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers font-medium-3 mr-1">
                  <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                  <polyline points="2 17 12 22 22 17"></polyline>
                  <polyline points="2 12 12 17 22 12"></polyline>
               </svg>
               {{__('webCaption.general_details.title')}}
            </h4>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.ownership_types.title')}}" 
                        tooltip="{{__('webCaption.ownership_types.caption')}}" for="ownership_types" name="ownership_types"
                        placeholder="{{ __('locale.ownership_types.caption') }}" customClass="ownership_types"  editSelected="{{(isset($data->ownership_types) && ($data->ownership_types != null)) ? $data->ownership_types :'' }}"  required="required"  />
                     @if($errors->has('ownership_types'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('ownership_types') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.language.title')}}" 
                        tooltip="{{__('webCaption.language.caption')}}" for="language" name="language"
                        placeholder="{{ __('locale.language.caption') }}" customClass="language"  editSelected="{{(isset($data->language) && ($data->language != null)) ? $data->language :'' }}"  required="required"  />
                     @if($errors->has('language'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('language') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.payment_terms.title')}}" 
                        tooltip="{{__('webCaption.payment_terms.caption')}}" for="payment_terms" name="payment_terms"
                        placeholder="{{ __('locale.payment_terms.caption') }}" customClass="payment_terms"  editSelected="{{(isset($data->payment_terms) && ($data->payment_terms != null)) ? $data->payment_terms :'' }}"  required="required"  />
                     @if($errors->has('payment_terms'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('payment_terms') }}"  />
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.year_established.title')}}" 
                        tooltip="{{__('webCaption.year_established.caption')}}" for="year_established" name="year_established"
                        placeholder="{{ __('locale.year_established.caption') }}" customClass="year_established"  editSelected="{{(isset($data->year_established) && ($data->year_established != null)) ? $data->year_established :'' }}"  required="required"  />
                     @if($errors->has('year_established'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('year_established') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.no_of_staffs.title')}}" 
                        tooltip="{{__('webCaption.no_of_staffs.caption')}}" for="no_of_staffs" name="no_of_staffs"
                        placeholder="{{ __('locale.no_of_staffs.caption') }}" customClass="no_of_staffs"  editSelected="{{(isset($data->no_of_staffs) && ($data->no_of_staffs != null)) ? $data->no_of_staffs :'' }}"  required="required"  />
                     @if($errors->has('no_of_staffs'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('no_of_staffs') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.office_timing.title')}}" 
                        tooltip="{{__('webCaption.office_timing.caption')}}" for="office_timing" name="office_timing"
                        placeholder="{{ __('locale.office_timing.caption') }}" customClass="office_timing"  editSelected="{{(isset($data->office_timing) && ($data->office_timing != null)) ? $data->office_timing:'' }}"  required="required"  />
                     @if($errors->has('office_timing'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('office_timing') }}"  />
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.text  for="holidays_values" tooltip="{{__('webCaption.holidays_values.caption')}}" label="{{__('webCaption.holidays_values.title')}}"  class="form-control" name="holidays_values"  placeholder="{{__('webCaption.holidays_values.title')}}" value="{{old('holidays_values', isset($data->title)?$data->holidays_values:'' )}}"  required="required" />
                     @if ($errors->has('holidays_values'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('holidays_values') }}" />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.deals_in.title')}}" 
                        tooltip="{{__('webCaption.deals_in.caption')}}" for="deals_in" name="deals_in"
                        placeholder="{{ __('locale.deals_in.caption') }}" customClass="deals_in"  editSelected="{{(isset($data->deals_in) && ($data->deals_in != null)) ? $data->deals_in :'' }}"  required="required"  />
                     @if($errors->has('deals_in'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('deals_in') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.business_type.title')}}" 
                        tooltip="{{__('webCaption.business_type.caption')}}" for="business_type" name="business_type"
                        placeholder="{{ __('locale.business_type.caption') }}" customClass="business_type"  editSelected="{{(isset($data->business_type) && ($data->business_type != null)) ? $data->business_type :'' }}"  required="required"  />
                     @if($errors->has('business_types'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('business_type') }}"  />
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.membership_in.title')}}" 
                        tooltip="{{__('webCaption.membership_in.caption')}}" for="membership_in" name="membership_in"
                        placeholder="{{ __('locale.membership_in.caption') }}" customClass="membership_in"  editSelected="{{(isset($data->membership_in) && ($data->membership_in != null)) ? $data->membership_in :'' }}"  required="required"  />
                     @if($errors->has('membership_in'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('membership_in') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.text  for="dealer_permit_number" tooltip="{{__('webCaption.dealer_permit_number.caption')}}" label="{{__('webCaption.dealer_permit_number.title')}}"  class="form-control" name="dealer_permit_number"  placeholder="{{__('webCaption.dealer_permit_number.title')}}" value="{{old('dealer_permit_number', isset($data->title)?$data->dealer_permit_number:'' )}}"  required="required" />
                     @if ($errors->has('dealer_permit_number'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('dealer_permit_number') }}" />
                     @endif
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <x-dash.form.inputs.select label="{{__('webCaption.business_type.title')}}" 
                        tooltip="{{__('webCaption.business_type.caption')}}" for="business_type_pending" name="business_type"
                        placeholder="{{ __('locale.business_type.caption') }}" customClass="business_type"  editSelected="{{(isset($data->business_type) && ($data->business_type != null)) ? $data->business_type :'' }}"  required="required"  />
                     @if($errors->has('business_types'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('business_type') }}"  />
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card card-primary">
         <div class="card-header">
            <h4 class="card-title">
               <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info font-medium-3 mr-1">
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="12" y1="16" x2="12" y2="12"></line>
                  <line x1="12" y1="8" x2="12.01" y2="8"></line>
               </svg>
               {{__('webCaption.information.title')}}
            </h4>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group">
                     <x-dash.form.inputs.text  for="slogan" tooltip="{{__('webCaption.slogan.caption')}}" label="{{__('webCaption.slogan.title')}}"  class="form-control" name="slogan"  placeholder="{{__('webCaption.slogan.title')}}" value="{{old('slogan', isset($data->title)?$data->slogan:'' )}}"  required="required" />
                     @if ($errors->has('slogan'))
                     <x-dash.form.form_error_messages message="{{ $errors->first('slogan') }}" />
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <x-dash.form.inputs.textarea id="" for="hp_welcome_text" tooltip="{{__('webCaption.hp_welcome_text.caption')}}"  label="{{__('webCaption.hp_welcome_text.title')}}" maxlength="250" class="form-control" name="hp_welcome_text"  placeholder="{{__('webCaption.hp_welcome_text.title')}}" value="{{old('hp_welcome_text', isset($data->hp_welcome_text)?$data->hp_welcome_text:'' )}}"  required="" />
                     @if($errors->has('hp_welcome_text'))
                     <x-admin.form.form_error_messages message="{{ $errors->first('hp_welcome_text') }}"  />
                     @endif
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <x-dash.form.inputs.textarea id="" for="members_of" tooltip="{{__('webCaption.members_of.caption')}}" label="{{__('webCaption.members_of.title')}}" maxlength="250" class="form-control" name="members_of"  placeholder="{{__('webCaption.members_of.title')}}" value="{{old('members_of', isset($data->members_of)?$data->members_of:'' )}}"  required="" />
                     @if($errors->has('members_of'))
                     <x-admin.form.form_error_messages message="{{ $errors->first('members_of') }}"  />
                     @endif
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group">
                     <x-dash.form.inputs.textarea id="" for="about_company_text" tooltip="{{__('webCaption.about_company_text.caption')}}"  label="{{__('webCaption.about_company_text.title')}}" maxlength="250" class="form-control" name="about_company_text"  placeholder="{{__('webCaption.about_company_text.title')}}" value="{{old('about_company_text', isset($data->about_company_text)?$data->about_company_text:'' )}}"  required="" />
                     @if($errors->has('about_company_text'))
                     <x-admin.form.form_error_messages message="{{ $errors->first('about_company_text') }}"  />
                     @endif
                  </div>
               </div>
               
            </div>
         </div>
      </div>




      



   </form>
</div>
@endsection