@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.inquiry.title'). ' ' .__('webCaption.edit.title') )
@else
@section('title', __('webCaption.inquiry.title'). ' ' .__('webCaption.add.title'))
@endif
@section('content')
<div>
    <form action="{{ route('dashinquiries.store')}}" method="POST" enctype="multipart/form-data">
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
                                tooltip="{{__('webCaption.stock_number.caption')}}" for="stock_number" maxlength="30" name="stock_number" placeholder="{{__('webCaption.stock_number.title')}}" value="{{old('stock_number', isset($data->stock_number)?$data->stock_number:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.body_type.title')}}"
                                tooltip="{{__('webCaption.body_type.caption')}}" for="type" maxlength="30" name="type" placeholder="{{__('webCaption.body_type.title')}}" value="{{old('type', isset($data->type)?$data->type:'')}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.sub_type.title')}}"
                                tooltip="{{__('webCaption.sub_type.caption')}}" for="subtype"
                                maxlength="30" name="subtype" placeholder="{{__('webCaption.sub_type.title')}}"
                                value="{{old('subtype', isset($data->subtype)?$data->subtype:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.make.title')}}"
                                tooltip="{{__('webCaption.make.caption')}}" for="make"
                                maxlength="30" name="make" placeholder="{{__('webCaption.make.title')}}"
                                value="{{old('make', isset($data->make)?$data->make:'' )}}" required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.model.title')}}"
                                tooltip="{{__('webCaption.model.caption')}}" for="model"
                                maxlength="30" name="model" placeholder="{{__('webCaption.model.title')}}"
                                value="{{old('model', isset($data->model)?$data->model:'' )}}" required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.model_code.title')}}"
                                tooltip="{{__('webCaption.model_code.caption')}}" for="model_code" maxlength="10" name="model_code" placeholder="{{__('webCaption.model_code.title')}}" value="{{old('model_code', isset($data->model_code)?$data->model_code:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.chassis_no.title')}}"
                                tooltip="{{__('webCaption.chassis_no.caption')}}" for="chassis_no" maxlength="30" name="chassis_no" placeholder="{{__('webCaption.chassis_no.title')}}" value="{{old('chassis_no', isset($data->chassis_no)?$data->chassis_no:'' )}}" required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.fuel.title')}}"
                                tooltip="{{__('webCaption.fuel.caption')}}" for="fuel" name="fuel"
                                placeholder="{{ __('locale.fuel.caption') }}" :optionData="$fuel"
                                editSelected="{{old('fuel', isset($data->fuel_id) ? $data->fuel_id :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.transmission.title')}}"
                                tooltip="{{__('webCaption.transmission.caption')}}" for="transmission"
                                name="transmission" placeholder="{{ __('locale.transmission.caption') }}"
                                 :optionData="$transmission" editSelected="{{old('transmission', isset($data->transmission_id) ? $data->transmission_id :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pr-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.year_from.title')}}"
                                tooltip="{{__('webCaption.year_from.caption')}}" for="year_from" name="year_from"
                                placeholder="{{ __('locale.year_from.caption') }}" 
                                :optionData="$year" editSelected="{{old('year_from', isset($data->year_from) ? $data->year_from :'') }}"  required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.year_to.title')}}"
                                tooltip="{{__('webCaption.year_to.caption')}}" for="year_to" name="year_to"
                                placeholder="{{ __('locale.year_to.caption') }}" :optionData="$year"  editSelected="{{ old('year_to', isset($data->year_to) ? $data->year_to :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pr-50">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.mileage.title')}}"
                                tooltip="{{__('webCaption.mileage.caption')}}" for="mileage"
                                maxlength="10" name="mileage" placeholder="{{__('webCaption.mileage.title')}}"
                                value="{{old('mileage', isset($data->mileage)?$data->mileage:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.terms.title')}}"
                                tooltip="{{__('webCaption.terms.caption')}}" for="terms" name="terms"
                                placeholder="{{ __('locale.terms.caption') }}"  :optionData="$terms"
                                editSelected="{{old('terms', isset($data->terms_id) ? $data->terms_id :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pr-50">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.budget.title')}}"
                                tooltip="{{__('webCaption.budget.caption')}}" for="budget"
                                maxlength="10" name="budget" placeholder="{{__('webCaption.budget.title')}}"
                                value="{{old('budget', isset($data->budget)?$data->budget:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.currency.title')}}"
                                tooltip="{{__('webCaption.currency.caption')}}" for="currency" name="currency"
                                placeholder="{{ __('locale.currency.caption') }}"
                                :optionData="$currency" editSelected="{{ old('currency', isset($data->currency) ? $data->currency :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="customer_message"
                                tooltip="{{__('webCaption.customer_message.caption')}}"
                                label="{{__('webCaption.customer_message.title')}}" maxlength="1000"
                                name="customer_message" placeholder="{{__('webCaption.customer_message.title')}}"
                                value="{{old('customer_message', isset($data->customer_message)?$data->customer_message:'' )}}" required="" />
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
                                tooltip="{{__('webCaption.name.caption')}}" for="name"
                                maxlength="50" name="name" placeholder="{{__('webCaption.name.title')}}"
                                value="{{old('name', isset($data->name)?$data->name:'' )}}" 
                                required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.email id="" for="email" tooltip="{{__('webCaption.email.caption')}}"
                                label="{{__('webCaption.email.title')}}" maxlength="50"
                                name="email" placeholder="{{__('webCaption.email.title')}}"
                                value="{{old('email', isset($data->email)?$data->email:'' )}}" required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.country.title')}}"
                                tooltip="{{__('webCaption.country.caption')}}" for="country" name="country"
                                placeholder="{{ __('locale.country.caption') }}" :optionData="$country"
                                editSelected="{{old('country', isset($data->country_id) && ($data->country_id != null) ? $data->country_id :'') }}" required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.port.title')}}"
                                tooltip="{{__('webCaption.port.caption')}}" for="port" name="port"
                                placeholder="{{ __('locale.port.caption') }}" :optionData="$ports"
                                editSelected="{{old('port', isset($data->port_id) && ($data->port_id != null) ? $data->port_id :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.purchase_capacity.title')}}"
                                tooltip="{{__('webCaption.purchase_capacity.caption')}}" for="purchase_capacity"
                                name="purchase_capacity" placeholder="{{ __('locale.purchase_capacity.caption') }}"  :optionData="$purchase_cap" editSelected="{{ old('purchase_capacity', isset($data->purchase_capacity) && ($data->purchase_capacity != null) ? $data->purchase_capacity :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.customer_type.title')}}" class=""
                                tooltip="{{__('webCaption.customer_type.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="buyer"
                                        tooltip="{{__('webCaption.buyer.caption')}}" class="border border-danger" name="customer_type" label="{{__('webCaption.buyer.title')}}" value="Buyer" checked="{{ (old('display') == 'Buyer') || (!isset($data->id))  ? 'checked' : '' }} {{ isset($data->customer_type) ? $data->customer_type == 'Buyer' ? 'checked=checked' :'' :'' }} " required="required" />&ensp;

                                    <x-dash.form.inputs.radio for="dealer" class="border border-danger"
                                        name="customer_type" tooltip="{{__('webCaption.dealer.caption')}}"
                                        label="{{__('webCaption.dealer.title')}}" value="Dealer" required="required" checked="{{ old('display') == 'Dealer' ? 'checked' : '' }} {{ isset($data->customer_type) ? $data->customer_type == 'Dealer' ? 'checked=checked' :'' :'' }}" required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-3 col-4">
                                <div class="form-group">
                                @php 
                                $data_phone  = (isset($data->phone) && !empty($data->phone)) ? explode('_', $data->phone) : null;
                                $phone = (isset($data_phone[1])) ? $data_phone[1] : null;
                                $countryCode = (isset($data_phone[0]))? $data_phone[0] :null;
                                @endphp
                                <x-dash.form.inputs.select tooltip="{{__('webCaption.country_code.caption')}}" label="{{__('webCaption.country_code.title')}}" id="" for="country_code_1" name="country_code" required="" :optionData="$country_code" editSelected="{{ old('country_code', isset($countryCode) && ($countryCode != null) ? $countryCode : '') }}" />
                                </div>
                            </div>
                            <div class="col-md-5 col-8 pr-md-0 pl-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.number for="mobile" maxlength="20" tooltip="{{__('webCaption.mobile.caption')}}" label="{{__('webCaption.mobile.title')}}" name="phone" placeholder="{{__('webCaption.mobile.title')}}" value="{{old('phone', isset($phone)? $phone:'' )}}" required="required" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                @if(isset($data->messenger)) @php $messenger_data = json_decode($data->messenger); @endphp
					            @else  @php $messenger_data = ''; @endphp @endif
                                @include('components.dash.form.inputs.messenger_common', ['id' =>
                                    'messenger', 'name' => 'messenger', 'editSelected' => $messenger_data])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="next_contact_date"
                                tooltip="{{__('webCaption.next_contact_date.caption')}}"
                                label="{{__('webCaption.next_contact_date.title')}}"
                                name="next_contact_date" placeholder="{{__('webCaption.next_contact_date.title')}}" value="{{old('next_contact_date', isset($data->next_contact_date)?$data->next_contact_date:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="admin_memo" tooltip="{{__('webCaption.admin_memo.caption')}}"
                                label="{{__('webCaption.admin_memo.title')}}" maxlength="1000" 
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
                                placeholder="{{ __('locale.rating.caption') }}" :optionData="$rating"
                                editSelected="{{old('rating', isset($data->rating_id) ? $data->rating_id :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.source.title')}}"
                                tooltip="{{__('webCaption.source.caption')}}" for="source" name="source"
                                placeholder="{{ __('locale.source.caption') }}" :optionData="[]"
                                editSelected="{{old('source', isset($data->source) ? $data->source :'') }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.stage.title')}}"
                                tooltip="{{__('webCaption.stage.caption')}}" for="stage" name="stage"
                                placeholder="{{ __('locale.stage.caption') }}" :optionData="[]"
                                editSelected="{{old('stage', isset($data->stage) ? $data->stage :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.sales_person.title')}}"
                                tooltip="{{__('webCaption.sales_person.caption')}}" for="sales_person"
                                name="sales_person" placeholder="{{ __('locale.sales_person.caption') }}"
                                 :optionData="$sales_person" editSelected="{{old('sales_person', isset($data->sales_person_id) ? $data->sales_person_id :'') }}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="inquiry_date"
                                tooltip="{{__('webCaption.inquiry_date.caption')}}"
                                label="{{__('webCaption.inquiry_date.title')}}" name="inquiry_date"
                                placeholder="{{__('webCaption.inquiry_date.title')}}"
                                value="{{old('inquiry_date', isset($data->inquiry_date)?$data->inquiry_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="dealer_comment"
                                tooltip="{{__('webCaption.dealer_comment.caption')}}"
                                label="{{__('webCaption.dealer_comment.title')}}" maxlength="1000" 
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