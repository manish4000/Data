@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.shipping_schedule.title') )
@else
@section('title', __('webCaption.shipping_schedule.title'))
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
                    {{__('webCaption.shipping_schedule.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="region"  tooltip="{{__('webCaption.region.caption')}}" label="{{__('webCaption.region.title')}}" name="region" placeholder="{{__('webCaption.region.title')}}" value="{{old('region', isset($data->region)?$data->region:'' )}}" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="ship_company"  tooltip="{{__('webCaption.ship_company.caption')}}" label="{{__('webCaption.ship_company.title')}}" name="ship_company" placeholder="{{__('webCaption.ship_company.title')}}" value="{{old('ship_company', isset($data->ship_company)?$data->ship_company:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="ship_name"  tooltip="{{__('webCaption.ship_name.caption')}}" label="{{__('webCaption.ship_name.title')}}" name="ship_name" placeholder="{{__('webCaption.ship_name.title')}}" value="{{old('ship_name', isset($data->ship_name)?$data->ship_name:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="voyage_number"  tooltip="{{__('webCaption.voyage_number.caption')}}" maxlength="100" label="{{__('webCaption.voyage_number.title')}}" name="voyage_number" placeholder="{{__('webCaption.voyage_number.title')}}" value="{{old('voyage_number', isset($data->voyage_number)?$data->voyage_number:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.ship_type.title')}}" class="" tooltip="{{__('webCaption.ship_type.caption')}}" />
                            <div>
                                <x-dash.form.inputs.radio for="roro" tooltip="{{__('webCaption.roro.caption')}}"  class="border border-danger" name="ship_type" label="{{__('webCaption.roro.title')}}" value="roro" required="required"  checked="{{ (isset ($user->companySalesTeam->ship_type) && $user->companySalesTeam->ship_type == 'Active') ? 'checked' : '' }}" />&ensp;

                                <x-dash.form.inputs.radio for="container" class="border border-danger" name="ship_type" tooltip="{{__('webCaption.container.caption')}}" label="{{__('webCaption.container.title')}}"  value="container"  required="required"  checked="{{ (isset($user->companySalesTeam->ship_type) && $user->companySalesTeam->ship_type == 'Blocked') ? 'checked' : '' }}" />&ensp;
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.hidden />
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8 pr-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.select  for="from_port"  tooltip="{{__('webCaption.from_port.caption')}}" label="{{__('webCaption.from_port.title')}}" name="from_port" placeholder="{{__('webCaption.from_port.title')}}" value="{{old('from_port', isset($data->from_port)?$data->from_port:'' )}}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="form-group">
                                    <x-dash.form.inputs.date  for="from_port_date"  tooltip="{{__('webCaption.from_port_date.caption')}}" label="{{__('webCaption.from_port_date.title')}}" name="from_port_date" placeholder="{{__('webCaption.from_port_date.title')}}" value="{{old('from_port_date', isset($data->from_port_date)?$data->from_port_date:'' )}}" />
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8 pr-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.select  for="to_port"  tooltip="{{__('webCaption.to_port.caption')}}" label="{{__('webCaption.to_port.title')}}" name="to_port" placeholder="{{__('webCaption.to_port.title')}}" value="{{old('to_port', isset($data->to_port)?$data->to_port:'' )}}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="form-group">
                                    <x-dash.form.inputs.date  for="to_port_date"  tooltip="{{__('webCaption.to_port_date.caption')}}" label="{{__('webCaption.to_port_date.title')}}" name="to_port_date" placeholder="{{__('webCaption.to_port_date.title')}}" value="{{old('to_port_date', isset($data->to_port_date)?$data->to_port_date:'' )}}" />
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