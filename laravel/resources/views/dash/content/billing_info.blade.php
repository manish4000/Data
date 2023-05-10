@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.billing_info.title') )
@else
@section('title', __('webCaption.billing_info.title'))
@endif


@section('content')
<div>
    <form action="{{route('dashbilling-info')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
            </svg>
             {{__('webCaption.account_details.title')}} 
            </h4>  
        </div>
        
        <hr class="m-0 p-0">
		<div class="card-body">
			<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="company_name" maxlength="100"  tooltip="{{__('webCaption.company_name.caption')}}" label="{{__('webCaption.company_name.title')}}"   name="company_name"  placeholder="{{__('webCaption.company_name.title')}}" value="{{old('company_name', isset($data->company_name)?$data->company_name:'' )}}" required="required"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="unique_gabs_id" maxlength="6"  tooltip="{{__('webCaption.unique_gabs_id.caption')}}" label="{{__('webCaption.unique_gabs_id.title')}}"   name="unique_gabs_id"  placeholder="{{__('webCaption.unique_gabs_id.title')}}" value="{{old('unique_gabs_id', isset($data->unique_gabs_id)?$data->unique_gabs_id:'' )}}"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.email  for="email"  maxlength="45" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}"   name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($data->email)?$data->email:'' )}}"  required="required" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <x-dash.form.inputs.textarea  for="address" maxlength="250"  tooltip="{{__('webCaption.address.caption')}}" label="{{__('webCaption.address.title')}}"   name="address"  placeholder="{{__('webCaption.address.title')}}" value="{{old('address', isset($data->address)?$data->address:'' )}}"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.select  for="country"  maxlength="" tooltip="{{__('webCaption.country.caption')}}" label="{{__('webCaption.country.title')}}"   name="country"  placeholder="{{__('webCaption.country.title')}}" value="{{old('country', isset($data->country)?$data->country:'' )}}"  required="required" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.select  for="state"  maxlength="" tooltip="{{__('webCaption.state.caption')}}" label="{{__('webCaption.state.title')}}"   name="state"  placeholder="{{__('webCaption.state.title')}}" value="{{old('state', isset($data->state)?$data->state:'' )}}"  required="" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.select  for="city"  maxlength="" tooltip="{{__('webCaption.city.caption')}}" label="{{__('webCaption.city.title')}}"   name="city"  placeholder="{{__('webCaption.city.title')}}" value="{{old('city', isset($data->city)?$data->city:'' )}}"  required="" />
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="zip_code" maxlength="15"  tooltip="{{__('webCaption.zip_code.caption')}}" label="{{__('webCaption.zip_code.title')}}"   name="zip_code"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{old('zip_code', isset($data->zip_code)?$data->zip_code:'' )}}"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.select  for="region" maxlength="" tooltip="{{__('webCaption.region.caption')}}" label="{{__('webCaption.region.title')}}"  name="region"  placeholder="{{__('webCaption.region.title')}}" value="{{old('region', isset($data->region)?$data->region:'' )}}"  required="" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="website" maxlength="50"  tooltip="{{__('webCaption.website.caption')}}" label="{{__('webCaption.website.title')}}"   name="website"  placeholder="{{__('webCaption.website.title')}}" value="{{old('website', isset($data->website)?$data->website:'' )}}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3 col-5">
                            <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="country_code" name="country_code"  required="" :optionData="[]"  editSelected="{{(isset($country_code) && ($country_code != null)) ? $country_code : ''; }}" />
                            </div>
                        </div>
                        <div class="col-md-5 col-7 px-0">
                            <div class="form-group">
                                <x-dash.form.inputs.number id="" for="Mobile" tooltip="{{__('webCaption.mobile.caption')}}" label="{{__('webCaption.mobile.title')}}" maxlength="20"  name="mobile"  placeholder="{{__('webCaption.mobile.title')}}" value="{{old('mobile', isset($data->mobile)?$data->mobile:'' )}}"  required="required" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                @include('components.dash.form.inputs.messenger_common', ['id' =>
                                'messenger_1', 'name' => 'messenger_1'])
                            </div>
                        </div>
                    </div> 
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.file id="" caption="{{__('webCaption.logo.title')}}" ImageId="logo-image-preview" for="logo" editImageUrl="{{ isset($data->logo)? asset('company_data/'.$imageFolder.'/billing_info/'.$data->logo) :''}}"    name="logo"  placeholder="{{__('webCaption.logo.title')}}" required="" />
                    </div>
                </div> 
            </div>
        </div>    
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
            </svg>
             {{__('webCaption.general_details.title')}} 
            </h4>  
        </div>

        <hr class="m-0 p-0">
		<div class="card-body">
			<div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.multiple_select  for="business_type"  maxlength="" tooltip="{{__('webCaption.business_type.caption')}}" label="{{__('webCaption.business_type.title')}}"   name="business_type"  placeholder="{{__('webCaption.business_type.title')}}" value="{{old('business_type', isset($data->business_type)?$data->business_type:'' )}}"  required="" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.multiple_select  for="deals_in"  maxlength="" tooltip="{{__('webCaption.deals_in.caption')}}" label="{{__('webCaption.deals_in.title')}}"   name="deals_in"  placeholder="{{__('webCaption.deals_in.title')}}" value="{{old('deals_in', isset($data->deals_in)?$data->deals_in:'' )}}"  required="" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.multiple_select  for="association_member"  maxlength="" tooltip="{{__('webCaption.association_member.caption')}}" label="{{__('webCaption.association_member.title')}}"   name="association_member"  placeholder="{{__('webCaption.association_member.title')}}" value="{{old('association_member', isset($data->association_member)?$data->association_member:'' )}}"  required="" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.file id="" caption="{{__('webCaption.document_upload.title')}}" ImageId="document_upload-image-preview" for="document_upload" editImageUrl="{{ isset($data->document_upload)? asset('company_data/'.$imageFolder.'/billing_info/'.$data->document_upload) :''}}"    name="document_upload"  placeholder="{{__('webCaption.document_upload.title')}}" required="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
            </svg>
             {{__('webCaption.contact_person_details.title')}} 
            </h4>  
        </div>

        <hr class="m-0 p-0">
		<div class="card-body">
            <h4 class="card-title">Contact Person 1</h4>
			<div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="name" maxlength="100"  tooltip="{{__('webCaption.name.caption')}}" label="{{__('webCaption.name.title')}}"   name="name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('name', isset($data->name)?$data->name:'' )}}"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.select  for="designation1"  maxlength="" tooltip="{{__('webCaption.designation.caption')}}" label="{{__('webCaption.designation.title')}}"   name="designation"  placeholder="{{__('webCaption.designation.title')}}" value="{{old('designation', isset($data->designation)?$data->designation:'' )}}"  required="" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.email  for="email"  maxlength="45" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}"   name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($data->email)?$data->email:'' )}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3 col-5">
                            <div class="form-group">
                                <x-dash.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="country_code2" name="country_code"  required="" :optionData="[]"  editSelected="{{(isset($country_code) && ($country_code != null)) ? $country_code : ''; }}" />
                            </div>
                        </div>
                        <div class="col-md-5 col-7 px-0">
                            <div class="form-group">
                                <x-dash.form.inputs.number id="" for="Mobile"  tooltip="{{__('webCaption.mobile.caption')}}" label="{{__('webCaption.mobile.title')}}" maxlength="20"  name="mobile"  placeholder="{{__('webCaption.mobile.title')}}" value="{{old('mobile', isset($data->mobile)?$data->mobile:'' )}}"  required="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                @include('components.dash.form.inputs.messenger_common', ['id' =>
                                'messenger_2', 'name' => 'messenger_2'])
                            </div>
                        </div>
                    </div> 
                </div>
            </div>    
        </div>
    
		<div class="card-body">
        <h4 class="card-title">Contact Person 2</h4>
			<div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="name"  maxlength="100" tooltip="{{__('webCaption.name.caption')}}" label="{{__('webCaption.name.title')}}"   name="name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('name', isset($data->name)?$data->name:'' )}}" />
                    </div>
                </div> 
                <div class="col-md-4">
                    <div class="form-group">
                    <x-dash.form.inputs.select  for="designation2"  maxlength="" tooltip="{{__('webCaption.designation.caption')}}" label="{{__('webCaption.designation.title')}}"   name="designation"  placeholder="{{__('webCaption.designation.title')}}" value="{{old('designation', isset($data->designation)?$data->designation:'' )}}"  required="" />
                    </div>
                </div> 
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.email  for="email"  maxlength="45" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}"   name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($data->email)?$data->email:'' )}}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3 col-5">
                            <div class="form-group">
                                <x-dash.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="country_code3" name="country_code"  required="" :optionData="[]"  editSelected="{{(isset($country_code) && ($country_code != null)) ? $country_code : ''; }}" />
                            </div>
                        </div>
                        <div class="col-md-5 col-7 px-0">
                            <div class="form-group">
                                <x-dash.form.inputs.number id="" for="Mobile"  tooltip="{{__('webCaption.mobile.caption')}}" label="{{__('webCaption.mobile.title')}}" maxlength="20"  name="mobile"  placeholder="{{__('webCaption.mobile.title')}}" value="{{old('mobile', isset($data->mobile)?$data->mobile:'' )}}"  required="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                @include('components.dash.form.inputs.messenger_common', ['id' =>
                                'messenger_3', 'name' => 'messenger_3'])
                            </div>
                        </div>
                    </div> 
                </div>
            </div>    
        </div>
    </div>
   
    
    
        <div class="form-group text-center">
            <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
            @if(isset($data->id)) 	<x-dash.form.buttons.create /> @else <x-dash.form.buttons.update/> @endif 
        </div>
    </form>
</div>
@endsection


@push('script')
<script src="{{ asset('assets/dash/assets/js/dash/master.js') }}"></script>
@endpush

@push('script')
<script>

$(document).ready(function() {
    messengerImageCode();
});

</script>
@endpush