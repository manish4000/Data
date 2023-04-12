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