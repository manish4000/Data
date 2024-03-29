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
                  <div class="col-md-12">
                     <div class="form-group">
                        <x-dash.form.inputs.text id="" for="company_name" tooltip="{{__('webCaption.company_name.caption')}}" label="{{__('webCaption.company_name.title')}}" maxlength="100" class="form-control" name="company_name"  placeholder="{{__('webCaption.company_name.title')}}" value="{{old('company_name', isset($data->company_name)?$data->company_name:'' )}}"  required="required" />
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <x-dash.form.inputs.textarea id="" for="address" tooltip="{{__('webCaption.address.caption')}}" label="{{__('webCaption.address.title')}}" maxlength="255"  class="form-control" name="address"  placeholder="{{__('webCaption.address.title')}}" value="{{old('address', isset($data->address)? $data->address:'' )}}"  required="" />   
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-dash.form.inputs.select label="{{__('webCaption.country.title')}}" 
                           tooltip="{{__('webCaption.country.caption')}}" for="country_id" name="country_id" :optionData="$country"
                           placeholder="{{ __('locale.country.caption') }}" customClass="country"  editSelected="{{(isset($data->country_id) && ($data->country_id != null)) ? $data->country_id :'' }}" disabled="disabled" required="required" />
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
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-dash.form.inputs.text id="" for="zip_code" tooltip="{{__('webCaption.zip_code.caption')}}" label="{{__('webCaption.zip_code.title')}}" maxlength="100"  class="form-control" name="postcode"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{old('postcode', isset($data->postcode)? $data->postcode:'' )}}"  required="" />
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-dash.form.inputs.email id="" for="email" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}" maxlength="45" class="form-control" name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($data->email)?$data->email:'' )}}"  required="required" />
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-dash.form.inputs.text id="" for="website" tooltip="{{__('webCaption.website.caption')}}" label="{{__('webCaption.website.title')}}" maxlength="75"  class="form-control" name="website"  placeholder="{{__('webCaption.website.title')}}" value="{{old('website', isset($data->website)? $data->website:'' )}}"  required="" />
                     </div>
                  </div>
                  <div class="col-md-6">
                     <fieldset>
                        <div class="row">
                           <div class="col-md-3 col-5">
                              <div class="form-group">
                                 <x-dash.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="country_code1" name="country_code"  required="" :optionData="[]"  editSelected="{{(isset($country_code) && ($country_code != null)) ? $country_code : ''; }}" />
                              </div>
                           </div>
                           <div class="col-md-5 col-7 px-0">
                              <div class="form-group">
                                 <x-dash.form.inputs.text  for="telephone"  maxlength="20" tooltip="{{__('webCaption.telephone.caption')}}" label="{{__('webCaption.telephone.title')}}"  class="form-control" name="telephone"  placeholder="{{__('webCaption.telephone.title')}}" value="{{old('telephone', isset($data->telephone)?$data->telephone:'' )}}"  required="" /> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 @include('components.dash.form.inputs.messenger_common', ['id' =>
                                 'messenger_1', 'name' => 'messenger_1'])
                              </div>
                           </div>
                        </div>
                     </fieldset>
                  </div>
                  <div class="col-md-6">
                     <fieldset>
                        <div class="row">
                           <div class="col-md-3 col-5">
                              <div class="form-group">
                              <x-dash.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="country_code2" name="country_code"  required="" :optionData="[]"  editSelected="{{(isset($country_code) && ($country_code != null)) ? $country_code : ''; }}" />
                              </div>
                           </div>
                           <div class="col-md-5 col-7 px-0">
                              <div class="form-group">
                                 <x-dash.form.inputs.text  for="Mobile"  maxlength="20" tooltip="{{__('webCaption.mobile.caption')}}" label="{{__('webCaption.mobile.title')}}"  class="form-control" name="mobile"  placeholder="{{__('webCaption.mobile.title')}}" value="{{old('mobile', isset($data->mobile)?$data->mobile:'' )}}"  required="" />
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 @include('components.dash.form.inputs.messenger_common', ['id' =>
                                 'messenger_2', 'name' => 'messenger_2'])
                              </div>
                           </div>
                        </div>
                     </fieldset>
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
 
             <div class="col-md-6">
                 <div class="form-group">
                   <x-dash.form.inputs.multiple_select tooltip="{{__('webCaption.business_type.caption')}}" label="{{__('webCaption.business_type.title')}}"  id="" for="business_type_id" name="business_type_id[]" placeholder="{{__('webCaption.business_type_id.title')}}" :editSelected="$editSelected" :oldValues="old('business_type_id')"  required="" :optionData="$business_types" />
                 </div>
             </div>
             
             <div class="col-md-6">
                 <div class="form-group">
                   <x-dash.form.inputs.multiple_select label="{{__('webCaption.association_member.title')}}"  tooltip="{{__('webCaption.association_member.caption')}}"   id="" for="association_member_id" name="association_member_id[]"   required="" :editSelected="$associationEditSelected"  :oldValues="old('association_member_id')" :optionData="$association" />
                 </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <x-dash.form.inputs.multiple_select label="{{__('webCaption.deals_in.title')}}"  id="" for="deals_in" name="deals_in" placeholder="{{__('webCaption.deals_in.title')}}" editSelected="{{old('deals_in',$data->deals_in)}}" required="" :optionData="[]" />   
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  @if(isset($user->companySalesTeam->language_id))
                     @php $editSelected = json_decode($user->companySalesTeam->language_id); @endphp
                  @else
                     @php $editSelected = ''; @endphp
                  @endif
                  <x-dash.form.inputs.multiple_select label="{{__('webCaption.language.title')}}"  id="" for="language" name="language[]" placeholder="{{__('webCaption.language.title')}}" :oldValues="old('language')" :editSelected="$editSelected"  required="" :optionData="[]" />
               </div>
            </div> 
         </div>  
 
         <div class="row">
             <div class="col-md-12">
                 <div class="form-group">
                   <x-dash.form.inputs.textarea id="" for="permit_number" label="{{__('webCaption.permit_number.title')}}" tooltip="{{__('webCaption.permit_number.caption')}}" maxlength="250"  name="permit_no"  placeholder="{{__('webCaption.permit_no.title')}}" 
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
               <h4 class="card-title">  {{__('webCaption.primary_contact.title')}} </h4>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-dash.form.inputs.text id="" for="primary_contact_name" tooltip="{{__('webCaption.name.caption')}}" label="{{__('webCaption.name.title')}}" maxlength="100" class="form-control" name="primary_contact_name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('primary_contact_name',$data->primary_contact_name)}}"  required="" />
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-dash.form.inputs.text id="" for="primary_contact_designation" tooltip="{{__('webCaption.designation.caption')}}" label="{{__('webCaption.designation.title')}}" maxlength="50" class="form-control" name="primary_contact_designation"  placeholder="{{__('webCaption.designation.title')}}" value="{{old('primary_contact_designation',$data->primary_contact_designation)}}"  required="" />
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <x-dash.form.inputs.email id="" for="primary_contact_email" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}" maxlength="50" class="form-control" name="primary_contact_email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('primary_contact_email',$data->primary_contact_email)}}"  required="" />
                     </div>
                  </div>
               </div>
   
               <div class="row">
                <div class="col-md-6">
                   <fieldset>
                      <div class="row">
                         <div class="col-md-3 col-5">
                            <div class="form-group">
                            <x-dash.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="country_code3" name="country_code"  required="" :optionData="[]"  editSelected="{{(isset($country_code) && ($country_code != null)) ? $country_code : ''; }}" />
                            </div>
                         </div>
                         <div class="col-md-5 col-7 px-0">
                            <div class="form-group">
                               <x-dash.form.inputs.text  for="Mobile"  maxlength="20" tooltip="{{__('webCaption.mobile.caption')}}" label="{{__('webCaption.mobile.title')}}"  class="form-control" name="mobile"  placeholder="{{__('webCaption.mobile.title')}}" value="{{old('mobile', isset($data->mobile)?$data->mobile:'' )}}"  required="" />
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                @include('components.dash.form.inputs.messenger_common', ['id' =>
                                'messenger_3', 'name' => 'messenger_3'])
                            </div>
                        </div>
                      </div>
                   </fieldset>
                </div>

               </div>
   
            </div>
   
            {{--  --}}
            <div class="card-body" >
               <h4 class="card-title">    {{__('webCaption.secondary_contact.title')}} </h4>
               <div class="row">
                   <div class="col-md-4">
                       <div class="form-group">
                           <x-dash.form.inputs.text id="" for="secondary_contact_name" tooltip="{{__('webCaption.name.caption')}}" label="{{__('webCaption.name.title')}}" maxlength="100" class="form-control" name="secondary_contact_name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('secondary_contact_name',$data->secondary_contact_name)}}"  required="" />
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <x-dash.form.inputs.text id="" for="secondary_contact_designation" tooltip="{{__('webCaption.designation.caption')}}" label="{{__('webCaption.designation.title')}}" maxlength="50" class="form-control" name="secondary_contact_designation"  placeholder="{{__('webCaption.designation.title')}}" value="{{old('secondary_contact_designation',$data->secondary_contact_designation)}}"   required="" />
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <x-dash.form.inputs.email id="" for="secondary_contact_email" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}" maxlength="50" class="form-control" name="secondary_contact_email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('secondary_contact_email',$data->secondary_contact_email )}}"  required="" />
                       </div>
                   </div>
               </div>  
       
               <div class="row">
               <div class="col-md-6">
                   <fieldset>
                      <div class="row">
                         <div class="col-md-3 col-5">
                            <div class="form-group">
                            <x-dash.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="country_code4" name="country_code"  required="" :optionData="[]"  editSelected="{{(isset($country_code) && ($country_code != null)) ? $country_code : ''; }}" />
                            </div>
                         </div>
                         <div class="col-md-5 col-7 px-0">
                            <div class="form-group">
                               <x-dash.form.inputs.text  for="Mobile"  maxlength="20" tooltip="{{__('webCaption.mobile.caption')}}" label="{{__('webCaption.mobile.title')}}"  class="form-control" name="mobile"  placeholder="{{__('webCaption.mobile.title')}}" value="{{old('mobile', isset($data->mobile)?$data->mobile:'' )}}"  required="" />
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                @include('components.dash.form.inputs.messenger_common', ['id' =>
                                'messenger_4', 'name' => 'messenger_4'])
                            </div>
                        </div>
                      </div>
                   </fieldset>
                </div>
                   
               </div>  
       
             </div>
            {{--  --}}
         </div>

        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-info font-medium-3 mr-1">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    {{__('webCaption.social_media.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    @include('components.dash.form.inputs.social_media', ['id' => 'social_media_company', 'name' =>
                    'company_social_media'])
                    <!-- <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text_with_icon for="facebook"
                                tooltip="{{__('webCaption.facebook.caption')}}"
                                label="{{__('webCaption.facebook.title')}}" maxlength="100" class="form-control"
                                iconColorClass="text-primary" iconClass="fab fa-facebook" name="facebook"
                                placeholder="{{__('webCaption.facebook.title')}}"
                                value="{{old('facebook', isset($data->id)?$data->facebook:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text_with_icon for="instagram"
                                tooltip="{{__('webCaption.instagram.caption')}}"
                                label="{{__('webCaption.instagram.title')}}" maxlength="100" class="form-control"
                                iconColorClass="text-primary" iconClass="fab fa-instagram" name="instagram"
                                placeholder="{{__('webCaption.instagram.title')}}"
                                value="{{old('instagram', isset($data->id)?$data->instagram:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text_with_icon for="twitter"
                                tooltip="{{__('webCaption.twitter.caption')}}"
                                label="{{__('webCaption.twitter.title')}}" maxlength="100" class="form-control"
                                iconColorClass="text-primary" iconClass="fab fa-twitter" name="twitter"
                                placeholder="{{__('webCaption.twitter.title')}}"
                                value="{{old('twitter', isset($data->id)?$data->twitter:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text_with_icon for="linked_in"
                                tooltip="{{__('webCaption.linked_in.caption')}}"
                                label="{{__('webCaption.linked_in.title')}}" maxlength="100" class="form-control"
                                iconColorClass="text-primary" iconClass="fab fa-linkedin" name="linked_in"
                                placeholder="{{__('webCaption.linked_in.title')}}"
                                value="{{old('linked_in', isset($data->id)?$data->linked_in:'' )}}" required="" />
                        </div>
                    </div> -->
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
    messengerImageCode();
});

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