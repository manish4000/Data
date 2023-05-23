@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.ocean_freight.title') )
@else
@section('title', __('webCaption.ocean_freight.title'))
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
                    {{__('webCaption.ocean_freight.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.shipping_company.title')}}"
                                tooltip="{{__('webCaption.shipping_company.caption')}}" for="shipping_company"
                                name="shipping_company" placeholder="{{ __('locale.shipping_company.caption') }}"
                                customClass="shipping_company" :optionData="[]"
                                editSelected="{{old('shipping_company', isset($data->shipping_company) ? $data->shipping_company :'') }}"
                                required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.from_country.title')}}"
                                tooltip="{{__('webCaption.from_country.caption')}}" for="from_country"
                                name="from_country" placeholder="{{ __('locale.from_country.caption') }}"
                                customClass="from_country" :optionData="[]"
                                editSelected="{{old('from_country', isset($data->from_country) ? $data->from_country :'') }}"
                                required="" />
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
                            <x-dash.form.inputs.select label="{{__('webCaption.to_country.title')}}"
                                tooltip="{{__('webCaption.to_country.caption')}}" for="to_country" name="to_country"
                                placeholder="{{ __('locale.to_country.caption') }}" customClass="to_country"
                                :optionData="[]"
                                editSelected="{{old('to_country', isset($data->to_country) ? $data->to_country :'') }}"
                                required="" />
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
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="date_of_update"
                                tooltip="{{__('webCaption.date_of_update.caption')}}"
                                label="{{__('webCaption.date_of_update.title')}}" class="form-control"
                                name="date_of_update" placeholder="{{__('webCaption.date_of_update.title')}}"
                                value="{{old('date_of_update', isset($data->date_of_update)?$data->date_of_update:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="validity" tooltip="{{__('webCaption.validity.caption')}}"
                                label="{{__('webCaption.validity.title')}}" class="form-control" name="validity"
                                placeholder="{{__('webCaption.validity.title')}}"
                                value="{{old('validity', isset($data->validity)?$data->validity:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.container_1.title')}}"
                                tooltip="{{__('webCaption.container_1.caption')}}" for="container_1"
                                class="form-control" maxlength="10" name="container_1"
                                placeholder="{{__('webCaption.container_1.title')}}"
                                value="{{old('container_1', isset($data->container_1)?$data->container_1:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.container_2.title')}}"
                                tooltip="{{__('webCaption.container_2.caption')}}" for="container_2"
                                class="form-control" maxlength="10" name="container_2"
                                placeholder="{{__('webCaption.container_2.title')}}"
                                value="{{old('container_2', isset($data->container_2)?$data->container_2:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.high_cube_container.title')}}"
                                tooltip="{{__('webCaption.high_cube_container.caption')}}" for="high_cube_container"
                                class="form-control" maxlength="10" name="high_cube_container"
                                placeholder="{{__('webCaption.high_cube_container.title')}}"
                                value="{{old('high_cube_container', isset($data->high_cube_container)?$data->high_cube_container:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.per_m3_rate.title')}}"
                                tooltip="{{__('webCaption.per_m3_rate.caption')}}" for="per_m3_rate"
                                class="form-control" maxlength="10" name="per_m3_rate"
                                placeholder="{{__('webCaption.per_m3_rate.title')}}"
                                value="{{old('per_m3_rate', isset($data->per_m3_rate)?$data->per_m3_rate:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.roro_rates.title')}}" class=""
                                tooltip="{{__('webCaption.roro_rates.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="height" tooltip="{{__('webCaption.height.caption')}}"
                                        class="border border-danger" name="roro_rates"
                                        label="{{__('webCaption.height.title')}}" value="Height" checked="checked"
                                        required="required" />&ensp;

                                    <x-dash.form.inputs.radio for="per_m3" class="border border-danger"
                                        name="roro_rates" tooltip="{{__('webCaption.per_m3.caption')}}"
                                        label="{{__('webCaption.per_m3.title')}}" value="Per M3" checked=""
                                        required="required" />&ensp;

                                    <x-dash.form.inputs.radio for="fixed" class="border border-danger" name="roro_rates"
                                        tooltip="{{__('webCaption.fixed.caption')}}"
                                        label="{{__('webCaption.fixed.title')}}" value="Fixed" checked=""
                                        required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 pr-md-50 col-6 ">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_1_from.title')}}"
                                tooltip="{{__('webCaption.range_1_from.caption')}}" for="range_1_from"
                                class="form-control" name="range_1_from"
                                placeholder="{{__('webCaption.range_1_from.title')}}"
                                value="{{old('range_1_from', isset($data->range_1_from)?$data->range_1_from:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_1_to.title')}}"
                                tooltip="{{__('webCaption.range_1_to.caption')}}" for="range_1_to" class="form-control"
                                name="range_1_to" placeholder="{{__('webCaption.range_1_to.title')}}"
                                value="{{old('range_1_to', isset($data->range_1_to)?$data->range_1_to:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-0 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.rate_1.title')}}"
                                tooltip="{{__('webCaption.rate_1.caption')}}" for="rate_1" class="form-control"
                                name="rate_1" placeholder="{{__('webCaption.rate_1.title')}}"
                                value="{{old('rate_1', isset($data->rate_1)?$data->rate_1:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pr-md-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_2_from.title')}}"
                                tooltip="{{__('webCaption.range_2_from.caption')}}" for="range_2_from"
                                class="form-control" name="range_2_from"
                                placeholder="{{__('webCaption.range_2_from.title')}}"
                                value="{{old('range_2_from', isset($data->range_2_from)?$data->range_2_from:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_2_to.title')}}"
                                tooltip="{{__('webCaption.range_2_to.caption')}}" for="range_2_to" class="form-control"
                                name="range_2_to" placeholder="{{__('webCaption.range_2_to.title')}}"
                                value="{{old('range_2_to', isset($data->range_2_to)?$data->range_2_to:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-0 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.rate_2.title')}}"
                                tooltip="{{__('webCaption.rate_2.caption')}}" for="rate_2" class="form-control"
                                name="rate_2" placeholder="{{__('webCaption.rate_2.title')}}"
                                value="{{old('rate_2', isset($data->rate_2)?$data->rate_2:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pr-md-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_3_from.title')}}"
                                tooltip="{{__('webCaption.range_3_from.caption')}}" for="range_3_from"
                                class="form-control" name="range_3_from"
                                placeholder="{{__('webCaption.range_3_from.title')}}"
                                value="{{old('range_3_from', isset($data->range_3_from)?$data->range_3_from:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_3_to.title')}}"
                                tooltip="{{__('webCaption.range_3_to.caption')}}" for="range_3_to" class="form-control"
                                name="range_3_to" placeholder="{{__('webCaption.range_3_to.title')}}"
                                value="{{old('range_3_to', isset($data->range_3_to)?$data->range_3_to:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-0 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.rate_3.title')}}"
                                tooltip="{{__('webCaption.rate_3.caption')}}" for="rate_3" class="form-control"
                                name="rate_3" placeholder="{{__('webCaption.rate_3.title')}}"
                                value="{{old('rate_3', isset($data->rate_3)?$data->rate_3:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pr-md-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_4_from.title')}}"
                                tooltip="{{__('webCaption.range_4_from.caption')}}" for="range_4_from"
                                class="form-control" name="range_4_from"
                                placeholder="{{__('webCaption.range_4_from.title')}}"
                                value="{{old('range_4_from', isset($data->range_4_from)?$data->range_4_from:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_4_to.title')}}"
                                tooltip="{{__('webCaption.range_4_to.caption')}}" for="range_4_to" class="form-control"
                                name="range_4_to" placeholder="{{__('webCaption.range_4_to.title')}}"
                                value="{{old('range_4_to', isset($data->range_4_to)?$data->range_4_to:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-0 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.rate_4.title')}}"
                                tooltip="{{__('webCaption.rate_4.caption')}}" for="rate_4" class="form-control"
                                name="rate_4" placeholder="{{__('webCaption.rate_4.title')}}"
                                value="{{old('rate_4', isset($data->rate_4)?$data->rate_4:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pr-md-50  col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_5_from.title')}}"
                                tooltip="{{__('webCaption.range_5_from.caption')}}" for="range_5_from"
                                class="form-control" name="range_5_from"
                                placeholder="{{__('webCaption.range_5_from.title')}}"
                                value="{{old('range_5_from', isset($data->range_5_from)?$data->range_5_from:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_5_to.title')}}"
                                tooltip="{{__('webCaption.range_5_to.caption')}}" for="range_5_to" class="form-control"
                                name="range_5_to" placeholder="{{__('webCaption.range_5_to.title')}}"
                                value="{{old('range_5_to', isset($data->range_5_to)?$data->range_5_to:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-0 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.rate_5.title')}}"
                                tooltip="{{__('webCaption.rate_5.caption')}}" for="rate_5" class="form-control"
                                name="rate_5" placeholder="{{__('webCaption.rate_5.title')}}"
                                value="{{old('rate_5', isset($data->rate_5)?$data->rate_5:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pr-md-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_6_from.title')}}"
                                tooltip="{{__('webCaption.range_6_from.caption')}}" for="range_6_from"
                                class="form-control" name="range_6_from"
                                placeholder="{{__('webCaption.range_6_from.title')}}"
                                value="{{old('range_6_from', isset($data->range_6_from)?$data->range_6_from:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-50 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.range_6_to.title')}}"
                                tooltip="{{__('webCaption.range_6_to.caption')}}" for="range_6_to" class="form-control"
                                name="range_6_to" placeholder="{{__('webCaption.range_6_to.title')}}"
                                value="{{old('range_6_to', isset($data->range_6_to)?$data->range_6_to:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 pl-md-0 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.rate_6.title')}}"
                                tooltip="{{__('webCaption.rate_6.caption')}}" for="rate_6" class="form-control"
                                name="rate_6" placeholder="{{__('webCaption.rate_6.title')}}"
                                value="{{old('rate_6', isset($data->rate_6)?$data->rate_6:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="admin_memo"
                                tooltip="{{__('webCaption.admin_memo.caption')}}"
                                label="{{__('webCaption.admin_memo.title')}}" maxlength="100" class="form-control"
                                name="admin_memo" placeholder="{{__('webCaption.admin_memo.title')}}"
                                value="{{old('admin_memo', isset($data->id)?$data->admin_memo:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.display_status.title')}}" class=""
                                tooltip="{{__('webCaption.display_status.caption')}}" required="" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="yes" tooltip="{{__('webCaption.yes.caption')}}"
                                        class="border border-danger" name="display_status"
                                        label="{{__('webCaption.yes.title')}}" value="Yes" checked="checked"
                                        required="" />&ensp;

                                    <x-dash.form.inputs.radio for="no" class="border border-danger"
                                        name="display_status" tooltip="{{__('webCaption.no.caption')}}"
                                        label="{{__('webCaption.no.title')}}" value="No" checked="" required="" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-16">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.default.title')}}" class=""
                                tooltip="{{__('webCaption.default.caption')}}" required="" />
                            <div>
                                <x-dash.form.inputs.checkbox for="default" name="default" class="form-control"
                                    label="{{__('webCaption.yes.title')}}" value="1"
                                    checked="{{ old('default') == 'No' ? 'checked' : '' }} {{ isset($data->default) ? $data->default == 'Yes' ? 'checked=checked' :'' :'' }}"
                                    customClass="custom-control-inline" required="" />
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

@push('script')
<script>
$(document).ready(function() {
    messengerImageCode();
});
</script>
@endpush