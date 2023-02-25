@props([
    'ownerShipTypes',
    'languages',
    'dealIns',
    'businessTypes',
    'organizations',
    'paymentTerms',
    'services'
])

<div class="card">
    <div class="card-header">
      <h4 class="card-title"><i data-feather="layers" class="font-medium-3 mr-1"></i>{{ __('locale.General_Details.caption') }}</h4>
    </div>
    <hr class="m-0 p-0" />
    <div class="card-body">
      <div class="row">        
        <div class="col-lg-4 col-md-6">
          <!-- <div class="form-group"> -->
            <!--<label>Ownership Type</label>-->
            <!-- <select class="selectdrop-data-ajax form-control select2" data-autofill="true" data-is-parent="false" data-model="OwnerShipTypes" name="ownership_type_id" id="ownership_type_id">
              @if(isset($OwnerShipTypes) && count($OwnerShipTypes)>0)
                @foreach($OwnerShipTypes as $dts)
                  <option value="{{$dts->id}}" @if(old('ownership_type_id') && old('ownership_type_id') == $dts->id){{'selected="selected"'}}@elseif(isset($data->ownership_type_id) && $data->ownership_type_id==$dts->id){{'selected="selected"'}}@endif>{{$dts->name}}</option>
                @endforeach
              @endif
            </select> -->
          <!-- </div> -->
          <x-admin.form.inputs.select for="ownership_type_id" name="ownership_type_id"  :optionData="$ownerShipTypes" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!-- <div class="form-group"> -->
            <!--<label for="languages">Languages</label>-->
            <!-- <select class="form-control select2" data-autofill="true" multiple data-is-parent="false" data-model="Languages" name="languages_id[]" id="languages_id">
              @if(isset($Languages) && count($Languages)>0)
                @foreach($Languages as $dts)
                  @php $sel = ''; @endphp
                  @if(is_array(old('languages_id')) && in_array($dts->id, old('languages_id'))) @php $sel = 'selected="selected"'; @endphp 
                  @elseif(isset($data->languages_id) && is_array($data->languages_id) && in_array($dts->id, $data->languages_id)) @php $sel = 'selected="selected"'; @endphp @endif
                  <option value="{{$dts->id}}" {{$sel}}>{{$dts->name}}</option>
                @endforeach
              @endif
            </select> -->
          <!-- </div> -->
          <x-admin.form.inputs.multiple_select for="language_id" name="language_id[]"  :optionData="$languages" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!-- <div class="form-group"> -->
            <!--<label for="payment_terms">Payment Terms</label>-->
            <!-- <select class="selectdrop-data-ajax form-control select2" data-autofill="true" multiple data-is-parent="false" data-model="PaymentTerms" name="payment_terms_id[]" id="payment_terms_id">
              @if(isset($payment_terms) && count($payment_terms)>0)
                @foreach($payment_terms as $dts)
                  @php $sel = ''; @endphp
                  @if(is_array(old('payment_terms_id')) && in_array($dts->id, old('payment_terms_id'))) @php $sel = 'selected="selected"'; @endphp 
                  @elseif(isset($data->payment_terms_id) && is_array($data->payment_terms_id) && in_array($dts->id, $data->payment_terms_id)) @php $sel = 'selected="selected"'; @endphp @endif
                  <option value="{{$dts->id}}" {{$sel}}>{{$dts->name}}</option>
                @endforeach
              @endif
            </select>
          </div> -->
          <x-admin.form.inputs.multiple_select for="payment_term_id" name="payment_term_id[]"  :optionData="$paymentTerms" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
         <!-- <label>Year Established</label>-->
          <!-- <div class="form-group">
            <input type="text" class="form-control" name="year_established" id="year_established" placeholder="{{ __('locale.Year_Established.caption') }}" value="@if(old('year_established')){{old('year_established')}}@elseif(isset($data->year_established)){{$data->year_established}}@endif"/>
          </div> -->
          <x-admin.form.inputs.text for="year_established" name="year_established" lable="Year Established" placeholder="{{ __('locale.Year_Established.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!--<label>Number of Staffs</label>-->
          <!-- <div class="form-group">
            <input type="text" class="form-control" name="number_of_staffs" placeholder="{{ __('locale.Number_of_Staffs.caption') }} id="number_of_staffs" value="@if(old('number_of_staffs')){{old('number_of_staffs')}}@elseif(isset($data->number_of_staffs)){{$data->number_of_staffs}}@endif"/>
          </div> -->
          <x-admin.form.inputs.text for="number_of_staffs" name="number_of_staffs" lable="Number of Staffs" placeholder="{{ __('locale.Number_of_Staffs.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!--<label>Office Timing</label>-->
          <!-- <div class="form-group">
            <input type="text" class="form-control" name="office_timing" id="office_timing" placeholder="{{ __('locale.Office_Timing.caption') }} value="@if(old('office_timing')){{old('office_timing')}}@elseif(isset($data->office_timing)){{$data->office_timing}}@endif"/>
          </div> -->
          <x-admin.form.inputs.text for="office_timing" name="office_timing" lable="Office Timing" placeholder="{{ __('locale.Office_Timing.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!--<label>Holidays</label>-->
          <!-- <div class="form-group">
            <input type="text" class="form-control" name="holidays" id="holidays"  placeholder="{{ __('locale.Holidays.caption') }} value="@if(old('holidays')){{old('holidays')}}@elseif(isset($data->holidays)){{$data->holidays}}@endif"/>
          </div> -->
          <x-admin.form.inputs.text for="holidays" name="holidays" lable="Holidays" placeholder="{{ __('locale.Holidays.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!-- <div class="form-group"> -->
            <!--<label for="languages">Deals In</label>-->
            <!-- <select class="form-control select2" data-autofill="true" multiple data-is-parent="false" data-model="DealIns" name="deals_in_id[]" id="deals_in_id">
              @if(isset($DealIns) && count($DealIns)>0)
                @foreach($DealIns as $dts)
                  @php $sel = ''; @endphp
                  @if(is_array(old('deals_in_id')) && in_array($dts->id, old('deals_in_id'))) @php $sel = 'selected="selected"'; @endphp 
                  @elseif(isset($data->deals_in_id) && is_array($data->deals_in_id) && in_array($dts->id, $data->deals_in_id)) @php $sel = 'selected="selected"'; @endphp @endif
                  <option value="{{$dts->id}}" {{$sel}}>{{$dts->name}}</option>
                @endforeach
              @endif
            </select>
          </div> -->
          <x-admin.form.inputs.multiple_select for="deals_in_id" name="deals_in_id[]" :optionData="$dealIns" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!-- <div class="form-group"> -->
            <!--<label for="business_type_id">Business Types</label>-->
            <!-- <select class="form-control select2" data-autofill="true" multiple data-is-parent="false" data-model="BusinessTypes" name="business_type_id[]" id="business_type_id">
              @if(isset($BusinessTypes) && count($BusinessTypes)>0)
                @foreach($BusinessTypes as $dts)
                  @if($dts['is_service'] == 'No')
                    @php $sel = ''; @endphp
                    @if(is_array(old('business_type_id')) && in_array($dts->id, old('business_type_id'))) @php $sel = 'selected="selected"'; @endphp 
                    @elseif(isset($data->business_type_id) && is_array($data->business_type_id) && in_array($dts->id, $data->business_type_id)) @php $sel = 'selected="selected"'; @endphp @endif
                    <option value="{{$dts->id}}" {{$sel}}>{{$dts->name}}</option>
                  @endif
                @endforeach
              @endif
            </select>
          </div> -->
          <x-admin.form.inputs.multiple_select for="business_type_id" name="business_type_id[]" :optionData="$businessTypes" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!-- <div class="form-group"> -->
            <!--<label for="Organizations">Organizations</label>-->
            <!-- <select class="form-control select2" data-autofill="true" multiple data-is-parent="false" data-model="Organizations" name="organizations_id[]" id="organizations_id">
              @if(isset($Organizations) && count($Organizations)>0)
                @foreach($Organizations as $dts)
                  @php $sel = ''; @endphp
                  @if(is_array(old('organizations_id')) && in_array($dts->id, old('organizations_id'))) @php $sel = 'selected="selected"'; @endphp 
                  @elseif(isset($data->organizations_id) && is_array($data->organizations_id) && in_array($dts->id, $data->organizations_id)) @php $sel = 'selected="selected"'; @endphp @endif
                  <option value="{{$dts->id}}" {{$sel}}>{{$dts->name}}</option>
                @endforeach
              @endif
            </select>
          </div> -->
          <x-admin.form.inputs.multiple_select for="organization_id" name="organization_id[]"  :optionData="$organizations" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!--<label>Dealer Permit Number</label>-->
          <!-- <div class="form-group">
            <input type="text" class="form-control" name="dealer_permit_number" id="dealer_permit_number" placeholder="{{ __('locale.Dealer_Permit_Number.caption') }}" value="@if(old('dealer_permit_number')){{old('dealer_permit_number')}}@elseif(isset($data->dealer_permit_number)){{$data->dealer_permit_number}}@endif"/>
          </div> -->
          <x-admin.form.inputs.text for="dealer_permit_number" name="dealer_permit_number" lable="Dealer Permit Number" placeholder="{{ __('locale.Dealer_Permit_Number.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-4 col-md-6">
          <!-- <div class="form-group"> -->
            <!--<label for="service_id">Services</label>-->
            <!-- <select class="form-control select2" data-autofill="true" multiple data-is-parent="false" data-model="BusinessTypes" name="service_id[]" id="service_id">
              @if(isset($BusinessTypes) && count($BusinessTypes)>0)
                @foreach($BusinessTypes as $dts)
                  @if($dts['is_service'] != 'No')
                    @php $sel = ''; @endphp
                    @if(is_array(old('business_type_id')) && in_array($dts->id, old('business_type_id'))) @php $sel = 'selected="selected"'; @endphp 
                    @elseif(isset($data->business_type_id) && is_array($data->business_type_id) && in_array($dts->id, $data->business_type_id)) @php $sel = 'selected="selected"'; @endphp @endif
                    <option value="{{$dts->id}}" {{$sel}}>{{$dts->name}}</option>
                  @endif
                @endforeach
              @endif
            </select>
          </div> -->
          <x-admin.form.inputs.multiple_select for="service_id" name="service_id[]"  :optionData="$services" value="" required="" />
        </div>
      </div>
    </div>
  </div>