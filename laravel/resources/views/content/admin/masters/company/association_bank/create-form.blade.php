@extends('layouts/contentLayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.business_type.title'). ' ' .__('webCaption.edit.title') )
@else
@section('title', __('webCaption.business_type.title').' '. __('webCaption.add.title') )
@endif

@section('content')
<form action="{{ route('masters.company.business-type.store')}}" method="POST">
    @csrf
    <section>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-map font-medium-3 mr-1">
                        <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                        <line x1="8" y1="2" x2="8" y2="18"></line>
                        <line x1="16" y1="6" x2="16" y2="22"></line>
                    </svg>
                    @if(isset($data->id) && !empty($data->id))
                    {{__('webCaption.association_bank.title'). ' ' .__('webCaption.edit.title')  }}
                    @else
                    {{  __('webCaption.association_bank.title').' '. __('webCaption.add.title')}}
                    @endif
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <x-admin.form.inputs.select tooltip="{{__('webCaption.association.caption')}}"
                                label="{{__('webCaption.association.title')}}" id="" for="association"
                                name="association" placeholder="{{__('webCaption.association.title')}}"
                                required="required" :optionData="[]"
                                editSelected="{{(isset($data->association) && ($data->association != null))?$data->association :''; }}" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <x-admin.form.inputs.select tooltip="{{__('webCaption.bank.caption')}}"
                                label="{{__('webCaption.bank.title')}}" id="" for="bank" name="bank"
                                placeholder="{{__('webCaption.bank.title')}}" required="required" :optionData="[]"
                                editSelected="{{(isset($data->bank) && ($data->bank != null))?$data->bank :''; }}" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            @php
                            $editImageUrl = (isset($data->logo)) ? "social_media/".$data->logo : '';
                            @endphp
                            <x-admin.form.inputs.file id="" caption="{{__('webCaption.logo.title')}}"
                                editImageUrl="{{$editImageUrl}}" ImageId="logo-preview" for="logo" name="logo"
                                maxFileSize="5000" placeholder="{{__('webCaption.logo.title')}}" required="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <x-admin.form.inputs.text tooltip="{{__('webCaption.branch.caption')}}"
                                label="{{__('webCaption.branch.title')}}" maxlength="50" for="branch" name="branch"
                                placeholder="{{ __('webCaption.branch.title') }}"
                                value="{{old('branch', isset($data->branch)?$data->branch:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <x-admin.form.inputs.text tooltip="{{__('webCaption.swift_code.caption')}}"
                                label="{{__('webCaption.swift_code.title')}}" maxlength="20" for="swift_code"
                                name="swift_code" placeholder="{{ __('webCaption.swift_code.title') }}"
                                value="{{old('swift_code', isset($data->swift_code)?$data->swift_code:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <x-admin.form.inputs.text tooltip="{{__('webCaption.branch_code.caption')}}"
                                label="{{__('webCaption.branch_code.title')}}" maxlength="20" for="branch_code"
                                name="branch_code" placeholder="{{ __('webCaption.branch_code.title') }}"
                                value="{{old('branch_code', isset($data->branch_code)?$data->branch_code:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <x-admin.form.inputs.text tooltip="{{__('webCaption.iban_no.caption')}}"
                                label="{{__('webCaption.iban_no.title')}}" maxlength="30" for="iban_no" name="iban_no"
                                placeholder="{{ __('webCaption.iban_no.title') }}"
                                value="{{old('iban_no', isset($data->iban_no)?$data->iban_no:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="form-group">
                            <x-admin.form.inputs.textarea tooltip="{{__('webCaption.bank_address.caption')}}"
                                label="{{__('webCaption.bank_address.title')}}" maxlength="250" for="bank_address"
                                name="bank_address" placeholder="{{ __('webCaption.bank_address.title') }}"
                                value="{{old('bank_address', isset($data->bank_address)?$data->bank_address:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <x-admin.form.inputs.text tooltip="{{__('webCaption.association_bank.caption')}}"
                                label="{{__('webCaption.association_bank.title')}}" maxlength="50" for="name"
                                name="name" placeholder="{{ __('webCaption.association_bank.title') }}"
                                value="{{old('name', isset($data->name)?$data->name:'' )}}" required="required" />
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <x-admin.form.label for="" value="{{__('webCaption.display.title')}}" class=""
                                tooltip="{{__('webCaption.display.caption')}}" />
                            <div>
                                <div class="form-check form-check-inline">
                                    <x-admin.form.inputs.radio for="Yes" tooltip="{{__('webCaption.yes.caption')}}"
                                        class="border border-danger" name="display"
                                        label="{{__('webCaption.yes.title')}}" value="Yes" required="required"
                                        checked="{{ (old('display') == 'Yes') || (!isset($data->id))  ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'Yes' ? 'checked=checked' :'' :'' }} "
                                        required="required" />&ensp;

                                    <x-admin.form.inputs.radio for="No" class="border border-danger" name="display"
                                        tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}"
                                        value="No" required="required"
                                        checked="{{ old('display') == 'No' ? 'checked' : '' }} {{ isset($data->display) ? $data->display == 'No' ? 'checked=checked' :'' :'' }} "
                                        required="required" />&ensp;

                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

        @if((isset($data->parent_id)) && ($data->parent_id == 0) )

        @php
        $activeSiteLanguages = (isset($activeSiteLanguages)) ? $activeSiteLanguages : null;
        @endphp
        {{-- //this is showing for data form master data translation  --}}
        <x-admin.site-language :activeSiteLanguages="$activeSiteLanguages" :data="$data->title_languages"
            name="title_languages" readonly="readonly" />
        @endif
        <div class="text-center">
            <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
            @if(isset($data->id))
            <x-admin.form.buttons.update /> @else
            <x-admin.form.buttons.create /> @endif
        </div>
    </section>
</form>
@endsection