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
                    {{__('webCaption.purchase_details.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.dummy.title')}}" class=""
                                tooltip="{{__('webCaption.dummy.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="yes" tooltip="{{__('webCaption.yes.caption')}}"
                                        class="border border-danger" name="dummy" label="{{__('webCaption.yes.title')}}"
                                        value="Yes" checked="checked" required="required" />&ensp;

                                    <x-dash.form.inputs.radio for="no" class="border border-danger" name="dummy"
                                        tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}"
                                        value="No" checked="" required="required" />&ensp;
                                </div>
                            </div>
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="purchase_price"
                                tooltip="{{__('webCaption.purchase_price.caption')}}"
                                label="{{__('webCaption.purchase_price.title')}}" class="form-control"
                                name="purchase_price" placeholder="{{__('webCaption.purchase_price.title')}}"
                                value="{{old('purchase_price', isset($data->id)?$data->purchase_price:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="total_quantity"
                                tooltip="{{__('webCaption.total_quantity.caption')}}"
                                label="{{__('webCaption.total_quantity.title')}}" class="form-control"
                                name="total_quantity" placeholder="{{__('webCaption.total_quantity.title')}}"
                                value="{{old('total_quantity', isset($data->id)?$data->total_quantity:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.purchased_from.title')}}"
                                tooltip="{{__('webCaption.purchased_from.caption')}}" for="purchased_from"
                                class="form-control" maxlength="50" name="purchased_from"
                                placeholder="{{__('webCaption.purchased_from.title')}}"
                                value="{{old('purchased_from', isset($data->id)?$data->purchased_from:'' )}}"
                                required="" />
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
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="purchase_date"
                                tooltip="{{__('webCaption.purchase_date.caption')}}"
                                label="{{__('webCaption.purchase_date.title')}}" class="form-control"
                                name="purchase_date" placeholder="{{__('webCaption.purchase_date.title')}}"
                                value="{{old('purchase_date', isset($data->purchase_date)?$data->purchase_date:'' )}}"
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