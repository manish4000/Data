@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.ship_id.title') )
@else
@section('title', __('webCaption.ship_id.title'))
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
                    {{__('webCaption.shipping_details.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number  for="ref_id"  tooltip="{{__('webCaption.ref_id.caption')}}" label="{{__('webCaption.ref_id.title')}}"  name="ref_id"  placeholder="{{__('webCaption.ref_id.title')}}" value="{{old('ref_id', isset($data->ref_id)?$data->ref_id:'' )}}" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="ship_name"  tooltip="{{__('webCaption.ship_name.caption')}}" label="{{__('webCaption.ship_name.title')}}" name="ship_name"  placeholder="{{__('webCaption.ship_name.title')}}" value="{{old('ship_name', isset($data->ship_name)?$data->ship_name:'' )}}" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="carrier_name"  tooltip="{{__('webCaption.carrier_name.caption')}}" label="{{__('webCaption.carrier_name.title')}}" name="carrier_name"  placeholder="{{__('webCaption.carrier_name.title')}}" value="{{old('carrier_name', isset($data->carrier_name)?$data->carrier_name:'' )}}" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="voyage_number"  tooltip="{{__('webCaption.voyage_number.caption')}}" label="{{__('webCaption.voyage_number.title')}}" maxlength="20" name="voyage_number"  placeholder="{{__('webCaption.voyage_number.title')}}" value="{{old('voyage_number', isset($data->voyage_number)?$data->voyage_number:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.number  for="booking_number"  tooltip="{{__('webCaption.booking_number.caption')}}" maxlength="20" label="{{__('webCaption.booking_number.title')}}"  name="booking_number"  placeholder="{{__('webCaption.booking_number.title')}}" value="{{old('booking_number', isset($data->booking_number)?$data->booking_number:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <x-dash.form.inputs.date  for="etd_date"  tooltip="{{__('webCaption.etd_date.caption')}}" label="{{__('webCaption.etd_date.title')}}"  name="etd_date"  placeholder="{{__('webCaption.etd_date.title')}}" value="{{old('etd_date', isset($data->etd_date)?$data->etd_date:'' )}}"/>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <x-dash.form.inputs.date  for="eta_date"  tooltip="{{__('webCaption.eta_date.caption')}}" label="{{__('webCaption.eta_date.title')}}"  name="eta_date"  placeholder="{{__('webCaption.eta_date.title')}}" value="{{old('eta_date', isset($data->eta_date)?$data->eta_date:'' )}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="sailing_port"  tooltip="{{__('webCaption.sailing_port.caption')}}" label="{{__('webCaption.sailing_port.title')}}"  name="sailing_port"  placeholder="{{__('webCaption.sailing_port.title')}}" value="{{old('sailing_port', isset($data->sailing_port)?$data->sailing_port:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="bl_port"  tooltip="{{__('webCaption.bl_port.caption')}}" label="{{__('webCaption.bl_port.title')}}"  name="bl_port"  placeholder="{{__('webCaption.bl_port.title')}}" value="{{old('bl_port', isset($data->bl_port)?$data->bl_port:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="destination_port"  tooltip="{{__('webCaption.destination_port.caption')}}" label="{{__('webCaption.destination_port.title')}}"  name="destination_port"  placeholder="{{__('webCaption.destination_port.title')}}" value="{{old('destination_port', isset($data->destination_port)?$data->destination_port:'' )}}"/>
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