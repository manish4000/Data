@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.roro_shipment.title') )
@else
@section('title', __('webCaption.roro_shipment.title'))
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
                    {{__('webCaption.vehicle_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="order_id" tooltip="{{__('webCaption.order_id.caption')}}"
                                label="{{__('webCaption.order_id.title')}}" class="form-control" name="order_id"
                                placeholder="{{__('webCaption.order_id.title')}}" readonly="readonly"
                                value="{{old('order_id', isset($data->id)?$data->order_id:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.model.caption')}}"
                                disabled="disabled" label="{{__('webCaption.model.title')}}" id="" for="model"
                                name="model" required="" :optionData="[]"
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
                                readonly="readonly"
                                value="{{old('chassis_no', isset($data->id)?$data->chassis_no:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pr-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.reg_month.caption')}}" disabled="disabled"
                                label="{{__('webCaption.reg_month.title')}}" id="" for="reg_month" name="reg_month"
                                required="" :optionData="[]" 
                                editSelected="{{(isset($data->reg_month) && ($data->reg_month != null)) ? $data->reg_month : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.reg_year.caption')}}" disabled="disabled"
                                label="{{__('webCaption.reg_year.title')}}" id="" for="reg_year" name="reg_year"
                                required="" :optionData="[]"
                                editSelected="{{(isset($data->reg_year) && ($data->reg_year != null)) ? $data->reg_year : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pr-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.mfg_month.caption')}}" disabled="disabled"
                                label="{{__('webCaption.mfg_month.title')}}" id="" for="mfg_month" name="mfg_month"
                                required="" :optionData="[]"
                                editSelected="{{(isset($data->mfg_month) && ($data->mfg_month != null)) ? $data->mfg_month : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.mfg_year.caption')}}" disabled="disabled"
                                label="{{__('webCaption.mfg_year.title')}}" id="" for="mfg_year" name="mfg_year"
                                required="" :optionData="[]"
                                editSelected="{{(isset($data->mfg_year) && ($data->mfg_year != null)) ? $data->mfg_year : ''; }}" />
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
                    {{__('webCaption.invoice_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.invoice_amount.title')}}"
                                tooltip="{{__('webCaption.invoice_amount.caption')}}" for="invoice_amount"
                                class="form-control" name="invoice_amount"
                                placeholder="{{__('webCaption.invoice_amount.title')}}" readonly="readonly"
                                value="{{old('invoice_amount', isset($data->id)?$data->invoice_amount:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.balance_amount.title')}}"
                                tooltip="{{__('webCaption.balance_amount.caption')}}" for="balance_amount"
                                class="form-control" name="balance_amount"
                                placeholder="{{__('webCaption.balance_amount.title')}}" readonly="readonly"
                                value="{{old('balance_amount', isset($data->id)?$data->balance_amount:'' )}}"
                                required="" />
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
                    {{__('webCaption.customer_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.consignee_name.title')}}"
                                tooltip="{{__('webCaption.consignee_name.caption')}}" for="consignee_name"
                                class="form-control" name="consignee_name"
                                placeholder="{{__('webCaption.consignee_name.title')}}" readonly="readonly"
                                value="{{old('consignee_name', isset($data->id)?$data->consignee_name:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.notify_party.title')}}"
                                tooltip="{{__('webCaption.notify_party.caption')}}" for="notify_party"
                                class="form-control" name="notify_party"
                                placeholder="{{__('webCaption.notify_party.title')}}" readonly="readonly"
                                value="{{old('notify_party', isset($data->id)?$data->notify_party:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.customer_name.title')}}"
                                tooltip="{{__('webCaption.customer_name.caption')}}" for="customer_name"
                                class="form-control" name="customer_name"
                                placeholder="{{__('webCaption.customer_name.title')}}" readonly="readonly"
                                value="{{old('customer_name', isset($data->id)?$data->customer_name:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.sales_person.title')}}"
                                tooltip="{{__('webCaption.sales_person.caption')}}" for="sales_person"
                                class="form-control" name="sales_person"
                                placeholder="{{__('webCaption.sales_person.title')}}" readonly="readonly"
                                value="{{old('sales_person', isset($data->id)?$data->sales_person:'' )}}" required="" />
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
                    {{__('webCaption.shipment_information.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.ship_id.title')}}"
                                tooltip="{{__('webCaption.ship_id.caption')}}" for="ship_id" class="form-control"
                                name="ship_id" placeholder="{{__('webCaption.ship_id.title')}}"
                                value="{{old('ship_id', isset($data->id)?$data->ship_id:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.ship_name.caption')}}"
                                label="{{__('webCaption.ship_name.title')}}" id="" for="ship_name" name="ship_name"
                                required="" :optionData="[]"
                                editSelected="{{(isset($data->ship_name) && ($data->ship_name != null)) ? $data->ship_name : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.voyage_no.title')}}"
                                tooltip="{{__('webCaption.voyage_no.caption')}}" for="voyage_no" class="form-control"
                                name="voyage_no" maxlenght="20" placeholder="{{__('webCaption.voyage_no.title')}}"
                                value="{{old('voyage_no', isset($data->id)?$data->voyage_no:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.carrier_name.caption')}}"
                                label="{{__('webCaption.carrier_name.title')}}" id="" for="carrier_name"
                                name="carrier_name" required="" :optionData="[]"
                                editSelected="{{(isset($data->carrier_name) && ($data->carrier_name != null)) ? $data->carrier_name : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="etd" tooltip="{{__('webCaption.etd.caption')}}" 
                                label="{{__('webCaption.etd.title')}}" class="form-control" name="etd"
                                placeholder="{{__('webCaption.etd.title')}}"
                                value="{{old('etd', isset($data->etd)?$data->etd:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="eta" tooltip="{{__('webCaption.eta.caption')}}" 
                                label="{{__('webCaption.eta.title')}}" class="form-control" name="eta"
                                placeholder="{{__('webCaption.eta.title')}}"
                                value="{{old('eta', isset($data->eta)?$data->eta:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.sailing_port.caption')}}"
                                label="{{__('webCaption.sailing_port.title')}}" id="" for="sailing_port"
                                name="sailing_port" required="" :optionData="[]"
                                editSelected="{{(isset($data->sailing_port) && ($data->sailing_port != null)) ? $data->sailing_port : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.destination_port.caption')}}"
                                label="{{__('webCaption.destination_port.title')}}" id="" for="destination_port"
                                name="destination_port" required="" :optionData="[]"
                                editSelected="{{(isset($data->destination_port) && ($data->destination_port != null)) ? $data->destination_port : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.bl_port.caption')}}"
                                label="{{__('webCaption.bl_port.title')}}" id="" for="bl_port" name="bl_port"
                                required="" :optionData="[]"
                                editSelected="{{(isset($data->bl_port) && ($data->bl_port != null)) ? $data->bl_port : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="booking_number"
                                tooltip="{{__('webCaption.booking_number.caption')}}"
                                label="{{__('webCaption.booking_number.title')}}" class="form-control"
                                name="booking_number" placeholder="{{__('webCaption.booking_number.title')}}"
                                value="{{old('booking_number', isset($data->id)?$data->booking_number:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="booking_req_date" 
                                tooltip="{{__('webCaption.booking_req_date.caption')}}"
                                label="{{__('webCaption.booking_req_date.title')}}" class="form-control"
                                name="booking_req_date" placeholder="{{__('webCaption.booking_req_date.title')}}"
                                value="{{old('booking_req_date', isset($data->booking_req_date)?$data->booking_req_date:'' )}}"
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