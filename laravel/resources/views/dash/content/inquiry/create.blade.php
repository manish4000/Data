@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.inquiry.title') )
@else
@section('title', __('webCaption.inquiry.title'))
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
                    {{__('webCaption.vehicle_details.title')}}
                </h4>
                <div class="offset-auto">
                    <x-dash.form.buttons.custom color="btn-success" value="{{__('webCaption.reply.title')}}" />
                </div>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.stock_number.title')}}"
                                tooltip="{{__('webCaption.stock_number.caption')}}" for="stock_number"
                                class="form-control" maxlength="30" name="stock_number"
                                placeholder="{{__('webCaption.stock_number.title')}}"
                                value="{{old('stock_number', isset($data->stock_number)?$data->stock_number:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.body_type.title')}}"
                                tooltip="{{__('webCaption.body_type.caption')}}" for="body_type" class="form-control"
                                maxlength="30" name="body_type" placeholder="{{__('webCaption.body_type.title')}}"
                                value="{{old('body_type', isset($data->body_type)?$data->body_type:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.sub_type.title')}}"
                                tooltip="{{__('webCaption.sub_type.caption')}}" for="sub_type" class="form-control"
                                maxlength="30" name="sub_type" placeholder="{{__('webCaption.sub_type.title')}}"
                                value="{{old('sub_type', isset($data->sub_type)?$data->sub_type:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.make.title')}}"
                                tooltip="{{__('webCaption.make.caption')}}" for="make" class="form-control"
                                maxlength="30" name="make" placeholder="{{__('webCaption.make.title')}}"
                                value="{{old('make', isset($data->make)?$data->make:'' )}}" required="required" />
                            @if($errors->has('make'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('make') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.model.title')}}"
                                tooltip="{{__('webCaption.model.caption')}}" for="model" class="form-control"
                                maxlength="30" name="model" placeholder="{{__('webCaption.model.title')}}"
                                value="{{old('model', isset($data->model)?$data->model:'' )}}" required="required" />
                            @if($errors->has('model'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('model') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.model_code.title')}}"
                                tooltip="{{__('webCaption.model_code.caption')}}" for="model_code" class="form-control"
                                maxlength="10" name="model_code" placeholder="{{__('webCaption.model_code.title')}}"
                                value="{{old('model_code', isset($data->model_code)?$data->model_code:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.chassis_no.title')}}"
                                tooltip="{{__('webCaption.chassis_no.caption')}}" for="chassis_no" class="form-control"
                                maxlength="100" name="chassis_no" placeholder="{{__('webCaption.chassis_no.title')}}"
                                value="{{old('chassis_no', isset($data->chassis_no)?$data->chassis_no:'' )}}"
                                required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.fuel.title')}}"
                                tooltip="{{__('webCaption.fuel.caption')}}" for="fuel" name="fuel"
                                placeholder="{{ __('locale.fuel.caption') }}" customClass="fuel" :optionData="[]"
                                editSelected="{{old('fuel', isset($data->fuel) ? $data->fuel :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.transmission.title')}}"
                                tooltip="{{__('webCaption.transmission.caption')}}" for="transmission"
                                name="transmission" placeholder="{{ __('locale.transmission.caption') }}"
                                customClass="transmission" :optionData="[]"
                                editSelected="{{old('transmission', isset($data->transmission) ? $data->transmission :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pr-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.year_from.title')}}"
                                tooltip="{{__('webCaption.year_from.caption')}}" for="year_from" name="year_from"
                                placeholder="{{ __('locale.year_from.caption') }}" customClass="year_from"
                                :optionData="[]"
                                editSelected="{{old('year_from', isset($data->year_from) ? $data->year_from :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.year_to.title')}}"
                                tooltip="{{__('webCaption.year_to.caption')}}" for="year_to" name="year_to"
                                placeholder="{{ __('locale.year_to.caption') }}" customClass="year_to" :optionData="[]"
                                editSelected="{{ old('year_to', isset($data->year_to) ? $data->year_to :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pr-50">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.mileage.title')}}"
                                tooltip="{{__('webCaption.mileage.caption')}}" for="mileage" class="form-control"
                                maxlength="10" name="mileage" placeholder="{{__('webCaption.mileage.title')}}"
                                value="{{old('mileage', isset($data->mileage)?$data->mileage:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.terms.title')}}"
                                tooltip="{{__('webCaption.terms.caption')}}" for="terms" name="terms"
                                placeholder="{{ __('locale.terms.caption') }}" customClass="terms" :optionData="[]"
                                editSelected="{{old('terms', isset($data->terms) ? $data->terms :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pr-50">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.budget.title')}}"
                                tooltip="{{__('webCaption.budget.caption')}}" for="budget" class="form-control"
                                maxlength="10" name="budget" placeholder="{{__('webCaption.budget.title')}}"
                                value="{{old('budget', isset($data->budget)?$data->budget:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.currency.title')}}"
                                tooltip="{{__('webCaption.currency.caption')}}" for="currency" name="currency"
                                placeholder="{{ __('locale.currency.caption') }}" customClass="currency"
                                :optionData="[]"
                                editSelected="{{ old('currency', isset($data->currency) ? $data->currency :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="customer_message"
                                tooltip="{{__('webCaption.customer_message.caption')}}"
                                label="{{__('webCaption.customer_message.title')}}" maxlength="1000"
                                class="form-control" name="customer_message"
                                placeholder="{{__('webCaption.customer_message.title')}}"
                                value="{{old('customer_message', isset($data->customer_message)?$data->customer_message:'' )}}"
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
                    {{__('webCaption.contact_details.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.name.title')}}"
                                tooltip="{{__('webCaption.name.caption')}}" for="name" class="form-control"
                                maxlength="50" name="name" placeholder="{{__('webCaption.name.title')}}"
                                value="{{old('name', isset($data->name)?$data->name:'' )}}" required="required" />
                            @if($errors->has('name'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('name') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.email id="" for="email" tooltip="{{__('webCaption.email.caption')}}"
                                label="{{__('webCaption.email.title')}}" maxlength="50" class="form-control"
                                name="email" placeholder="{{__('webCaption.email.title')}}"
                                value="{{old('email', isset($data->email)?$data->email:'' )}}" required="required" />
                            @if($errors->has('email'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('email') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.country.title')}}"
                                tooltip="{{__('webCaption.country.caption')}}" for="local_country" name="country"
                                placeholder="{{ __('locale.country.caption') }}" customClass="country" :optionData="[]"
                                editSelected="{{(isset($data->country) && ($data->country != null)) ? $data->country :'' }}"
                                required="required" />
                            @if($errors->has('country'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('country') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.port.title')}}"
                                tooltip="{{__('webCaption.port.caption')}}" for="port" name="port"
                                placeholder="{{ __('locale.port.caption') }}" customClass="port" :optionData="[]"
                                editSelected="{{(isset($data->port) && ($data->port != null)) ? $data->port :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.purchase_capacity.title')}}"
                                tooltip="{{__('webCaption.purchase_capacity.caption')}}" for="purchase_capacity"
                                name="purchase_capacity" placeholder="{{ __('locale.purchase_capacity.caption') }}"
                                customClass="purchase_capacity" :optionData="[]"
                                editSelected="{{(isset($data->purchase_capacity) && ($data->purchase_capacity != null)) ? $data->purchase_capacity :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.customer_type.title')}}" class=""
                                tooltip="{{__('webCaption.customer_type.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="individual"
                                        tooltip="{{__('webCaption.individual.caption')}}" class="border border-danger"
                                        name="customer_type" label="{{__('webCaption.individual.title')}}"
                                        value="Individual"
                                        checked="{{ (old('display') == 'Individual') || (!isset($data->id))  ? 'checked' : '' }} {{ isset($data->customer_type) ? $data->customer_type == 'Individual' ? 'checked=checked' :'' :'' }} "
                                        required="required" />&ensp;

                                    <x-dash.form.inputs.radio for="dealer" class="border border-danger"
                                        name="customer_type" tooltip="{{__('webCaption.dealer.caption')}}"
                                        label="{{__('webCaption.dealer.title')}}" value="Dealer" required="required"
                                        checked="{{ old('display') == 'Dealer' ? 'checked' : '' }} {{ isset($data->customer_type) ? $data->customer_type == 'Dealer' ? 'checked=checked' :'' :'' }} "
                                        required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3 col-4">
                                <div class="form-group">
                                    <x-dash.form.inputs.select tooltip="{{__('webCaption.country_code.caption')}}"
                                        label="{{__('webCaption.country_code.title')}}" id="" for="country_code_1"
                                        name="country_code" required="" :optionData="[]"
                                        editSelected="{{(isset($data->country_code) && ($data->country_code != null)) ? $data->country_code : ''; }}" />
                                </div>
                            </div>
                            <div class="col-md-5 col-8 pr-md-0 pl-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.number for="mobile" maxlength="20"
                                        tooltip="{{__('webCaption.mobile.caption')}}"
                                        label="{{__('webCaption.mobile.title')}}" class="form-control" name="mobile"
                                        placeholder="{{__('webCaption.mobile.title')}}"
                                        value="{{old('mobile', isset($data->mobile)?$data->mobile:'' )}}"
                                        required="required" />
                                    @if ($errors->has('mobile'))
                                    <x-dash.form.form_error_messages message="{{ $errors->first('mobile') }}" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    @include('components.dash.form.inputs.messenger_common', ['id' =>
                                    'messenger', 'name' => 'messenger', 'editSelected'=>[]])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="next_contact_date"
                                tooltip="{{__('webCaption.next_contact_date.caption')}}"
                                label="{{__('webCaption.next_contact_date.title')}}" class="form-control"
                                name="next_contact_date" placeholder="{{__('webCaption.next_contact_date.title')}}"
                                value="{{old('next_contact_date', isset($data->next_contact_date)?$data->next_contact_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="admin_memo" tooltip="{{__('webCaption.admin_memo.caption')}}"
                                label="{{__('webCaption.admin_memo.title')}}" maxlength="1000" class="form-control"
                                name="admin_memo" placeholder="{{__('webCaption.admin_memo.title')}}"
                                value="{{old('admin_memo', isset($data->admin_memo)?$data->admin_memo:'' )}}" required="" />
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
                    {{__('webCaption.enquiry_details.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.rating.title')}}"
                                tooltip="{{__('webCaption.rating.caption')}}" for="rating" name="rating"
                                placeholder="{{ __('locale.rating.caption') }}" customClass="rating" :optionData="[]"
                                editSelected="{{old('rating', isset($data->rating) ? $data->rating :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.source.title')}}"
                                tooltip="{{__('webCaption.source.caption')}}" for="source" name="source"
                                placeholder="{{ __('locale.source.caption') }}" customClass="source" :optionData="[]"
                                editSelected="{{old('source', isset($data->source) ? $data->source :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.stage.title')}}"
                                tooltip="{{__('webCaption.stage.caption')}}" for="stage" name="stage"
                                placeholder="{{ __('locale.stage.caption') }}" customClass="stage" :optionData="[]"
                                editSelected="{{old('stage', isset($data->stage) ? $data->stage :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.sales_person.title')}}"
                                tooltip="{{__('webCaption.sales_person.caption')}}" for="sales_person"
                                name="sales_person" placeholder="{{ __('locale.sales_person.caption') }}"
                                customClass="sales_person" :optionData="[]"
                                editSelected="{{old('sales_person', isset($data->sales_person) ? $data->sales_person :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="inquiry_date"
                                tooltip="{{__('webCaption.inquiry_date.caption')}}"
                                label="{{__('webCaption.inquiry_date.title')}}" class="form-control" name="inquiry_date"
                                placeholder="{{__('webCaption.inquiry_date.title')}}"
                                value="{{old('inquiry_date', isset($data->inquiry_date)?$data->inquiry_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="dealer_comment"
                                tooltip="{{__('webCaption.dealer_comment.caption')}}"
                                label="{{__('webCaption.dealer_comment.title')}}" maxlength="1000" class="form-control"
                                name="dealer_comment" placeholder="{{__('webCaption.dealer_comment.title')}}"
                                value="{{old('dealer_comment', isset($data->dealer_comment)?$data->dealer_comment:'' )}}"
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

@push('script')
<script>
$(document).ready(function() {
    messengerImageCode();
});
</script>
@endpush