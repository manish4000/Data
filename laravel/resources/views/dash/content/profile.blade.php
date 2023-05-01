@extends('dash/layouts/LayoutMaster')

@section('title', __('webCaption.edit_profile.title') )

@section('content')
<div>
	<form action="{{route('dashprofile.update')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card card-primary">
           <div class="card-header">
              <h4 class="card-title">
                 <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check font-medium-3 mr-1">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <polyline points="17 11 19 13 23 9"></polyline>
                 </svg>
                 {{__('webCaption.edit_profile.title')}}
              </h4>
           </div>
           <div class="card-body">
              <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                       <x-dash.form.inputs.text id="" for="company_name" tooltip="{{__('webCaption.company_name.caption')}}" label="{{__('webCaption.company_name.title')}}" maxlength="100" class="form-control" name="company_name"  placeholder="{{__('webCaption.company_name.title')}}" value="{{old('company_name', isset($data->company_name)?$data->company_name:'' )}}"  required="required" />
                       
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                       <x-dash.form.inputs.email id="" for="email" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}" maxlength="45" class="form-control" name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($data->email)?$data->email:'' )}}"  required="required" />
                       
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                   <div class="form-group">
                      <x-dash.form.inputs.select label="{{__('webCaption.country.title')}}" 
                         tooltip="{{__('webCaption.country.caption')}}" for="country_id" name="country_id" :optionData="$country"
                         placeholder="{{ __('locale.country.caption') }}" customClass="country"  editSelected="{{(isset($data->country_id) && ($data->country_id != null)) ? $data->country_id :'' }}"  required="required"  />
                   </div>
                </div>
                <div class="col-md-4">
                   <div class="form-group">
                      <x-dash.form.inputs.select label="{{__('webCaption.state.title')}}" 
                         tooltip="{{__('webCaption.state.caption')}}" for="state_id" name="state_id"
                         placeholder="{{ __('locale.state.caption') }}" customClass="state"  required=""  />
                   </div>
                </div>
                <div class="col-md-4">
                   <div class="form-group">
                      <x-dash.form.inputs.select label="{{__('webCaption.city.title')}}" 
                         tooltip="{{__('webCaption.city.caption')}}" for="city_id" name="city_id"
                         placeholder="{{ __('locale.city.caption') }}" customClass="city"   required=""  />
                   </div>
                </div>
             </div>
             <div class="row">
                <div class="col-md-4">
                   <div class="form-group">
                      <x-dash.form.inputs.text  for="skype_id"  maxlength="50" tooltip="{{__('webCaption.skype.caption')}}" label="{{__('webCaption.skype.title')}}"  class="form-control" name="skype_id"  placeholder="{{__('webCaption.skype.title')}}" value="{{old('skype_id', isset($data->skype_id)?$data->skype_id:'' )}}"  required="" />
                   </div>
                </div>
                <div class="col-md-4">
                   <fieldset>
                      <div class="row">
                         <div class="col-md-5">
                            <div class="form-group">
                               <x-dash.form.inputs.select label="{{__('webCaption.country_code.title')}}" 
                                  tooltip="{{__('webCaption.country_code.caption')}}" for="country_code" name="country_code"
                                  placeholder="{{ __('locale.country_code.caption') }}" customClass="country_code" :optionData="$country_phone_code"  editSelected="{{$company_tel_country_code}}"  required=""  />
                               
                            </div>
                         </div>
                         <div class="col-md-7">
                            <div class="form-group">
                               <x-dash.form.inputs.text  for="telephone"  maxlength="20" tooltip="{{__('webCaption.telephone.caption')}}" label="{{__('webCaption.telephone.title')}}"  class="form-control" name="telephone"  placeholder="{{__('webCaption.telephone.title')}}" value="{{old('telephone', isset($data->telephone)?$data->telephone:'' )}}"  required="" />
                             
                            </div>
                         </div>
                      </div>
                   </fieldset>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                       <x-dash.form.inputs.text id="" for="post_code" tooltip="{{__('webCaption.post_code.caption')}}" label="{{__('webCaption.post_code.title')}}" maxlength="100"  class="form-control" name="postcode"  placeholder="{{__('webCaption.post_code.title')}}" value="{{old('postcode', isset($data->postcode)? $data->postcode:'' )}}"  required="" />
                    </div>
                 </div>

             </div>

              <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                       <x-dash.form.inputs.text id="" for="address" tooltip="{{__('webCaption.address.caption')}}" label="{{__('webCaption.address.title')}}" maxlength="255"  class="form-control" name="address"  placeholder="{{__('webCaption.address.title')}}" value="{{old('address', isset($data->address)? $data->address:'' )}}"  required="" />   
                    </div>
                 </div>
                <div class="col-md-4">
                <div class="form-group">
                    <x-dash.form.inputs.text id="" for="website" tooltip="{{__('webCaption.website.caption')}}" label="{{__('webCaption.website.title')}}" maxlength="75"  class="form-control" name="website"  placeholder="{{__('webCaption.website.title')}}" value="{{old('website', isset($data->website)? $data->website:'' )}}"  required="" />
                </div>
                </div>
              </div>

           </div>
        </div>

        {{--  --}}
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
             
             @php if(isset($data->business_type_id)){
               $editSelected = $data->business_type_id;
             } else{
               $editSelected = '';
             }
             @endphp
 
             @php if(isset($data->association_member_id)){
                 $associationEditSelected = $data->association_member_id;
               } else{
                 $associationEditSelected = '';
               }
             @endphp
 
             <div class="col-md-4">
                 <div class="form-group">
                   <x-admin.form.inputs.multiple_select tooltip="{{__('webCaption.business_type.caption')}}" label="{{__('webCaption.business_type.title')}}"  id="" for="business_type_id" name="business_type_id[]" placeholder="{{__('webCaption.business_type_id.title')}}" :editSelected="$editSelected" :oldValues="old('business_type_id')"  required="" :optionData="$business_types" />
                     
                 </div>
             </div>
             
             <div class="col-md-4">
                 <div class="form-group">
                   <x-admin.form.inputs.multiple_select label="{{__('webCaption.association_member.title')}}"  tooltip="{{__('webCaption.association_member.caption')}}"   id="" for="association_member_id" name="association_member_id[]"   required="" :editSelected="$associationEditSelected"  :oldValues="old('association_member_id')" :optionData="$association" />
                    
                 </div>
             </div>
             <div class="col-md-4">
               <div class="form-group">
                 <x-admin.form.inputs.select label="{{__('webCaption.region.title')}}"  id="" for="region_id" name="region_id" placeholder="{{__('webCaption.region.title')}}" editSelected="{{old('region_id',$data->region_id)}}" required="" :optionData="$regions" />   
               </div>
            </div>
         </div>  
 
         <div class="row">
             <div class="col-md-8">
                 <div class="form-group">
                   <x-admin.form.inputs.textarea id="" for="permit_number" label="{{__('webCaption.permit_number.title')}}" tooltip="{{__('webCaption.permit_number.caption')}}" maxlength="250"  name="permit_no"  placeholder="{{__('webCaption.permit_no.title')}}" 
                   value="{{old('permit_no' ,$data->permit_no)}}"  required="" />
                   
                 </div>
            </div>
            
 
         </div>  
         <div class="row">
 
           
         </div>  
 
 
       </div>
     </div>
        {{--  --}}
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
                        <x-dash.form.inputs.text id="" for="contact_option" tooltip="{{__('webCaption.name.caption')}}" label="{{__('webCaption.name.title')}}" maxlength="100" class="form-control" name="contact_1_name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('contact_1_name',$data->contact_1_name)}}"  required="" />
                        
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-dash.form.inputs.text id="" for="contact_1_designation" tooltip="{{__('webCaption.designation.caption')}}" label="{{__('webCaption.designation.title')}}" maxlength="50" class="form-control" name="contact_1_designation"  placeholder="{{__('webCaption.designation.title')}}" value="{{old('contact_1_designation',$data->contact_1_designation)}}"  required="" />
                       
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-dash.form.inputs.email id="" for="contact_1_email" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}" maxlength="50" class="form-control" name="contact_1_email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('contact_1_email',$data->contact_1_email)}}"  required="" />
                        
                     </div>
                  </div>
               </div>
   
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-dash.form.inputs.number id="" for="contact_1_phone" tooltip="{{__('webCaption.phone.caption')}}" label="{{__('webCaption.phone.title')}}" maxlength="20" class="form-control" name="contact_1_phone"  placeholder="{{__('webCaption.phone.title')}}" value="{{old('contact_1_phone',$data->contact_1_phone)}}"  required="" />
                        
                     </div>
                  </div>
                  <div class="col-md-4">
                     <x-dash.form.label for="" tooltip="{{__('webCaption.contact_option.caption')}}" value="{{__('webCaption.contact_option.title')}}" class="" />
                     <div class="form-group">
                        <x-dash.form.inputs.checkbox id="" for="contact_1_option_viber" tooltip="{{__('webCaption.viber.caption')}}" label="{{__('webCaption.viber.title')}}"  class="form-control" name="contact_1_viber"   value="1" checked="{{ ( old('contact_1_viber') == '1' || $data->contact_1_viber == '1' ) ? 'checked' : '' }}" />
   
                        <x-dash.form.inputs.checkbox id="" for="contact_1_option_line" tooltip="{{__('webCaption.line.caption')}}" label="{{__('webCaption.line.title')}}" class="form-control" name="contact_1_line"   value="1" 
                        checked="{{ ( old('contact_1_line') == '1' || $data->contact_1_line == '1' ) ? 'checked' : '' }}" />
   
                        <x-dash.form.inputs.checkbox id="" for="contact_1_option_whatsapp" tooltip="{{__('webCaption.whatsapp.caption')}}"  label="{{__('webCaption.whatsapp.title')}}"  class="form-control" name="contact_1_whatsapp"   value="1"
                          checked="{{ ( old('contact_1_whatsapp') == '1' || $data->contact_1_whatsapp == '1' ) ? 'checked' : '' }}" />&ensp; 
                     </div>
                  </div>
               </div>
   
            </div>
   
            {{--  --}}
            <div class="card-body" >
               <h4 class="card-title">    {{__('webCaption.contact_person_2.title')}} </h4>
               <div class="row">
                   <div class="col-md-4">
                       <div class="form-group">
                           <x-dash.form.inputs.text id="" for="contact_2_name" tooltip="{{__('webCaption.name.caption')}}" label="{{__('webCaption.name.title')}}" maxlength="100" class="form-control" name="contact_2_name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('contact_2_name',$data->contact_2_name)}}"  required="" />
                         
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <x-dash.form.inputs.text id="" for="contact_2_designation" tooltip="{{__('webCaption.designation.caption')}}" label="{{__('webCaption.designation.title')}}" maxlength="50" class="form-control" name="contact_2_designation"  placeholder="{{__('webCaption.designation.title')}}" value="{{old('contact_2_designation',$data->contact_2_designation)}}"   required="" />
                         
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <x-dash.form.inputs.email id="" for="contact_2_email" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}" maxlength="50" class="form-control" name="contact_2_email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('contact_2_email',$data->contact_2_email )}}"  required="" />
                          
                       </div>
                   </div>
               </div>  
       
               <div class="row">
                   <div class="col-md-4">
                       <div class="form-group">
                           <x-dash.form.inputs.number id="" for="contact_2_phone" tooltip="{{__('webCaption.phone.caption')}}" label="{{__('webCaption.phone.title')}}" maxlength="20" class="form-control" name="contact_2_phone"  placeholder="{{__('webCaption.phone.title')}}" value="{{old('contact_2_phone',$data->contact_2_phone )}}"   required="" />
                           
                       </div>
                   </div>
                   <div class="col-md-4">
                       <x-dash.form.label for="" tooltip="{{__('webCaption.contact_option.caption')}}" value="{{__('webCaption.contact_option.title')}}" class="" />
                       <div class="form-group">
                           <x-dash.form.inputs.checkbox id="" for="contact_2_option_viber" tooltip="{{__('webCaption.viber.caption')}}" label="{{__('webCaption.viber.title')}}"  class="form-control" name="contact_2_viber"   value="1" checked="{{( old('contact_2_viber') == '1' || $data->contact_2_viber == '1' ) ? 'checked' : '' }}" /> &ensp;
   
                           <x-dash.form.inputs.checkbox id="" for="contact_2_option_line" tooltip="{{__('webCaption.line.caption')}}" label="{{__('webCaption.line.title')}}" class="form-control" name="contact_2_line"   value="1" 
                            checked="{{ ( old('contact_2_line') == '1'|| $data->contact_2_line == '1'  ) ? 'checked' : '' }}" />&ensp;
   
                           <x-dash.form.inputs.checkbox id="" for="contact_2_option_whatsapp" tooltip="{{__('webCaption.whatsapp.caption')}}" label="{{__('webCaption.whatsapp.title')}}"  class="form-control" name="contact_2_whatsapp"   value="1" 
                            checked="{{ ( old('contact_2_whatsapp') == '1'  || $data->contact_2_whatsapp == '1'  ) ? 'checked' : '' }}" />&ensp;
                       </div>    
                   </div>
               </div>  
       
             </div>
            {{--  --}}
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
                     <x-dash.form.inputs.text_with_icon id="" for="facebook" label="{{__('webCaption.facebook.title')}}" tooltip="{{__('webCaption.facebook.caption')}}"  maxlength="100"  name="facebook" iconColorClass="text-primary"  iconClass="fab fa-facebook" placeholder="{{__('webCaption.facebook.title')}}" value="{{old('facebook', $data->facebook)}}"  required="" />
                 </div> 
             </div>
             <div class="col-md-4">
                 <div class="form-group">
                     <x-dash.form.inputs.text_with_icon id="" for="instagram" label="{{__('webCaption.instagram.title')}}" tooltip="{{__('webCaption.instagram.caption')}}" maxlength="100"  name="instagram" iconColorClass="text-primary"  iconClass="fab fa-instagram" placeholder="{{__('webCaption.instagram.title')}}" value="{{old('instagram', $data->instagram)}}"  required="" />
                     
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="form-group">
                     <x-dash.form.inputs.text_with_icon id="" for="linkedin" label="{{__('webCaption.linkedin.title')}}"  tooltip="{{__('webCaption.linkedin.caption')}}" maxlength="100" name="linkedin" iconColorClass="text-primary"  iconClass="fab fa-linkedin" placeholder="{{__('webCaption.linkedin.title')}}" value="{{old('linkedin', $data->linkedin )}}"  required="" />
                     
                 </div>
             </div>
         </div>  
 
         <div class="row">
             <div class="col-md-4">
                 <div class="form-group">
                     <x-dash.form.inputs.text_with_icon id="" for="youtube" tooltip="{{__('webCaption.youtube.caption')}}" label="{{__('webCaption.youtube.title')}}" maxlength="100" name="youtube" iconColorClass="text-primary"  iconClass="fab fa-youtube" placeholder="{{__('webCaption.youtube.title')}}" value="{{old('youtube', $data->youtube )}}"  required="" />
                     
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="form-group">
                     <x-dash.form.inputs.text_with_icon id="" for="twitter" tooltip="{{__('webCaption.twitter.caption')}}"  label="{{__('webCaption.twitter.title')}}" maxlength="100"  name="twitter" iconColorClass="text-primary"  iconClass="fab fa-twitter" placeholder="{{__('webCaption.twitter.title')}}" value="{{old('twitter',$data->twitter)}}"  required="" />
                    
                 </div>
             </div>
         </div>  
 
  
 
       </div>
     </div>

        <div class="form-group text-center">
			<input type="hidden" name="id" value="@if(isset($data->company_gabs_id ) && !empty($data->company_gabs_id)){{$data->company_gabs_id}}@endif" />
            <x-dash.form.buttons.update />  
		</div>
  
  
     </form>
</div>
@endsection

@push('script')
  <!-- Page js files -->

  <script src="{{ asset('assets/dash/assets/js/dash/master.js') }}"></script>

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
                      url: "{{route('dashstate-list')}}",
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
                url: "{{route('dashcity-list')}}",
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