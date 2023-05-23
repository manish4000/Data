@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.member.title') )
@else
@section('title', __('webCaption.member.title'))
@endif
@section('content')
<div>
    <form action="{{route('dashmembers.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-user-check font-medium-3 mr-1">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <polyline points="17 11 19 13 23 9"></polyline>
                    </svg>
                    {{__('webCaption.account_details.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.company_name.title')}}"
                                tooltip="{{__('webCaption.company_name.caption')}}" for="company_name"
                                class="form-control" maxlength="100" name="company_name"
                                placeholder="{{__('webCaption.company_name.title')}}"
                                value="{{old('company_name', isset($data->id)?$data->company_name:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-3 col-4">
                                <div class="form-group">
                                    <x-dash.form.inputs.name_prefix label="{{__('webCaption.title.title')}}"
                                        tooltip="{{__('webCaption.title.caption')}}" for="title" name="title"
                                        placeholder="{{ __('locale.title.caption') }}" 
                                        value="{{old('title', isset($data->id)?$data->title:'' )}}"
                                        editSelected="{{old('title', isset($data->title) ? $data->title :'') }}"
                                        required="required" />
                                </div>
                            </div>
                            <div class="col-md-9 col-8 pl-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.text id="" label="{{__('webCaption.name.title')}}"
                                        tooltip="{{__('webCaption.name.caption')}}" for="name" class="form-control"
                                        maxlength="100" name="name" placeholder="{{__('webCaption.name.title')}}"
                                        value="{{old('name', isset($data->id)?$data->name:'' )}}" required="required" />
                                    @if($errors->has('name'))
                                    <x-dash.form.form_error_messages message="{{ $errors->first('name') }}" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @if(isset($data->id))
                                <x-dash.form.inputs.text for="customer_uid"
                                tooltip="{{__('webCaption.customer_uid.caption')}}" maxlength="6"
                                label="{{__('webCaption.customer_uid.title')}}" class="form-control" name="customer_uid"
                                placeholder="{{__('webCaption.customer_uid.title')}}" value="{{old('customer_uid',
                                isset($data->customer_uid) ? $data->customer_uid:''  )}}" 
                                required="required" disabled="disabled"/>
                            @else
                                <x-dash.form.inputs.uid_input for="customer_uid"
                                tooltip="{{__('webCaption.customer_uid.caption')}}" maxlength="6"
                                label="{{__('webCaption.customer_uid.title')}}" class="form-control" name="customer_uid"
                                placeholder="{{__('webCaption.customer_uid.title')}}" value="{{old('customer_uid',
                                isset($data->customer_uid) ? $data->customer_uid:''  )}}" 
                                required="required" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.email id="" for="email_1" tooltip="{{__('webCaption.email_1.caption')}}"
                                label="{{__('webCaption.email_1.title')}}" maxlength="50" class="form-control"
                                name="email_1" placeholder="{{__('webCaption.email_1.title')}}"
                                value="{{old('email_1', isset($data->id)?$data->email_1:'' )}}" required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.password id="" :passwordGenerator="true"
                                tooltip="{{__('webCaption.password.caption')}}"
                                label="{{__('webCaption.password.title')}}" for="password" class="form-control"
                                maxlength="15" name="password" placeholder="{{__('webCaption.password.title')}}"
                                value="{{old('password', isset($data->id)?$data->password:'' )}}"
                                required="<?php echo (!isset($data->id))? 'required' :''; ?>" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.email id="" for="email_2" tooltip="{{__('webCaption.email_2.caption')}}"
                                label="{{__('webCaption.email_2.title')}}" maxlength="50" class="form-control"
                                name="email_2" placeholder="{{__('webCaption.email_2.title')}}"
                                value="{{old('email_2', isset($data->id)?$data->email_2:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3 col-5">
                                @php
                                $mobile = (isset($data->mobile_1) && !empty($data->mobile_1)) ?
                                explode('_',$data->mobile_1) : null;
                                $mobile_1 = ($mobile != null) ? $mobile[1] : null;
                                $country_code_1 = (isset($mobile[0]))? $mobile[0] :null;
                                @endphp
                                <div class="form-group">
                                    <x-dash.form.inputs.select tooltip="{{__('webCaption.country_code.caption')}}"
                                        label="{{__('webCaption.country_code.title')}}" id="" for="country_code_1"
                                        name="country_code_1" required="" :optionData="$country_code"
                                        editSelected="{{ old('$country_code_1', isset($country_code_1) && !empty($country_code_1) ? $country_code_1 : '') }}" />
                                </div>
                            </div>
                            <div class="col-md-5 col-7 pr-md-0 pl-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.number for="mobile_1" maxlength="20"
                                        tooltip="{{__('webCaption.mobile_1.caption')}}"
                                        label="{{__('webCaption.mobile_1.title')}}" class="form-control" name="mobile_1"
                                        placeholder="{{__('webCaption.mobile_1.title')}}"
                                        value="{{old('mobile_1', isset($mobile_1) && !empty($mobile_1)?$mobile_1:'' )}}"
                                        required="required" />
                                    @if ($errors->has('mobile_1'))
                                    <x-dash.form.form_error_messages message="{{ $errors->first('mobile_1') }}" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                            @if(isset($data->messenger_1))
								@php $edit_messenger = json_decode($data->messenger_1); @endphp
							@else
								@php $edit_messenger = ''; @endphp
							@endif
                                <div class="form-group">
                                    @include('components.dash.form.inputs.messenger_common', ['id' =>
                                    'messenger_1', 'name' => 'messenger_1', 'editSelected'=>$edit_messenger])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3 col-5">
                                @php
                                $mobile = (isset($data->mobile_2) && !empty($data->mobile_2)) ?
                                explode('_',$data->mobile_2) : null;
                                $mobile_2 = ($mobile != null) ? $mobile[1] : null;
                                $country_code_2 = (isset($mobile[0]))? $mobile[0] :null;
                                @endphp
                                <div class="form-group">
                                    <x-dash.form.inputs.select tooltip="{{__('webCaption.country_code.caption')}}"
                                        label="{{__('webCaption.country_code.title')}}" id="" for="country_code_2"
                                        name="country_code_2" required="" :optionData="$country_code"
                                        editSelected="{{(isset($country_code_2) && ($country_code_2 != null)) ? $country_code_2 : ''; }}" />
                                </div>
                            </div>
                            <div class="col-md-5 col-7 pr-md-0 pl-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.number for="mobile_2" maxlength="20"
                                        tooltip="{{__('webCaption.mobile_2.caption')}}"
                                        label="{{__('webCaption.mobile_2.title')}}" class="form-control" name="mobile_2"
                                        placeholder="{{__('webCaption.mobile_2.title')}}"
                                        value="{{old('mobile_2', isset($mobile_2) && ($mobile_2 != null)?$mobile_2:'' )}}"
                                        required="" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                @if(isset($data->messenger_2))
								@php $edit_messenger = json_decode($data->messenger_2); @endphp
							@else
								@php $edit_messenger = ''; @endphp
							@endif
                                <div class="form-group">
                                    @include('components.dash.form.inputs.messenger_common', ['id' =>
                                    'messenger_2', 'name' => 'messenger_2', 'editSelected'=>$edit_messenger])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.dealer_type.title')}}" class=""
                                tooltip="{{__('webCaption.dealer_type.caption')}}" required="" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="dealer" tooltip="{{__('webCaption.dealer.caption')}}"
                                        class="border border-danger" name="dealer_type"
                                        label="{{__('webCaption.dealer.title')}}" value="Dealer"
                                        checked="{{ (isset($data->dealer_type) && $data->dealer_type == 'Dealer') ? 'checked' : 'checked' }}"
                                        required="" />&ensp;

                                    <x-dash.form.inputs.radio for="individual_buyer" class="border border-danger"
                                        name="dealer_type" tooltip="{{__('webCaption.individual_buyer.caption')}}"
                                        label="{{__('webCaption.individual_buyer.title')}}" value="Buyer" required=""
                                        checked="{{ (isset($data->dealer_type) && $data->dealer_type == 'Buyer') ? 'checked' : '' }}" />
                                    &ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.member_login.title')}}" class=""
                                tooltip="{{__('webCaption.member_login.caption')}}" required="" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="yes" tooltip="{{__('webCaption.yes.caption')}}"
                                        class="border border-danger" name="member_login"
                                        label="{{__('webCaption.yes.title')}}" value="Yes"
                                        checked="{{ (isset($data->member_login) && $data->member_login == 'Yes') ? 'checked' : 'checked' }}"
                                        required="" />&ensp;

                                    <x-dash.form.inputs.radio for="no" class="border border-danger" name="member_login"
                                        tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}"
                                        value="No"
                                        checked="{{ (isset($data->member_login) && $data->member_login == 'No') ? 'checked' : '' }}"
                                        required="" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.broker.title')}}" class=""
                                tooltip="{{__('webCaption.broker.caption')}}" required="" />
                            <div>
                                <x-dash.form.inputs.checkbox for="broker" name="broker" class="form-control"
                                    label="{{__('webCaption.yes.title')}}" value="1"
                                    checked="{{ old('broker') == 'No' ? 'checked' : '' }} {{ isset($data->broker) ? $data->broker == 'Yes' ? 'checked=checked' :'' :'' }}"
                                    customClass="custom-control-inline" required="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-map font-medium-3 mr-1">
                        <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                        <line x1="8" y1="2" x2="8" y2="18"></line>
                        <line x1="16" y1="6" x2="16" y2="22"></line>
                    </svg>
                    {{__('webCaption.contact_details.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="address"
                                tooltip="{{__('webCaption.address.caption')}}"
                                label="{{__('webCaption.address.title')}}" maxlength="250" class="form-control"
                                name="address" placeholder="{{__('webCaption.address.title')}}"
                                value="{{old('address', isset($data->id)?$data->address:'' )}}" required="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select onChange="stateLists(this.id,'state')"
                                label="{{__('webCaption.country.title')}}"
                                tooltip="{{__('webCaption.country.caption')}}" for="country" name="country"
                                placeholder="{{ __('locale.country.caption') }}" 
                                :optionData="$country"
                                editSelected="{{ old('country', isset($data->country_id) ? $data->country_id :'') }}"
                                required="required" />
                            @if($errors->has('country'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('country') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select onChange="cityList('state','city')"
                                label="{{__('webCaption.state.title')}}" tooltip="{{__('webCaption.state.caption')}}"
                                for="state" name="state" placeholder="{{ __('locale.state.caption') }}"
                                :optionData="[]"
                                editSelected="{{ old('state', isset($data->state_id) ? $data->state_id :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.city.title')}}"
                                tooltip="{{__('webCaption.city.caption')}}" for="city" name="city"
                                placeholder="{{ __('locale.city.caption') }}" :optionData="[]"
                                editSelected="{{ old('city', isset($data->city_id) ? $data->city_id :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.port.title')}}"
                                tooltip="{{__('webCaption.port.caption')}}" for="port" name="port"
                                placeholder="{{ __('locale.port.caption') }}"  :optionData="$port"
                                editSelected="{{(isset($data->port_id) && ($data->port_id != null)) ? $data->port_id :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" for="zip_code"
                                tooltip="{{__('webCaption.zip_code.caption')}}"
                                label="{{__('webCaption.zip_code.title')}}" maxlength="10" class="form-control"
                                name="zip_code" placeholder="{{__('webCaption.zip_code.title')}}"
                                value="{{old('zip_code', isset($data->id)? $data->zip_code:'' )}}" required="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-layers font-medium-3 mr-1">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                    {{__('webCaption.general_details.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.religion.title')}}"
                                tooltip="{{__('webCaption.religion.caption')}}" for="religion" name="religion"
                                placeholder="{{ __('locale.religion.caption') }}" 
                                :optionData="$religion"
                                editSelected="{{(isset($data->religion_id) && ($data->religion_id != null)) ? $data->religion_id :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.nationality.title')}}"
                                tooltip="{{__('webCaption.nationality.caption')}}" for="nationality" name="nationality"
                                placeholder="{{ __('locale.nationality.caption') }}" 
                                :optionData="$country"
                                editSelected="{{(isset($data->nationality_id) && ($data->nationality_id != null)) ? $data->nationality_id :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="birth_date" tooltip="{{__('webCaption.birth_date.caption')}}"
                                label="{{__('webCaption.birth_date.title')}}" class="form-control" name="birth_date"
                                placeholder="{{__('webCaption.birth_date.title')}}"
                                value="{{old('birth_date', isset($data->birth_date)?$data->birth_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="anniversary_date"
                                tooltip="{{__('webCaption.anniversary_date.caption')}}"
                                label="{{__('webCaption.anniversary_date.title')}}" class="form-control"
                                name="anniversary_date" placeholder="{{__('webCaption.anniversary_date.title')}}"
                                value="{{old('anniversary_date', isset($data->id)?$data->anniversary_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                </div>
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
                    @if(isset($data->social_media))
                    @php $social_media = json_decode($data->social_media);
                    $userID = $data->id;
                    @endphp
                    @else
                    @php $social_media = '';
                    $userID = '';
                    @endphp
                    @endif
                    @include('components.dash.form.inputs.social_media', ['id' => 'social_media_company', 'name' =>
                    'social_media', 'social_media' => $social_media])
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-layers font-medium-3 mr-1">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                    {{__('webCaption.crm.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.sales_person.title')}}"
                                tooltip="{{__('webCaption.sales_person.caption')}}" for="sales_person" 
                                name="sales_person" placeholder="{{ __('locale.sales_person.caption') }}" :optionData="$sales_person"
                                editSelected="{{(isset($data->sales_person_id) && ($data->sales_person_id != null)) ? $data->sales_person_id :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.rating.title')}}"
                                tooltip="{{__('webCaption.rating.caption')}}" for="rating" name="rating"
                                placeholder="{{ __('locale.rating.caption') }}" 
                                :optionData="$rating"
                                editSelected="{{(isset($data->rating_id) && ($data->rating_id != null)) ? $data->rating_id :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.stage.title')}}"
                                tooltip="{{__('webCaption.stage.caption')}}" for="stage" name="stage"
                                placeholder="{{ __('locale.stage.caption') }}"  :optionData="[]"
                                editSelected="{{(isset($data->stage_id) && ($data->stage_id != null)) ? $data->stage_id :'' }}"
                                required="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.terms.title')}}"
                                tooltip="{{__('webCaption.terms.caption')}}" for="terms" name="terms"
                                placeholder="{{ __('locale.terms.caption') }}"  :optionData="$terms"
                                editSelected="{{(isset($data->terms_id) && ($data->terms_id != null)) ? $data->terms_id :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="next_follow_up_date"
                                tooltip="{{__('webCaption.next_follow_up_date.caption')}}"
                                label="{{__('webCaption.next_follow_up_date.title')}}" class="form-control"
                                name="next_follow_up_date" placeholder="{{__('webCaption.next_follow_up_date.title')}}"
                                value="{{old('next_follow_up_date', isset($data->id)?$data->next_follow_up_date:'' )}}"
                                required="" />
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="admin_memo"
                                tooltip="{{__('webCaption.admin_memo.caption')}}"
                                label="{{__('webCaption.admin_memo.title')}}" maxlength="250" class="form-control"
                                name="admin_memo" placeholder="{{__('webCaption.admin_memo.title')}}"
                                value="{{old('admin_memo', isset($data->id)?$data->admin_memo:'' )}}" required="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-layers font-medium-3 mr-1">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                    {{__('webCaption.opening_balance.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="opening_balance_date"
                                tooltip="{{__('webCaption.opening_balance_date.caption')}}"
                                label="{{__('webCaption.opening_balance_date.title')}}" class="form-control"
                                name="opening_balance_date"
                                placeholder="{{__('webCaption.opening_balance_date.title')}}"
                                value="{{old('opening_balance_date', isset($data->id)?$data->opening_balance_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-5">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.currency.title')}}"
                                tooltip="{{__('webCaption.currency.caption')}}" for="currency" name="currency"
                                placeholder="{{ __('locale.currency.caption') }}" 
                                :optionData="$currency"
                                editSelected="{{(isset($data->currency_id) && ($data->currency_id != null)) ? $data->currency_id :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4 col-7">
                        @php
                        if (isset($data->opening_balance)) {
                            $opening_balance = number_format($data->opening_balance);
                        } 
                        @endphp
                        <div class="form-group">
                            <x-dash.form.inputs.number id="" for="opening_balance"
                                tooltip="{{__('webCaption.opening_balance.caption')}}" numberFormat="true"
                                label="{{__('webCaption.opening_balance.title')}}" class="form-control" name="opening_balance"
                                placeholder="{{__('webCaption.opening_balance.title')}}" maxlength="20"
                                value="{{old('opening_balance', isset($data->opening_balance)?$opening_balance:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.opening_balance_type.title')}}" class=""
                                tooltip="{{__('webCaption.opening_balance_type.caption')}}" required="" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="debit" tooltip="{{__('webCaption.debit.caption')}}"
                                        class="border border-danger" name="opening_balance_type"
                                        label="{{__('webCaption.debit.title')}}" value="debit"
                                        checked="{{ (isset($data->opening_balance_type) && $data->opening_balance_type == 'Debit') ? 'checked' : '' }}"
                                        required="" />
                                    &ensp;

                                    <x-dash.form.inputs.radio for="credit" class="border border-danger"
                                        name="opening_balance_type" tooltip="{{__('webCaption.credit.caption')}}"
                                        label="{{__('webCaption.credit.title')}}" value="credit"
                                        checked="{{ (isset($data->opening_balance_type) && $data->opening_balance_type == 'Credit') ? 'checked' : '' }}"
                                        required="" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-layers font-medium-3 mr-1">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                    {{__('webCaption.upload_image.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                            $editImageUrl = (isset($data->id)) ?"dash/user_image/".$data->user_image: '';
                            @endphp
                            <x-dash.form.inputs.file id="" caption="{{__('webCaption.user_image.title')}}"
                                editImageUrl="{{$editImageUrl}}" ImageId="user_image-preview" for="user_image"
                                name="user_image" maxFileSize="5000" placeholder="{{__('webCaption.user_image.title')}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                            $editImageUrl = (isset($data->id))
                            ?"dash/visiting_card_img/".$data->visiting_card_img:
                            '';
                            @endphp
                            <x-dash.form.inputs.file id="" caption="{{__('webCaption.visiting_card_img.title')}}"
                                editImageUrl="{{$editImageUrl}}" ImageId="visiting_card_img-preview"
                                for="visiting_card_img" name="visiting_card_img" maxFileSize="5000"
                                placeholder="{{__('webCaption.visiting_card_img.title')}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                            $editImageUrl = (isset($data->id)) ?"dash/company_logo/".$data->company_logo: '';
                            @endphp
                            <x-dash.form.inputs.file id="" caption="{{__('webCaption.company_logo.title')}}"
                                editImageUrl="{{$editImageUrl}}" ImageId="company_logo-preview" for="company_logo"
                                name="company_logo" maxFileSize="5000"
                                placeholder="{{__('webCaption.company_logo.title')}}" required="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-map font-medium-3 mr-1">
                        <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                        <line x1="8" y1="2" x2="8" y2="18"></line>
                        <line x1="16" y1="6" x2="16" y2="22"></line>
                    </svg>
                    {{__('webCaption.clients_permission.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @php
                        if (isset($data->credit_limit)) {
                            $credit_limit = number_format($data->credit_limit);
                        }
                        @endphp
                        <div class="form-group">
                            <x-dash.form.inputs.number id="" for="credit_limit"
                                tooltip="{{__('webCaption.credit_limit.caption')}}" numberFormat='true'
                                label="{{__('webCaption.credit_limit.title')}}" class="form-control" name="credit_limit"
                                placeholder="{{__('webCaption.credit_limit.title')}}" maxlength="20"
                                value="{{old('credit_limit', isset($data->credit_limit)?$credit_limit:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-dash.form.inputs.select id="" for="storage_days"
                                tooltip="{{__('webCaption.storage_days.caption')}}"
                                label="{{__('webCaption.storage_days.title')}}" class="form-control" name="storage_days"
                                placeholder="{{__('webCaption.storage_days.title')}}" 
                                :optionData="$countingArr"
                                editSelected="{{(isset($data->storage_days) && ($data->storage_days != null)) ? $data->storage_days :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-dash.form.inputs.select id="" for="intial_payment_due_days"
                                tooltip="{{__('webCaption.payment_due_days.caption')}}"
                                label="{{__('webCaption.payment_due_days.title')}}" maxlength=""
                                class="form-control" name="intial_payment_due_days"
                                placeholder="{{__('webCaption.intial_payment_due_days.title')}}"
                                :optionData="$countingArr"
                                editSelected="{{(isset($data->intial_payment_due_days) && ($data->intial_payment_due_days != null)) ? $data->intial_payment_due_days :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-dash.form.inputs.select id="" for="uss_images"
                                tooltip="{{__('webCaption.uss_images.caption')}}"
                                label="{{__('webCaption.uss_images.title')}}" maxlength="" 
                                name="uss_images" placeholder="{{__('webCaption.uss_images.title')}}"
                                :optionData="$countingArr"
                                editSelected="{{(isset($data->uss_images) && ($data->uss_images != null)) ? $data->uss_images :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-dash.form.inputs.select id="" for="bid_limitations"
                                tooltip="{{__('webCaption.bid_limitations.caption')}}" 
                                label="{{__('webCaption.bid_limitations.title')}}" class="form-control"
                                name="bid_limitations" placeholder="{{__('webCaption.bid_limitations.title')}}"
                                 :optionData="$countingArr"
                                editSelected="{{(isset($data->bid_limitations) && ($data->bid_limitations != null)) ? $data->bid_limitations :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        @php
                        if (isset($data->bid_amount_limit)) {
                            $bid_amount_limit = number_format($data->bid_amount_limit);
                        } 
                        @endphp
                        <div class="form-group">
                            <x-dash.form.inputs.number id="" for="bid_amount_limit"
                                tooltip="{{__('webCaption.bid_amount_limit.caption')}}" maxlength="20"  numberFormat='true'
                                label="{{__('webCaption.bid_amount_limit.title')}}" class="form-control"
                                name="bid_amount_limit" placeholder="{{__('webCaption.bid_amount_limit.title')}}"
                                value="{{old('bid_amount_limit', isset($data->bid_amount_limit)?$bid_amount_limit:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" for="bid_limit_reason"
                                tooltip="{{__('webCaption.bid_limit_reason.caption')}}"
                                label="{{__('webCaption.bid_limit_reason.title')}}" maxlength="100" class="form-control"
                                name="bid_limit_reason" placeholder="{{__('webCaption.bid_limit_reason.title')}}"
                                value="{{old('bid_limit_reason', isset($data->bid_limit_reason)?$data->bid_limit_reason:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2 col-6">
                                <div class="form-group">
                                    <x-dash.form.label for="" value="{{__('webCaption.auction.title')}}" class=""
                                        tooltip="{{__('webCaption.auction.caption')}}" required="" />
                                    <div>
                                        <div class="form-check-inline">
                                            <x-dash.form.inputs.radio for="auction_yes"
                                                tooltip="{{__('webCaption.yes.caption')}}" class="border border-danger"
                                                name="auction" label="{{__('webCaption.yes.title')}}" value="Yes"
                                                checked="{{ (isset($data->auction) && $data->auction == 'Yes') ? 'checked' : 'checked' }}"
                                                required="" />&ensp;

                                            <x-dash.form.inputs.radio for="auction_no" class="border border-danger"
                                                name="auction" tooltip="{{__('webCaption.no.caption')}}"
                                                label="{{__('webCaption.no.title')}}" value="No"
                                                checked="{{ (isset($data->auction) && $data->auction == 'No') ? 'checked' : '' }}"
                                                required="" />&ensp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="form-group">
                                    <x-dash.form.label for="" value="{{__('webCaption.uss.title')}}" class=""
                                        tooltip="{{__('webCaption.uss.caption')}}" required="" />
                                    <div>
                                        <div class="form-check-inline">
                                            <x-dash.form.inputs.radio for="uss_yes"
                                                tooltip="{{__('webCaption.yes.caption')}}" class="border border-danger"
                                                name="uss" label="{{__('webCaption.yes.title')}}" value="Yes"
                                                checked="{{ (isset($data->uss) && $data->uss == 'Yes') ? 'checked' : '' }}"
                                                required="" />&ensp;

                                            <x-dash.form.inputs.radio for="uss_no" class="border border-danger"
                                                name="uss" tooltip="{{__('webCaption.no.caption')}}"
                                                label="{{__('webCaption.no.title')}}" value="No"
                                                checked="{{ (isset($data->uss) && $data->uss == 'No') ? 'checked' : 'checked' }}"
                                                required="" />&ensp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="form-group">
                                    <x-dash.form.label for="" value="{{__('webCaption.bid.title')}}" class=""
                                        tooltip="{{__('webCaption.bid.caption')}}" required="" />
                                    <div>
                                        <div class="form-check-inline">
                                            <x-dash.form.inputs.radio for="bid_yes"
                                                tooltip="{{__('webCaption.yes.caption')}}" class="border border-danger"
                                                name="bid" label="{{__('webCaption.yes.title')}}" value="Yes"
                                                checked="{{ (isset($data->bid) && $data->bid == 'Yes') ? 'checked' : 'checked' }}"
                                                required="" />&ensp;

                                            <x-dash.form.inputs.radio for="bid_no" class="border border-danger"
                                                name="bid" tooltip="{{__('webCaption.no.caption')}}"
                                                label="{{__('webCaption.no.title')}}" value="No"
                                                checked="{{ (isset($data->bid) && $data->bid == 'No') ? 'checked' : '' }}"
                                                required="" />&ensp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="form-group">
                                    <x-dash.form.label for="" value="{{__('webCaption.bid_mail.title')}}" class=""
                                        tooltip="{{__('webCaption.bid_mail.caption')}}" required="" />
                                    <div>
                                        <div class="form-check-inline">
                                            <x-dash.form.inputs.radio for="bid_mail_yes"
                                                tooltip="{{__('webCaption.yes.caption')}}" class="border border-danger"
                                                name="bid_mail" label="{{__('webCaption.yes.title')}}" value="Yes"
                                                checked="{{ (isset($data->bid_mail) && $data->bid_mail == 'Yes') ? 'checked' : 'checked' }}"
                                                required="" />&ensp;

                                            <x-dash.form.inputs.radio for="bid_mail_no" class="border border-danger"
                                                name="bid_mail" tooltip="{{__('webCaption.no.caption')}}"
                                                label="{{__('webCaption.no.title')}}" value="No"
                                                checked="{{ (isset($data->bid_mail) && $data->bid_mail == 'No') ? 'checked' : '' }}"
                                                required="" />&ensp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="form-group">
                                    <x-dash.form.label for="" value="{{__('webCaption.sales_statistics.title')}}"
                                        class="" tooltip="{{__('webCaption.sales_statistics.caption')}}" required="" />
                                    <div>
                                        <div class="form-check-inline">
                                            <x-dash.form.inputs.radio for="sales_statistics_yes"
                                                tooltip="{{__('webCaption.yes.caption')}}" class="border border-danger"
                                                name="sales_statistics" label="{{__('webCaption.yes.title')}}"
                                                value="Yes"
                                                checked="{{ (isset($data->sales_statistics) && $data->sales_statistics == 'Yes') ? 'checked' : 'checked' }}"
                                                required="" />&ensp;

                                            <x-dash.form.inputs.radio for="sales_statistics_no"
                                                class="border border-danger" name="sales_statistics"
                                                tooltip="{{__('webCaption.no.caption')}}"
                                                label="{{__('webCaption.no.title')}}" value="No"
                                                checked="{{ (isset($data->sales_statistics) && $data->sales_statistics == 'No') ? 'checked' : '' }}"
                                                required="" />&ensp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
            @if(isset($data->id))
            <x-dash.form.buttons.update /> @else
            <x-dash.form.buttons.create /> @endif
        </div>

    </form>
</div>
@endsection

@php

$state_id = session()->getOldInput('state');
$city_id = session()->getOldInput('city');

$country_id = (isset($country_id)) ? $country_id : ( (isset($data->country_id)) ? $data->country_id : old('country'));

$state_id = (isset($state_id)) ? $state_id : ( (isset($data->state_id)) ? $data->state_id : old('state'));

$city_id = (isset($city_id)) ? $city_id : ( (isset($data->city_id)) ? $data->city_id : old('city'));

@endphp

@push('script')

<script type="text/javascript">
$(document).ready(function() {
    //For MESSENGER
    messengerImageCode();
    $(".messenger").each(function() {
        messengerSelect(this.id);
    });
});

let country_id = "{{$country_id}}";
let state_id = "{{$state_id}}";
let city_id = "{{$city_id}}";

if (country_id != '') {
    stateLists('country', 'state', state_id);
}
if (city_id != '') {
    cityList('state', 'city', city_id, state_id);
}
</script>
@endpush
@include('components.dash.form.country_state_city')