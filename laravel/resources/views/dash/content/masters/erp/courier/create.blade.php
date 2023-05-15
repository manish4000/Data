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
                            <x-dash.form.inputs.text  for="courier_company"  tooltip="{{__('webCaption.courier_company.caption')}}" label="{{__('webCaption.courier_company.title')}}" maxlength="50" name="courier_company"  placeholder="{{__('webCaption.courier_company.title')}}" value="{{old('courier_company', isset($data->courier_company)?$data->courier_company:'' )}}" required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="parent"  tooltip="{{__('webCaption.parent.caption')}}" label="{{__('webCaption.parent.title')}}" name="parent"  placeholder="{{__('webCaption.parent.title')}}" value="{{old('parent', isset($data->parent)?$data->parent:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="url"  tooltip="{{__('webCaption.url.caption')}}" label="{{__('webCaption.url.title')}}" name="url"  maxlength="100" placeholder="{{__('webCaption.url.title')}}" value="{{old('url', isset($data->url)?$data->url:'' )}}" />
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
                                    <x-dash.form.inputs.checkbox  name="default"  for="Yes" label="{{__('webCaption.yes.caption')}}" checked="{{$default}}"  value="1"  customClass="form-check-input"  />
                                    @if ($errors->has('default'))
                                        <x-dash.form.form_error_messages message="{{ $errors->first('default') }}" />
                                    @endif
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