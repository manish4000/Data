@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.reauction.title') )
@else
@section('title', __('webCaption.reauction.title'))
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
                    {{__('webCaption.vehicle_information.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="stock_number"  tooltip="{{__('webCaption.stock_number.caption')}}" label="{{__('webCaption.stock_number.title')}}" name="stock_number"  placeholder="{{__('webCaption.stock_number.title')}}" value="{{old('stock_number', isset($data->stock_number)?$data->stock_number:'' )}}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="make"  tooltip="{{__('webCaption.make.caption')}}" label="{{__('webCaption.make.title')}}" name="make"  placeholder="{{__('webCaption.make.title')}}" value="{{old('make', isset($data->make)?$data->make:'' )}}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="model"  tooltip="{{__('webCaption.model.caption')}}" label="{{__('webCaption.model.title')}}" name="model"  placeholder="{{__('webCaption.model.title')}}" value="{{old('model', isset($data->model)?$data->model:'' )}}" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="model_code"  tooltip="{{__('webCaption.model_code.caption')}}" label="{{__('webCaption.model_code.title')}}" name="model_code"  placeholder="{{__('webCaption.model_code.title')}}" value="{{old('model_code', isset($data->model_code)?$data->model_code:'' )}}"  readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="chassis_number"  tooltip="{{__('webCaption.chassis_number.caption')}}" label="{{__('webCaption.chassis_number.title')}}" name="chassis_number"  placeholder="{{__('webCaption.chassis_number.title')}}" value="{{old('chassis_number', isset($data->chassis_number)?$data->chassis_number:'' )}}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="registration_year"  tooltip="{{__('webCaption.registration_year.caption')}}" label="{{__('webCaption.registration_year.title')}}" name="registration_year"  placeholder="{{__('webCaption.registration_year.title')}}" value="{{old('registration_year', isset($data->registration_year)?$data->registration_year:'' )}}" readonly="readonly" />
                        </div>
                    </div>
                
                </div>
            </div>

        </div>

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
                    {{__('webCaption.purchase_information.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="lot_number"  tooltip="{{__('webCaption.lot_number.caption')}}" label="{{__('webCaption.lot_number.title')}}" name="lot_number"  placeholder="{{__('webCaption.lot_number.title')}}" value="{{old('lot_number', isset($data->lot_number)?$data->lot_number:'' )}}" readonly="readonly" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="purchase_from"  tooltip="{{__('webCaption.purchase_from.caption')}}" label="{{__('webCaption.purchase_from.title')}}" name="purchase_from"  placeholder="{{__('webCaption.purchase_from.title')}}" value="{{old('purchase_from', isset($data->purchase_from)?$data->purchase_from:'' )}}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="customer"  tooltip="{{__('webCaption.customer.caption')}}" label="{{__('webCaption.customer.title')}}" name="customer"  placeholder="{{__('webCaption.customer.title')}}" value="{{old('customer', isset($data->customer)?$data->customer:'' )}}" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date  for="purchase_date"  tooltip="{{__('webCaption.purchase_date.caption')}}" label="{{__('webCaption.purchase_date.title')}}" name="purchase_date"  placeholder="{{__('webCaption.purchase_date.title')}}" value="{{old('purchase_date', isset($data->purchase_date)?$data->purchase_date:'' )}}" readonly="readonly" />
                        </div>
                    </div>                   
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date  for="invoice_date"  tooltip="{{__('webCaption.invoice_date.caption')}}" label="{{__('webCaption.invoice_date.title')}}" name="invoice_date"  placeholder="{{__('webCaption.invoice_date.title')}}" value="{{old('invoice_date', isset($data->invoice_date)?$data->invoice_date:'' )}}" readonly="readonly" />
                        </div>
                    </div>
                   
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="purchase_price"  tooltip="{{__('webCaption.purchase_price.caption')}}" label="{{__('webCaption.purchase_price.title')}}" name="purchase_price"  placeholder="{{__('webCaption.purchase_price.title')}}" value="{{old('purchase_price', isset($data->purchase_price)?$data->purchase_price:'' )}}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="other_cost"  tooltip="{{__('webCaption.other_cost.caption')}}" label="{{__('webCaption.other_cost.title')}}" name="other_cost"  placeholder="{{__('webCaption.other_cost.title')}}" value="{{old('other_cost', isset($data->other_cost)?$data->other_cost:'' )}}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="tax"  tooltip="{{__('webCaption.tax.caption')}}" label="{{__('webCaption.tax.title')}}" name="tax"  placeholder="{{__('webCaption.tax.title')}}" value="{{old('tax', isset($data->tax)?$data->tax:'' )}}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="total_cost"  tooltip="{{__('webCaption.total_cost.caption')}}" label="{{__('webCaption.total_cost.title')}}" name="total_cost"  placeholder="{{__('webCaption.total_cost.title')}}" value="{{old('total_cost', isset($data->total_cost)?$data->total_cost:'' )}}" readonly="readonly" />
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>

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
                    {{__('webCaption.reauction_information.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
                <div class="row">
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date  for="reauction_date"  tooltip="{{__('webCaption.reauction_date.caption')}}" label="{{__('webCaption.reauction_date.title')}}" name="reauction_date"  placeholder="{{__('webCaption.reauction_date.title')}}" value="{{old('reauction_date', isset($data->reauction_date)?$data->reauction_date:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="reauction_hall"  tooltip="{{__('webCaption.reauction_hall.caption')}}" label="{{__('webCaption.reauction_hall.title')}}" name="reauction_hall"  placeholder="{{__('webCaption.reauction_hall.title')}}" value="{{old('reauction_hall', isset($data->reauction_hall)?$data->reauction_hall:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="sold_by"  tooltip="{{__('webCaption.sold_by.caption')}}" label="{{__('webCaption.sold_by.title')}}" name="sold_by"  placeholder="{{__('webCaption.sold_by.title')}}" value="{{old('sold_by', isset($data->sold_by)?$data->sold_by:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="sold_amount"  tooltip="{{__('webCaption.sold_amount.caption')}}" label="{{__('webCaption.sold_amount.title')}}" name="sold_amount" placeholder="{{__('webCaption.sold_amount.title')}}" value="{{old('sold_amount', isset($data->sold_amount)?$data->sold_amount:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.number  for="amount_tax"  tooltip="{{__('webCaption.amount_tax.caption')}}" label="{{__('webCaption.amount_tax.title')}}" name="amount_tax"  placeholder="{{__('webCaption.amount_tax.title')}}" value="{{old('amount_tax', isset($data->amount_tax)?$data->amount_tax:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.number  for="total_amount"  tooltip="{{__('webCaption.total_amount.caption')}}" label="{{__('webCaption.total_amount.title')}}" name="total_amount"  placeholder="{{__('webCaption.total_amount.title')}}" value="{{old('total_amount', isset($data->total_amount)?$data->total_amount:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.number  for="difference_amount"  tooltip="{{__('webCaption.difference_amount.caption')}}" label="{{__('webCaption.difference_amount.title')}}" name="difference_amount"  placeholder="{{__('webCaption.difference_amount.title')}}" value="{{old('difference_amount', isset($data->difference_amount)?$data->difference_amount:'' )}}" />
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea  for="admin_memo"  tooltip="{{__('webCaption.admin_memo.caption')}}" maxlength="100" label="{{__('webCaption.admin_memo.title')}}" name="admin_memo"  placeholder="{{__('webCaption.admin_memo.title')}}" value="{{old('admin_memo', isset($data->admin_memo)?$data->admin_memo:'' )}}" />
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