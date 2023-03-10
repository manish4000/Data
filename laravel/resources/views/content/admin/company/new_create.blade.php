@extends('layouts/contentLayoutMaster')
{{-- @section('title', $pageConfigs['moduleName']) --}}
@if(isset($data->id) && !empty($data->id))
   @section('title', __('webCaption.company_edit.title'))
@else
   @section('title', __('webCaption.company_add.title'))
@endif



@section('content')
   <!-- users edit start -->

   <form action="{{route('company.store')}}" method="POST"  enctype="multipart/form-data">

      @csrf

      <section class="form-control-repeater">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check font-medium-3 mr-1"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                  {{__('webCaption.account_details.title')}}
               </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-8">
                     <div class="form-group">
                        <x-admin.form.inputs.text id="" for="company_name" tooltip="{{__('webCaption.company_name.caption')}}" label="{{__('webCaption.company_name.title')}}" maxlength="100" class="form-control" name="company_name"  placeholder="{{__('webCaption.company_name.title')}}" value="{{old('company_name', isset($data->company_name)?$data->company_name:'' )}}"  required="required" />
                        @if($errors->has('company_name'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('company_name') }}"  />
                        @endif
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.text id="" label="{{__('webCaption.gabs_uuid.title')}}" tooltip="{{__('webCaption.gabs_uuid.caption')}}" for="gabs_uuid" class="form-control" maxlength="6" name="gabs_uuid"  placeholder="{{__('webCaption.gabs_uuid.title')}}" value="{{old('gabs_uuid', isset($data->gabs_uuid)?$data->gabs_uuid:'' )}}"  required="required" />
                        @if($errors->has('gabs_uuid'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('gabs_uuid') }}"  />
                        @endif
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.email id="" for="email" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}" maxlength="45" class="form-control" name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($data->email)?$data->email:'' )}}"  required="required" />
                        @if($errors->has('email'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('email') }}"  />
                        @endif
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.password id="" tooltip="{{__('webCaption.password.caption')}}" label="{{__('webCaption.password.title')}}" for="password" class="form-control" maxlength="15" name="password"  placeholder="{{__('webCaption.password.title')}}" value=""  required="required" />
                        @if($errors->has('password'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('password') }}"  />
                        @endif
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.select label="{{__('webCaption.status.title')}}" tooltip="{{__('webCaption.status.caption')}}"  id="" for="status" name="status" placeholder="{{ __('locale.status.caption') }}" editSelected=""  required="" :optionData="$status" />
                        @if($errors->has('status'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('status') }}"  />
                        @endif
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <x-admin.form.inputs.textarea id="" for="address" tooltip="{{__('webCaption.address.caption')}}" label="{{__('webCaption.address.title')}}" maxlength="250" class="form-control" name="address"  placeholder="{{__('webCaption.address.title')}}" value="{{old('address', isset($data->address)?$data->address:'' )}}"  required="" />
                        @if($errors->has('address'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('address') }}"  />
                        @endif
                     </div>
                  </div>
               </div>
               <div class="row">

                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.select label="{{__('webCaption.country.title')}}"  tooltip="{{__('webCaption.country.caption')}}" for="country_id" name="country_id"
                                                    placeholder="{{ __('locale.country.caption') }}" customClass="country"  editSelected="{{(isset($data->country_id) && ($data->country_id != null)) ? $data->country_id :'' }}"  required="required" :optionData="$country" />
                        @if($errors->has('country_id'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('country_id') }}"  />
                        @endif
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.select label="{{__('webCaption.state.title')}}"  tooltip="{{__('webCaption.state.caption')}}"  customClass="state" id="" for="state_id" name="state_id" placeholder="{{ __('locale.state.caption') }}" editSelected=""  required="" :optionData="[]" />
                        @if($errors->has('state_id'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('state_id') }}"  />
                        @endif
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.select label="{{__('webCaption.city.title')}}"   tooltip="{{__('webCaption.city.caption')}}" id="" for="city_id" name="city_id" placeholder="{{ __('locale.city.caption') }}" editSelected=""  required="" :optionData="[]" />
                        @if($errors->has('city_id'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('city_id') }}"  />
                        @endif
                     </div>
                  </div>

               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.text id="" for="postcode"  tooltip="{{__('webCaption.postcode.caption')}}" label="{{__('webCaption.postcode.title')}}" maxlength="15" class="form-control" name="postcode"  placeholder="{{__('webCaption.postcode.title')}}" value="{{old('postcode', isset($data->postcode)?$data->postcode:'' )}}"  required="" />
                        @if($errors->has('postcode'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('postcode') }}"  />
                        @endif
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.select label="{{__('webCaption.region.title')}}"   tooltip="{{__('webCaption.region.caption')}}" id="" for="region_id" name="region_id" placeholder="{{ __('locale.region.caption') }}" editSelected=""  required="" :optionData="[]" />
                        @if($errors->has('region_id'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('region_id') }}"  />
                        @endif
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.text id="" for="telephone"  tooltip="{{__('webCaption.telephone.caption')}}" label="{{__('webCaption.telephone.title')}}" maxlength="20" class="form-control" name="telephone"  placeholder="{{__('webCaption.telephone.title')}}" value="{{old('telephone', isset($data->telephone)?$data->telephone:'' )}}"  required="required" />
                        @if($errors->has('telephone'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('telephone') }}"  />
                        @endif
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.text id="" for="skype"  tooltip="{{__('webCaption.skype.caption')}}" label="{{__('webCaption.skype.title')}}" maxlength="50" class="form-control" name="skype_id"  placeholder="{{__('webCaption.skype.title')}}" value="{{old('skype_id', isset($data->skype_id)?$data->skype_id:'' )}}"  required="" />
                        @if($errors->has('skype_id'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('skype_id') }}"  />
                        @endif
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.text id="" for="website" tooltip="{{__('webCaption.website.caption')}}" label="{{__('webCaption.website.title')}}" maxlength="75" class="form-control" name="website"  placeholder="{{__('webCaption.website.title')}}" value="{{old('website', isset($data->website)?$data->website:'' )}}"  required="" />
                        @if($errors->has('website'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('website') }}"  />
                        @endif
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.file id="" caption="{{__('webCaption.upload_logo.title')}}" ImageId="logo-preview" for="logo"  class="form-control" name="logo"  placeholder="{{__('webCaption.logo.title')}}" required="required" />
                        @if($errors->has('logo'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('logo') }}"  />
                        @endif
                     </div>
                  </div>
               </div>


            </div>
         </div>
         <div class="card">
            <div class="card-header">
               <h4 class="card-title">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers font-medium-3 mr-1"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                  {{__('webCaption.general_details.title')}}
               </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.select  tooltip="{{__('webCaption.package.caption')}}" label="{{__('webCaption.package.title')}}"  id="" for="package_id" name="package_id" placeholder="{{__('webCaption.package_id.title')}}" editSelected=""  required="" :optionData="[]" />
                        @if($errors->has('package_id'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('package_id') }}"  />
                        @endif
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.select tooltip="{{__('webCaption.business_type.caption')}}" label="{{__('webCaption.business_type.title')}}"  id="" for="business_type_id" name="business_type_id" placeholder="{{__('webCaption.business_type_id.title')}}" editSelected=""  required="" :optionData="$BusinessTypes" />
                        @if($errors->has('business_type_id'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('business_type_id') }}"  />
                        @endif
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.select label="{{__('webCaption.association_member.title')}}" tooltip="{{__('webCaption.association_member.caption')}}"  id="" for="association_member_id" name="association_member_id"  editSelected=""  required="" :optionData="[]" />
                        @if($errors->has('association_member_id'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('association_member_id') }}"  />
                        @endif
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <x-admin.form.inputs.textarea id="" for="permit_number" tooltip="{{__('webCaption.permit_number.caption')}}"  label="{{__('webCaption.permit_number.title')}}" maxlength="250" class="form-control" name="permit_no"  placeholder="{{__('webCaption.permit_no.title')}}" value="{{old('permit_no', isset($data->permit_no)?$data->permit_no:'' )}}"  required="" />
                        @if($errors->has('permit_no'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('permit_no') }}"  />
                        @endif
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <x-admin.form.inputs.textarea id="" for="admin_comment" tooltip="{{__('webCaption.admin_comment.caption')}}" label="{{__('webCaption.admin_comment.title')}}" maxlength="250" class="form-control" name="admin_comment"  placeholder="{{__('webCaption.admin_comment.title')}}" value="{{old('admin_comment', isset($data->admin_comment)?$data->admin_comment:'' )}}"  required="" />
                        @if($errors->has('admin_comment'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('admin_comment') }}"  />
                        @endif
                     </div>
                  </div>

               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="card border">
                        <div class="card-header">
                           <h6 class="card-title">
                              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers font-medium-3 mr-1"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                              {{__('webCaption.upload_document_files.title')}}
                           </h6>
                        </div>
                        <hr class="m-0 p-0">
                        <div class="row m-2">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <x-admin.form.inputs.file id="" caption="{{__('webCaption.document_upload.title')}}" for="document"  class="form-control" name="document[]"  placeholder="{{__('webCaption.document.title')}}" required=""   multiple="multiple" />
                                 @if($errors->has('document'))
                                    <x-admin.form.form_error_messages message="{{ $errors->first('document') }}"  />
                                 @endif
                              </div>
                           </div>
                            <div class="col-md-6">
                               <div class="form-group">
                                   <x-admin.form.inputs.file id="" caption="{{__('webCaption.document_upload.title')}}" for="document"  class="form-control" name="document[]"  placeholder="{{__('webCaption.logo.title')}}" required="" />
                                   @if($errors->has('logo'))
                                   <x-admin.form.form_error_messages message="{{ $errors->first('logo') }}"  />
                                   @endif
                               </div>
                           </div>
                        </div>
                         <div class="row m-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-admin.form.inputs.file id="" caption="{{__('webCaption.document_upload.title')}}" for="document"  class="form-control" name="document[]"  placeholder="{{__('webCaption.logo.title')}}" required="" />
                                    @if($errors->has('logo'))
                                    <x-admin.form.form_error_messages message="{{ $errors->first('logo') }}"  />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-admin.form.inputs.file id="" caption="{{__('webCaption.document_upload.title')}}" for="document"  class="form-control" name="document[]"  placeholder="{{__('webCaption.logo.title')}}" required="" />
                                    @if($errors->has('logo'))
                                    <x-admin.form.form_error_messages message="{{ $errors->first('logo') }}"  />
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-admin.form.inputs.file id="" caption="{{__('webCaption.document_upload.title')}}" for="document"  class="form-control" name="document[]"  placeholder="{{__('webCaption.logo.title')}}" required="" />
                                    @if($errors->has('logo'))
                                    <x-admin.form.form_error_messages message="{{ $errors->first('logo') }}"  />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-admin.form.inputs.file id="" caption="{{__('webCaption.document_upload.title')}}" for="document"  class="form-control" name="document[]"  placeholder="{{__('webCaption.logo.title')}}" required="" />
                                    @if($errors->has('logo'))
                                    <x-admin.form.form_error_messages message="{{ $errors->first('logo') }}"  />
                                    @endif
                                </div>
                            </div>
                        </div>

                     </div>
                  </div>
                   <div class="col-md-4">
                      <div class="form-group">
                          <x-admin.form.inputs.select label="{{__('webCaption.marketing_status.title')}}"  id="" for="marketing_status" name="marketing_status" placeholder="{{__('webCaption.marketing_status.title')}}" editSelected=""  required="" :optionData="[]" />
                            @if($errors->has('marketing_status'))
                            <x-admin.form.form_error_messages message="{{ $errors->first('marketing_status') }}"  />
                            @endif
                      </div>
                  </div>

               </div>


            </div>
         </div>
         <div class="card">
            <div class="card-header">
               <h4 class="card-title">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info font-medium-3 mr-1"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                  {{__('webCaption.contact_person_details.title')}}
               </h4>
            </div>
            <hr class="m-0 p-0">
            <div id="container">

               <div class="card-body" >
                  <h4 class="card-title">  {{__('webCaption.contact_person_1.title')}} </h4>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <x-admin.form.inputs.text id="" for="contact_1_name" tooltip="{{__('webCaption.name.caption')}}" label="{{__('webCaption.name.title')}}" maxlength="100" class="form-control" name="contact_name[]"  placeholder="{{__('webCaption.name.title')}}" value=""  required="" />
                           @if($errors->has('contact_name.0'))
                              <x-admin.form.form_error_messages message="{{ $errors->first('contact_name.0') }}"  />
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <x-admin.form.inputs.text id="" for="contact_1_designation" tooltip="{{__('webCaption.designation.caption')}}" label="{{__('webCaption.designation.title')}}" maxlength="50" class="form-control" name="contact_designation[]"  placeholder="{{__('webCaption.designation.title')}}" value=""  required="" />
                           @if($errors->has('contact_designation0'))
                              <x-admin.form.form_error_messages message="{{ $errors->first('contact_designation0') }}"  />
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <x-admin.form.inputs.email id="" for="contact_1_email" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}" maxlength="50" class="form-control" name="contact_email[]"  placeholder="{{__('webCaption.email.title')}}" value=""  required="" />
                           @if($errors->has('contact_email.0'))
                              <x-admin.form.form_error_messages message="{{ $errors->first('contact_email.0') }}"  />
                           @endif
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <x-admin.form.inputs.text id="" for="contact_1_phone" tooltip="{{__('webCaption.phone.caption')}}" label="{{__('webCaption.phone.title')}}" maxlength="20" class="form-control" name="contact_phone[]"  placeholder="{{__('webCaption.phone.title')}}" value=""  required="" />
                           @if($errors->has('contact_phone.0'))
                              <x-admin.form.form_error_messages message="{{ $errors->first('contact_phone.0') }}"  />
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <x-admin.form.label for="" tooltip="{{__('webCaption.contact_option.caption')}}" value="{{__('webCaption.contact_option.title')}}" class="" />
{{--                        <div class="form-group">--}}
{{--                           <x-admin.form.inputs.checkbox id="" for="contact_1_option_viber" tooltip="{{__('webCaption.viber.caption')}}" label="{{__('webCaption.viber.title')}}"  class="form-control" name="contact_viber[0]"   value="1" checked="{{ ( old('contact_viber.0')  == 1 )? 'checked' :'' }}" /> &ensp;--}}

