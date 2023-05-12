@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.proforma.title') )
@else
@section('title', __('webCaption.proforma.title'))
@endif
@section('content')
<div>
    <form action="{{route('dashmembers.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.proforma_no.title')}}"
                                tooltip="{{__('webCaption.proforma_no.caption')}}" for="proforma_no"
                                class="form-control" maxlength="50" name="proforma_no"
                                placeholder="{{__('webCaption.proforma_no.title')}}"
                                value="{{old('proforma_no', isset($data->proforma_no)?$data->proforma_no:'' )}}"
                                required="required" />
                            @if($errors->has('proforma_no'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('proforma_no') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="proforma_date"
                                tooltip="{{__('webCaption.proforma_date.caption')}}"
                                label="{{__('webCaption.proforma_date.title')}}" class="form-control"
                                name="proforma_date" placeholder="{{__('webCaption.proforma_date.title')}}"
                                value="{{old('proforma_date', isset($data->proforma_date)?$data->proforma_date:'' )}}"
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
                        class="feather feather-user-check font-medium-3 mr-1">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <polyline points="17 11 19 13 23 9"></polyline>
                    </svg>
                    {{__('webCaption.buyer_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.company_name.title')}}"
                                tooltip="{{__('webCaption.company_name.caption')}}" for="company_name"
                                class="form-control" maxlength="100" name="company_name"
                                placeholder="{{__('webCaption.company_name.title')}}"
                                value="{{old('company_name', isset($data->company_name)?$data->company_name:'' )}}"
                                required="required" />
                            @if($errors->has('company_name'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('company_name') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.consignee_name.title')}}"
                                tooltip="{{__('webCaption.consignee_name.caption')}}" for="consignee_name"
                                class="form-control" maxlength="100" name="consignee_name"
                                placeholder="{{__('webCaption.consignee_name.title')}}"
                                value="{{old('consignee_name', isset($data->consignee_name)?$data->consignee_name:'' )}}"
                                required="required" />
                            @if($errors->has('consignee_name'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('consignee_name') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.email id="" for="email" tooltip="{{__('webCaption.email.caption')}}"
                                label="{{__('webCaption.email.title')}}" maxlength="45" class="form-control"
                                name="email" placeholder="{{__('webCaption.email.title')}}"
                                value="{{old('email', isset($data->email)?$data->email:'' )}}" required="required" />
                            @if($errors->has('email'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('email') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="address"
                                tooltip="{{__('webCaption.address.caption')}}"
                                label="{{__('webCaption.address.title')}}" maxlength="250" class="form-control"
                                name="address" placeholder="{{__('webCaption.address.title')}}"
                                value="{{old('address', isset($data->id)?$data->address:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.country.title')}}"
                                tooltip="{{__('webCaption.country.caption')}}" for="local_country" name="country"
                                placeholder="{{ __('locale.country.caption') }}" customClass="country" :optionData="[]"
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.city.title')}}"
                                tooltip="{{__('webCaption.city.caption')}}" for="local_city" name="city"
                                placeholder="{{ __('locale.city.caption') }}" customClass="city" :optionData="[]"
                                editSelected="{{ old('local_city', isset($data->id) ? $data->city :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3 col-4 pr-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.select tooltip="{{__('webCaption.country_code.caption')}}"
                                        label="{{__('webCaption.country_code.title')}}" id="" for="country_code_1"
                                        name="country_code" required="" :optionData="[]"
                                        editSelected="{{(isset($data->country_code) && ($data->country_code != null)) ? $data->country_code : ''; }}" />
                                </div>
                            </div>
                            <div class="col-md-9 col-8">
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
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3 col-4 pr-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.select tooltip="{{__('webCaption.country_code.caption')}}"
                                        label="{{__('webCaption.country_code.title')}}" id="" for="country_code_2"
                                        name="country_code" required="" :optionData="[]"
                                        editSelected="{{(isset($data->country_code) && ($data->country_code != null)) ? $data->country_code : ''; }}" />
                                </div>
                            </div>
                            <div class="col-md-9 col-8">
                                <div class="form-group">
                                    <x-dash.form.inputs.number for="mobile_2" maxlength="20"
                                        tooltip="{{__('webCaption.mobile_2.caption')}}"
                                        label="{{__('webCaption.mobile_2.title')}}" class="form-control" name="mobile_2"
                                        placeholder="{{__('webCaption.mobile_2.title')}}"
                                        value="{{old('mobile_2', isset($data->id)?$data->mobile_2:'' )}}" required="" />
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
                        class="feather feather-user-check font-medium-3 mr-1">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <polyline points="17 11 19 13 23 9"></polyline>
                    </svg>
                    {{__('webCaption.shipping_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.from_country.title')}}"
                                tooltip="{{__('webCaption.from_country.caption')}}" for="from_country"
                                name="from_country" placeholder="{{ __('locale.from_country.caption') }}"
                                customClass="from_country" :optionData="[]"
                                editSelected="{{(isset($data->from_country) && ($data->from_country != null)) ? $data->from_country :'' }}"
                                required="" />
                            @if($errors->has('from_country'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('from_country') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.from_port.title')}}"
                                tooltip="{{__('webCaption.from_port.caption')}}" for="from_port" name="from_port"
                                placeholder="{{ __('locale.from_port.caption') }}" customClass="from_port"
                                :optionData="[]"
                                editSelected="{{old('from_port', isset($data->from_port) ? $data->from_port :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="payment_due_date"
                                tooltip="{{__('webCaption.payment_due_date.caption')}}"
                                label="{{__('webCaption.payment_due_date.title')}}" class="form-control"
                                name="payment_due_date" placeholder="{{__('webCaption.payment_due_date.title')}}"
                                value="{{old('payment_due_date', isset($data->payment_due_date)?$data->payment_due_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.to_country.title')}}"
                                tooltip="{{__('webCaption.to_country.caption')}}" for="to_country" name="to_country"
                                placeholder="{{ __('locale.to_country.caption') }}" customClass="to_country"
                                :optionData="[]"
                                editSelected="{{(isset($data->to_country) && ($data->to_country != null)) ? $data->to_country :'' }}"
                                required="" />
                            @if($errors->has('to_country'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('to_country') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.to_port.title')}}"
                                tooltip="{{__('webCaption.to_port.caption')}}" for="to_port" name="to_port"
                                placeholder="{{ __('locale.to_port.caption') }}" customClass="to_port" :optionData="[]"
                                editSelected="{{old('to_port', isset($data->to_port) ? $data->to_port :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.payment_terms.title')}}"
                                tooltip="{{__('webCaption.payment_terms.caption')}}" for="payment_terms"
                                class="form-control" maxlength="100" name="payment_terms"
                                placeholder="{{__('webCaption.payment_terms.title')}}"
                                value="{{old('payment_terms', isset($data->payment_terms)?$data->payment_terms:'' )}}"
                                required="" />
                            @if($errors->has('payment_terms'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('payment_terms') }}" />
                            @endif
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
                        class="feather feather-user-check font-medium-3 mr-1">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <polyline points="17 11 19 13 23 9"></polyline>
                    </svg>
                    {{__('webCaption.vehicle_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                            $editImageUrl = (isset($data->vehicle_image)) ?"dash/vehicle_image/".$data->vehicle_image:
                            '';
                            @endphp
                            <x-dash.form.inputs.file id="" caption="{{__('webCaption.vehicle_image.title')}}"
                                editImageUrl="{{$editImageUrl}}" ImageId="vehicle_image-preview" for="vehicle_image"
                                name="vehicle_image" maxFileSize="5000"
                                placeholder="{{__('webCaption.vehicle_image.title')}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.make.title')}}"
                                tooltip="{{__('webCaption.make.caption')}}" for="make" name="make"
                                placeholder="{{ __('locale.make.caption') }}" customClass="make" :optionData="[]"
                                editSelected="{{(isset($data->make) && ($data->make != null)) ? $data->make :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.model.title')}}"
                                tooltip="{{__('webCaption.model.caption')}}" for="model" name="model"
                                placeholder="{{ __('locale.model.caption') }}" customClass="model" :optionData="[]"
                                editSelected="{{old('model', isset($data->model) ? $data->model :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.model_code.title')}}"
                                tooltip="{{__('webCaption.model_code.caption')}}" for="model_code" name="model_code"
                                placeholder="{{ __('locale.model_code.caption') }}" customClass="model_code"
                                :optionData="[]"
                                editSelected="{{old('model_code', isset($data->model_code) ? $data->model_code :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.chassis_no.title')}}"
                                tooltip="{{__('webCaption.chassis_no.caption')}}" for="chassis_no" class="form-control"
                                maxlength="100" name="chassis_no" placeholder="{{__('webCaption.chassis_no.title')}}"
                                value="{{old('chassis_no', isset($data->chassis_no)?$data->chassis_no:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.grade.title')}}"
                                tooltip="{{__('webCaption.grade.caption')}}" for="grade" class="form-control"
                                maxlength="100" name="grade" placeholder="{{__('webCaption.grade.title')}}"
                                value="{{old('grade', isset($data->grade)?$data->grade:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pr-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.manufacturing_year.title')}}"
                                tooltip="{{__('webCaption.manufacturing_year.caption')}}" for="manufacturing_year"
                                name="manufacturing_year" placeholder="{{ __('locale.manufacturing_year.caption') }}"
                                customClass="manufacturing_year" :optionData="[]"
                                editSelected="{{old('manufacturing_year', isset($data->manufacturing_year) ? $data->manufacturing_year :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.manufacturing_month.title')}}"
                                tooltip="{{__('webCaption.manufacturing_month.caption')}}" for="manufacturing_month"
                                name="manufacturing_month" placeholder="{{ __('locale.manufacturing_month.caption') }}"
                                customClass="manufacturing_month" :optionData="[]"
                                editSelected="{{ old('manufacturing_month', isset($data->id) ? $data->manufacturing_month :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pr-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.registration_year.title')}}"
                                tooltip="{{__('webCaption.registration_year.caption')}}" for="registration_year"
                                name="registration_year" placeholder="{{ __('locale.registration_year.caption') }}"
                                customClass="registration_year" :optionData="[]"
                                editSelected="{{old('registration_year', isset($data->registration_year) ? $data->registration_year :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.registration_month.title')}}"
                                tooltip="{{__('webCaption.registration_month.caption')}}" for="registration_month"
                                name="registration_month" placeholder="{{ __('locale.registration_month.caption') }}"
                                customClass="registration_month" :optionData="[]"
                                editSelected="{{ old('registration_month', isset($data->registration_month) ? $data->registration_month :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.fuel.title')}}"
                                tooltip="{{__('webCaption.fuel.caption')}}" for="fuel" name="fuel"
                                placeholder="{{ __('locale.fuel.caption') }}" customClass="fuel" :optionData="[]"
                                editSelected="{{ old('fuel', isset($data->fuel) ? $data->fuel :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.engine_cc.title')}}"
                                tooltip="{{__('webCaption.engine_cc.caption')}}" for="engine_cc" class="form-control"
                                maxlength="10" name="engine_cc" placeholder="{{__('webCaption.engine_cc.title')}}"
                                value="{{old('engine_cc', isset($data->engine_cc)?$data->engine_cc:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.color.title')}}"
                                tooltip="{{__('webCaption.color.caption')}}" for="color" name="color"
                                placeholder="{{ __('locale.color.caption') }}" customClass="color" :optionData="[]"
                                editSelected="{{ old('color', isset($data->color) ? $data->color :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.steering.title')}}"
                                tooltip="{{__('webCaption.steering.caption')}}" for="steering" name="steering"
                                placeholder="{{ __('locale.steering.caption') }}" customClass="steering"
                                :optionData="[]"
                                editSelected="{{ old('steering', isset($data->steering) ? $data->steering :'') }}"
                                required="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h4 class="card-title">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-info font-medium-3 mr-1">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg> -->
                        {{__('webCaption.specific_information.title')}}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-dash.form.inputs.select label="{{__('webCaption.vehicle_type.title')}}"
                                    tooltip="{{__('webCaption.vehicle_type.caption')}}" for="vehicle_type"
                                    name="vehicle_type" placeholder="{{ __('locale.vehicle_type.caption') }}"
                                    customClass="vehicle_type" :optionData="[]"
                                    editSelected="{{ old('vehicle_type', isset($data->vehicle_type) ? $data->vehicle_type :'') }}"
                                    required="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-dash.form.inputs.select label="{{__('webCaption.transmission.title')}}"
                                    tooltip="{{__('webCaption.transmission.caption')}}" for="transmission"
                                    name="transmission" placeholder="{{ __('locale.transmission.caption') }}"
                                    customClass="transmission" :optionData="[]"
                                    editSelected="{{ old('transmission', isset($data->transmission) ? $data->transmission :'') }}"
                                    required="" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <x-dash.form.inputs.text id="" label="{{__('webCaption.hs_code.title')}}"
                                    tooltip="{{__('webCaption.hs_code.caption')}}" for="hs_code" class="form-control"
                                    maxlength="10" name="hs_code" placeholder="{{__('webCaption.hs_code.title')}}"
                                    value="{{old('hs_code', isset($data->hs_code)?$data->hs_code:'' )}}" required="" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <x-dash.form.inputs.text id="" label="{{__('webCaption.mileage.title')}}"
                                    tooltip="{{__('webCaption.mileage.caption')}}" for="mileage" class="form-control"
                                    maxlength="10" name="mileage" placeholder="{{__('webCaption.mileage.title')}}"
                                    value="{{old('mileage', isset($data->mileage)?$data->mileage:'' )}}" required="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-dash.form.inputs.text id="" label="{{__('webCaption.engine_no.title')}}"
                                    tooltip="{{__('webCaption.engine_no.caption')}}" for="engine_no"
                                    class="form-control" maxlength="50" name="engine_no"
                                    placeholder="{{__('webCaption.engine_no.title')}}"
                                    value="{{old('engine_no', isset($data->engine_no)?$data->engine_no:'' )}}"
                                    required="" />
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <div class="form-group">
                                <x-dash.form.inputs.text id="" label="{{__('webCaption.seat_capacity.title')}}"
                                    tooltip="{{__('webCaption.seat_capacity.caption')}}" for="seat_capacity"
                                    class="form-control" maxlength="10" name="seat_capacity"
                                    placeholder="{{__('webCaption.seat_capacity.title')}}"
                                    value="{{old('seat_capacity', isset($data->seat_capacity)?$data->seat_capacity:'' )}}"
                                    required="" />
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <div class="form-group">
                                <x-dash.form.inputs.select label="{{__('webCaption.wd.title')}}"
                                    tooltip="{{__('webCaption.wd.caption')}}" for="wd" name="wd"
                                    placeholder="{{ __('locale.wd.caption') }}" customClass="wd" :optionData="[]"
                                    editSelected="{{ old('wd', isset($data->wd) ? $data->wd :'') }}" required="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-dash.form.inputs.text id="" label="{{__('webCaption.stock_no.title')}}"
                                    tooltip="{{__('webCaption.stock_no.caption')}}" for="stock_no" class="form-control"
                                    maxlength="50" name="stock_no" placeholder="{{__('webCaption.stock_no.title')}}"
                                    value="{{old('stock_no', isset($data->stock_no)?$data->stock_no:'' )}}"
                                    required="" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-dash.form.inputs.textarea id="" for="remark"
                                    tooltip="{{__('webCaption.remark.caption')}}"
                                    label="{{__('webCaption.remark.title')}}" maxlength="250" class="form-control"
                                    name="remark" placeholder="{{__('webCaption.remark.title')}}"
                                    value="{{old('remark', isset($data->remark)?$data->remark:'' )}}" required="" />
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
                        class="feather feather-info font-medium-3 mr-1">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    {{__('webCaption.cost_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-6 offset-md-9">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.currency.title')}}"
                                tooltip="{{__('webCaption.currency.caption')}}" for="currency" name="currency"
                                placeholder="{{ __('locale.currency.caption') }}" customClass="currency"
                                :optionData="[]"
                                editSelected="{{ old('currency', isset($data->currency) ? $data->currency :'') }}"
                                required="" />
                        </div>
                    </div>
                </div>
                <table class="table table-responsive mt-1">
                    <thead>
                        <tr>
                            <th class="auto" data-toggle="tooltip" title="{{__('webCaption.no.caption')}}">
                                {{__('webCaption.no.title')}}
                            </th>
                            <th class="w-75" data-toggle="tooltip"
                                title="{{__('webCaption.item_description.caption')}}">
                                {{__('webCaption.item_description.title')}}
                            </th>
                            <th class="w-auto" data-toggle="tooltip" title="{{__('webCaption.quantity.caption')}}">
                                {{__('webCaption.quantity.title')}}
                            </th>
                            <th class="w-auto" data-toggle="tooltip" title="{{__('webCaption.amount.caption')}}">
                                {{__('webCaption.amount.title')}}
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            
                            <th colspan="2" class="text-right" data-toggle="tooltip" title="{{__('webCaption.total.caption')}}">
                                {{__('webCaption.total.title')}}
                            </th>
                            <th class="w-auto" data-toggle="tooltip" title="{{__('webCaption.unit.caption')}}">
                                {{__('webCaption.unit.title')}}
                            </th>
                            <th class="w-auto" data-toggle="tooltip" title="{{__('webCaption.amount.caption')}}">
                                {{__('webCaption.amount.title')}}
                            </th>
                        </tr>
                    </tfoot>
                </table>
                <div class="row mt-1">
                    <div class="col-md-6 offset-md-6">
                        <div class="row">
                            <div class="col-md-7 col-8">
                                <div class="form-group">
                                    <x-dash.form.inputs.select label="{{__('webCaption.inspection_charges.title')}}"
                                        tooltip="{{__('webCaption.inspection_charges.caption')}}"
                                        for="inspection_charges" name="inspection_charges"
                                        placeholder="{{ __('locale.inspection_charges.caption') }}"
                                        customClass="inspection_charges" :optionData="[]"
                                        editSelected="{{ old('inspection_charges', isset($data->inspection_charges) ? $data->inspection_charges :'') }}"
                                        required="" />
                                </div>
                            </div>
                            <div class="col-md-5 col-4">
                                <div class="form-group">
                                    <x-dash.form.inputs.text id="" label="{{__('webCaption.inspection_price.title')}}"
                                        tooltip="{{__('webCaption.inspection_price.caption')}}" for="inspection_price"
                                        class="form-control" maxlength="10" name="inspection_price"
                                        placeholder="{{__('webCaption.inspection_price.title')}}"
                                        value="{{old('inspection_price', isset($data->inspection_price)?$data->inspection_price:'' )}}"
                                        required="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 offset-md-6">
                        <div class="row">
                            <div class="col-md-7 col-8">
                                <div class="form-group">
                                    <x-dash.form.inputs.select label="{{__('webCaption.cost_charges.title')}}"
                                        tooltip="{{__('webCaption.cost_charges.caption')}}" for="cost_charges"
                                        name="cost_charges" placeholder="{{ __('locale.cost_charges.caption') }}"
                                        customClass="cost_charges" :optionData="[]"
                                        editSelected="{{ old('cost_charges', isset($data->cost_charges) ? $data->cost_charges :'') }}"
                                        required="" />
                                </div>
                            </div>
                            <div class="col-md-5 col-4">
                                <div class="form-group">
                                    <x-dash.form.inputs.text id="" label="{{__('webCaption.charges_amount.title')}}"
                                        tooltip="{{__('webCaption.charges_amount.caption')}}" for="charges_amount"
                                        class="form-control" maxlength="10" name="charges_amount"
                                        placeholder="{{__('webCaption.charges_amount.title')}}"
                                        value="{{old('charges_amount', isset($data->charges_amount)?$data->charges_amount:'' )}}"
                                        required="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 offset-md-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.sub_total.title')}}"
                                tooltip="{{__('webCaption.sub_total.caption')}}" for="sub_total" class="form-control"
                                maxlength="10" name="sub_total" placeholder="{{__('webCaption.sub_total.title')}}"
                                value="{{old('sub_total', isset($data->sub_total)?$data->sub_total:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <hr class="mx-0 my-1 p-0">
                    <div class="col-md-2 offset-md-5">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.terms.title')}}"
                                tooltip="{{__('webCaption.terms.caption')}}" for="terms"
                                name="terms" placeholder="{{ __('locale.terms.caption') }}"
                                customClass="terms" :optionData="[]"
                                editSelected="{{ old('terms', isset($data->terms) ? $data->terms :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.payment_terms.title')}}"
                                tooltip="{{__('webCaption.payment_terms.caption')}}" for="payment_terms"
                                name="payment_terms" placeholder="{{ __('locale.payment_terms.caption') }}"
                                customClass="payment_terms" :optionData="[]"
                                editSelected="{{ old('payment_terms', isset($data->payment_terms) ? $data->payment_terms :'') }}"
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
                    {{__('webCaption.bank_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.banks.title')}}"
                                tooltip="{{__('webCaption.banks.caption')}}" for="banks" name="banks"
                                placeholder="{{ __('locale.banks.caption') }}" customClass="banks" :optionData="[]"
                                editSelected="{{ old('banks', isset($data->banks) ? $data->banks :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="sales_agreement"
                                tooltip="{{__('webCaption.sales_agreement.caption')}}"
                                label="{{__('webCaption.sales_agreement.title')}}" maxlength="1000" class="form-control"
                                name="sales_agreement" placeholder="{{__('webCaption.sales_agreement.title')}}"
                                value="{{old('sales_agreement', isset($data->sales_agreement)?$data->sales_agreement:'' )}}"
                                required="" />
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