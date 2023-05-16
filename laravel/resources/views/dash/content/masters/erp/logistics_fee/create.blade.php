@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.logistics_fee.title') )
@else
@section('title', __('webCaption.logistics_fee.title'))
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
                    {{__('webCaption.logistics_fee.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.transport_company.caption')}}"
                                label="{{__('webCaption.transport_company.title')}}" id="" for="transport_company_1"
                                name="transport_company" required="" :optionData="[]"
                                editSelected="{{(isset($data->transport_company) && ($data->transport_company != null)) ? $data->transport_company : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.purchase_from.caption')}}"
                                label="{{__('webCaption.purchase_from.title')}}" id="" for="purchase_from_1"
                                name="purchase_from" required="" :optionData="[]"
                                editSelected="{{(isset($data->purchase_from) && ($data->purchase_from != null)) ? $data->purchase_from : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.delivery_yard.caption')}}"
                                label="{{__('webCaption.delivery_yard.title')}}" id="" for="delivery_yard_1"
                                name="delivery_yard" required="" :optionData="[]"
                                editSelected="{{(isset($data->delivery_yard) && ($data->delivery_yard != null)) ? $data->delivery_yard : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.default_amount.title')}}"
                                tooltip="{{__('webCaption.default_amount.caption')}}" for="default_amount"
                                class="form-control" maxlength="20" name="default_amount"
                                placeholder="{{__('webCaption.default_amount.title')}}"
                                value="{{old('default_amount', isset($data->default_amount)?$data->default_amount:'' )}}"
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