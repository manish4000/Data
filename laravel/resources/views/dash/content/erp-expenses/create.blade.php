@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.expenses.title') )
@else
@section('title', __('webCaption.expenses.title'))
@endif
@section('content')

<div>
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.charges.title')}}" class=""
                                tooltip="{{__('webCaption.charges.caption')}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.default_cost.title')}}" class=""
                                tooltip="{{__('webCaption.default_cost.caption')}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-8">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.actual_cost.title')}}" class=""
                                tooltip="{{__('webCaption.actual_cost.caption')}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.plus_minus.title')}}" class=""
                                tooltip="{{__('webCaption.plus_minus.caption')}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-8">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.sales_cost.title')}}" class=""
                                tooltip="{{__('webCaption.sales_cost.caption')}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.difference.title')}}" class=""
                                tooltip="{{__('webCaption.difference.caption')}}" required="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.cost_totals.title')}}" class=""
                                tooltip="{{__('webCaption.cost_totals.caption')}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-8">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="default_cost" 
                                tooltip="{{__('webCaption.default_cost.caption')}}" label="" class="form-control"
                                name="default_cost" placeholder="{{__('webCaption.default_cost.title')}}"
                                value="{{old('default_cost', isset($data->id)?$data->default_cost:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-8">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="actual_cost" 
                                tooltip="{{__('webCaption.actual_cost.caption')}}" label="" class="form-control"
                                name="actual_cost" placeholder="{{__('webCaption.actual_cost.title')}}"
                                value="{{old('actual_cost', isset($data->id)?$data->actual_cost:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-dash.form.buttons.custom color="btn-success" value="+" />
                            <x-dash.form.buttons.custom color="btn-danger" value="-" />
                        </div>
                    </div>
                    <div class="col-md-2 col-8">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="sales_costs" 
                                tooltip="{{__('webCaption.sales_costs.caption')}}" label="" class="form-control"
                                name="sales_costs" placeholder="{{__('webCaption.sales_costs.title')}}"
                                value="{{old('sales_costs', isset($data->id)?$data->sales_costs:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text for="difference" 
                                tooltip="{{__('webCaption.difference.caption')}}" label="" class="form-control"
                                name="difference" placeholder="{{__('webCaption.difference.title')}}"
                                value="{{old('difference', isset($data->difference)?$data->difference:'' )}}" required="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.refund.title')}}" class=""
                                tooltip="{{__('webCaption.refund.caption')}}" required="required" />
                        </div>
                    </div>
                    <div class="col-md-2 col-8">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="default_cost" 
                                tooltip="{{__('webCaption.default_cost.caption')}}" label="" class="form-control"
                                name="default_cost" placeholder="{{__('webCaption.default_cost.title')}}"
                                value="{{old('default_cost', isset($data->id)?$data->default_cost:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-8">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="actual_cost" 
                                tooltip="{{__('webCaption.actual_cost.caption')}}" label="" class="form-control"
                                name="actual_cost" placeholder="{{__('webCaption.actual_cost.title')}}"
                                value="{{old('actual_cost', isset($data->id)?$data->actual_cost:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-dash.form.buttons.custom color="btn-success" value="+" />
                            <x-dash.form.buttons.custom color="btn-danger" value="-" />
                        </div>
                    </div>
                    <div class="col-md-2 col-8">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="sales_costs" 
                                tooltip="{{__('webCaption.sales_costs.caption')}}" label="" class="form-control"
                                name="sales_costs" placeholder="{{__('webCaption.sales_costs.title')}}"
                                value="{{old('sales_costs', isset($data->id)?$data->sales_costs:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text for="difference" 
                                tooltip="{{__('webCaption.difference.caption')}}" label="" class="form-control"
                                name="difference" placeholder="{{__('webCaption.difference.title')}}"
                                value="{{old('difference', isset($data->difference)?$data->difference:'' )}}" required="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.profit_loss.title')}}" class=""
                                tooltip="{{__('webCaption.profit_loss.caption')}}" required="required" />
                        </div>
                    </div>
                    <div class="col-md-2 col-8">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="default_cost" 
                                tooltip="{{__('webCaption.default_cost.caption')}}" label="" class="form-control"
                                name="default_cost" placeholder="{{__('webCaption.default_cost.title')}}"
                                value="{{old('default_cost', isset($data->id)?$data->default_cost:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-8">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="actual_cost" 
                                tooltip="{{__('webCaption.actual_cost.caption')}}" label="" class="form-control"
                                name="actual_cost" placeholder="{{__('webCaption.actual_cost.title')}}"
                                value="{{old('actual_cost', isset($data->id)?$data->actual_cost:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-dash.form.buttons.custom color="btn-success" value="+" />
                            <x-dash.form.buttons.custom color="btn-danger" value="-" />
                        </div>
                    </div>
                    <div class="col-md-2 col-8">
                        <div class="form-group">
                            <x-dash.form.inputs.number for="sales_costs" 
                                tooltip="{{__('webCaption.sales_costs.caption')}}" label="" class="form-control"
                                name="sales_costs" placeholder="{{__('webCaption.sales_costs.title')}}"
                                value="{{old('sales_costs', isset($data->id)?$data->sales_costs:'' )}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <x-dash.form.inputs.text for="difference" 
                                tooltip="{{__('webCaption.difference.caption')}}" label="" class="form-control"
                                name="difference" placeholder="{{__('webCaption.difference.title')}}"
                                value="{{old('difference', isset($data->difference)?$data->difference:'' )}}" required="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection