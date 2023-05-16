@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.container_group.title') )
@else
@section('title', __('webCaption.container_group.title'))
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
                    {{__('webCaption.container_information.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
                <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="container_group_number"  tooltip="{{__('webCaption.container_group_number.caption')}}"  label="{{__('webCaption.container_group_number.title')}}" name="container_group_number"  placeholder="{{__('webCaption.container_group_number.title')}}" value="{{old('container_group_number', isset($data->container_group_number)?$data->container_group_number:'' )}}" />
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        <x-dash.form.inputs.date  for="container_date"  tooltip="{{__('webCaption.container_date.caption')}}" label="{{__('webCaption.container_date.title')}}" name="container_date"  placeholder="{{__('webCaption.container_date.title')}}" value="{{old('container_date', isset($data->container_date)?$data->container_date:'' )}}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="number_of_units"  tooltip="{{__('webCaption.number_of_units.caption')}}"  label="{{__('webCaption.number_of_units.title')}}" name="number_of_units"  placeholder="{{__('webCaption.number_of_units.title')}}" value="{{old('number_of_units', isset($data->number_of_units)?$data->number_of_units:'' )}}" readonly="readonly" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="container_number"  tooltip="{{__('webCaption.container_number.caption')}}"  label="{{__('webCaption.container_number.title')}}" name="container_number"  placeholder="{{__('webCaption.container_number.title')}}" value="{{old('container_number', isset($data->container_number)?$data->container_number:'' )}}" maxlength="30" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="seal_number"  tooltip="{{__('webCaption.seal_number.caption')}}"  label="{{__('webCaption.seal_number.title')}}" name="seal_number"  placeholder="{{__('webCaption.seal_number.title')}}" value="{{old('seal_number', isset($data->seal_number)?$data->seal_number:'' )}}" maxlength="30" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.text  for="container_weight"  tooltip="{{__('webCaption.container_weight.caption')}}"  label="{{__('webCaption.container_weight.title')}}" name="container_weight"  placeholder="{{__('webCaption.container_weight.title')}}" value="{{old('container_weight', isset($data->container_weight)?$data->container_weight:'' )}}" maxlength="10" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.select  for="container_size"  tooltip="{{__('webCaption.container_size.caption')}}"  label="{{__('webCaption.container_size.title')}}" name="container_size"  placeholder="{{__('webCaption.container_size.title')}}" value="{{old('container_size', isset($data->container_size)?$data->container_size:'' )}}"      />
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