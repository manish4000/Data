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
                            <x-dash.form.label for="" value="{{__('webCaption.payment_status.title')}}" class=""
                                tooltip="{{__('webCaption.payment_status.caption')}}" required="" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="yes" tooltip="{{__('webCaption.yes.caption')}}"
                                        class="border border-danger" name="payment_status"
                                        label="{{__('webCaption.yes.title')}}" value="Yes"
                                        checked="{{ (old('display') == 'Yes') || (!isset($data->id))  ? 'checked' : '' }} {{ isset($data->payment_status) ? $data->payment_status == 'Yes' ? 'checked=checked' :'' :'' }} "
                                        required="required" />&ensp;

                                    <x-dash.form.inputs.radio for="no" class="border border-danger"
                                        name="payment_status" tooltip="{{__('webCaption.no.caption')}}"
                                        label="{{__('webCaption.no.title')}}" value="No" required="required"
                                        checked="{{ old('display') == 'No' ? 'checked' : '' }} {{ isset($data->payment_status) ? $data->payment_status == 'No' ? 'checked=checked' :'' :'' }} "
                                        required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.payment_ref_no.title')}}"
                                tooltip="{{__('webCaption.payment_ref_no.caption')}}" for="payment_ref_no"
                                class="form-control" maxlength="100" name="payment_ref_no"
                                placeholder="{{__('webCaption.payment_ref_no.title')}}"
                                value="{{old('payment_ref_no', isset($data->id)?$data->payment_ref_no:'' )}}"
                                required="required" />
                            @if($errors->has('payment_ref_no'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('payment_ref_no') }}" />
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
                    <div class="col-md-2 col-6">
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
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.payment_mode.title')}}"
                                tooltip="{{__('webCaption.payment_mode.caption')}}" for="payment_mode"
                                name="payment_mode" placeholder="{{ __('locale.payment_mode.caption') }}"
                                customClass="payment_mode" :optionData="[]"
                                editSelected="{{(isset($data->payment_mode) && ($data->payment_mode != null)) ? $data->payment_mode :'' }}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.client_id.title')}}"
                                tooltip="{{__('webCaption.client_id.caption')}}" for="client_id" class="form-control"
                                maxlength="5" name="client_id" placeholder="{{__('webCaption.client_id.title')}}"
                                value="{{old('client_id', isset($data->client_id)?$data->client_id:'' )}}"
                                required="" />
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
                                value="{{old('depositer_name', isset($data->depositer_name)?$data->depositer_name:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                            $editImageUrl = (isset($data->payment_receipt))
                            ?"dash/payment_receipt/".$data->payment_receipt: '';
                            @endphp
                            <x-dash.form.inputs.file id="" caption="{{__('webCaption.payment_receipt.title')}}"
                                editImageUrl="{{$editImageUrl}}" ImageId="payment_receipt-preview" for="payment_receipt"
                                name="payment_receipt" maxFileSize="5000"
                                placeholder="{{__('webCaption.payment_receipt.title')}}" required="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="memo" tooltip="{{__('webCaption.memo.caption')}}"
                                label="{{__('webCaption.memo.title')}}" maxlength="250" class="form-control" name="memo"
                                placeholder="{{__('webCaption.memo.title')}}"
                                value="{{old('memo', isset($data->memo)?$data->memo:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="note_for_accounting"
                                tooltip="{{__('webCaption.note_for_accounting.caption')}}"
                                label="{{__('webCaption.note_for_accounting.title')}}" maxlength="250"
                                class="form-control" name="note_for_accounting"
                                placeholder="{{__('webCaption.note_for_accounting.title')}}"
                                value="{{old('note_for_accounting', isset($data->note_for_accounting)?$data->note_for_accounting:'' )}}"
                                required="" />
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