@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.blacklist.title') )
@else
@section('title', __('webCaption.blacklist.title'))
@endif


@section('content')
<div>
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
                </svg>
                {{__('webCaption.blacklist_manager.title')}} 
                </h4>  
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
			    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="email" maxlength="50"  tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}"   name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($data->email)?$data->email:'' )}}" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="block_from" tooltip="{{__('webCaption.block_from.caption')}}" label="{{__('webCaption.block_from.title')}}"   name="block_from"  placeholder="{{__('webCaption.block_from.title')}}" value="{{old('block_from', isset($data->block_from)?$data->block_from:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.hidden  for="hidden" tooltip="{{__('webCaption.hidden.caption')}}" label="{{__('webCaption.hidden.title')}}"   name="hidden"  placeholder="{{__('webCaption.hidden.title')}}" value="{{old('hidden', isset($data->hidden)?$data->hidden:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="block_reason" tooltip="{{__('webCaption.block_reason.caption')}}"  label="{{__('webCaption.block_reason.title')}}" maxlength="1000" class="form-control" name="block_reason"  placeholder="{{__('webCaption.block_reason.title')}}" value="{{old('block_reason', isset($data->block_reason)?$data->block_reason:'' )}}"  required="" />   
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.stop_emails.title')}}" class=""  tooltip="{{__('webCaption.stop_emails.caption')}}"/>
                            <div>
                                <div class=" form-check-inline">
                                    <x-dash.form.inputs.radio for="Yes" tooltip="{{__('webCaption.yes.caption')}}"  class="border border-danger" name="stop_emails" label="{{__('webCaption.yes.title')}}" placeholder="" value="Yes"  required=""  checked="" required="required" />&ensp;
                                        
                                    <x-dash.form.inputs.radio for="No" class="border border-danger" name="stop_emails" tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" placeholder="" value="No"  required=""  checked="" required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.type.title')}}" class="" tooltip="{{__('webCaption.type.caption')}}"/>
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="Pending" tooltip="{{__('webCaption.pending.caption')}}"  class="border border-danger" name="type" label="{{__('webCaption.pending.title')}}" placeholder="" value="pending"  required=""  checked=""/>&ensp;
                                        
                                    <x-dash.form.inputs.radio for="White" class="border border-danger" name="type" tooltip="{{__('webCaption.white.caption')}}" label="{{__('webCaption.white.title')}}" placeholder="" value="white"  required=""  checked="" />&ensp;
                                   
                                    <x-dash.form.inputs.radio for="Black" class="border border-danger" name="type" tooltip="{{__('webCaption.black.caption')}}" label="{{__('webCaption.black.title')}}" placeholder="" value="black"  required=""  checked="" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.block_type.title')}}" class="" tooltip="{{__('webCaption.block_type.caption')}}" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="Temporary" tooltip="{{__('webCaption.temporary.caption')}}"  class="border border-danger" name="block_type" label="{{__('webCaption.temporary.title')}}" value="Temporary"  required="required" 
                                    checked="" />&ensp;
                                    
                                    <x-dash.form.inputs.radio for="Permanent" class="border border-danger" name="block_type" tooltip="{{__('webCaption.permanent.caption')}}" label="{{__('webCaption.permanent.title')}}" value="Permanent"  required="required"  checked="" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


        </div>

        <div class="form-group text-center">
            <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
            @if(isset($data->id)) 	<x-dash.form.buttons.update /> @else <x-dash.form.buttons.create/> @endif 
        </div>
    </form>
</div>
@endsection


@push('script')
<script src="{{ asset('assets/dash/assets/js/dash/master.js') }}"></script>
@endpush