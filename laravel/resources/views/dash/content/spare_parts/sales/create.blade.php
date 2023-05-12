@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.spare_parts.title') )
@else
@section('title', __('webCaption.spare_parts.title'))
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
                    {{__('webCaption.spare_parts_details.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.purchase_id.caption')}}"
                                label="{{__('webCaption.purchase_id.title')}}" id="" for="purchase_id"
                                name="purchase_id" required="" :optionData="[]"
                                editSelected="{{(isset($data->purchase_id) && ($data->purchase_id != null)) ? $data->purchase_id : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.part_no.title')}}"
                                tooltip="{{__('webCaption.part_no.caption')}}" for="part_no" class="form-control"
                                maxlength="50" name="part_no" placeholder="{{__('webCaption.part_no.title')}}"
                                value="{{old('part_no', isset($data->id)?$data->part_no:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.part_name.title')}}"
                                tooltip="{{__('webCaption.part_name.caption')}}" for="part_name" class="form-control"
                                maxlength="100" name="part_name" placeholder="{{__('webCaption.part_name.title')}}"
                                value="{{old('part_name', isset($data->id)?$data->part_name:'' )}}"
                                required="required" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.make.caption')}}"
                                label="{{__('webCaption.make.title')}}" id="" for="make" name="make" required=""
                                :optionData="[]"
                                editSelected="{{(isset($data->make) && ($data->make != null)) ? $data->make : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.model.caption')}}"
                                label="{{__('webCaption.model.title')}}" id="" for="model" name="model" required=""
                                :optionData="[]"
                                editSelected="{{(isset($data->model) && ($data->model != null)) ? $data->model : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.model_code.caption')}}"
                                label="{{__('webCaption.model_code.title')}}" id="" for="model_code" name="model_code"
                                required="" :optionData="[]"
                                editSelected="{{(isset($data->model_code) && ($data->model_code != null)) ? $data->model_code : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.chassis_no.title')}}"
                                tooltip="{{__('webCaption.chassis_no.caption')}}" for="chassis_no" class="form-control"
                                maxlength="20" name="chassis_no" placeholder="{{__('webCaption.chassis_no.title')}}"
                                value="{{old('chassis_no', isset($data->id)?$data->chassis_no:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.main_category.caption')}}"
                                label="{{__('webCaption.main_category.title')}}" id="" for="main_category"
                                name="main_category" required="" :optionData="[]"
                                editSelected="{{(isset($data->main_category) && ($data->main_category != null)) ? $data->main_category : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.sub_category.caption')}}"
                                label="{{__('webCaption.sub_category.title')}}" id="" for="sub_category"
                                name="sub_category" required="" :optionData="[]"
                                editSelected="{{(isset($data->sub_category) && ($data->sub_category != null)) ? $data->sub_category : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.year_from.caption')}}"
                                label="{{__('webCaption.year_from.title')}}" id="" for="year_from" name="year_from"
                                required="" :optionData="[]"
                                editSelected="{{(isset($data->year_from) && ($data->year_from != null)) ? $data->year_from : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.year_to.caption')}}"
                                label="{{__('webCaption.year_to.title')}}" id="" for="year_to" name="year_to"
                                required="" :optionData="[]"
                                editSelected="{{(isset($data->year_to) && ($data->year_to != null)) ? $data->year_to : ''; }}" />
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
                    {{__('webCaption.spare_parts_selling_details.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.client_id.title')}}"
                                tooltip="{{__('webCaption.client_id.caption')}}" for="client_id" class="form-control"
                                maxlength="50" name="client_id" placeholder="{{__('webCaption.client_id.title')}}"
                                value="{{old('client_id', isset($data->id)?$data->client_id:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.customer_name.title')}}"
                                tooltip="{{__('webCaption.customer_name.caption')}}" for="customer_name"
                                class="form-control" maxlength="100" name="customer_name"
                                placeholder="{{__('webCaption.customer_name.title')}}"
                                value="{{old('customer_name', isset($data->id)?$data->customer_name:'' )}}"
                                required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="sales_quantity"
                                tooltip="{{__('webCaption.sales_quantity.caption')}}"
                                label="{{__('webCaption.sales_quantity.title')}}" class="form-control"
                                name="sales_quantity" placeholder="{{__('webCaption.sales_quantity.title')}}"
                                value="{{old('sales_quantity', isset($data->id)?$data->sales_quantity:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.currency.caption')}}"
                                label="{{__('webCaption.currency.title')}}" id="" for="currency" name="currency"
                                required="" :optionData="[]"
                                editSelected="{{(isset($data->currency) && ($data->currency != null)) ? $data->currency : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.selling_price.title')}}"
                                tooltip="{{__('webCaption.selling_price.caption')}}" for="selling_price"
                                class="form-control" maxlength="20" name="selling_price"
                                placeholder="{{__('webCaption.selling_price.title')}}"
                                value="{{old('selling_price', isset($data->id)?$data->selling_price:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.total_price.title')}}"
                                tooltip="{{__('webCaption.total_price.caption')}}" for="total_price"
                                class="form-control" maxlength="20" name="total_price"
                                placeholder="{{__('webCaption.total_price.title')}}"
                                value="{{old('total_price', isset($data->id)?$data->total_price:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="ex_rate" tooltip="{{__('webCaption.ex_rate.caption')}}"
                                label="{{__('webCaption.ex_rate.title')}}" class="form-control" name="ex_rate"
                                placeholder="{{__('webCaption.ex_rate.title')}}"
                                value="{{old('ex_rate', isset($data->id)?$data->ex_rate:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.equivalent_price.title')}}"
                                tooltip="{{__('webCaption.equivalent_price.caption')}}" for="equivalent_price"
                                class="form-control" maxlength="20" name="equivalent_price"
                                placeholder="{{__('webCaption.equivalent_price.title')}}"
                                value="{{old('equivalent_price', isset($data->id)?$data->equivalent_price:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="sold_date" tooltip="{{__('webCaption.sold_date.caption')}}"
                                label="{{__('webCaption.sold_date.title')}}" class="form-control" name="sold_date"
                                placeholder="{{__('webCaption.sold_date.title')}}"
                                value="{{old('sold_date', isset($data->sold_date)?$data->sold_date:'' )}}"
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
                    {{__('webCaption.shipping_and_courier.title')}}
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
                                value="{{old('address', isset($data->address)?$data->address:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.country.caption')}}"
                                label="{{__('webCaption.country.title')}}" id="" for="country" name="country"
                                required="" :optionData="[]"
                                editSelected="{{(isset($data->country) && ($data->country != null)) ? $data->country : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.ship_id.caption')}}"
                                label="{{__('webCaption.ship_id.title')}}" id="" for="ship_id" name="ship_id"
                                required="" :optionData="[]"
                                editSelected="{{(isset($data->ship_id) && ($data->ship_id != null)) ? $data->ship_id : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.container_id.caption')}}"
                                label="{{__('webCaption.container_id.title')}}" id="" for="container_id"
                                name="container_id" required="" :optionData="[]"
                                editSelected="{{(isset($data->container_id) && ($data->container_id != null)) ? $data->container_id : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.courier_company.title')}}"
                                tooltip="{{__('webCaption.courier_company.caption')}}" for="courier_company"
                                class="form-control" maxlength="50" name="courier_company"
                                placeholder="{{__('webCaption.courier_company.title')}}"
                                value="{{old('courier_company', isset($data->id)?$data->courier_company:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.tracking.title')}}"
                                tooltip="{{__('webCaption.tracking.caption')}}" for="tracking" class="form-control"
                                maxlength="50" name="tracking" placeholder="{{__('webCaption.tracking.title')}}"
                                value="{{old('tracking', isset($data->id)?$data->tracking:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="courier_date"
                                tooltip="{{__('webCaption.courier_date.caption')}}"
                                label="{{__('webCaption.courier_date.title')}}" class="form-control" name="courier_date"
                                placeholder="{{__('webCaption.courier_date.title')}}"
                                value="{{old('courier_date', isset($data->courier_date)?$data->courier_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="admin_memo"
                                tooltip="{{__('webCaption.admin_memo.caption')}}"
                                label="{{__('webCaption.admin_memo.title')}}" maxlength="1000" class="form-control"
                                name="admin_memo" placeholder="{{__('webCaption.admin_memo.title')}}"
                                value="{{old('admin_memo', isset($data->admin_memo)?$data->admin_memo:'' )}}"
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