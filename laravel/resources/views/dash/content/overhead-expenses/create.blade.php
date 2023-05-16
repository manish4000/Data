@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.overhead_expenses.title') )
@else
@section('title', __('webCaption.overhead_expenses.title'))
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
                    {{__('webCaption.overhead_expenses.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 col-6 pr-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.month.caption')}}"
                                label="{{__('webCaption.month.title')}}" id="" for="month_1"
                                name="month" required="" :optionData="[]"
                                editSelected="{{(isset($data->month) && ($data->month != null)) ? $data->month : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-50">
                        <div class="form-group">
                            <x-dash.form.inputs.select tooltip="{{__('webCaption.year.caption')}}"
                                label="{{__('webCaption.year.title')}}" id="" for="year_1"
                                name="year" required="" :optionData="[]"
                                editSelected="{{(isset($data->year) && ($data->year != null)) ? $data->year : ''; }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.charge_1.title')}}"
                                tooltip="{{__('webCaption.charge_1.caption')}}" for="charge_1"
                                class="form-control" maxlength="20" name="charge_1"
                                placeholder="{{__('webCaption.charge_1.title')}}"
                                value="{{old('charge_1', isset($data->charge_1)?$data->charge_1:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.charge_2.title')}}"
                                tooltip="{{__('webCaption.charge_2.caption')}}" for="charge_2"
                                class="form-control" maxlength="20" name="charge_2"
                                placeholder="{{__('webCaption.charge_2.title')}}"
                                value="{{old('charge_2', isset($data->charge_2)?$data->charge_2:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.charge_3.title')}}"
                                tooltip="{{__('webCaption.charge_3.caption')}}" for="charge_3"
                                class="form-control" maxlength="20" name="charge_3"
                                placeholder="{{__('webCaption.charge_3.title')}}"
                                value="{{old('charge_3', isset($data->charge_3)?$data->charge_3:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.charge_4.title')}}"
                                tooltip="{{__('webCaption.charge_4.caption')}}" for="charge_4"
                                class="form-control" maxlength="20" name="charge_4"
                                placeholder="{{__('webCaption.charge_4.title')}}"
                                value="{{old('charge_4', isset($data->charge_4)?$data->charge_4:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.total_charge.title')}}"
                                tooltip="{{__('webCaption.total_charge.caption')}}" for="total_charge" readonly="readonly"
                                class="form-control" maxlength="20" name="total_charge"
                                placeholder="{{__('webCaption.total_charge.title')}}"
                                value="{{old('total_charge', isset($data->total_charge)?$data->total_charge:'' )}}"
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