{{--                           <x-admin.form.inputs.checkbox id="" for="contact_1_option_line" tooltip="{{__('webCaption.line.caption')}}" label="{{__('webCaption.line.title')}}" class="form-control" name="contact_line[0]"   value="1"  checked="{{ ( old('contact_line.0')  == 1 )? 'checked' :'' }}" />&ensp;--}}

{{--                           <x-admin.form.inputs.checkbox id="" for="contact_1_option_whatsapp" tooltip="{{__('webCaption.whatsapp.caption')}}"  label="{{__('webCaption.whatsapp.title')}}"  class="form-control" name="contact_whatsapp[0]"   value="1"  checked="{{ ( old('contact_whatsapp.0')  == 1 )? 'checked' :'' }}" />&ensp;--}}
{{--                        </div>--}}
                     </div>
                  </div>

               </div>
               <hr class="m-0 p-0">
{{--               <div class="card-body" >--}}
{{--                  <h4 class="card-title">    {{__('webCaption.contact_person_2.title')}} </h4>--}}
{{--                  <div class="row">--}}
{{--                     <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                           <x-admin.form.inputs.text id="" for="contact_2_name" tooltip="{{__('webCaption.name.caption')}}" label="{{__('webCaption.name.title')}}" maxlength="100" class="form-control" name="contact_name[]"  placeholder="{{__('webCaption.name.title')}}" value=""  required="" />--}}
{{--                           @if($errors->has('contact_name.1'))--}}
{{--                              <x-admin.form.form_error_messages message="{{ $errors->first('contact_name.1') }}"  />--}}
{{--                           @endif--}}
{{--                        </div>--}}
{{--                     </div>--}}
{{--                     <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                           <x-admin.form.inputs.text id="" for="contact_2_designation" tooltip="{{__('webCaption.designation.caption')}}" label="{{__('webCaption.designation.title')}}" maxlength="50" class="form-control" name="contact_designation[]"  placeholder="{{__('webCaption.designation.title')}}" value=""  required="" />--}}
{{--                           @if($errors->has('contact_designation.1'))--}}
{{--                              <x-admin.form.form_error_messages message="{{ $errors->first('contact_designation.1') }}"  />--}}
{{--                           @endif--}}
{{--                        </div>--}}
{{--                     </div>--}}
{{--                     <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                           <x-admin.form.inputs.email id="" for="contact_2_email" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}" maxlength="50" class="form-control" name="contact_email[]"  placeholder="{{__('webCaption.email.title')}}" value=""  required="" />--}}
{{--                           @if($errors->has('contact_email.1'))--}}
{{--                              <x-admin.form.form_error_messages message="{{ $errors->first('contact_email.1') }}"  />--}}
{{--                           @endif--}}
{{--                        </div>--}}
{{--                     </div>--}}
{{--                  </div>--}}

{{--                  <div class="row">--}}
{{--                     <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                           <x-admin.form.inputs.text id="" for="contact_2_phone" tooltip="{{__('webCaption.phone.caption')}}" label="{{__('webCaption.phone.title')}}" maxlength="20" class="form-control" name="contact_phone[]"  placeholder="{{__('webCaption.phone.title')}}" value=""  required="" />--}}
{{--                           @if($errors->has('contact_phone.1'))--}}
{{--                              <x-admin.form.form_error_messages message="{{ $errors->first('contact_phone.1') }}"  />--}}
{{--                           @endif--}}
{{--                        </div>--}}
{{--                     </div>--}}
{{--                     <div class="col-md-4">--}}
{{--                        <x-admin.form.label for="" tooltip="{{__('webCaption.contact_option.caption')}}" value="{{__('webCaption.contact_option.title')}}" class="" />--}}
{{--                        <div class="form-group">--}}
{{--                           <x-admin.form.inputs.checkbox id="" for="contact_2_option_viber" tooltip="{{__('webCaption.viber.caption')}}" label="{{__('webCaption.viber.title')}}"  class="form-control" name="contact_viber[1]"   value="1" checked="{{ ( old('contact_viber.1')  == 1 )? 'checked' :'' }}" /> &ensp;--}}

{{--                           <x-admin.form.inputs.checkbox id="" for="contact_2_option_line" tooltip="{{__('webCaption.line.caption')}}" label="{{__('webCaption.line.title')}}" class="form-control" name="contact_line[1]"   value="1"  checked="{{ ( old('contact_line.1')  == 1 )? 'checked' :'' }}" />&ensp;--}}

{{--                           <x-admin.form.inputs.checkbox id="" for="contact_2_option_whatsapp" tooltip="{{__('webCaption.whatsapp.caption')}}" label="{{__('webCaption.whatsapp.title')}}"  class="form-control" name="contact_whatsapp[1]"   value="1"  checked="{{ ( old('contact_whatsapp.1')  == 1 )? 'checked' :'' }}" />&ensp;--}}
{{--                        </div>--}}
{{--                     </div>--}}
{{--                  </div>--}}

{{--               </div>--}}
            </div>


         </div>


         <div class="card">
            <div class="card-header">
               <h4 class="card-title">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe font-medium-3 mr-1"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                  {{__('webCaption.social_media_profile.title')}}
               </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">

               <div class="row">

                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.text_with_icon id="" for="facebook" tooltip="{{__('webCaption.facebook.caption')}}" label="{{__('webCaption.facebook.title')}}" maxlength="100" class="form-control" name="facebook" iconColorClass="text-primary"  iconClass="fab fa-facebook" placeholder="{{__('webCaption.facebook.title')}}" value="{{old('facebook', isset($data->facebook)?$data->facebook:'' )}}"  required="" />
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.text_with_icon id="" for="instagram" tooltip="{{__('webCaption.instagram.caption')}}" label="{{__('webCaption.instagram.title')}}" maxlength="100" class="form-control" name="instagram" iconColorClass="text-primary"  iconClass="fab fa-instagram" placeholder="{{__('webCaption.instagram.title')}}" value="{{old('instagram', isset($data->instagram)?$data->instagram:'' )}}"  required="" />
                        @if($errors->has('instagram'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('instagram') }}"  />
                        @endif
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.text_with_icon id="" for="linkedin" tooltip="{{__('webCaption.linkedin.caption')}}" label="{{__('webCaption.linkedin.title')}}" maxlength="100" class="form-control" name="linkedin" iconColorClass="text-primary"  iconClass="fab fa-linkedin" placeholder="{{__('webCaption.linkedin.title')}}" value="{{old('linkedin', isset($data->linkedin)?$data->linkedin:'' )}}"  required="" />
                        @if($errors->has('linkedin'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('linkedin') }}"  />
                        @endif
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.text_with_icon id="" for="youtube" tooltip="{{__('webCaption.youtube.caption')}}" label="{{__('webCaption.youtube.title')}}" maxlength="100" class="form-control" name="youtube" iconColorClass="text-primary"  iconClass="fab fa-youtube" placeholder="{{__('webCaption.youtube.title')}}" value="{{old('youtube', isset($data->youtube)?$data->youtube:'' )}}"  required="" />
                        @if($errors->has('youtube'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('youtube') }}"  />
                        @endif
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.text_with_icon id="" for="twitter"  tooltip="{{__('webCaption.twitter.caption')}}" label="{{__('webCaption.twitter.title')}}" maxlength="100" class="form-control" name="twitter" iconColorClass="text-primary"  iconClass="fab fa-twitter" placeholder="{{__('webCaption.twitter.title')}}" value="{{old('twitter', isset($data->twitter)?$data->twitter:'' )}}"  required="" />
                        @if($errors->has('twitter'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('twitter') }}"  />
                        @endif
                     </div>
                  </div>
               </div>



            </div>
         </div>

         <div class="form-group">
            <x-admin.form.inputs.checkbox id="" for="terms_and_services"  tooltip="{{__('webCaption.accept_terms_and_services.caption')}}" label="{{__('webCaption.accept_terms_and_services.title')}}"  class="form-control" name="terms_and_services"   value="1" checked="{{ old('terms_and_services') == '1' ? 'checked' : '' }}" /> &ensp;
         </div>
      </section>
      <div>
         <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
         @if(isset($data->id)) <x-admin.form.buttons.update />   @else <x-admin.form.buttons.create />    @endif
      </div>
   </form>
@endsection


