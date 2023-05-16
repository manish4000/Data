@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.tax.title') )
@else
@section('title', __('webCaption.tax.title'))
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
                    {{__('webCaption.tax.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
		    <div class="card-body">
                <div class="row">
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        <x-dash.form.inputs.date  for="tax_change_date"  tooltip="{{__('webCaption.tax_change_date.caption')}}"  label="{{__('webCaption.tax_change_date.title')}}" name="tax_change_date"  placeholder="{{__('webCaption.tax_change_date.title')}}" value="{{old('tax_change_date', isset($data->tax_change_date)?$data->tax_change_date:'' )}}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-dash.form.inputs.number  for="tax_percentage"  tooltip="{{__('webCaption.tax_percentage.caption')}}"  maxlength="3" label="{{__('webCaption.tax_percentage.title')}}" name="tax_percentage"  placeholder="{{__('webCaption.tax_percentage.title')}}" value="{{old('tax_percentage', isset($data->tax_percentage)?$data->tax_percentage:'' )}}" />
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