@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.online_payments.title') )
@else
@section('title', __('webCaption.online_payments.title'))
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
                    {{__('webCaption.online_payments.title')}}
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.type.title')}}"
                                tooltip="{{__('webCaption.type.caption')}}" for="type" name="type"
                                placeholder="{{ __('locale.type.caption') }}" customClass="type" :optionData="[]"
                                editSelected="{{(isset($data->type) && ($data->type != null)) ? $data->type :'' }}"
                                required="required" />
                            @if($errors->has('type'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('type') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.secret_key_id.title')}}"
                                tooltip="{{__('webCaption.secret_key_id.caption')}}" for="secret_key_id"
                                class="form-control" maxlength="100" name="secret_key_id"
                                placeholder="{{__('webCaption.secret_key_id.title')}}"
                                value="{{old('secret_key_id', isset($data->secret_key_id)?$data->secret_key_id:'' )}}"
                                required="required" />
                            @if($errors->has('secret_key_id'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('secret_key_id') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text id="" label="{{__('webCaption.sitekey.title')}}"
                                tooltip="{{__('webCaption.sitekey.caption')}}" for="sitekey" class="form-control"
                                maxlength="100" name="sitekey" placeholder="{{__('webCaption.sitekey.title')}}"
                                value="{{old('sitekey', isset($data->sitekey)?$data->sitekey:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="commission" maxlength="2"
                                tooltip="{{__('webCaption.commission.caption')}}"
                                label="{{__('webCaption.commission.title')}}" class="form-control" name="commission"
                                placeholder="{{__('webCaption.commission.title')}}"
                                value="{{old('commission', isset($data->commission)?$data->commission:'' )}}" required="required" />
                            @if ($errors->has('commission'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('commission') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.status.title')}}" class="" tooltip="{{__('webCaption.status.caption')}}" required="required" />
                            <div>
                                <div class="form-check-inline">
                                    <x-dash.form.inputs.radio for="yes" tooltip="{{__('webCaption.yes.caption')}}"
                                    class="border border-danger" name="status"
                                    label="{{__('webCaption.yes.title')}}" value="Yes"
                                    checked="checked" required="required" />&ensp;

                                    <x-dash.form.inputs.radio for="no" class="border border-danger" name="status"
                                    tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" value="No" checked="" required="required" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="description"
                                tooltip="{{__('webCaption.description.caption')}}"
                                label="{{__('webCaption.description.title')}}" maxlength="1000" class="form-control"
                                name="description" placeholder="{{__('webCaption.description.title')}}"
                                value="{{old('description', isset($data->description)?$data->description:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="admin_memo"
                                tooltip="{{__('webCaption.admin_memo.caption')}}"
                                label="{{__('webCaption.admin_memo.title')}}" maxlength="1000" class="form-control"
                                name="admin_memo" placeholder="{{__('webCaption.admin_memo.title')}}"
                                value="{{old('admin_memo', isset($data->admin_memo)?$data->admin_memo:'' )}}" required="" />
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
<script>
$(document).ready(function() {
    messengerImageCode();
});
</script>
@endpush