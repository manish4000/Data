@extends('layouts/contentLayoutMaster')

{{-- @section('title', $pageConfigs['moduleName']) --}}
@section('title', __('webCaption.company_edit.title'))

@section('content')
<!-- users edit start -->


<form action="{{route('company.update',$data->id)}}" method="POST"  enctype="multipart/form-data">

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
                    <x-admin.form.inputs.text id="" for="company_name" tooltip="{{__('webCaption.company_name.caption')}}" label="{{__('webCaption.company_name.title')}}" maxlength="100"  name="company_name"  placeholder="{{__('webCaption.company_name.title')}}" value="{{old('company_name',$data->company_name)}}"  required="required" />
                   
                  </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.text id="" label="{{__('webCaption.gabs_uuid.title')}}" for="gabs_uuid"  tooltip="{{__('webCaption.gabs_uuid.caption')}}"  maxlength="6" name="gabs_uuid"  placeholder="{{__('webCaption.gabs_uuid.title')}}" value="{{old('gabs_uuid',$data->gabs_uuid )}}"  required="required" />
                  
                </div>
              </div>
          </div>  

          <div class="row">
              <div class="col-md-4">
                  <div class="form-group">
                    <x-admin.form.inputs.email id="" for="email" label="{{__('webCaption.email.title')}}" tooltip="{{__('webCaption.email.caption')}}" maxlength="45"  name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', $data->email)}}"  required="required" />
                   
                  </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.password id="" label="{{__('webCaption.password.title')}}" tooltip="{{__('webCaption.password.caption')}}" for="password"  maxlength="15" name="password"  placeholder="{{__('webCaption.password.title')}}" value=""  required="" />
                  
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.select label="{{__('webCaption.status.title')}}"  id="" for="status" tooltip="{{__('webCaption.status.caption')}}" name="status" placeholder="{{ __('locale.status.caption') }}" editSelected="{{old('status', $data->status)}}"  required="" :optionData="$status" />
                    
                </div>
              </div>
          </div>  
          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                    <x-admin.form.inputs.textarea id="" for="address" tooltip="{{__('webCaption.address.caption')}}" label="{{__('webCaption.address.title')}}" maxlength="250"  name="address"  placeholder="{{__('webCaption.address.title')}}" value="{{old('address', $data->address )}}"  required="" />
                    
                  </div>
              </div>
          </div>  
          <div class="row">
            
            <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.select label="{{__('webCaption.country.title')}}" for="country_id" tooltip="{{__('webCaption.country.caption')}}" name="country_id" 
                   placeholder="{{ __('locale.country.caption') }}" customClass="country"  editSelected="{{ old('country_id',$data->country_id)}}"  required="required" :optionData="$country" />
                    
                </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.select label="{{__('webCaption.state.title')}}" customClass="state"  tooltip="{{__('webCaption.state.caption')}}" id="" for="state_id" name="state_id" placeholder="{{ __('locale.state.caption') }}" editSelected="{{old('state_id',$data->state_id)}}"  required="" :optionData="[]" />
              </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <x-admin.form.inputs.select tooltip="{{__('webCaption.city.caption')}}"  label="{{__('webCaption.city.title')}}"  id="" for="city_id" name="city_id" placeholder="{{ __('locale.city.caption') }}" editSelected="{{old('city_id',$data->city_id)}}"  required="" :optionData="[]" />
                
            </div>
          </div>
            
          </div>  
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.text id="" tooltip="{{__('webCaption.postcode.caption')}}" for="postcode" label="{{__('webCaption.postcode.title')}}" maxlength="15"  name="postcode"  placeholder="{{__('webCaption.postcode.title')}}" value="{{old('postcode',$data->postcode)}}"  required="" />
               
              </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.select label="{{__('webCaption.region.title')}}"  id="" for="region_id" tooltip="{{__('webCaption.region.caption')}}"  name="region_id" placeholder="{{ __('locale.region.caption') }}" editSelected="{{old('region_id',$data->region_id)}}"  required="" :optionData="[]" />
                    
                </div>
            </div>

            <div class="col-md-4">
                  
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                        <x-admin.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="country_code" name="country_code"  required="" :optionData="$country_phone_code"  editSelected="{{(isset($company_tel_country_code) && ($company_tel_country_code != null)) ? $company_tel_country_code : ''; }}" />
                        </div>
                    </div>
                    <div class="col-8">
                      <div class="form-group">
                                  <x-admin.form.inputs.text id="" for="telephone"  tooltip="{{__('webCaption.telephone.caption')}}" label="{{__('webCaption.telephone.title')}}" maxlength="20"  name="telephone"  placeholder="{{__('webCaption.telephone.title')}}" value="{{old('telephone', isset($data->telephone)?$data->telephone:'' )}}"  required="" />
                                  
                      </div>
                    </div>
                  </div>

            </div>
          </div>  
          <div class="row">
            <div class="col-md-4">
                  <div class="form-group">
                    <x-admin.form.inputs.text id="" for="skype"  tooltip="{{__('webCaption.skype.caption')}}" label="{{__('webCaption.skype.title')}}" maxlength="50"  name="skype_id"  placeholder="{{__('webCaption.skype.title')}}" value="{{old('skype_id',$data->skype_id)}}"  required="" />
                   
                  </div>
            </div>
            <div class="col-md-4">
                  <div class="form-group">
                    <x-admin.form.inputs.text id="" for="website" tooltip="{{__('webCaption.website.caption')}}" label="{{__('webCaption.website.title')}}" maxlength="75"  name="website"  placeholder="{{__('webCaption.website.title')}}" value="{{old('website',$data->website)}}"  required="" />
                    
                  </div>
            </div>
            <div class="col-md-4">
                  <div class="form-group">
                    <x-admin.form.inputs.file id="" editImageUrl="{{asset('company_data/'.$data->gabs_uuid.'/logo/'.$data->logo)}}" caption="{{__('webCaption.upload_logo.title')}}" for="logo"  ImageId="logo-preview"   name="logo"  placeholder="{{__('webCaption.logo.title')}}" required="required" />
                    
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
                  <x-admin.form.inputs.select tooltip="{{__('webCaption.plan.caption')}}" label="{{__('webCaption.plan.title')}}"  id="" for="plan_id" name="plan_id" placeholder="{{__('webCaption.plan_id.title')}}" editSelected="{{old('plan_id',$data->plan_id)}}"  required="" :optionData="$plans" />
                </div>
            </div>
            @php if(isset($data->business_type_id)){
              $editSelected = $data->business_type_id;
            } else{
              $editSelected = '';
            }
            @endphp
            <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.multiple_select tooltip="{{__('webCaption.business_type.caption')}}" label="{{__('webCaption.business_type.title')}}"  id="" for="business_type_id" name="business_type_id[]" placeholder="{{__('webCaption.business_type_id.title')}}" :editSelected="$editSelected" :oldValues="old('business_type_id')"  required="" :optionData="$BusinessTypes" />
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.select label="{{__('webCaption.association_member.title')}}"  tooltip="{{__('webCaption.association_member.caption')}}"   id="" for="association_member_id" name="association_member_id"  editSelected="{{old('association_member_id',$data->association_member_id)}}"  required="" 
                     :optionData="[]" />
                   
                </div>
            </div>
        </div>  

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <x-admin.form.inputs.textarea id="" for="permit_number" label="{{__('webCaption.permit_number.title')}}" tooltip="{{__('webCaption.permit_number.caption')}}" maxlength="250"  name="permit_no"  placeholder="{{__('webCaption.permit_no.title')}}" 
                  value="{{old('permit_no' ,$data->permit_no)}}"  required="" />
                  
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <x-admin.form.inputs.textarea id="" for="admin_comment" label="{{__('webCaption.admin_comment.title')}}" tooltip="{{__('webCaption.admin_comment.caption')}}" maxlength="250"  name="admin_comment"  placeholder="{{__('webCaption.admin_comment.title')}}" value="{{old('admin_comment', $data->admin_comment)}}"  required="" />
                  
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
                                <x-admin.form.inputs.file id="" caption="{{__('webCaption.document_upload.title')}}" for="document"  name="document[]"  placeholder="{{__('webCaption.logo.title')}}" required=""  multiple="multiple" />
                                
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-around">

                        @foreach($data->documents as $document)
                            <div>
                              <img src="{{asset('company_data/'.$data->gabs_uuid.'/document/'.$document->name)}}" class="img-fluid p-2" alt="" height="70" width="80">
                            </div>
                        @endforeach

                    </div>
                    
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.select label="{{__('webCaption.marketing_status.title')}}"  id="" for="marketing_status" name="marketing_status" placeholder="{{__('webCaption.marketing_status.title')}}" editSelected=""  required="" :optionData="[]" />
                      
                </div>
            </div>

        </div>  


      </div>
    </div>
    {{-- <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info font-medium-3 mr-1"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
              {{__('webCaption.contact_person_details.title')}}
            </h4>  
        </div>
        <hr class="m-0 p-0">
        <div id="container">
        
          <div class="card-body" >
              <h4 class="card-title">    {{__('webCaption.contact_person_1.title')}}  </h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <x-admin.form.inputs.text id="" tooltip="{{__('webCaption.name.caption')}}" for="contact_1_name" label="{{__('webCaption.name.title')}}" maxlength="100" class="form-control" name="contact_name[]"  placeholder="{{__('webCaption.name.title')}}"
                         value="{{old('contact_name.0',(isset($data->contcatPersonDetails[0]->name)) ? $data->contcatPersonDetails[0]->name : '' )}}"  required="" />
                        @if($errors->has('contact_name.0'))
                          <x-admin.form.form_error_messages message="{{ $errors->first('contact_name.0') }}"  />
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-admin.form.inputs.text id="" for="contact_1_designation" label="{{__('webCaption.designation.title')}}" tooltip="{{__('webCaption.designation.caption')}}" maxlength="50" class="form-control" name="contact_designation[]"  placeholder="{{__('webCaption.designation.title')}}"
                         value="{{old('contact_designation.0',(isset($data->contcatPersonDetails[0]->designation)) ?
                          $data->contcatPersonDetails[0]->designation : ''  )}}"  required="" />
                        @if($errors->has('contact_designation.0'))
                         <x-admin.form.form_error_messages message="{{ $errors->first('contact_designation.0') }}"  />
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-admin.form.inputs.email id="" for="contact_1_email" label="{{__('webCaption.email.title')}}" tooltip="{{__('webCaption.email.caption')}}"  maxlength="50" class="form-control" name="contact_email[]"  placeholder="{{__('webCaption.email.title')}}" 
                        value="{{old('contact_email.0',(isset($data->contcatPersonDetails[0]->email)) ? $data->contcatPersonDetails[0]->email : '' )}}"  required="" />
                        @if($errors->has('contact_email.0'))
                            <x-admin.form.form_error_messages message="{{ $errors->first('contact_email.0') }}"  />
                        @endif
                    </div>
                </div>
            </div>  
    
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <x-admin.form.inputs.text id="" for="contact_1_phone" label="{{__('webCaption.phone.title')}}" maxlength="20" class="form-control" name="contact_phone[]" tooltip="{{__('webCaption.phone.caption')}}"  placeholder="{{__('webCaption.phone.title')}}" 
                        value="{{old('contact_phone.0',(isset($data->contcatPersonDetails[0]->phone))? $data->contcatPersonDetails[0]->phone : '')}}"  required="" />
                        @if($errors->has('contact_phone.0'))
                        <x-admin.form.form_error_messages message="{{ $errors->first('contact_phone.0') }}"  />
                        @endif
                    </div>
                </div>
            </div>  
    
          </div>
          <hr class="m-0 p-0">
          <div class="card-body" >
            <h4 class="card-title">   {{__('webCaption.contact_person_2.title')}}   </h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <x-admin.form.inputs.text id="" for="contact_2_name" label="{{__('webCaption.name.title')}}" tooltip="{{__('webCaption.name.caption')}}" maxlength="100" class="form-control" name="contact_name[]"  placeholder="{{__('webCaption.name.title')}}" 
                         value="{{old('contact_name.1',isset($data->contcatPersonDetails[1]->name)? $data->contcatPersonDetails[1]->name : '')}}"  required="" />
                        @if($errors->has('contact_name.1'))
                        <x-admin.form.form_error_messages message="{{ $errors->first('contact_name.1') }}"  />
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-admin.form.inputs.text id="" for="contact_2_designation" label="{{__('webCaption.designation.title')}}" tooltip="{{__('webCaption.designation.caption')}}" maxlength="50" class="form-control" name="contact_designation[]"  placeholder="{{__('webCaption.designation.title')}}" 
                        value="{{old('contact_designation.1',isset($data->contcatPersonDetails[1]->designation) ?$data->contcatPersonDetails[1]->designation  : '')}}"  required="" />
                        @if($errors->has('contact_designation.1'))
                        <x-admin.form.form_error_messages message="{{ $errors->first('contact_designation.1') }}"  />
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-admin.form.inputs.email id="" for="contact_2_email"
                        tooltip="{{__('webCaption.email.caption')}}"  label="{{__('webCaption.email.title')}}" maxlength="50" class="form-control" name="contact_email[]"  placeholder="{{__('webCaption.email.title')}}" 
                        value="{{old('contact_email.1', isset($data->contcatPersonDetails[1]->email) ? $data->contcatPersonDetails[1]->email : '' ) }}"  required="" />
                        @if($errors->has('contact_email.1'))
                        <x-admin.form.form_error_messages message="{{ $errors->first('contact_email.1') }}"  />
                        @endif
                    </div>
                </div>
            </div>  
    
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <x-admin.form.inputs.text id="" tooltip="{{__('webCaption.phone.caption')}}" for="contact_2_phone" label="{{__('webCaption.phone.title')}}" maxlength="20" class="form-control" name="contact_phone[]"  placeholder="{{__('webCaption.phone.title')}}"  
                        value="{{old('contact_name.1', (isset($data->contcatPersonDetails[1]->phone)) ? $data->contcatPersonDetails[1]->phone : '' )}}"  required="" />
                        @if($errors->has('contact_phone.1'))
                        <x-admin.form.form_error_messages message="{{ $errors->first('contact_phone.1') }}"  />
                        @endif
                    </div>
                </div>
            </div>  
    
          </div>
        </div>
 

    </div> --}}


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
                    <x-admin.form.inputs.text_with_icon id="" for="facebook" label="{{__('webCaption.facebook.title')}}" tooltip="{{__('webCaption.facebook.caption')}}"  maxlength="100"  name="facebook" iconColorClass="text-primary"  iconClass="fab fa-facebook" placeholder="{{__('webCaption.facebook.title')}}" value="{{old('facebook', $data->facebook)}}"  required="" />
                </div> 
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.text_with_icon id="" for="instagram" label="{{__('webCaption.instagram.title')}}" tooltip="{{__('webCaption.instagram.caption')}}" maxlength="100"  name="instagram" iconColorClass="text-primary"  iconClass="fab fa-instagram" placeholder="{{__('webCaption.instagram.title')}}" value="{{old('instagram', $data->instagram)}}"  required="" />
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.text_with_icon id="" for="linkedin" label="{{__('webCaption.linkedin.title')}}"  tooltip="{{__('webCaption.linkedin.caption')}}" maxlength="100" name="linkedin" iconColorClass="text-primary"  iconClass="fab fa-linkedin" placeholder="{{__('webCaption.linkedin.title')}}" value="{{old('linkedin', $data->linkedin )}}"  required="" />
                    
                </div>
            </div>
        </div>  

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.text_with_icon id="" for="youtube" tooltip="{{__('webCaption.youtube.caption')}}" label="{{__('webCaption.youtube.title')}}" maxlength="100" name="youtube" iconColorClass="text-primary"  iconClass="fab fa-youtube" placeholder="{{__('webCaption.youtube.title')}}" value="{{old('youtube', $data->youtube )}}"  required="" />
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.text_with_icon id="" for="twitter" tooltip="{{__('webCaption.twitter.caption')}}"  label="{{__('webCaption.twitter.title')}}" maxlength="100"  name="twitter" iconColorClass="text-primary"  iconClass="fab fa-twitter" placeholder="{{__('webCaption.twitter.title')}}" value="{{old('twitter',$data->twitter)}}"  required="" />
                   
                </div>
            </div>
        </div>  

 

      </div>
    </div>

    <div class="form-group">

      {{-- <x-admin.form.inputs.checkbox id="" for="terms_and_services"  tooltip="{{__('webCaption.accept_terms_and_services.caption')}}" label="{{__('webCaption.accept_terms_and_services.title')}}"  class="form-control" name="terms_and_services"   value="1" checked="{{ old('terms_and_services') == '1' ? 'checked' : '' }} {{ ($data->terms_and_services == '1') ? 'checked' :''}}" /> &ensp; --}}
    </div>
  </section>
  <div class="text-center">
    <input type="hidden" name="id" value="{{$data->id}}" />
      <x-admin.form.buttons.update />  
  </div>
  </form>
