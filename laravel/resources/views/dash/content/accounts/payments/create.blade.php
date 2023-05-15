@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.payment.title') )
@else
@section('title', __('webCaption.payment.title'))
@endif
@section('content')
<div>
    <form action="{{route('dashaccounts.payments.store')}}" method="POST" enctype="multipart/form-data">
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
                    {{__('webCaption.payment_details.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="cash_in_date"
                                tooltip="{{__('webCaption.cash_in_date.caption')}}"
                                label="{{__('webCaption.cash_in_date.title')}}" class="form-control" name="cash_in_date"
                                placeholder="{{__('webCaption.cash_in_date.title')}}"
                                value="{{old('cash_in_date', isset($data->id)?$data->cash_in_date:'' )}}"
                                required="required" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.approved_by_accounts.title')}}" class="" tooltip="{{__('webCaption.approved_by_accounts.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.checkbox for="yes" tooltip="{{__('webCaption.yes.caption')}}"
                                    class="border border-danger" name="approved_by_accounts"
                                    label="{{__('webCaption.yes.title')}}" value="Yes"
                                    checked="" required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.payment_reference_number.title')}}" tooltip="{{__('webCaption.payment_reference_number.caption')}}" for="payment_reference_number"
                            class="form-control" maxlength="100" name="payment_reference_number"
                            placeholder="{{__('webCaption.payment_reference_number.title')}}"
                            value="{{old('payment_reference_number', isset($data->id)?$data->payment_reference_number:'' )}}"
                            required="required" />
                            @if($errors->has('payment_reference_number'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('payment_reference_number') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.receiving_bank.title')}}"
                                tooltip="{{__('webCaption.receiving_bank.caption')}}" for="receiving_bank"
                                name="receiving_bank" placeholder="{{ __('locale.receiving_bank.caption') }}"
                                customClass="receiving_bank" :optionData="[]"
                                editSelected="{{(isset($data->receiving_bank) && ($data->receiving_bank != null)) ? $data->receiving_bank :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.amount.title')}}"
                                tooltip="{{__('webCaption.amount.caption')}}" for="amount" class="form-control"
                                maxlength="20" name="amount" placeholder="{{__('webCaption.amount.title')}}"
                                value="{{old('amount', isset($data->amount)?$data->amount:'' )}}" required="required" />
                            @if($errors->has('amount'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('amount') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.currency.title')}}"
                                tooltip="{{__('webCaption.currency.caption')}}" for="currency" name="currency"
                                placeholder="{{ __('locale.currency.caption') }}" customClass="currency"
                                :optionData="[]"
                                editSelected="{{(isset($data->id) && ($data->id != null)) ? $data->currency :'' }}"
                                required="required" />
                            @if($errors->has('currency'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('currency') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-0">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.ex_rate.title')}}"
                                tooltip="{{__('webCaption.ex_rate.caption')}}" for="ex_rate" class="form-control"
                                maxlength="10" name="ex_rate" placeholder="{{__('webCaption.ex_rate.title')}}"
                                value="{{old('ex_rate', isset($data->ex_rate)?$data->ex_rate:'' )}}"
                                required="required" />
                            @if($errors->has('ex_rate'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('ex_rate') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.eq_in_accounting_currency.title')}}"
                                tooltip="{{__('webCaption.eq_in_accounting_currency.caption')}}"
                                for="accounting_currency" class="form-control" maxlength="20" name="accounting_currency"
                                placeholder="{{__('webCaption.eq_in_accounting_currency.title')}}"
                                value="{{old('accounting_currency', isset($data->accounting_currency)?$data->accounting_currency:'' )}}"
                                required="required" />
                            @if($errors->has('accounting_currency'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('accounting_currency') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="balance_amount"
                                tooltip="{{__('webCaption.balance_amount.caption')}}"
                                label="{{__('webCaption.balance_amount.title')}}" class="form-control"
                                name="balance_amount" placeholder="{{__('webCaption.balance_amount.title')}}"
                                value="{{old('balance_amount', isset($data->balance_amount)?$data->balance_amount:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="refund_amount"
                                tooltip="{{__('webCaption.refund_amount.caption')}}"
                                label="{{__('webCaption.refund_amount.title')}}" class="form-control"
                                name="refund_amount" placeholder="{{__('webCaption.refund_amount.title')}}"
                                value="{{old('refund_amount', isset($data->refund_amount)?$data->refund_amount:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.date for="refund_date"
                                tooltip="{{__('webCaption.refund_date.caption')}}"
                                label="{{__('webCaption.refund_date.title')}}" class="form-control" name="refund_date"
                                placeholder="{{__('webCaption.refund_date.title')}}"
                                value="{{old('refund_date', isset($data->refund_date)?$data->refund_date:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6 pl-0">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.payment_mode.title')}}"
                                tooltip="{{__('webCaption.payment_mode.caption')}}" for="payment_mode"
                                name="payment_mode" placeholder="{{ __('locale.payment_mode.caption') }}"
                                customClass="payment_mode" :optionData="[]"
                                editSelected="{{(isset($data->payment_mode) && ($data->payment_mode != null)) ? $data->payment_mode :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.client_id.title')}}"
                                tooltip="{{__('webCaption.client_id.caption')}}" for="client_id" class="form-control" maxlength="5" name="client_id" placeholder="{{__('webCaption.client_id.title')}}" value="{{old('client_id', isset($data->client_id)?$data->client_id:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.customer_name.title')}}"
                                tooltip="{{__('webCaption.customer_name.caption')}}" for="customer_name"
                                class="form-control" maxlength="100" name="customer_name"
                                placeholder="{{__('webCaption.customer_name.title')}}"
                                value="{{old('customer_name', isset($data->customer_name)?$data->customer_name:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.depositer_name.title')}}"
                            tooltip="{{__('webCaption.depositer_name.caption')}}" for="depositer_name"
                            class="form-control" maxlength="100" name="depositer_name"
                            placeholder="{{__('webCaption.depositer_name.title')}}"
                            value="{{old('depositer_name', isset($data->depositer_name)?$data->depositer_name:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <x-dash.form.inputs.select id="" label="{{__('webCaption.issuing_bank.title')}}"
                            tooltip="{{__('webCaption.issuing_bank.caption')}}" for="issuing_bank" class="form-control" name="issuing_bank" placeholder="{{__('webCaption.issuing_bank.title')}}" value="{{old('issuing_bank', isset($data->issuing_bank)?$data->issuing_bank:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.select id="" label="{{__('webCaption.payment_currency.title')}}"
                            tooltip="{{__('webCaption.payment_currency.caption')}}" for="payment_currency" class="form-control" name="payment_currency" placeholder="{{__('webCaption.payment_currency.title')}}" value="{{old('payment_currency', isset($data->payment_currency)?$data->payment_currency:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <x-dash.form.inputs.text id="" label="{{__('webCaption.Payment_currency_realised_amount.title')}}"
                            tooltip="{{__('webCaption.Payment_currency_realised_amount.caption')}}" for="Payment_currency_realised_amount" class="form-control" name="Payment_currency_realised_amount" placeholder="{{__('webCaption.Payment_currency_realised_amount.title')}}" value="{{old('Payment_currency_realised_amount', isset($data->Payment_currency_realised_amount)?$data->Payment_currency_realised_amount:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <x-dash.form.inputs.text id="" label="{{__('webCaption.Payment_currency_unrealised_amount.title')}}"
                            tooltip="{{__('webCaption.Payment_currency_unrealised_amount.caption')}}" for="Payment_currency_unrealised_amount" class="form-control" name="Payment_currency_unrealised_amount" placeholder="{{__('webCaption.Payment_currency_unrealised_amount.title')}}" value="{{old('Payment_currency_unrealised_amount', isset($data->Payment_currency_unrealised_amount)?$data->Payment_currency_unrealised_amount:'' )}}" disabled="disabled" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <x-dash.form.inputs.text id="" label="{{__('webCaption.lc_realised_amount.title')}}"
                            tooltip="{{__('webCaption.lc_realised_amount.caption')}}" for="lc_realised_amount" class="form-control" name="lc_realised_amount" placeholder="{{__('webCaption.lc_realised_amount.title')}}" value="{{old('lc_realised_amount', isset($data->lc_realised_amount)?$data->lc_realised_amount:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <x-dash.form.inputs.text id="" label="{{__('webCaption.lc_unrealised_amount.title')}}"
                            tooltip="{{__('webCaption.lc_unrealised_amount.caption')}}" for="lc_unrealised_amount" class="form-control" name="lc_unrealised_amount" placeholder="{{__('webCaption.lc_unrealised_amount.title')}}" value="{{old('lc_unrealised_amount', isset($data->lc_unrealised_amount)?$data->lc_unrealised_amount:'' )}}" disabled="disabled" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.date id="" label="{{__('webCaption.submit_date.title')}}"
                            tooltip="{{__('webCaption.submit_date.caption')}}" for="submit_date" class="form-control" name="submit_date" placeholder="{{__('webCaption.submit_date.title')}}" value="{{old('submit_date', isset($data->submit_date)?$data->submit_date:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <x-dash.form.inputs.text id="" label="{{__('webCaption.lc_dhl_number.title')}}"
                            tooltip="{{__('webCaption.lc_dhl_number.caption')}}" for="lc_dhl_number" class="form-control" name="lc_dhl_number" maxlength="20" placeholder="{{__('webCaption.lc_dhl_number.title')}}" value="{{old('lc_dhl_number', isset($data->lc_dhl_number)?$data->lc_dhl_number:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.date id="" label="{{__('webCaption.document_purchase_date.title')}}"
                            tooltip="{{__('webCaption.document_purchase_date.caption')}}" for="document_purchase_date" class="form-control" name="document_purchase_date" placeholder="{{__('webCaption.document_purchase_date.title')}}" value="{{old('document_purchase_date', isset($data->document_purchase_date)?$data->document_purchase_date:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.text id="" label="{{__('webCaption.less_charge.title')}}"
                            tooltip="{{__('webCaption.less_charge.caption')}}" for="less_charge" class="form-control" name="less_charge" maxlength="20" placeholder="{{__('webCaption.less_charge.title')}}" value="{{old('less_charge', isset($data->less_charge)?$data->less_charge:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.text id="" label="{{__('webCaption.lc_charge_domestic.title')}}"
                            tooltip="{{__('webCaption.lc_charge_domestic.caption')}}" for="lc_charge_domestic" class="form-control" name="lc_charge_domestic" maxlength="20" placeholder="{{__('webCaption.lc_charge_domestic.title')}}" value="{{old('lc_charge_domestic', isset($data->lc_charge_domestic)?$data->lc_charge_domestic:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.text id="" label="{{__('webCaption.lc_charge_advise_bank_usd.title')}}"
                            tooltip="{{__('webCaption.lc_charge_advise_bank_usd.caption')}}" for="lc_charge_advise_bank_usd" class="form-control" name="lc_charge_advise_bank_usd" maxlength="20" placeholder="{{__('webCaption.lc_charge_advise_bank_usd.title')}}" value="{{old('lc_charge_advise_bank_usd', isset($data->lc_charge_advise_bank_usd)?$data->lc_charge_advise_bank_usd:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.number id="" label="{{__('webCaption.ex_rate.title')}}"
                            tooltip="{{__('webCaption.ex_rate.caption')}}" for="ex_rate" class="form-control" name="ex_rate" placeholder="{{__('webCaption.ex_rate.title')}}" value="{{old('ex_rate', isset($data->ex_rate)?$data->ex_rate:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.text id="" label="{{__('webCaption.lc_charge_advise_bank_in_jpy.title')}}" tooltip="{{__('webCaption.lc_charge_advise_bank_in_jpy.caption')}}" for="lc_charge_advise_bank_in_jpy" class="form-control"
                        name="lc_charge_advise_bank_in_jpy" placeholder="{{__('webCaption.lc_charge_advise_bank_in_jpy.title')}}" disabled="disabled" value="{{old('lc_charge_advise_bank_in_jpy', isset($data->lc_charge_advise_bank_in_jpy)?$data->lc_charge_advise_bank_in_jpy:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.date id="" label="{{__('webCaption.expiry_date.title')}}"
                            tooltip="{{__('webCaption.expiry_date.caption')}}" for="expiry_date" class="form-control" name="expiry_date" placeholder="{{__('webCaption.expiry_date.title')}}" value="{{old('expiry_date', isset($data->expiry_date)?$data->expiry_date:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.text id="" label="{{__('webCaption.expiry_days.title')}}"
                            tooltip="{{__('webCaption.expiry_days.caption')}}" for="expiry_days" class="form-control" name="expiry_days" placeholder="{{__('webCaption.expiry_days.title')}}"  value="{{old('expiry_days', isset($data->expiry_days)?$data->expiry_days:'' )}}" disabled="disabled" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.date id="" label="{{__('webCaption.latest_ship_date.title')}}"
                            tooltip="{{__('webCaption.latest_ship_date.caption')}}" for="latest_ship_date" class="form-control" name="latest_ship_date" placeholder="{{__('webCaption.latest_ship_date.title')}}" value="{{old('latest_ship_date', isset($data->latest_ship_date)?$data->latest_ship_date:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.date id="" label="{{__('webCaption.lc_received_date.title')}}"
                            tooltip="{{__('webCaption.lc_received_date.caption')}}" for="lc_received_date" class="form-control" name="lc_received_date" placeholder="{{__('webCaption.lc_received_date.title')}}" value="{{old('lc_received_date', isset($data->lc_received_date)?$data->lc_received_date:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.credit_report.title')}}" class="" tooltip="{{__('webCaption.credit_report.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.checkbox for="credit_report" tooltip="{{__('webCaption.credit_report.caption')}}" class="border border-danger"
                                    name="credit_report" label="{{__('webCaption.credit_report.title')}}" value="credit_report" checked="" required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.lc_check.title')}}" class="" tooltip="{{__('webCaption.lc_check.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.checkbox for="lc_check" tooltip="{{__('webCaption.lc_check.caption')}}" class="border border-danger"  name="lc_check" 
                                    label="{{__('webCaption.lc_check.title')}}" value="lc_check"
                                    checked="" required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.mistake.title')}}" class="" tooltip="{{__('webCaption.mistake.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.checkbox for="mistake" tooltip="{{__('webCaption.mistake.caption')}}" class="border border-danger" name="mistake"
                                    label="{{__('webCaption.mistake.title')}}" value="mistake"
                                    checked="" required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                        <x-dash.form.inputs.textarea id="" label="{{__('webCaption.lc_remarks.title')}}"
                            tooltip="{{__('webCaption.lc_remarks.caption')}}" for="lc_remarks" class="form-control" name="lc_remarks" maxlength="100" placeholder="{{__('webCaption.lc_remarks.title')}}" value="{{old('lc_remarks', isset($data->lc_remarks)?$data->lc_remarks:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                        <x-dash.form.inputs.textarea id="" label="{{__('webCaption.mistake_remarks.title')}}"
                            tooltip="{{__('webCaption.mistake_remarks.caption')}}" for="mistake_remarks" class="form-control" name="mistake_remarks" maxlength="100" placeholder="{{__('webCaption.mistake_remarks.title')}}" value="{{old('mistake_remarks', isset($data->mistake_remarks)?$data->mistake_remarks:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.number id="" label="{{__('webCaption.cl.title')}}"
                            tooltip="{{__('webCaption.cl.caption')}}" for="cl" maxlength="2" class="form-control" name="cl"  placeholder="{{__('webCaption.cl.title')}}" value="{{old('cl', isset($data->cl)?$data->cl:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.number id="" label="{{__('webCaption.bl.title')}}"
                            tooltip="{{__('webCaption.bl.caption')}}" maxlength="2" for="bl" class="form-control" name="bl"  placeholder="{{__('webCaption.bl.title')}}" value="{{old('bl', isset($data->bl)?$data->bl:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.number id="" label="{{__('webCaption.nn_bl.title')}}"
                            tooltip="{{__('webCaption.nn_bl.caption')}}" maxlength="2" for="nn_bl" class="form-control" name="nn_bl"  placeholder="{{__('webCaption.nn_bl.title')}}" value="{{old('nn_bl', isset($data->nn_bl)?$data->nn_bl:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.number id="" label="{{__('webCaption.ins.title')}}"
                            tooltip="{{__('webCaption.ins.caption')}}" maxlength="2" for="ins" class="form-control" name="ins"  placeholder="{{__('webCaption.ins.title')}}" value="{{old('ins', isset($data->ins)?$data->ins:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.number id="" label="{{__('webCaption.ic.title')}}"
                            tooltip="{{__('webCaption.ic.caption')}}" maxlength="2" for="ic" class="form-control" name="ic"  placeholder="{{__('webCaption.ic.title')}}" value="{{old('ic', isset($data->ic)?$data->ic:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.number id="" label="{{__('webCaption.co.title')}}"
                            tooltip="{{__('webCaption.co.caption')}}" maxlength="2" for="co" class="form-control" name="co"  placeholder="{{__('webCaption.co.title')}}" value="{{old('co', isset($data->co)?$data->co:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.number id="" label="{{__('webCaption.bc.title')}}"
                            tooltip="{{__('webCaption.bc.caption')}}" maxlength="2" for="bc" class="form-control" name="bc"  placeholder="{{__('webCaption.bc.title')}}" value="{{old('bc', isset($data->bc)?$data->bc:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.number id="" label="{{__('webCaption.ecr.title')}}"
                            tooltip="{{__('webCaption.ecr.caption')}}" maxlength="2" for="ecr" class="form-control" name="ecr"  placeholder="{{__('webCaption.ecr.title')}}" value="{{old('ecr', isset($data->ecr)?$data->ecr:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.number id="" label="{{__('webCaption.tr.title')}}"
                            tooltip="{{__('webCaption.tr.caption')}}" maxlength="2" for="tr" class="form-control" name="tr"  placeholder="{{__('webCaption.tr.title')}}" value="{{old('tr', isset($data->tr)?$data->tr:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                        <x-dash.form.inputs.number id="" label="{{__('webCaption.pkg.title')}}"
                            tooltip="{{__('webCaption.pkg.caption')}}" maxlength="2" for="pkg" class="form-control" name="pkg"  placeholder="{{__('webCaption.pkg.title')}}" value="{{old('pkg', isset($data->pkg)?$data->pkg:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                            $editImageUrl = (isset($data->payment_receipt))
                            ?"dash/payment_receipt/".$data->payment_receipt: '';
                            @endphp
                            <x-dash.form.inputs.file id="" caption="{{__('webCaption.payment_receipt.title')}}"
                            editImageUrl="{{$editImageUrl}}" ImageId="payment_receipt-preview" for="payment_receipt"  name="payment_receipt" maxFileSize="5000"
                            placeholder="{{__('webCaption.payment_receipt.title')}}" required="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="admin_memo" tooltip="{{__('webCaption.admin_memo.caption')}}"
                            label="{{__('webCaption.admin_memo.title')}}" maxlength="100" class="form-control" name="admin_memo" placeholder="{{__('webCaption.admin_memo.title')}}"  value="{{old('admin_memo', isset($data->admin_memo)?$data->admin_memo:'' )}}" required="" />     
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="note_for_accounting"
                            tooltip="{{__('webCaption.note_for_accounting.caption')}}" maxlength="250"
                            label="{{__('webCaption.note_for_accounting.title')}}" class="form-control"
                            name="note_for_accounting" placeholder="{{__('webCaption.note_for_accounting.title')}}"  value="{{old('note_for_accounting', isset($data->note_for_accounting)?
                            $data->note_for_accounting:'' )}}" required="" />
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