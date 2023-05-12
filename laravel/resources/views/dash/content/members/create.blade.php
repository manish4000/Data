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
                            @if($errors->has('company_name'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('company_name') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="customer_uid"
                                tooltip="{{__('webCaption.customer_uid.caption')}}"
                                label="{{__('webCaption.customer_uid.title')}}" class="form-control" name="customer_uid"
                                placeholder="{{__('webCaption.customer_uid.title')}}"
                                value="{{old('customer_uid', isset($data->id)?$data->customer_uid:'' )}}"
                                required="required" />
                            @if ($errors->has('customer_uid'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('customer_uid') }}" />
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-3 col-4">
                                <div class="form-group">
                                    <x-dash.form.inputs.name_prefix label="{{__('webCaption.title.title')}}"
                                        tooltip="{{__('webCaption.title.caption')}}" for="title" name="title"
                                        placeholder="{{ __('locale.title.caption') }}" customClass="title"
                                        value="{{old('title', isset($data->id)?$data->title:'' )}}"
                                        editSelected="{{old('title', isset($data->title) ? $data->title :'') }}"
                                        required="required" />
                                    @if($errors->has('title'))
                                    <x-dash.form.form_error_messages message="{{ $errors->first('title') }}" />
                                    @endif
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
                            <x-dash.form.inputs.email id="" for="email_1" tooltip="{{__('webCaption.email_1.caption')}}"
                                label="{{__('webCaption.email_1.title')}}" maxlength="45" class="form-control"
                                name="email_1" placeholder="{{__('webCaption.email_1.title')}}"
                                value="{{old('email_1', isset($data->id)?$data->email_1:'' )}}" required="required" />
                            @if($errors->has('email_1'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('email_1') }}" />
                            @endif
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
                                label="{{__('webCaption.email_2.title')}}" maxlength="45" class="form-control"
                                name="email_2" placeholder="{{__('webCaption.email_2.title')}}"
                                value="{{old('email_2', isset($data->id)?$data->email_2:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3 col-5">
                                <div class="form-group">
                                    <x-dash.form.inputs.select tooltip="{{__('webCaption.country_code.caption')}}"
                                        label="{{__('webCaption.country_code.title')}}" id="" for="country_code_1"
                                        name="country_code" required="" :optionData="[]"
                                        editSelected="{{(isset($data->country_code) && ($data->country_code != null)) ? $data->country_code : ''; }}" />
                                </div>
                            </div>
                            <div class="col-md-5 col-7 pl-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.number for="mobile_1" maxlength="20"
                                        tooltip="{{__('webCaption.mobile_1.caption')}}"
                                        label="{{__('webCaption.mobile_1.title')}}" class="form-control" name="mobile_1"
                                        placeholder="{{__('webCaption.mobile_1.title')}}"
                                        value="{{old('mobile_1', isset($data->id)?$data->mobile_1:'' )}}"
                                        required="required" />
                                    @if ($errors->has('mobile_1'))
                                    <x-dash.form.form_error_messages message="{{ $errors->first('mobile_1') }}" />
                                    @endif
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
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3 col-5">
                                <div class="form-group">
                                    <x-dash.form.inputs.select tooltip="{{__('webCaption.country_code.caption')}}"
                                        label="{{__('webCaption.country_code.title')}}" id="" for="country_code_2"
                                        name="country_code" required="" :optionData="[]"
                                        editSelected="{{(isset($data->country_code) && ($data->country_code != null)) ? $data->country_code : ''; }}" />
                                </div>
                            </div>
                            <div class="col-md-5 col-7 pr-md-0 pl-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.number for="mobile_2" maxlength="20"
                                        tooltip="{{__('webCaption.mobile_2.caption')}}"
                                        label="{{__('webCaption.mobile_2.title')}}" class="form-control" name="mobile_2"
                                        placeholder="{{__('webCaption.mobile_2.title')}}"
                                        value="{{old('mobile_2', isset($data->id)?$data->mobile_2:'' )}}" required="" />
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
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.member_login.title')}}" class="" tooltip="{{__('webCaption.member_login.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="yes" tooltip="{{__('webCaption.yes.caption')}}"
                                    class="border border-danger" name="member_login"
                                    label="{{__('webCaption.yes.title')}}" value="Yes"
                                    checked="checked" required="required" />&ensp;

                                    <x-dash.form.inputs.radio for="no" class="border border-danger" name="member_login"
                                    tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" value="No" checked="" required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.broker.title')}}" class=""
                                tooltip="{{__('webCaption.broker.caption')}}" required="required" />
                            <div>
                                <x-dash.form.inputs.checkbox for="broker" name="broker" class="form-control"
                                    label="{{__('webCaption.yes.title')}}" value="1"
                                    checked="{{ old('broker') == 'No' ? 'checked' : '' }} {{ isset($data->broker) ? $data->broker == 'Yes' ? 'checked=checked' :'' :'' }}"
                                    customClass="custom-control-inline" required="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.dealer_type.title')}}" class="" tooltip="{{__('webCaption.dealer_type.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="dealer" tooltip="{{__('webCaption.dealer.caption')}}"
                                        class="border border-danger" name="dealer_type"
                                        label="{{__('webCaption.dealer.title')}}" value="dealer"
                                        checked=""
                                        required="required" />&ensp;

                                    <x-dash.form.inputs.radio for="individual_buyer" class="border border-danger" name="dealer_type"
                                        tooltip="{{__('webCaption.individual_buyer.caption')}}" label="{{__('webCaption.individual_buyer.title')}}"
                                        value="individual_buyer" required="required"
                                        checked=""
                                        required="required" />&ensp;
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
                            <x-dash.form.inputs.select label="{{__('webCaption.country.title')}}"
                                tooltip="{{__('webCaption.country.caption')}}" for="local_country" name="country"
                                placeholder="{{ __('locale.country.caption') }}" customClass="country"
                                :optionData="$country"
                                editSelected="{{(isset($data->id) && ($data->id != null)) ? $data->country :'' }}"
                                required="required" />
                            @if($errors->has('country'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('country') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.state.title')}}"
                                tooltip="{{__('webCaption.state.caption')}}" for="local_state" name="state"
                                placeholder="{{ __('locale.state.caption') }}" customClass="state" :optionData="[]"
                                editSelected="{{old('local_state', isset($data->id) ? $data->state :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.city.title')}}"
                                tooltip="{{__('webCaption.city.caption')}}" for="local_city" name="city"
                                placeholder="{{ __('locale.city.caption') }}" customClass="city" :optionData="[]"
                                editSelected="{{ old('local_city', isset($data->id) ? $data->city :'') }}"
                                required="" />
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" for="zip_code"
                                tooltip="{{__('webCaption.zip_code.caption')}}"
                                label="{{__('webCaption.zip_code.title')}}" maxlength="15" class="form-control"
                                name="zip_code" placeholder="{{__('webCaption.zip_code.title')}}"
                                value="{{old('zip_code', isset($data->id)? $data->zip_code:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.port.title')}}"
                                tooltip="{{__('webCaption.port.caption')}}" for="port" name="port"
                                placeholder="{{ __('locale.port.caption') }}" customClass="port" :optionData="$port"
                                editSelected="{{(isset($data->id) && ($data->id != null)) ? $data->port :'' }}"
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
                                placeholder="{{ __('locale.religion.caption') }}" customClass="religion"
                                :optionData="$religion"
                                editSelected="{{(isset($data->id) && ($data->id != null)) ? $data->religion :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.nationality.title')}}"
                                tooltip="{{__('webCaption.nationality.caption')}}" for="nationality" name="nationality"
                                placeholder="{{ __('locale.nationality.caption') }}" customClass="nationality"
                                :optionData="$country"
                                editSelected="{{(isset($data->nationality) && ($data->nationality != null)) ? $data->nationality :'' }}"
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
                    @include('components.dash.form.inputs.social_media', ['id' => 'social_media_company', 'name' =>
                    'company_social_media'])
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
                                name="sales_person" placeholder="{{ __('locale.sales_person.caption') }}"
                                customClass="sales_person"
                                editSelected="{{(isset($data->id) && ($data->id != null)) ? $data->sales_person :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.rating.title')}}"
                                tooltip="{{__('webCaption.rating.caption')}}" for="rating" name="rating"
                                placeholder="{{ __('locale.rating.caption') }}" customClass="rating"
                                editSelected="{{(isset($data->id) && ($data->id != null)) ? $data->rating :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.stage.title')}}"
                                tooltip="{{__('webCaption.stage.caption')}}" for="stage" name="stage"
                                placeholder="{{ __('locale.stage.caption') }}" customClass="stage"
                                editSelected="{{(isset($data->id) && ($data->id != null)) ? $data->stage :'' }}"
                                required="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.term.title')}}"
                                tooltip="{{__('webCaption.term.caption')}}" for="term" name="term"
                                placeholder="{{ __('locale.term.caption') }}" customClass="term"
                                editSelected="{{(isset($data->id) && ($data->id != null)) ? $data->term :'' }}"
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
                    <div class="col-md-2 col-5">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.currency.title')}}"
                                tooltip="{{__('webCaption.currency.caption')}}" for="currency" name="currency"
                                placeholder="{{ __('locale.currency.caption') }}" customClass="currency"
                                editSelected="{{(isset($data->currency) && ($data->currency != null)) ? $data->currency :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4 col-7">
                        <div class="form-group">
                            <x-dash.form.inputs.text for="opening_balance"
                                tooltip="{{__('webCaption.opening_balance.caption')}}"
                                label="{{__('webCaption.opening_balance.title')}}" maxlength="20" class="form-control"
                                name="opening_balance" placeholder="{{__('webCaption.opening_balance.title')}}"
                                value="{{old('opening_balance', isset($data->id)?$data->opening_balance:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.opening_balance_type.title')}}" class="" tooltip="{{__('webCaption.opening_balance_type.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="debit" tooltip="{{__('webCaption.debit.caption')}}"
                                    class="border border-danger" name="opening_balance_type"
                                    label="{{__('webCaption.debit.title')}}" value="debit"
                                    checked="" required="required" />&ensp;

                                    <x-dash.form.inputs.radio for="credit" class="border border-danger" name="opening_balance_type"
                                    tooltip="{{__('webCaption.credit.caption')}}" label="{{__('webCaption.credit.title')}}" value="credit" checked="" required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
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
                        <div class="form-group">
                           <x-dash.form.inputs.select id="" for="storage_days" tooltip="{{__('webCaption.storage_days.caption')}}" label="{{__('webCaption.storage_days.title')}}"   class="form-control" name="storage_days" placeholder="{{__('webCaption.storage_days.title')}}" value="{{old('storage_days', isset($data->id)?$data->storage_days:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                           <x-dash.form.inputs.number id="" for="credit_limit" tooltip="{{__('webCaption.credit_limit.caption')}}" label="{{__('webCaption.credit_limit.title')}}"   class="form-control" name="credit_limit" placeholder="{{__('webCaption.credit_limit.title')}}" value="{{old('credit_limit', isset($data->id)?$data->credit_limit:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                           <x-dash.form.inputs.select id="" for="bid_limitations" tooltip="{{__('webCaption.bid_limitations.caption')}}" label="{{__('webCaption.bid_limitations.title')}}"   class="form-control" name="bid_limitations" placeholder="{{__('webCaption.bid_limitations.title')}}" value="{{old('bid_limitations', isset($data->id)?$data->bid_limitations:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                           <x-dash.form.inputs.number id="" for="bid_amount_limit" tooltip="{{__('webCaption.bid_amount_limit.caption')}}" label="{{__('webCaption.bid_amount_limit.title')}}"   class="form-control" name="bid_amount_limit" placeholder="{{__('webCaption.bid_amount_limit.title')}}" value="{{old('bid_amount_limit', isset($data->id)?$data->bid_amount_limit:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                           <x-dash.form.inputs.text id="" for="bid_limit_reason" tooltip="{{__('webCaption.bid_limit_reason.caption')}}" label="{{__('webCaption.bid_limit_reason.title')}}"   maxlength="100"  class="form-control" name="bid_limit_reason" placeholder="{{__('webCaption.bid_limit_reason.title')}}" value="{{old('bid_limit_reason', isset($data->id)?$data->bid_limit_reason:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                           <x-dash.form.inputs.select id="" for="intial_payment_due_days" tooltip="{{__('webCaption.intial_payment_due_days.caption')}}" label="{{__('webCaption.intial_payment_due_days.title')}}"   maxlength=""  class="form-control" name="intial_payment_due_days" placeholder="{{__('webCaption.intial_payment_due_days.title')}}" value="{{old('intial_payment_due_days', isset($data->id)?$data->intial_payment_due_days:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2 col-6">
                                <div class="form-group">
                                    <x-dash.form.label for="" value="{{__('webCaption.bid.title')}}" class=""
                                        tooltip="{{__('webCaption.bid.caption')}}" required="required" />
                                    <div>
                                        <div class="form-check-inline">
                                            <x-dash.form.inputs.radio for="bid_yes" tooltip="{{__('webCaption.yes.caption')}}"
                                                class="border border-danger" name="bid"
                                                label="{{__('webCaption.yes.title')}}" value="Yes"
                                                checked="" required="required" />&ensp;

                                            <x-dash.form.inputs.radio for="bid_no" class="border border-danger" name="bid"
                                                tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" value="No" checked="" required="required" />&ensp;
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-md-2 col-6">
                                <div class="form-group">
                                    <x-dash.form.label for="" value="{{__('webCaption.bid_mail.title')}}" class="" tooltip="{{__('webCaption.bid_mail.caption')}}" required="required" />
                                    <div>
                                        <div class="form-check-inline">
                                            <x-dash.form.inputs.radio for="bid_mail_yes" tooltip="{{__('webCaption.yes.caption')}}"
                                            class="border border-danger" name="bid_mail"
                                            label="{{__('webCaption.yes.title')}}" value="Yes"
                                            checked="" required="required" />&ensp;

                                            <x-dash.form.inputs.radio for="bid_mail_no" class="border border-danger" name="bid_mail"
                                            tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" value="No" checked="" required="required" />&ensp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="form-group">
                                    <x-dash.form.label for="" value="{{__('webCaption.sales_statistics.title')}}" class="" tooltip="{{__('webCaption.sales_statistics.caption')}}" required="required" />
                                    <div>
                                        <div class="form-check-inline">
                                            <x-dash.form.inputs.radio for="sales_statistics_yes" tooltip="{{__('webCaption.yes.caption')}}"
                                            class="border border-danger" name="sales_statistics"
                                            label="{{__('webCaption.yes.title')}}" value="Yes"
                                            checked="" required="required" />&ensp;

                                            <x-dash.form.inputs.radio for="sales_statistics_no" class="border border-danger" name="sales_statistics"
                                            tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" value="No" checked="" required="required" />&ensp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="form-group">
                                    <x-dash.form.label for="" value="{{__('webCaption.auction.title')}}" class="" tooltip="{{__('webCaption.auction.caption')}}" required="required" />
                                    <div>
                                        <div class="form-check-inline">
                                            <x-dash.form.inputs.radio for="auction_yes" tooltip="{{__('webCaption.yes.caption')}}"
                                            class="border border-danger" name="auction"
                                            label="{{__('webCaption.yes.title')}}" value="Yes"
                                            checked="" required="required" />&ensp;

                                            <x-dash.form.inputs.radio for="auction_no" class="border border-danger" name="auction"
                                            tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" value="No" checked="" required="required" />&ensp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <x-dash.form.label for="" value="{{__('webCaption.uss.title')}}" class="" tooltip="{{__('webCaption.uss.caption')}}" required="required" />
                                    <div>
                                        <div class="form-check-inline">
                                            <x-dash.form.inputs.radio for="uss_yes" tooltip="{{__('webCaption.yes.caption')}}"
                                            class="border border-danger" name="uss"
                                            label="{{__('webCaption.yes.title')}}" value="Yes"
                                            checked="" required="required" />&ensp;

                                            <x-dash.form.inputs.radio for="uss_no" class="border border-danger" name="uss"
                                            tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" value="No" checked="" required="required" />&ensp;
                                        </div>
                                    </div>
                                </div>
                           </div>
                       </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                           <x-dash.form.inputs.select id="" for="uss_images" tooltip="{{__('webCaption.uss_images.caption')}}" label="{{__('webCaption.uss_images.title')}}"   maxlength=""  class="form-control" name="uss_images" placeholder="{{__('webCaption.uss_images.title')}}" value="{{old('uss_images', isset($data->id)?$data->uss_images:'' )}}" required="" />
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

$local_state = session()->getOldInput('local_state');
$local_city = session()->getOldInput('local_city');
$local_state_id = (isset($local_state)) ? $local_state : ( (isset($data->state)) ? $data->state:'' );
$local_city_id = (isset($local_city)) ? $local_city : ( (isset($data->city)) ? $data->city:'' );

@endphp

@push('script')
<script>
$(document).ready(function() {
    messengerImageCode();
});

$(document).ready(function() {
    var local_country = $('#local_country').find(":selected").val();
    var local_state = "<?php echo $local_state_id; ?>";
    var local_city = "<?php echo $local_city_id; ?>";

    if (local_country) {
        stateList(local_country, local_state);
    }

    if (local_state) {
        $.ajax({
            type: 'POST',
            url: "{{route('dashcity-list')}}",
            data: {
                id: local_state
            },
            success: function(result) {
                $('#local_city').html('<option value="">Select City</option>');
                $.each(result.cities, function(key, value) {
                    if (value.id == local_city) {
                        var selected_c = 'selected';
                    } else {
                        var selected_c = '';
                    }
                    $("#local_city").append('<option value="' + value.id + '" ' +
                        selected_c + '>' + value.name + '</option>');
                });
            }
        });
    }

    $('#local_country').on('change', function() {
        var selectCountry = $(this).val();
        stateList(selectCountry);
    });
    $('#local_state').on('change', function() {
        var selectState = $(this).val();
        cityList(selectState);
    });
});

function stateList(country, selected_state = '') {
    $.ajax({
        type: 'POST',
        url: "{{route('dashstate-list')}}",
        data: {
            id: country
        },
        success: function(result) {
            $('#local_state').html('<option value="">Select State</option>');
            $.each(result.states, function(key, value) {
                if (value.id == selected_state) {
                    var selected_s = 'selected';
                } else {
                    var selected_s = '';
                }
                $("#local_state").append('<option value="' + value.id + '" ' + selected_s + '>' +
                    value.name + '</option>');
            });
            $('#local_city').html('<option value="">Select City</option>');
        }
    });
}

function cityList(state, selected_city = '') {
    $.ajax({
        type: 'POST',
        url: "{{route('dashcity-list')}}",
        data: {
            id: state
        },
        success: function(result) {
            $('#local_city').html('<option value="">Select City</option>');
            $.each(result.cities, function(key, value) {
                if (value.id == selected_city) {
                    var selected_c = 'selected';
                } else {
                    var selected_c = '';
                }
                $("#local_city").append('<option value="' + value.id + '" ' + selected_c + '>' +
                    value.name + '</option>');
            });
        }
    });
}
</script>
@endpush