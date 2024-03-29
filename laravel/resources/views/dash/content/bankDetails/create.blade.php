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
          <hr class="m-0 p-0">
          <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <x-dash.form.inputs.text for="account_name" maxlength="50" tooltip="{{__('webCaption.account_name.caption')}}" label="{{__('webCaption.account_name.title')}}"  name="account_name"  placeholder="{{__('webCaption.account_name.title')}}" value="{{old('account_name', isset($data->account_name)?$data->account_name:'' )}}" required="" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.number  for="account_number"  maxlength="30" tooltip="{{__('webCaption.account_number.caption')}}" label="{{__('webCaption.account_number.title')}}"  name="account_number"  placeholder="{{__('webCaption.account_number.title')}}" value="{{old('account_number', isset($data->account_number)?$data->account_number:'' )}}"  required="required" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                         <x-dash.form.inputs.select label="{{__('webCaption.account_currency.title')}}"  tooltip="{{__('webCaption.account_currency.caption')}}" for="account_currency" name="account_currency" placeholder="{{ __('locale.account_currency.caption') }}" customClass="account_currency"  editSelected="{{old('account_currency', isset($data->account_currency)?$data->account_currency:'')}}"  required="" :optionData="$currency" />   
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <x-dash.form.inputs.textarea id="" for="account_address" tooltip="{{__('webCaption.account_address.caption')}}"  label="{{__('webCaption.account_address.title')}}" maxlength="250" class="form-control" name="account_address"  placeholder="{{__('webCaption.account_address.title')}}" value="{{old('account_address', isset($data->account_address)?$data->account_address:'' )}}"  required="" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.select onChange="stateLists(this.id,'state_id')" label="{{__('webCaption.country.title')}}"  tooltip="{{__('webCaption.country.caption')}}" for="country_id" name="country" placeholder="{{ __('locale.country.caption') }}" customClass="country"  editSelected="{{(isset($data->country_id) && ($data->country_id != null))?$data->country_id :''; }}"  required="" :optionData="$country" />
                    </div>
               </div>
               <div class="col-md-4">
                    <div class="form-group">
                         <x-dash.form.inputs.select onChange="cityList(this.id,'city_id')" label="{{__('webCaption.state.title')}}"  tooltip="{{__('webCaption.state.caption')}}"  customClass="state" for="state_id" name="state" placeholder="{{ __('locale.state.caption') }}" editSelected=""  required="" :optionData="[]" />
                    </div>
               </div>
               <div class="col-md-4">
                    <div class="form-group">
                    <x-dash.form.inputs.select label="{{__('webCaption.city.title')}}"   tooltip="{{__('webCaption.city.caption')}}" for="city_id" name="city" placeholder="{{ __('locale.city.caption') }}" editSelected=""  required="" :optionData="[]" />
                    </div>
               </div>
               <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="zip_code"  tooltip="{{__('webCaption.zip_code.caption')}}" label="{{__('webCaption.zip_code.title')}}"  name="zip_code"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{old('zip_code', isset($data->zip_code)?$data->zip_code:'' )}}"  required="" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <div class="form-group">
                                <x-dash.form.label for="" value="{{__('webCaption.display_status.title')}}" class="" 
                                tooltip="{{__('webCaption.display_status.caption')}}" />
                                <div>
                                    <div class=" form-check-inline">
                                    <x-dash.form.inputs.radio for="Yes" tooltip="{{__('webCaption.yes.caption')}}"  class="border border-danger" name="display_status" label="{{__('webCaption.yes.title')}}" placeholder="" value="Yes"  required="required"  checked="{{ old('display_status', (isset($data->display) && $data->display == 'Yes') ? 'checked' : 'checked') }}" />&ensp;
                                        
                                    <x-dash.form.inputs.radio for="No" class="border border-danger" name="display_status" tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" placeholder="" value="No"  required="required"  checked="{{ old('display_status', (isset($data->display) && $data->display == 'No') ? 'checked' : '') }}" />&ensp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-6">
                            <div class="form-group">
                                <x-dash.form.label for="" value="{{__('webCaption.primary_bank.title')}}" class="" 
                                tooltip="{{__('webCaption.primary_bank.caption')}}" />
                                <div>
                                    <div class=" form-check-inline">
                                    <x-dash.form.inputs.radio for="yes" tooltip="{{__('webCaption.yes.caption')}}"  class="border border-danger" name="primary_bank" label="{{__('webCaption.yes.title')}}" placeholder="" value="Yes"  required="required"  checked="{{old('primary_bank',(isset($data->primary_bank) && $data->primary_bank == 'Yes') ? 'checked' : '') }}" />&ensp;
                                        
                                    <x-dash.form.inputs.radio for="no" class="border border-danger" name="primary_bank" tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" placeholder="" value="No"  required="required"  checked="{{ old('primary_bank', (isset($data->primary_bank) && $data->primary_bank == 'No') ? 'checked' : 'checked') }}" />&ensp;
                                    </div>
                                </div>
                            </div>
                        </div>
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
            
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                @php
                $old_jumvea_account_value =  session()->getOldInput('jumvea_account');
                $jumvea_account =   (isset($old_jumvea_account_value) && $old_jumvea_account_value == 1  ) ? 'checked' : ((isset($data->jumvea_account) && $data->jumvea_account == 1)? 'checked' :'' );
                @endphp  
            <div class="col-md-12">
                <div class="form-group">
                    <x-dash.form.inputs.checkbox  name="jumvea_account"  for="" label="{{__('webCaption.jumvea_safe_trade.caption')}}" checked="{{$jumvea_account}}"  value="1"  customClass="form-check-input" />
                </div>
            </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.bank_name.title')}}"   tooltip="{{__('webCaption.bank_name.caption')}}" id="" for="bank_name" name="bank_name"  editSelected="{{old('bank_name', isset($data->bank_name_id)?$data->bank_name_id:'')}}"  required="required" :optionData="$banks" />    
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <x-dash.form.label for="" value="{{__('webCaption.bank_logo.title')}}" class=""
                        tooltip="{{__('webCaption.bank_logo.caption')}}" required="" />   
                        <img src="{{asset('assets/dash/assets/images/banklogo/bank_logo_image.png')}}" width="100%" height="100%" alt="BankLogo" name="bank_logo" for="bank_logo" value="{{old('bank_logo', isset($data->bank_logo)?$data->bank_logo:'' )}}" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="branch_name"  maxlength="50" tooltip="{{__('webCaption.branch_name.caption')}}" label="{{__('webCaption.branch_name.title')}}"  name="branch_name"  placeholder="{{__('webCaption.branch_name.title')}}" value="{{old('branch_name', isset($data->branch_name)?$data->branch_name:'' )}}"  required="" /> 
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="swift_code"  maxlength="20" tooltip="{{__('webCaption.swift_code.caption')}}" label="{{__('webCaption.swift_code.title')}}"   name="swift_code"  placeholder="{{__('webCaption.swift_code.title')}}" value="{{old('swift_code', isset($data->swift_code)?$data->swift_code:'' )}}"  required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="branch_code"  maxlength="20" tooltip="{{__('webCaption.branch_code.caption')}}" label="{{__('webCaption.branch_code.title')}}"  name="branch_code"  placeholder="{{__('webCaption.branch_code.title')}}" value="{{old('branch_code', isset($data->branch_code)?$data->branch_code:'' )}}"  required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="iban_no"  maxlength="30" tooltip="{{__('webCaption.iban_no.caption')}}" label="{{__('webCaption.iban_no.title')}}"  name="iban_no"  placeholder="{{__('webCaption.iban_no.title')}}" value="{{old('iban_no', isset($data->iban_no)?$data->iban_no:'' )}}"  required="" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="bank_address" tooltip="{{__('webCaption.bank_address.caption')}}"  label="{{__('webCaption.bank_address.title')}}" maxlength="250" class="form-control" name="bank_address"  placeholder="{{__('webCaption.bank_address.title')}}" value="{{old('bank_address', isset($data->bank_address)?$data->bank_address:'' )}}"  required="" />   
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="reason_for_remittance" tooltip="{{__('webCaption.reason_for_remittance.caption')}}"  label="{{__('webCaption.reason_for_remittance.title')}}" maxlength="250" class="form-control" name="reason_for_remittance"  placeholder="{{__('webCaption.reason_for_remittance.title')}}" value="{{old('reason_for_remittance', isset($data->reason_for_remittance)?$data->reason_for_remittance:'' )}}"  required="" />
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

$country_id =  (isset($country_id)) ? $country_id : ( (isset($data->country_id)) ? $data->country_id : old('country_id'));
$state_id =  (isset($state_id)) ? $state_id : ( (isset($data->state_id)) ? $data->state_id : old('state_id'));
$city_id =  (isset($city_id)) ? $city_id : ( (isset($data->city_id)) ? $data->city_id : old('city_id'));
@endphp 

@push('script')
  <!-- Page js files -->
  <script src="{{ asset('assets/dash/assets/js/dash/master.js') }}"></script>

<script>

$('#send-otp ,#resend-otp').on('click', function(e) {
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
                errorToast(data.result.message);
            }
        }    
    });
});

    let country_id =  "{{$country_id}}";
    let state_id = "{{$state_id}}";
    let city_id = "{{$city_id}}";

    if(country_id != ''){
      stateLists('country_id','state_id', state_id);
    }
    if(city_id != ''){
      cityList('state_id','city_id', city_id, state_id);
    }
</script>
@endpush
@include('components.dash.form.country_state_city')