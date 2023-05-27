@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.online_payments.title'). ' ' .__('webCaption.edit.title') )
@else
@section('title', __('webCaption.online_payments.title').' '. __('webCaption.add.title') )
@endif

@section('content')
@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif
<form action="{{ route('masters.company.online-payments.store')}}" method="POST" enctype="multipart/form-data" >
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
                    {{__('webCaption.online_payments.title'). ' ' .__('webCaption.edit.title')  }}
                    @else
                    {{  __('webCaption.online_payments.title').' '. __('webCaption.add.title')}}
                    @endif
                </h4>
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <x-admin.form.inputs.text tooltip="{{__('webCaption.online_payments.caption')}}"
                                label="{{__('webCaption.online_payments.title')}}" maxlength="50" for="name" name="name"
                                placeholder="{{ __('webCaption.online_payments.title') }}"
                                value="{{old('name', isset($data->name)?$data->name:'' )}}" required="required" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            @php
                            $editImageUrl = (isset($data->logo)) ? "dash/online_payments/".$data->logo : '';
                            @endphp
                            <x-admin.form.inputs.file id="" caption="{{__('webCaption.logo.title')}}"
                                editImageUrl="{{$editImageUrl}}" ImageId="logo-preview" for="logo" name="logo"
                                maxFileSize="5000" placeholder="{{__('webCaption.logo.title')}}" required="required" />
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <x-admin.form.inputs.text tooltip="{{__('webCaption.commission.caption')}}"
                                label="{{__('webCaption.commission.title')}}" maxlength="2" for="commission"
                                name="commission" placeholder="{{ __('webCaption.commission.title') }}"
                                value="{{old('commission', isset($data->commission)?$data->commission:'' )}}"
                                required="" />
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <x-admin.form.inputs.textarea tooltip="{{__('webCaption.description.caption')}}"
                                label="{{__('webCaption.description.title')}}" maxlength="1000" for="description" name="description"
                                placeholder="{{ __('webCaption.description.title') }}"
                                value="{{old('description', isset($data->description)?$data->description:'' )}}" required="" />
                        </div>
                    </div>
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