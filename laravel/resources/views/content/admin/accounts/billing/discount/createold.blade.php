@extends('layouts/contentLayoutMaster',['activeUrl' => 'billing'])
@if(isset($data->id) && !empty($data->id))
@section('title',  __('webCaption.billing.title'). ' ' .__('webCaption.edit.title') )
@else
@section('title',  __('webCaption.billing.title'). ' ' .__('webCaption.add.title') )
@endif


@section('content')
<form action="{{ route('masters.vehicle.make.store')}}" method="POST">
@csrf
<section >
<div class="card">
    <div class="card-header">
			<h4 class="card-title">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			</svg>
			@if(isset($data->id) && !empty($data->id))
			{{__('webCaption.billing.title'). ' ' .__('webCaption.edit.title')}}
			@else
			{{__('webCaption.billing.title'). ' ' .__('webCaption.add.title')}}
			@endif
			</h4>  
    </div>
    <hr class="m-0 p-0">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.date tooltip="{{__('webCaption.invoice_date.caption')}}" label="{{__('webCaption.invoice_date.title')}}" maxlength="80" for="invoice_date" name="invoice_date" placeholder="{{ __('webCaption.invoice_date.title') }}" value="{{old('invoice_date', isset($data->invoice_date)?$data->invoice_date:'' )}}" />
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                <x-admin.form.inputs.select label="{{__('webCaption.package.title')}}"  tooltip="{{__('webCaption.package.caption')}}"  customClass="package" for="package" name="package" placeholder="{{ __('locale.package.caption') }}" editSelected=""  required="" :optionData="[]" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.text tooltip="{{__('webCaption.amount.caption')}}" label="{{__('webCaption.amount.title')}}" maxlength="80" for="amount" name="amount" placeholder="{{ __('webCaption.amount.title') }}" value="{{old('amount', isset($data->amount)?$data->amount:'' )}}" />
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.date tooltip="{{__('webCaption.start_date.caption')}}" label="{{__('webCaption.start_date.title')}}" maxlength="80" for="start_date" name="start_date" placeholder="{{ __('webCaption.start_date.title') }}" value="{{old('start_date', isset($data->start_date)?$data->start_date:'' )}}" />
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.date tooltip="{{__('webCaption.end_date.caption')}}" label="{{__('webCaption.end_date.title')}}" maxlength="80" for="end_date" name="end_date" placeholder="{{ __('webCaption.end_date.title') }}" value="{{old('end_date', isset($data->end_date)?$data->end_date:'' )}}" />
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.text tooltip="{{__('webCaption.duration.caption')}}" label="{{__('webCaption.duration.title')}}" maxlength="80" for="duration" name="duration" placeholder="{{ __('webCaption.duration.title') }}" value="{{old('duration', isset($data->duration)?$data->duration:'' )}}" disabled="disabled"/>
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.text tooltip="{{__('webCaption.gross_total.caption')}}" label="{{__('webCaption.gross_total.title')}}" maxlength="80" for="gross_total" name="gross_total" placeholder="{{ __('webCaption.gross_total.title') }}" value="{{old('gross_total', isset($data->gross_total)?$data->gross_total:'' )}}" disabled="disabled"/>
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.text tooltip="{{__('webCaption.tax_percentage.caption')}}" label="{{__('webCaption.tax_percentage.title')}}" maxlength="80" for="tax_percentage" name="tax_percentage" placeholder="{{ __('webCaption.tax_percentage.title') }}" value="{{old('tax_percentage', isset($data->tax_percentage)?$data->tax_percentage:'' )}}" />
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.text tooltip="{{__('webCaption.tax_amount.caption')}}" label="{{__('webCaption.tax_amount.title')}}" maxlength="80" for="tax_amount" name="tax_amount" placeholder="{{ __('webCaption.tax_amount.title') }}" value="{{old('tax_amount', isset($data->tax_amount)?$data->tax_amount:'' )}}" disabled="disabled"/>
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.text tooltip="{{__('webCaption.net_amount_total.caption')}}" label="{{__('webCaption.net_amount_total.title')}}" maxlength="80" for="net_amount_total" name="net_amount_total" placeholder="{{ __('webCaption.net_amount_total.title') }}" value="{{old('net_amount_total', isset($data->net_amount_total)?$data->net_amount_total:'' )}}" disabled="disabled"/>
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.text tooltip="{{__('webCaption.amount_in_words.caption')}}" label="{{__('webCaption.amount_in_words.title')}}" maxlength="80" for="amount_in_words" name="amount_in_words" placeholder="{{ __('webCaption.amount_in_words.title') }}" value="{{old('amount_in_words', isset($data->amount_in_words)?$data->amount_in_words:'' )}}" disabled="disabled"/>
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                <x-admin.form.inputs.select label="{{__('webCaption.status.title')}}"  tooltip="{{__('webCaption.status.caption')}}"  customClass="status" for="status" name="status" placeholder="{{ __('locale.status.caption') }}" editSelected=""  required="" :optionData="[]" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <x-admin.form.inputs.date tooltip="{{__('webCaption.received_date.caption')}}" label="{{__('webCaption.received_date.title')}}" maxlength="80" for="received_date" name="received_date" placeholder="{{ __('webCaption.received_date.title') }}" value="{{old('received_date', isset($data->received_date)?$data->received_date:'' )}}" />
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                <x-admin.form.inputs.textarea id="" for="admin_comment" tooltip="{{__('webCaption.admin_comment.caption')}}" label="{{__('webCaption.admin_comment.title')}}" maxlength="2000" name="admin_comment"  placeholder="{{__('webCaption.admin_comment.title')}}" value="{{old('admin_comment', isset($data->admin_comment)?$data->admin_comment:'' )}}" />
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@endsection