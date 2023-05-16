@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.logistics.title') )
@else
@section('title', __('webCaption.logistics.title'))
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
                    {{__('webCaption.vehicle_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.stock_no.title')}}"
                                tooltip="{{__('webCaption.stock_no.caption')}}" for="stock_no" class="form-control"
                                name="stock_no" placeholder="{{__('webCaption.stock_no.title')}}"
                                value="{{old('stock_no', isset($data->id)?$data->stock_no:'' )}}" readonly="readonly"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.make.caption')}}" disabled="disabled"
                                label="{{__('webCaption.make.title')}}" id="" for="make_1" name="make" required=""
                                :optionData="[]"
                                editSelected="{{(isset($data->make) && ($data->make != null)) ? $data->make : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.model.caption')}}" disabled="disabled"
                                label="{{__('webCaption.model.title')}}" id="" for="model_1" name="model" required=""
                                :optionData="[]"
                                editSelected="{{(isset($data->model) && ($data->model != null)) ? $data->model : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.model_code.caption')}}"
                                disabled="disabled" label="{{__('webCaption.model_code.title')}}" id="" for="model_code"
                                name="model_code" required="" :optionData="[]"
                                editSelected="{{(isset($data->model_code) && ($data->model_code != null)) ? $data->model_code : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.chassis_no.title')}}"
                                tooltip="{{__('webCaption.chassis_no.caption')}}" for="chassis_no" class="form-control"
                                name="chassis_no" placeholder="{{__('webCaption.chassis_no.title')}}"
                                value="{{old('chassis_no', isset($data->id)?$data->chassis_no:'' )}}"
                                readonly="readonly" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pr-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.reg_month.caption')}}"
                                disabled="disabled" label="{{__('webCaption.reg_month.title')}}" id="" for="reg_month"
                                name="reg_month" required="" :optionData="[]"
                                editSelected="{{(isset($data->reg_month) && ($data->reg_month != null)) ? $data->reg_month : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.reg_year.caption')}}"
                                disabled="disabled" label="{{__('webCaption.reg_year.title')}}" id="" for="reg_year"
                                name="reg_year" required="" :optionData="[]"
                                editSelected="{{(isset($data->reg_year) && ($data->reg_year != null)) ? $data->reg_year : ''; }}" />
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
                    {{__('webCaption.purchase_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.lot_no.title')}}"
                                tooltip="{{__('webCaption.lot_no.caption')}}" for="lot_no" class="form-control"
                                name="lot_no" placeholder="{{__('webCaption.lot_no.title')}}"
                                value="{{old('lot_no', isset($data->id)?$data->lot_no:'' )}}" readonly="readonly"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.purchased_from.title')}}"
                                tooltip="{{__('webCaption.purchased_from.caption')}}" for="purchased_from"
                                class="form-control" name="purchased_from"
                                placeholder="{{__('webCaption.purchased_from.title')}}"
                                value="{{old('purchased_from', isset($data->id)?$data->purchased_from:'' )}}"
                                readonly="readonly" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="purchased_date" readonly="readonly"
                                tooltip="{{__('webCaption.purchased_date.caption')}}"
                                label="{{__('webCaption.purchased_date.title')}}" class="form-control"
                                name="purchased_date" placeholder="{{__('webCaption.purchased_date.title')}}"
                                value="{{old('purchased_date', isset($data->purchased_date)?$data->purchased_date:'' )}}"
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
                    {{__('webCaption.sales_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.customer_name.title')}}"
                                tooltip="{{__('webCaption.customer_name.caption')}}" for="customer_name"
                                class="form-control" name="customer_name"
                                placeholder="{{__('webCaption.customer_name.title')}}"
                                value="{{old('customer_name', isset($data->id)?$data->customer_name:'' )}}"
                                readonly="readonly" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.sales_person.title')}}"
                                tooltip="{{__('webCaption.sales_person.caption')}}" for="sales_person"
                                class="form-control" name="sales_person"
                                placeholder="{{__('webCaption.sales_person.title')}}"
                                value="{{old('sales_person', isset($data->id)?$data->sales_person:'' )}}"
                                readonly="readonly" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.country.caption')}}"
                                disabled="disabled" label="{{__('webCaption.country.title')}}" id="" for="country"
                                name="country" required="" :optionData="[]"
                                editSelected="{{(isset($data->country) && ($data->country != null)) ? $data->country : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.destination_port.title')}}"
                                tooltip="{{__('webCaption.destination_port.caption')}}" for="destination_port"
                                class="form-control" name="destination_port"
                                placeholder="{{__('webCaption.destination_port.title')}}"
                                value="{{old('destination_port', isset($data->id)?$data->destination_port:'' )}}"
                                readonly="readonly" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="invoice_date" readonly="readonly"
                                tooltip="{{__('webCaption.invoice_date.caption')}}"
                                label="{{__('webCaption.invoice_date.title')}}" class="form-control" name="invoice_date"
                                placeholder="{{__('webCaption.invoice_date.title')}}"
                                value="{{old('invoice_date', isset($data->invoice_date)?$data->invoice_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="etd_date" tooltip="{{__('webCaption.etd_date.caption')}}" readonly="readonly"
                                label="{{__('webCaption.etd_date.title')}}" class="form-control" name="etd_date"
                                placeholder="{{__('webCaption.etd_date.title')}}"
                                value="{{old('etd_date', isset($data->etd_date)?$data->etd_date:'' )}}" required="" />
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
                    {{__('webCaption.logistics.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.plate_check.title')}}" class=""
                                tooltip="{{__('webCaption.plate_check.caption')}}" required="required" />
                            <div>
                                <x-dash.form.inputs.checkbox for="plate_check" name="plate_check" class="form-control"
                                    label="{{__('webCaption.yes.title')}}" value="1"
                                    checked="{{ old('plate_check') == 'No' ? 'checked' : '' }} {{ isset($data->plate_check) ? $data->plate_check == 'Yes' ? 'checked=checked' :'' :'' }}"
                                    customClass="custom-control-inline" required="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="order_date" tooltip="{{__('webCaption.order_date.caption')}}" 
                                label="{{__('webCaption.order_date.title')}}" class="form-control" name="order_date"
                                placeholder="{{__('webCaption.order_date.title')}}"
                                value="{{old('order_date', isset($data->order_date)?$data->order_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="cut_off_date" 
                                tooltip="{{__('webCaption.cut_off_date.caption')}}"
                                label="{{__('webCaption.cut_off_date.title')}}" class="form-control" name="cut_off_date"
                                placeholder="{{__('webCaption.cut_off_date.title')}}"
                                value="{{old('cut_off_date', isset($data->cut_off_date)?$data->cut_off_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="admin_memo"
                                tooltip="{{__('webCaption.admin_memo.caption')}}"
                                label="{{__('webCaption.admin_memo.title')}}" maxlength="500" class="form-control"
                                name="admin_memo" placeholder="{{__('webCaption.admin_memo.title')}}"
                                value="{{old('admin_memo', isset($data->admin_memo)?$data->admin_memo:'' )}}"
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
                    {{__('webCaption.transport_1.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.customer_broker.title')}}"
                                tooltip="{{__('webCaption.customer_broker.caption')}}" for="customer_broker"
                                class="form-control" name="customer_broker"
                                placeholder="{{__('webCaption.customer_broker.title')}}"
                                value="{{old('customer_broker', isset($data->id)?$data->customer_broker:'' )}}"
                                readonly="readonly" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.port.caption')}}" disabled="disabled"
                                label="{{__('webCaption.port.title')}}" id="" for="port" name="port" required=""
                                :optionData="[]"
                                editSelected="{{(isset($data->port) && ($data->port != null)) ? $data->port : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.delivery_yard.title')}}"
                                tooltip="{{__('webCaption.delivery_yard.caption')}}" for="delivery_yard"
                                class="form-control" name="delivery_yard"
                                placeholder="{{__('webCaption.delivery_yard.title')}}"
                                value="{{old('delivery_yard', isset($data->id)?$data->delivery_yard:'' )}}"
                                readonly="readonly" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.transporter.title')}}"
                                tooltip="{{__('webCaption.transporter.caption')}}" for="transporter"
                                class="form-control" name="transporter"
                                placeholder="{{__('webCaption.transporter.title')}}"
                                value="{{old('transporter', isset($data->id)?$data->transporter:'' )}}"
                                readonly="readonly" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.logistics_cost.title')}}"
                                maxlength="20" tooltip="{{__('webCaption.logistics_cost.caption')}}"
                                for="logistics_cost" class="form-control" name="logistics_cost"
                                placeholder="{{__('webCaption.logistics_cost.title')}}"
                                value="{{old('logistics_cost', isset($data->id)?$data->logistics_cost:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="yard_in_date" 
                                tooltip="{{__('webCaption.yard_in_date.caption')}}"
                                label="{{__('webCaption.yard_in_date.title')}}" class="form-control" name="yard_in_date"
                                placeholder="{{__('webCaption.yard_in_date.title')}}"
                                value="{{old('yard_in_date', isset($data->yard_in_date)?$data->yard_in_date:'' )}}"
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
                    {{__('webCaption.transport_2.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.customer_broker.title')}}"
                                tooltip="{{__('webCaption.customer_broker.caption')}}" for="customer_broker"
                                class="form-control" name="customer_broker"
                                placeholder="{{__('webCaption.customer_broker.title')}}"
                                value="{{old('customer_broker', isset($data->id)?$data->customer_broker:'' )}}"
                                readonly="readonly" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.port.caption')}}" disabled="disabled"
                                label="{{__('webCaption.port.title')}}" id="" for="port_1" name="port" required=""
                                :optionData="[]"
                                editSelected="{{(isset($data->port) && ($data->port != null)) ? $data->port : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.delivery_yard.title')}}"
                                tooltip="{{__('webCaption.delivery_yard.caption')}}" for="delivery_yard"
                                class="form-control" name="delivery_yard"
                                placeholder="{{__('webCaption.delivery_yard.title')}}"
                                value="{{old('delivery_yard', isset($data->id)?$data->delivery_yard:'' )}}"
                                readonly="readonly" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.transporter.title')}}"
                                tooltip="{{__('webCaption.transporter.caption')}}" for="transporter"
                                class="form-control" name="transporter"
                                placeholder="{{__('webCaption.transporter.title')}}"
                                value="{{old('transporter', isset($data->id)?$data->transporter:'' )}}"
                                readonly="readonly" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.logistics_cost.title')}}"
                                maxlength="20" tooltip="{{__('webCaption.logistics_cost.caption')}}"
                                for="logistics_cost" class="form-control" name="logistics_cost"
                                placeholder="{{__('webCaption.logistics_cost.title')}}"
                                value="{{old('logistics_cost', isset($data->id)?$data->logistics_cost:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="yard_in_date"
                                tooltip="{{__('webCaption.yard_in_date.caption')}}"
                                label="{{__('webCaption.yard_in_date.title')}}" class="form-control" name="yard_in_date"
                                placeholder="{{__('webCaption.yard_in_date.title')}}"
                                value="{{old('yard_in_date', isset($data->yard_in_date)?$data->yard_in_date:'' )}}"
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