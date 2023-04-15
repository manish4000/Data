@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.edit_bank_details.title') )
@else
@section('title', __('webCaption.add_bank_details.title'))
@endif


@section('content')
<div>
	<form action="{{ route('dashbank-details.store')}}" method="POST" id="bank-details">
		@csrf
		<div class="card card-primary">
			<div class="card-header">
				<h4 class="card-title">
		
				<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
				</svg>
				@if(isset($data->id))  {{__('webCaption.edit_bank_details.title')}}  @else {{__('webCaption.add_bank_details.title')}} @endif 
				</h4>  
			</div>
			<hr class="m-0 p-0">    
		</div>
        {{-- <div class="card">
            <div class="card-header">
                <h4 class="card-title">
        
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
                </svg>
                {{__('webCaption.dealer_information.title')}} 
                </h4>  
            </div>
          <div class="card-body">
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <x-dash.form.inputs.text  for="dealer_name"  maxlength="255" tooltip="{{__('webCaption.dealer_name.caption')}}" label="{{__('webCaption.dealer_name.title')}}"  name="dealer_name"  placeholder="{{__('webCaption.dealer_name.title')}}" value="{{old('dealer_name', isset($data->dealer_name)?$data->dealer_name:'' )}}"  required="" />
                      </div>
                  </div>

              </div>
          </div>
        </div>      --}}
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
        
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
                </svg>
                {{__('webCaption.beneficiary_details.title')}} 
                </h4>  
            </div>
          <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="account_name"  maxlength="100" tooltip="{{__('webCaption.account_name.caption')}}" label="{{__('webCaption.account_name.title')}}"  name="account_name"  placeholder="{{__('webCaption.account_name.title')}}" value="{{old('account_name', isset($data->account_name)?$data->account_name:'' )}}"  required="" />
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.number  for="account_number"  maxlength="255" tooltip="{{__('webCaption.account_number.caption')}}" label="{{__('webCaption.account_number.title')}}"  name="account_number"  placeholder="{{__('webCaption.account_number.title')}}" value="{{old('account_number', isset($data->account_number)?$data->account_number:'' )}}"  required="required" />
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="account_currency"  maxlength="255" tooltip="{{__('webCaption.account_currency.caption')}}" label="{{__('webCaption.account_currency.title')}}"   name="account_currency"  placeholder="{{__('webCaption.account_currency.title')}}" value="{{old('account_currency', isset($data->account_currency)?$data->account_currency:'' )}}"  required="" />
                        
                    </div>
                </div>
              </div>  
          </div>
          <div class="card-header">
            <h4 class="card-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin font-medium-4 mr-25"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
            </svg>
            {{__('webCaption.beneficiary_address.title')}} 
            </h4>  
        </div>
          <div class="card-body">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <x-dash.form.inputs.textarea id="" for="account_address" tooltip="{{__('webCaption.account_address.caption')}}"  label="{{__('webCaption.account_address.title')}}" maxlength="250" class="form-control" name="account_address"  placeholder="{{__('webCaption.account_address.title')}}" value="{{old('account_address', isset($data->account_address)?$data->account_address:'' )}}"  required="" />
                        @if($errors->has('account_address'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('account_address') }}"  />
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.select label="{{__('webCaption.country.title')}}"  tooltip="{{__('webCaption.country.caption')}}" for="country_id" name="country_id" 
                        placeholder="{{ __('locale.country.caption') }}" customClass="country"  editSelected="{{(isset($data->country_id) && ($data->country_id != null))?$data->country_id :''; }}"  required="" :optionData="$country" />
                       
                    </div>
               </div>
               <div class="col-md-4">
                    <div class="form-group">
                         <x-dash.form.inputs.select label="{{__('webCaption.state.title')}}"  tooltip="{{__('webCaption.state.caption')}}"  customClass="state" id="" for="state_id" name="state_id" placeholder="{{ __('locale.state.caption') }}" editSelected=""  required="" :optionData="[]" />
                        
                    </div>
               </div>
               <div class="col-md-4">
                    <div class="form-group">
                    <x-dash.form.inputs.select label="{{__('webCaption.city.title')}}"   tooltip="{{__('webCaption.city.caption')}}" id="" for="city_id" name="city_id" placeholder="{{ __('locale.city.caption') }}" editSelected=""  required="" :optionData="[]" />
                        
                    </div>
               </div> 

            </div>
          </div>

        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
        
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
                </svg>
                {{__('webCaption.bank_details.title')}} 
                </h4>  
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                            $banks  =  [ 
                                            [ 'value' => 'SBI', 'name'=> 'SBI' ],
                                            [ 'value' => 'OBC', 'name'=> 'OBC' ],
                                            [ 'value'=> 'HDFC', 'name'=> 'HDFC' ], 
                                        ];
                             $banks =   json_decode(json_encode($banks)) ;
                            @endphp

                            <x-dash.form.inputs.select label="{{__('webCaption.bank_name.title')}}"   tooltip="{{__('webCaption.bank_name.caption')}}" id="" for="bank_name" name="bank_name"  editSelected=""  required="required" :optionData="$banks" />    
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="branch_name"  maxlength="255" tooltip="{{__('webCaption.branch_name.caption')}}" label="{{__('webCaption.branch_name.title')}}"  name="branch_name"  placeholder="{{__('webCaption.branch_name.title')}}" value="{{old('branch_name', isset($data->branch_name)?$data->branch_name:'' )}}"  required="" />
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="swift_code"  maxlength="100" tooltip="{{__('webCaption.swift_code.caption')}}" label="{{__('webCaption.swift_code.title')}}"   name="swift_code"  placeholder="{{__('webCaption.swift_code.title')}}" value="{{old('swift_code', isset($data->swift_code)?$data->swift_code:'' )}}"  required="required" />
                            
                        </div>
                    </div>
                </div>  

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="branch_code"  maxlength="255" tooltip="{{__('webCaption.branch_code.caption')}}" label="{{__('webCaption.branch_code.title')}}"  name="branch_code"  placeholder="{{__('webCaption.branch_code.title')}}" value="{{old('branch_code', isset($data->branch_code)?$data->branch_code:'' )}}"  required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="iban_no"  maxlength="255" tooltip="{{__('webCaption.iban_no.caption')}}" label="{{__('webCaption.iban_no.title')}}"  name="iban_no"  placeholder="{{__('webCaption.iban_no.title')}}" value="{{old('iban_no', isset($data->iban_no)?$data->iban_no:'' )}}"  required="" />
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="reason_for_remittance" tooltip="{{__('webCaption.reason_for_remittance.caption')}}"  label="{{__('webCaption.reason_for_remittance.title')}}" maxlength="250" class="form-control" name="reason_for_remittance"  placeholder="{{__('webCaption.reason_for_remittance.title')}}" value="{{old('reason_for_remittance', isset($data->reason_for_remittance)?$data->reason_for_remittance:'' )}}"  required="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                      $old_jumvea_account_value =  session()->getOldInput('jumvea_account');
                      $jumvea_account =   (isset($old_jumvea_account_value) && $old_jumvea_account_value == 1  ) ? 'checked' : ((isset($data->jumvea_account) && $data->jumvea_account == 1)? 'checked' :'' );
                      @endphp
                    <div class="col-md-4">
                        <x-admin.form.label for="" tooltip="{{__('webCaption.jumvea_safe_trade.caption')}}" value="{{__('webCaption.jumvea_safe_trade.title')}}" class="" />
                           <div class="form-group">
                               <x-dash.form.inputs.checkbox  name="jumvea_account"  for="" label="{{__('webCaption.yes.caption')}}" checked="{{$jumvea_account}}"  value="1"  customClass="form-check-input"  />
                               @if ($errors->has('jumvea_account'))
                                   <x-dash.form.form_error_messages message="{{ $errors->first('jumvea_account') }}" />
                               @endif
                           </div>
                    </div>
                </div>
  
            </div>

            <div class="card-header">
                <h4 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
                </svg>
                {{__('webCaption.bank_address.title')}} 
                </h4>  
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="bank_address" tooltip="{{__('webCaption.bank_address.caption')}}"  label="{{__('webCaption.bank_address.title')}}" maxlength="250" class="form-control" name="bank_address"  placeholder="{{__('webCaption.bank_address.title')}}" value="{{old('bank_address', isset($data->bank_address)?$data->bank_address:'' )}}"  required="" />
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="display_order"  maxlength="255" tooltip="{{__('webCaption.display_order.caption')}}" label="{{__('webCaption.display_order.title')}}"   name="display_order"  placeholder="{{__('webCaption.display_order.title')}}" value="{{old('display_order', isset($data->display_order)?$data->display_order:'' )}}"  required="" />
                        
                        </div>
                    </div>
                    
                </div>  
  
            </div>
        </div>
        @if($errors->any())
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
        
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
                </svg>
                {{__('webCaption.verify_account.title')}} 
                </h4>  
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="otp"  tooltip="{{__('webCaption.otp.caption')}}"  label="{{__('webCaption.otp.title')}}"  name="otp"  placeholder="{{__('webCaption.enter_otp.title')}}" value="{{old('otp')}}"  required="required" />
                        </div>
                    </div>

                    @if($errors->has('otp_expire'))

                    <div class="col-md-4">
                        <div class="form-group ">
                            <button id="resend-otp" class="btn btn-info mt-2"> Resend OTP</button> 
                        </div>
                    </div>

                    @endif
                </div>  
                
            </div>
        </div>
        <div class="form-group text-center" id="submit-form">
            <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
            @if(isset($data->id)) 	<x-dash.form.buttons.update /> @else <x-dash.form.buttons.create /> @endif 
        </div>
        @else
        
        <div class="card" id="otp-input-div" style="display: none" >
            <div class="card-header">
                <h4 class="card-title">
        
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
                </svg>
                {{__('webCaption.verify_account.title')}} 
                </h4>  
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="otp"  tooltip="{{__('webCaption.otp.caption')}}"  label="{{__('webCaption.otp.title')}}"  name="otp"  placeholder="{{__('webCaption.enter_otp.title')}}" value="{{old('otp')}}"  required="required" />
                        </div>
                    </div>
                </div>  
            </div>

        </div>
        
        <div class="form-group text-center" id="send-otp-div">
                <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
                @if(isset($data->id)) 	<x-dash.form.buttons.update id="send-otp" /> @else <x-dash.form.buttons.create id="send-otp"/> @endif 
        </div>
       
        <div class="form-group text-center" id="submit-form" style="display: none">
            <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
            @if(isset($data->id)) 	<x-dash.form.buttons.update /> @else <x-dash.form.buttons.create /> @endif 
        </div>
        @endif
        
       

    </form>
