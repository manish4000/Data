@props([
    'abbrivation',
    'languages'
])

<div class="card">
    <div class="card-header">
      <h4 class="card-title"><i data-feather="map" class="font-medium-3 mr-1"></i>{{ __('locale.Contact_Details.caption') }}</h4>
    </div>
    <hr class="m-0 p-0" />
    <div class="card-body">
      <div class="row">        
        <div class="col-lg-8 col-md-12">
          <x-admin.form.inputs.text for="address" name="address" lable="Address" placeholder="{{ __('locale.Address.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <x-admin.form.inputs.text for="postcode" name="postcode" lable="Postcode" placeholder="{{ __('locale.Postcode.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!--<label for="country_id" class="text-danger"></label>-->
          <!-- <div class="form-group">
            <select class="selectdrop-data-ajax selectdrop-data-change form-control select2 attributes-ajax same_as_check_data_value border-danger " add-master-data="No" data-autofill="true" data-relation="true" data-is-parent="false" data-model="Countries" data-index-model="States|state_id" id="country_id" name="country_id" data-value="@if(old('country_id')){{old('country_id')}}@elseif(isset($data->country_id)){{$data->country_id}}@endif" required>
              <option value="">{{ __('locale.Select.caption') }} {{ __('locale.Country.caption') }}</option>
            </select>
          </div> -->
          <x-admin.form.inputs.select for="country_id" name="country_id" :optionData="$languages" placeholder="{{ __('locale.Country.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
         <!-- <label>State</label>-->
          <!-- <div class="form-group">
            <select class="selectdrop-data-change form-control select2 same_as_check_data_value" data-autofill="false" data-relation="true" data-is-parent="false" data-model="States" data-index-model="Cities|city_id" id="state_id" name="state_id" data-value="@if(old('state_id')){{old('state_id')}}@elseif(isset($data->state_id)){{$data->state_id}}@endif"></select>
          </div> -->
          <x-admin.form.inputs.select for="state_id" name="state_id" :optionData="$languages" placeholder="{{ __('locale.State.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!--<label for="city_id" class="text-danger">City</label>-->
          <!-- <div class="form-group">
            <select class="form-control select2 same_as_check_data_value border-danger" data-index-model="Cities" id="city_id" name="city_id"  data-value="@if(old('city_id')){{old('city_id')}}@elseif(isset($data->city_id)){{$data->city_id}}@endif" required>
              <option value="">{{ __('locale.Select.caption') }} {{ __('locale.City.caption') }}</option>
            </select>
          </div> -->
          <x-admin.form.inputs.select for="city_id" name="city_id" :optionData="$languages" placeholder="{{ __('locale.City.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-12">
          <!-- <div class="form-group"> -->
            <!--<label for="skype_id">Skype Id</label>-->
            <!-- <input id="skype_id" type="text" class="form-control" value="@if(old('skype_id')){{old('skype_id')}}@elseif(isset($data->skype_id)){{$data->skype_id}}@endif" placeholder="{{ __('locale.Skype.caption') }}" name="skype_id" /> -->
          <!-- </div> -->
          <x-admin.form.inputs.text for="skype_id" name="skype_id" lable="Skype" placeholder="{{ __('locale.Skype.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-12">
          <!--<label for="phone-number" class="text-danger">Phone 1</label>-->
          <fieldset>
            <div class="row">
              <div class="col-md-5  ">
                
                <x-admin.form.inputs.select for="mobile1_abbrivation" name="mobile1_abbrivation"  value="" required="" :optionData="$abbrivation" />
              </div>
               <div class="col-md-7 pl-0"> 
                <!-- <input type="text" class="form-control phone-number-mask border-danger " placeholder="{{ __('locale.Phone_1.caption') }}" value="@if(old('mobile1')){{old('mobile1')}}@elseif(isset($data->mobile1)){{$data->mobile1}}@endif" id="mobile1" name="mobile1" required/> -->
                <x-admin.form.inputs.text for="mobile1" name="mobile1" lable="Mobile1" placeholder="{{ __('locale.Mobile1.caption') }}" value="" required="" />
              </div>
            </div>
          </fieldset>
        </div>



        <div class="col-lg-4 col-md-6">
          <div class="form-group">
            <label class="d-block mb-1">Phone 1 Contact Options</label>
            <!-- <div class="custom-control custom-checkbox custom-control-inline">
              @php $checki = ''; @endphp
              @if(is_array(old('mobile1_contact_options')) && in_array('whatsapp', old('mobile1_contact_options'))) @php $checki = 'checked="checked"'; @endphp 
              @elseif(isset($data->mobile1_contact_options) && is_array($data->mobile1_contact_options) && in_array('whatsapp', $data->mobile1_contact_options)) @php $checki = 'checked="checked"'; @endphp @endif
              <input type="checkbox" class="custom-control-input" name="mobile1_contact_options[]" value="whatsapp" id="mobile1_whatsapp" {{$checki}}/>
              <label class="custom-control-label" for="mobile1_whatsapp">Whats App</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
              @php $checki = ''; @endphp
              @if(is_array(old('mobile1_contact_options')) && in_array('viber', old('mobile1_contact_options'))) @php $checki = 'checked="checked"'; @endphp 
              @elseif(isset($data->mobile1_contact_options) && is_array($data->mobile1_contact_options) && in_array('viber', $data->mobile1_contact_options)) @php $checki = 'checked="checked"'; @endphp @endif
              <input type="checkbox" class="custom-control-input" name="mobile1_contact_options[]" value="viber" id="mobile1_viber" {{$checki}}/>
              <label class="custom-control-label" for="mobile1_viber">Viber</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
              @php $checki = ''; @endphp
              @if(is_array(old('mobile1_contact_options')) && in_array('line', old('mobile1_contact_options'))) @php $checki = 'checked="checked"'; @endphp 
              @elseif(isset($data->mobile1_contact_options) && is_array($data->mobile1_contact_options) && in_array('line', $data->mobile1_contact_options)) @php $checki = 'checked="checked"'; @endphp @endif
              <input type="checkbox" class="custom-control-input" name="mobile1_contact_options[]" value="line" id="mobile1_line" {{$checki}}/>
              <label class="custom-control-label" for="mobile1_line">Line</label>
            </div> -->

            <x-admin.form.inputs.checkbox for="mobile1_whatsapp" name="mobile1_contact_options[]" lable="Whats App" value="" customClass="custom-control-inline" required="" />
            <x-admin.form.inputs.checkbox for="mobile1_viber" name="mobile1_contact_options[]" lable="Viber" value="" customClass="custom-control-inline" required="" />
            <x-admin.form.inputs.checkbox for="mobile1_line" name="mobile1_contact_options[]" lable="Line" value="" customClass="custom-control-inline" required="" />

          </div>
        </div>
        <div class="col-lg-4 col-md-12">
          <!--<label>Website</label>-->
          <fieldset>
            <div class="input-group">
              <div class="input-group-prepend">
                <select class="form-control" name="website_prefix" id="website_prefix">
                  <option value="https://" @if(old('website_prefix') && old('website_prefix') == 'https://'){{'selected="selected"'}}@elseif(isset($data->website_prefix) && $data->website_prefix=='https://'){{'selected="selected"'}}@endif>https://&nbsp;&nbsp;&nbsp;&nbsp;</option>
                  <option value="http://" @if(old('website_prefix') && old('website_prefix') == 'http://'){{'selected="selected"'}}@elseif(isset($data->website_prefix) && $data->website_prefix=='http://'){{'selected="selected"'}}@endif>http://&nbsp;&nbsp;&nbsp;&nbsp;</option>
                </select>
              </div>
              <input type="text" class="form-control" name="website" id="website" value="@if(old('website')){{old('website')}}@elseif(isset($data->website)){{$data->website}}@endif"/>
            </div>
          </fieldset>
        </div>
        <div class="col-lg-4 col-md-12">
          <!--<label for="phone-number" class="text-danger">Phone 2</label>-->
          <fieldset>
             <div class="row">
                <div class="col-md-5">
                  {{-- <select class="form-control mobile_abbrivation" name="mobile2_abbrivation" id="mobile2_abbrivation">
                  @if(isset($abbrivation) && count($abbrivation)>0)
                    @foreach($abbrivation as $abbr)
                    <option value="{{$abbr->country_code.' | '.$abbr->phone_code}}" @if(old('mobile2_abbrivation') && old('mobile2_abbrivation') == $abbr->country_code.' | '.$abbr->phone_code){{'selected="selected"'}}@elseif(isset($data->mobile2_abbrivation) && $data->mobile2_abbrivation==$abbr->country_code.' | '.$abbr->phone_code){{'selected="selected"'}}@endif>{{$abbr->country_code.' ('.$abbr->phone_code.')'}}</option>
                    @endforeach
                  @endif
                 </select> --}}
                 <x-admin.form.inputs.select for="mobile2_abbrivation" name="mobile2_abbrivation"  :optionData="$abbrivation" value="" required="" />
               </div>
                 <div class=" col-md-7 pl-0">
                    <!-- <input type="text" class="form-control phone-number-mask" placeholder="{{ __('locale.Phone_2.caption') }}" value="@if(old('mobile2')){{old('mobile2')}}@elseif(isset($data->mobile2)){{$data->mobile2}}@endif" id="mobile2" name="mobile2"/> -->

                    <x-admin.form.inputs.text for="mobile2" name="mobile2" lable="Mobile1" placeholder="{{ __('locale.Mobile2.caption') }}" value="" required="" />
                 </div>
              </div>
          </fieldset>
      </div>

        <div class="col-lg-4 col-md-6">
          <div class="form-group">
            <label class="d-block mb-1">Phone 2 Contact Options</label>
            <!-- <div class="custom-control custom-checkbox custom-control-inline">
              @php $checki = ''; @endphp
              @if(is_array(old('mobile2_contact_options')) && in_array('whatsapp', old('mobile2_contact_options'))) @php $checki = 'checked="checked"'; @endphp 
              @elseif(isset($data->mobile2_contact_options) && is_array($data->mobile2_contact_options) && in_array('whatsapp', $data->mobile2_contact_options)) @php $checki = 'checked="checked"'; @endphp @endif
              <input type="checkbox" class="custom-control-input" name="mobile2_contact_options[]" value="whatsapp" id="mobile2_whatsapp" {{$checki}}/>
              <label class="custom-control-label" for="mobile2_whatsapp">Whats App</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
              @php $checki = ''; @endphp
              @if(is_array(old('mobile2_contact_options')) && in_array('viber', old('mobile2_contact_options'))) @php $checki = 'checked="checked"'; @endphp 
              @elseif(isset($data->mobile2_contact_options) && is_array($data->mobile2_contact_options) && in_array('viber', $data->mobile2_contact_options)) @php $checki = 'checked="checked"'; @endphp @endif
              <input type="checkbox" class="custom-control-input" name="mobile2_contact_options[]" value="viber" id="mobile2_viber" {{$checki}}/>
              <label class="custom-control-label" for="mobile2_viber">Viber</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
              @php $checki = ''; @endphp
              @if(is_array(old('mobile2_contact_options')) && in_array('line', old('mobile2_contact_options'))) @php $checki = 'checked="checked"'; @endphp 
              @elseif(isset($data->mobile2_contact_options) && is_array($data->mobile2_contact_options) && in_array('line', $data->mobile2_contact_options)) @php $checki = 'checked="checked"'; @endphp @endif
              <input type="checkbox" class="custom-control-input" name="mobile2_contact_options[]" value="line" id="mobile2_line" {{$checki}}/>
              <label class="custom-control-label" for="mobile2_line">Line</label>
            </div> -->

            <x-admin.form.inputs.checkbox for="mobile2_whatsapp" name="mobile2_contact_options[]" lable="Whats App" value="" customClass="custom-control-inline" required="" />
            <x-admin.form.inputs.checkbox for="mobile2_viber" name="mobile2_contact_options[]" lable="Viber" value="" customClass="custom-control-inline" required="" />
            <x-admin.form.inputs.checkbox for="mobile2_line" name="mobile2_contact_options[]" lable="Line" value="" customClass="custom-control-inline" required="" />

          </div>
        </div>
        
      </div>
    </div>
  </div>