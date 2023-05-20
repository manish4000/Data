@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.hs_code.title') )
@else
@section('title', __('webCaption.hs_code.title'))
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
                    {{__('webCaption.hs_code.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="hs_code"  tooltip="{{__('webCaption.hs_code.caption')}}" label="{{__('webCaption.hs_code.title')}}" maxlength="20" name="hs_code"  placeholder="{{__('webCaption.hs_code.title')}}" value="{{old('hs_code', isset($data->hs_code)?$data->hs_code:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="fuel"  tooltip="{{__('webCaption.fuel.caption')}}" label="{{__('webCaption.fuel.title')}}" name="fuel"  placeholder="{{__('webCaption.fuel.title')}}" value="{{old('fuel', isset($data->fuel)?$data->fuel:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="type"  tooltip="{{__('webCaption.type.caption')}}" label="{{__('webCaption.type.title')}}" name="type"  placeholder="{{__('webCaption.type.title')}}" value="{{old('type', isset($data->type)?$data->type:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="engine_cc"  tooltip="{{__('webCaption.engine_cc.caption')}}" label="{{__('webCaption.engine_cc.title')}}" maxlength="5" name="engine_cc"  placeholder="{{__('webCaption.engine_cc.title')}}" value="{{old('engine_cc', isset($data->engine_cc)?$data->engine_cc:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.number  for="year"  tooltip="{{__('webCaption.year.caption')}}" label="{{__('webCaption.year.title')}}" maxlength="4" name="year"  placeholder="{{__('webCaption.year.title')}}" value="{{old('year', isset($data->year)?$data->year:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="carrying_capacity_kg"  tooltip="{{__('webCaption.carrying_capacity_kg.caption')}}" label="{{__('webCaption.carrying_capacity_kg.title')}}" maxlength="10" name="carrying_capacity_kg"  placeholder="{{__('webCaption.carrying_capacity_kg.title')}}" value="{{old('carrying_capacity_kg', isset($data->carrying_capacity_kg)?$data->carrying_capacity_kg:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="gross_weight_kg"  tooltip="{{__('webCaption.gross_weight_kg.caption')}}" label="{{__('webCaption.gross_weight_kg.title')}}" maxlength="10" name="gross_weight_kg"  placeholder="{{__('webCaption.gross_weight_kg.title')}}" value="{{old('gross_weight_kg', isset($data->gross_weight_kg)?$data->gross_weight_kg:'' )}}" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea  for="admin_memo"  tooltip="{{__('webCaption.admin_memo.caption')}}" label="{{__('webCaption.admin_memo.title')}}" maxlength="500" name="admin_memo"  placeholder="{{__('webCaption.admin_memo.title')}}" value="{{old('admin_memo', isset($data->admin_memo)?$data->admin_memo:'' )}}" />
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