</div>
@endsection

@php
$state_id = session()->getOldInput('state_id');
$city_id = session()->getOldInput('city_id');
$state_id =  (isset($state_id)) ? $state_id : ( (isset($data->state_id)) ? $data->state_id :'' );
$city_id =  (isset($city_id)) ? $city_id : ( (isset($data->city_id)) ? $data->city_id :'' );
@endphp 

@push('script')
  <!-- Page js files -->
  <script src="{{ asset('assets/dash/assets/js/dash/master.js') }}"></script>

<script>

      var  country  = $('.country').find(":selected").val();
      var  state  =   "<?php echo $state_id ; ?>";
      var  city  = "<?php echo $city_id; ?>";
    
      if(country){
              stateList(country,state);
      }
       
      if(state){
          $.ajax ({
              type: 'POST',
              url: "{{route('dashcity-list')}}",
              data: { id : state ,"_token": "{{ csrf_token() }}"},
              success : function(result) {
                $('#city_id').html('<option value="">Select City</option>');
                  $.each(result.cities, function (key, value) {

                    if(value.id == city){
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
                    data: { id : country ,"_token": "{{ csrf_token() }}"},
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
            data: { id : state ,"_token": "{{ csrf_token() }}" },
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

    
    $( '#send-otp ,#resend-otp' ).on('click', function(e) {
        e.preventDefault();
        $.ajax({
        type: "GET",
        url: "{{route('dashbank-details.send-otp')}}",
        data: { }, 
        success: function( data ) {
                if(data.result.status  == true){
                    $('#otp-input-div').css("display", "block");
                    $('#send-otp-div').css("display", "none");
                    $('#submit-form').css("display", "block");
                    successToast(data.result.message);
                }else{
                    errorToast(data.result.message)
                }
             }    
        });

    });




</script>
  
@endpush