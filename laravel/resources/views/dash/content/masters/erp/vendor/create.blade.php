@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.vendor.title') )
@else
@section('title', __('webCaption.vendor.title'))
@endif
@section('content')
<div>
    <form action="" method="POST" enctype="multipart/form-data">
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
                    {{__('webCaption.contact_details.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.company_name.title')}}"
                                tooltip="{{__('webCaption.company_name.caption')}}" for="company_name"
                                class="form-control" maxlength="50" name="company_name"
                                placeholder="{{__('webCaption.company_name.title')}}"
                                value="{{old('company_name', isset($data->id)?$data->company_name:'' )}}"
                                required="required" />
                            @if($errors->has('company_name'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('company_name') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.email id="" for="email" tooltip="{{__('webCaption.email.caption')}}"
                                label="{{__('webCaption.email.title')}}" maxlength="50" class="form-control"
                                name="email" placeholder="{{__('webCaption.email.title')}}"
                                value="{{old('email', isset($data->id)?$data->email:'' )}}" required="required" />
                            @if($errors->has('email'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('email') }}" />
                            @endif
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="address"
                                tooltip="{{__('webCaption.address.caption')}}"
                                label="{{__('webCaption.address.title')}}" maxlength="100" class="form-control"
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
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.city.title')}}"
                                tooltip="{{__('webCaption.city.caption')}}" for="local_city" name="city"
                                placeholder="{{ __('locale.city.caption') }}" customClass="city" :optionData="[]"
                                editSelected="{{ old('local_city', isset($data->id) ? $data->city :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" for="zip_code"
                                tooltip="{{__('webCaption.zip_code.caption')}}"
                                label="{{__('webCaption.zip_code.title')}}" maxlength="15" class="form-control"
                                name="zip_code" placeholder="{{__('webCaption.zip_code.title')}}"
                                value="{{old('zip_code', isset($data->id)? $data->zip_code:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.designation.title')}}"
                                tooltip="{{__('webCaption.designation.caption')}}" for="designation"
                                class="form-control" maxlength="20" name="designation"
                                placeholder="{{__('webCaption.designation.title')}}"
                                value="{{old('designation', isset($data->designation)?$data->designation:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.fax.title')}}"
                                tooltip="{{__('webCaption.fax.caption')}}" for="fax" class="form-control" maxlength="20"
                                name="fax" placeholder="{{__('webCaption.fax.title')}}"
                                value="{{old('fax', isset($data->fax)?$data->fax:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.contact_person.title')}}"
                                tooltip="{{__('webCaption.contact_person.caption')}}" for="contact_person"
                                class="form-control" maxlength="20" name="contact_person"
                                placeholder="{{__('webCaption.contact_person.title')}}"
                                value="{{old('contact_person', isset($data->contact_person)?$data->contact_person:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 col-4">
                                <div class="form-group">
                                    <x-dash.form.inputs.select tooltip="{{__('webCaption.country_code.caption')}}"
                                        label="{{__('webCaption.country_code.title')}}" id="" for="country_code"
                                        name="country_code" required="" :optionData="[]"
                                        editSelected="{{(isset($data->country_code) && ($data->country_code != null)) ? $data->country_code : ''; }}" />
                                </div>
                            </div>
                            <div class="col-md-8 col-8 pl-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.number for="mobile_1" maxlength="20"
                                        tooltip="{{__('webCaption.mobile_1.caption')}}"
                                        label="{{__('webCaption.mobile_1.title')}}" class="form-control"
                                        name="mobile_1" placeholder="{{__('webCaption.mobile_1.title')}}"
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
                            <div class="col-md-4 col-4">
                                <div class="form-group">
                                    <x-dash.form.inputs.select tooltip="{{__('webCaption.country_code.caption')}}"
                                        label="{{__('webCaption.country_code.title')}}" id="" for="country_code_1"
                                        name="country_code" required="" :optionData="[]"
                                        editSelected="{{(isset($data->country_code) && ($data->country_code != null)) ? $data->country_code : ''; }}" />
                                </div>
                            </div>
                            <div class="col-md-8 col-8 pl-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.number for="mobile_2" maxlength="20"
                                        tooltip="{{__('webCaption.mobile_2.caption')}}"
                                        label="{{__('webCaption.mobile_2.title')}}" class="form-control"
                                        name="mobile_2" placeholder="{{__('webCaption.mobile_2.title')}}"
                                        value="{{old('mobile_2', isset($data->id)?$data->mobile_2:'' )}}"
                                        required="" />
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
                    {{__('webCaption.account_details.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.vendor_type.title')}}"
                                tooltip="{{__('webCaption.vendor_type.caption')}}" for="vendor_type" name="vendor_type"
                                placeholder="{{ __('locale.vendor_type.caption') }}" customClass="vendor_type"
                                :optionData="[]"
                                editSelected="{{(isset($data->id) && ($data->id != null)) ? $data->vendor_type :'' }}"
                                required="required" />
                            @if($errors->has('vendor_type'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('vendor_type') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
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
                            <x-dash.form.label for="" value="{{__('webCaption.opening_balance_type.title')}}" class=""
                                tooltip="{{__('webCaption.opening_balance_type.caption')}}" required="" />
                            <div>
                                <div class="form-check form-check-inline">
                                    <x-dash.form.inputs.radio for="debit" tooltip="{{__('webCaption.debit.caption')}}"
                                        class="border border-danger" name="opening_balance_type"
                                        label="{{__('webCaption.debit.title')}}" value="Debit"
                                        checked="{{ (old('opening_balance_type') == 'Debit') || (!isset($data->id))  ? 'checked' : '' }} {{ isset($data->opening_balance_type) ? $data->opening_balance_type == 'Debit' ? 'checked=checked' :'' :'' }} " />
                                    &ensp;

                                    <x-dash.form.inputs.radio for="credit" class="border border-danger"
                                        name="opening_balance_type" tooltip="{{__('webCaption.credit.caption')}}"
                                        label="{{__('webCaption.credit.title')}}" value="Credit"
                                        checked="{{ old('opening_balance_type') == 'Credit' ? 'checked' : '' }} {{ isset($data->opening_balance_type) ? $data->opening_balance_type == 'Credit' ? 'checked=checked' :'' :'' }} "
                                        required="" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="admin_comment"
                                tooltip="{{__('webCaption.admin_comment.caption')}}"
                                label="{{__('webCaption.admin_comment.title')}}" maxlength="500" class="form-control"
                                name="admin_comment" placeholder="{{__('webCaption.admin_comment.title')}}"
                                value="{{old('admin_comment', isset($data->admin_comment)?$data->admin_comment:'' )}}"
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
                    {{__('webCaption.settings.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <x-dash.form.inputs.text for="auction_charges"
                                tooltip="{{__('webCaption.auction_charges.caption')}}"
                                label="{{__('webCaption.auction_charges.title')}}" maxlength="15" class="form-control"
                                name="auction_charges" placeholder="{{__('webCaption.auction_charges.title')}}"
                                value="{{old('auction_charges', isset($data->auction_charges)?$data->auction_charges:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="free_days" tooltip="{{__('webCaption.free_days.caption')}}"
                                label="{{__('webCaption.free_days.title')}}" class="form-control" name="free_days"
                                placeholder="{{__('webCaption.free_days.title')}}" maxlength="3"
                                value="{{old('free_days', isset($data->free_days)?$data->free_days:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-3 col-8">
                        <div class="form-group">
                            <x-dash.form.inputs.text for="per_day_charges"
                                tooltip="{{__('webCaption.per_day_charges.caption')}}"
                                label="{{__('webCaption.per_day_charges.title')}}" maxlength="15" class="form-control"
                                name="per_day_charges" placeholder="{{__('webCaption.per_day_charges.title')}}"
                                value="{{old('per_day_charges', isset($data->per_day_charges)?$data->per_day_charges:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                            $editImageUrl = (isset($data->visiting_card_img))
                            ?"dash/visiting_card_img/".$data->visiting_card_img: '';
                            @endphp
                            <x-dash.form.inputs.file id="" caption="{{__('webCaption.visiting_card_img.title')}}"
                                editImageUrl="{{$editImageUrl}}" ImageId="visiting_card_img-preview"
                                for="visiting_card_img" name="visiting_card_img" maxFileSize="5000"
                                placeholder="{{__('webCaption.visiting_card_img.title')}}" required="" />
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