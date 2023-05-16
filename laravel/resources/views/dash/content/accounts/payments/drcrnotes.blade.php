@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.drcrnotes.title') )
@else
@section('title', __('webCaption.drcrnotes.title'))
@endif
@section('content')
<div>
    <form action="{{route('dashaccounts.payments.drcrnotes')}}" method="POST" enctype="multipart/form-data">
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
                    {{__('webCaption.drcrnotes.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 col-6">
                                <div class="form-group">
                                    <x-dash.form.inputs.select  for="type" maxlength=""  tooltip="{{__('webCaption.type.caption')}}" label="{{__('webCaption.type.title')}}"   name="type"  placeholder="{{__('webCaption.type.title')}}" value="{{old('type', isset($data->type)?$data->type:'' )}}" required="required"/>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="form-group">
                                    <x-dash.form.inputs.date  for="cash_in_date" maxlength=""  tooltip="{{__('webCaption.cash_in_date.caption')}}" label="{{__('webCaption.cash_in_date.title')}}"   name="cash_in_date"  placeholder="{{__('webCaption.cash_in_date.title')}}" value="{{old('cash_in_date', isset($data->cash_in_date)?$data->cash_in_date:'' )}}" required="required"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <x-dash.form.inputs.text  for="client_id" maxlength="5"  tooltip="{{__('webCaption.client_id.caption')}}" label="{{__('webCaption.client_id.title')}}"  name="client_id"  placeholder="{{__('webCaption.client_id.title')}}" value="{{old('client_id', isset($data->client_id)?$data->client_id:'' )}}" required="required"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="customer_name" maxlength="100"  tooltip="{{__('webCaption.customer_name.caption')}}" label="{{__('webCaption.customer_name.title')}}"  name="customer_name"  placeholder="{{__('webCaption.customer_name.title')}}" value="{{old('customer_name', isset($data->customer_name)?$data->customer_name:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2 col-5">
                                <div class="form-group">
                                    <x-dash.form.inputs.select  for="currency"  maxlength="" tooltip="{{__('webCaption.currency.caption')}}" label="{{__('webCaption.currency.title')}}"  name="currency"  placeholder="{{__('webCaption.currency.title')}}" value="{{old('currency', isset($data->currency)?$data->currency:'' )}}"  required="required" />
                                </div>
                            </div>
                            <div class="col-md-4 col-7">
                                <div class="form-group">
                                    <x-dash.form.inputs.text  for="amount" maxlength="20"  tooltip="{{__('webCaption.amount.caption')}}" label="{{__('webCaption.amount.title')}}"  name="amount"  placeholder="{{__('webCaption.amount.title')}}" value="{{old('amount', isset($data->amount)?$data->amount:'' )}}" required="required"/>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="form-group">
                                    <x-dash.form.inputs.number id="" for="ex_rate"  tooltip="{{__('webCaption.ex_rate.caption')}}" label="{{__('webCaption.ex_rate.title')}}" maxlength="6"  name="ex_rate"  placeholder="{{__('webCaption.ex_rate.title')}}" value="{{old('ex_rate', isset($data->ex_rate)?$data->ex_rate:'' )}}"  required="required" />
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="form-group">
                                    <x-dash.form.inputs.text  for="equivalent_amount"  tooltip="{{__('webCaption.equivalent_amount.caption')}}" label="{{__('webCaption.equivalent_amount.title')}}"   name="equivalent_amount"  placeholder="{{__('webCaption.equivalent_amount.title')}}" value="{{old('equivalent_amount', isset($data->equivalent_amount)?$data->equivalent_amount:'' )}}" />
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.label for="Approved_by_accounts" value="{{__('webCaption.approved_by_accounts.title')}}" class=""  tooltip="{{__('webCaption.approved_by_accounts.caption')}}" />
                        </div>
                        <div class=" form-check-inline">
                            <x-dash.form.inputs.checkbox for="Yes" tooltip="{{__('webCaption.yes.caption')}}"  class="border border-danger" name="approved_by_accounts" label="{{__('webCaption.yes.title')}}" placeholder="" value="yes"  checked="{{ (isset ($user->companySalesTeam->approved_by_accounts) && $user->companySalesTeam->approved_by_accounts == 'Active') ? 'checked' : '' }}" />
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea  for="purpose" maxlength="500"  tooltip="{{__('webCaption.purpose.caption')}}" label="{{__('webCaption.purpose.title')}}"   name="purpose"  placeholder="{{__('webCaption.purpose.title')}}" value="{{old('purpose', isset($data->purpose)?$data->purpose:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea  for="dealer_comment" maxlength="500"  tooltip="{{__('webCaption.dealer_comment.caption')}}" label="{{__('webCaption.dealer_comment.title')}}"   name="dealer_comment"  placeholder="{{__('webCaption.dealer_comment.title')}}" value="{{old('dealer_comment', isset($data->dealer_comment)?$data->dealer_comment:'' )}}"/>
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