@endsection



@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
@endsection
@push('script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>
  <script src="{{ asset('assets/js/gabs/master.js') }}"></script>
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
  </script>

  @php
  $state_id = session()->getOldInput('state_id');
  $city_id = session()->getOldInput('city_id');
  $state_id =  (isset($state_id)) ? $state_id : ( (isset($data->state_id)) ? $data->state_id :'' );
  $city_id =  (isset($city_id)) ? $city_id : ( (isset($data->city_id)) ? $data->city_id :'' );
  @endphp 


<script>
  $(document).ready(function() {
    
    var  country  = $('.country').find(":selected").val();
    var  state  =   "<?php echo $state_id ; ?>";
    var  city  = "<?php echo $city_id; ?>";
  
    if(country){
            stateList(country,state);
    }
     
    if(state){
            cityList(state,city);
    }
          
    $('.country').on('change', function(){
     
          var selectCountry  = $(this).val();  
          stateList(selectCountry);        
    });
    $('.state').on('change', function () {
      
          var selectState  = $(this).val();  
          cityList(selectState);
    });
    
    
      function stateList(country , selected_state = ''){
    
        $.ajax ({
                      type: 'POST',
                      url: "{{route('company.state-list')}}",
                      data: { id : country },
                      success : function(result) {
    
                        $('#state_id').html('<option value="">Select State</option>');
                          $.each(result.states, function (key, value) {
    
                            if(value.id == selected_state){
                              var selected_s = 'selected';
                            }else{
                              var selected_s = '';
                            }
                              $("#state_id").append('<option value="' + value
                                  .id + '" '+ selected_s + '>' + value.name + '</option>');
                          });
                          $('#city_id').html('<option value="">Select City</option>');
                      }
               });
    
      }
    
    
      function cityList(state,selected_city =''){
    
      $.ajax ({
                type: 'POST',
                url: "{{route('company.city-list')}}",
                data: { id : state },
                success : function(result) {
                  $('#city_id').html('<option value="">Select City</option>');
                    $.each(result.cities, function (key, value) {
    
                      if(value.id == selected_city){
                              var selected_c = 'selected';
                            }else{
                              var selected_c = '';
                            }
    
                        $("#city_id").append('<option value="' + value
                            .id + '" '+ selected_c +'>' + value.name + '</option>');
                    });
                }
            });
      }
  });
</script>

@endpush
