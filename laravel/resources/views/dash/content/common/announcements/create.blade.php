@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.announcements.title') )
@else
@section('title', __('webCaption.announcements.title'))
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
                    {{__('webCaption.announcements.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.title.title')}}"
                                tooltip="{{__('webCaption.title.caption')}}" for="title" class="form-control"
                                maxlength="250" name="title" placeholder="{{__('webCaption.title.title')}}"
                                value="{{old('title', isset($data->title)?$data->title:'' )}}" required="required" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.show_title.title')}}" class=""
                                tooltip="{{__('webCaption.show_title.caption')}}" required="" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="yes" tooltip="{{__('webCaption.yes.caption')}}"
                                        class="border border-danger" name="show_title"
                                        label="{{__('webCaption.yes.title')}}" value="Yes" checked="checked"
                                        required="" />&ensp;

                                    <x-dash.form.inputs.radio for="no" class="border border-danger" name="show_title"
                                        tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}"
                                        value="No" checked="" required="" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @if(isset($data->companySalesTeam->language_id))
                            @php $editSelected = json_decode($user->companySalesTeam->language_id); @endphp
                            @else
                            @php $editSelected = ''; @endphp
                            @endif
                            <x-dash.form.inputs.multiple_select label="{{__('webCaption.display_users.title')}}" id=""
                                for="display_users" name="display_users[]"
                                placeholder="{{__('webCaption.display_users.title')}}" :oldValues="old('display_users')"
                                :editSelected="$editSelected" required="" :optionData="[]" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @if(isset($data->companySalesTeam->language_id))
                            @php $editSelected = json_decode($user->companySalesTeam->language_id); @endphp
                            @else
                            @php $editSelected = ''; @endphp
                            @endif
                            <x-dash.form.inputs.multiple_select label="{{__('webCaption.display_department.title')}}"
                                id="" for="display_department" name="display_department[]"
                                placeholder="{{__('webCaption.display_department.title')}}"
                                :oldValues="old('display_department')" :editSelected="$editSelected" required=""
                                :optionData="[]" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pr-50">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="start_date" tooltip="{{__('webCaption.start_date.caption')}}"
                                label="{{__('webCaption.start_date.title')}}" class="form-control" name="start_date"
                                placeholder="{{__('webCaption.start_date.title')}}"
                                value="{{old('start_date', isset($data->start_date)?$data->start_date:'' )}}"
                                required="required" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-50">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="exp_date" tooltip="{{__('webCaption.exp_date.caption')}}"
                                label="{{__('webCaption.exp_date.title')}}" class="form-control" name="exp_date"
                                placeholder="{{__('webCaption.exp_date.title')}}"
                                value="{{old('exp_date', isset($data->exp_date)?$data->exp_date:'' )}}"
                                required="required" />
                        </div>
                    </div>                
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="description"
                                tooltip="{{__('webCaption.description.caption')}}"
                                label="{{__('webCaption.description.title')}}" maxlength="2000" class="form-control"
                                name="description" placeholder="{{__('webCaption.description.title')}}"
                                value="{{old('description', isset($data->description)?$data->description:'' )}}"
                                required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.show_as.title')}}" class=""
                                tooltip="{{__('webCaption.show_as.caption')}}" required="" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="dashboard"
                                        tooltip="{{__('webCaption.dashboard.caption')}}" class="border border-danger"
                                        name="show_as" label="{{__('webCaption.dashboard.title')}}" value="Dashboard"
                                        checked="checked" required="" />&ensp;

                                    <x-dash.form.inputs.radio for="popup" class="border border-danger" name="show_as"
                                        tooltip="{{__('webCaption.popup.caption')}}"
                                        label="{{__('webCaption.popup.title')}}" value="Popup" checked="" required="" />
                                    &ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.display_status.title')}}" class=""
                                tooltip="{{__('webCaption.display_status.caption')}}" required="" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="Active" tooltip="{{__('webCaption.yes.caption')}}"
                                        class="border border-danger" name="display_status"
                                        label="{{__('webCaption.yes.title')}}" value="Yes" checked="checked"
                                        required="" />&ensp;

                                    <x-dash.form.inputs.radio for="Deactive" class="border border-danger"
                                        name="display_status" tooltip="{{__('webCaption.no.caption')}}"
                                        label="{{__('webCaption.no.title')}}" value="No" checked="" required="" />&ensp;
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