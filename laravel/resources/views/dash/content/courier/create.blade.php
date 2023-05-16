@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.courier.title') )
@else
@section('title', __('webCaption.courier.title'))
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
                    {{__('webCaption.courier_details.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="courier_company"  tooltip="{{__('webCaption.courier_company.caption')}}" label="{{__('webCaption.courier_company.title')}}" name="courier_company"  placeholder="{{__('webCaption.courier_company.title')}}" value="{{old('courier_company', isset($data->courier_company)?$data->courier_company:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="customer_name"  tooltip="{{__('webCaption.customer_name.caption')}}" label="{{__('webCaption.customer_name.title')}}" name="customer_name"  placeholder="{{__('webCaption.customer_name.title')}}" value="{{old('customer_name', isset($data->customer_name)?$data->customer_name:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="customer_email"  tooltip="{{__('webCaption.customer_email.caption')}}" label="{{__('webCaption.customer_email.title')}}" name="customer_email"  placeholder="{{__('webCaption.customer_email.title')}}" value="{{old('customer_email', isset($data->customer_email)?$data->customer_email:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.date  for="courier_date"  tooltip="{{__('webCaption.courier_date.caption')}}" label="{{__('webCaption.courier_date.title')}}" name="courier_date"  placeholder="{{__('webCaption.courier_date.title')}}" value="{{old('courier_date', isset($data->courier_date)?$data->courier_date:'' )}}" />
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