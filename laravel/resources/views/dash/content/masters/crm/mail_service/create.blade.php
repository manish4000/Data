@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.mail_service.title') )
@else
@section('title', __('webCaption.mail_service.title'))
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
                    {{__('webCaption.mail_service.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
			    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="email_from" maxlength="50"  tooltip="{{__('webCaption.email_from.caption')}}" label="{{__('webCaption.email_from.title')}}"   name="email_from"  placeholder="{{__('webCaption.email_from.title')}}" value="{{old('email_from', isset($data->email_from)?$data->email_from:'' )}}" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="host" maxlength="100"  tooltip="{{__('webCaption.host.caption')}}" label="{{__('webCaption.host.title')}}"   name="host"  placeholder="{{__('webCaption.host.title')}}" value="{{old('host', isset($data->host)?$data->host:'' )}}" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="username" maxlength="100"  tooltip="{{__('webCaption.username.caption')}}" label="{{__('webCaption.username.title')}}"   name="username"  placeholder="{{__('webCaption.username.title')}}" value="{{old('username', isset($data->username)?$data->username:'' )}}" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.password  for="password" maxlength="100"  tooltip="{{__('webCaption.password.caption')}}" label="{{__('webCaption.password.title')}}"   name="password"  placeholder="{{__('webCaption.password.title')}}" value="{{old('password', isset($data->password)?$data->password:'' )}}" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="host_name" maxlength="50"  tooltip="{{__('webCaption.host_name.caption')}}" label="{{__('webCaption.host_name.title')}}"   name="host_name"  placeholder="{{__('webCaption.host_name.title')}}" value="{{old('host_name', isset($data->host_name)?$data->host_name:'' )}}" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number  for="port" maxlength="5"  tooltip="{{__('webCaption.port.caption')}}" label="{{__('webCaption.port.title')}}"   name="port"  placeholder="{{__('webCaption.port.title')}}" value="{{old('port', isset($data->port)?$data->port:'' )}}" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-8 col-8">
                                <div class="form-group">
                                    <x-dash.form.label for="" value="{{__('webCaption.status.title')}}" class="" tooltip="{{__('webCaption.status.caption')}}" />
                                    <div>
                                        <div class="form-check-inline">
                                            <x-dash.form.inputs.radio for="Active" tooltip="{{__('webCaption.active.caption')}}"  class="border border-danger" name="status" label="{{__('webCaption.active.title')}}" value="Active"  required="required" 
                                            checked="" />&ensp;
                                            
                                            <x-dash.form.inputs.radio for="Deactive" class="border border-danger" name="status" tooltip="{{__('webCaption.deactive.caption')}}" label="{{__('webCaption.deactive.title')}}" value="Deactive"  required="required"  checked="" />&ensp;
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @php
                            $old_default =  session()->getOldInput('default');
                            $default =   (isset($old_default) && $old_default == 1  ) ? 'checked' : ((isset($data->default) && $data->default == 1)? 'checked' :'' );
                            @endphp
                            <div class="col-md-4 col-4">
                                <x-dash.form.label for="" value="{{__('webCaption.default.caption')}}" class=""/>
                                <div class="form-group">
                                    <x-dash.form.inputs.checkbox  name="default"  for="" label="{{__('webCaption.default.caption')}}" checked="{{$default}}"  value="1"  customClass="form-check-input"  />
                                    @if ($errors->has('default'))
                                        <x-dash.form.form_error_messages message="{{ $errors->first('default') }}" />
                                    @endif
                                </div>
                            </div>
                        </div>    
                    </div>

                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number  for="mail_quantity" maxlength="5"  tooltip="{{__('webCaption.mail_quantity.caption')}}" label="{{__('webCaption.mail_quantity.title')}}"   name="mail_quantity"  placeholder="{{__('webCaption.mail_quantity.title')}}" value="{{old('mail_quantity', isset($data->mail_quantity)?$data->mail_quantity:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number  for="mail_frequency" maxlength="5"  tooltip="{{__('webCaption.mail_frequency.caption')}}" label="{{__('webCaption.mail_frequency.title')}}"   name="mail_frequency"  placeholder="{{__('webCaption.mail_frequency.title')}}" value="{{old('mail_frequency', isset($data->mail_frequency)?$data->mail_frequency:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="mail_frequency_unit" maxlength="5"  tooltip="{{__('webCaption.mail_frequency_unit.caption')}}" label="{{__('webCaption.mail_frequency_unit.title')}}"  name="mail_frequency_unit"  placeholder="{{__('webCaption.mail_frequency_unit.title')}}" value="{{old('mail_frequency_unit', isset($data->mail_frequency_unit)?$data->mail_frequency_unit:'' )}}"/>
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
<script src="{{ asset('assets/dash/assets/js/dash/master.js') }}"></script>
@endpush