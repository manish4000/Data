@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.sales_agreement.title') )
@else
@section('title', __('webCaption.sales_agreement.title'))
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
                    {{__('webCaption.sales_agreement.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="agreement_term"  tooltip="{{__('webCaption.agreement_term.caption')}}" label="{{__('webCaption.agreement_term.title')}}" maxlength="20" name="agreement_term"  placeholder="{{__('webCaption.agreement_term.title')}}" value="{{old('agreement_term', isset($data->agreement_term)?$data->agrrement_term:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.status.title')}}" class="" tooltip="{{__('webCaption.status.caption')}}" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="Active" tooltip="{{__('webCaption.active.caption')}}"  class="border border-danger" name="status" label="{{__('webCaption.active.title')}}" value="Active"  required="required" checked="" />&ensp;
                                    
                                    <x-dash.form.inputs.radio for="Deactive" class="border border-danger" name="status" tooltip="{{__('webCaption.deactive.caption')}}" label="{{__('webCaption.deactive.title')}}" value="Deactive"  required="required"  checked="" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea  for="discription"  tooltip="{{__('webCaption.discription.caption')}}" label="{{__('webCaption.discription.title')}}" maxlength="20" name="discription"  placeholder="{{__('webCaption.discription.title')}}" value="{{old('discription', isset($data->discription)?$data->discription:'' )}}" />
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