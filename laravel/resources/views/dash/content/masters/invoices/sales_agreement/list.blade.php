@extends('dash/layouts/LayoutMaster')
@section('title', $pageConfigs['moduleName'])

@section('content')
<!-- users list start -->
<section>
     <!-- filter  -->
      <div class="card">
        <div class="card-header py-75 px-50">
          <h4 class="card-title" data-toggle="tooltip" data-placement="right" title="{{__('webCaption.search_filter.caption')}}">{{__('webCaption.search_filter.title')}}</h4>                    
        </div>
        <hr class="m-0 p-0">
        <div class="card-body pt-75 pb-75 px-50">
          <form method="GET" action="{{route('dashmasters.invoices.sales-agreement.index')}}">
            <div class="row">
                <div class="col-sm-3 col-md-5 col-lg-7 col-xl-7">
                    <div class="form-group">
                        <x-dash.form.inputs.text id="searchKeyword" for="{{__('webCaption.keyword.title')}}" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
                    </div>
                </div>
                <div class="col-7 col-sm-3 col-md-4 col-lg-3" >
                    <div class="form-group">
                        <x-dash.form.label for="" value="{{__('webCaption.display_status.title')}}" class="" tooltip="{{__('webCaption.display_status.caption')}}" />
                        <div>
                            <div class="form-check-inline">
                                <x-dash.form.inputs.radio for="searchDisplayStatusOn" class="border border-danger" name="search[displayStatus]" tooltip="{{__('webCaption.yes.caption')}}" label="{{__('webCaption.yes.title')}}" value="Yes"  required=""  checked="{{ (request()->input('search.displayStatus') ) == 'Yes' ? 'checked' : '' }}" required="" />&ensp;
                                    
                                <x-dash.form.inputs.radio for="searchDisplayStatusOff" class="border border-danger" name="search[displayStatus]" label="{{__('webCaption.no.title')}}" tooltip="{{__('webCaption.no.caption')}}" value="No"  required=""  checked="{{ (request()->input('search.displayStatus') ) == 'No' ? 'checked' : '' }}" required="" />&ensp;

                                <x-dash.form.inputs.radio for="searchDisplayStatusAll" class="border border-danger" name="search[displayStatus]" label="{{__('webCaption.all.title')}}" tooltip="{{__('webCaption.all.caption')}}" value=""  required=""  checked="{{  ( (request()->input('search.displayStatus') ) == null ) || ( (request()->input('search.displayStatus') ) == '' )  ? 'checked' : '' }}" required="" />&ensp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 pt-0 text-center">
                    <x-dash.form.buttons.search />
                    <x-dash.form.buttons.reset href="{{route('dashmasters.invoices.sales-agreement.index')}}" />
                </div>
            </div>
          </form>
        </div>
      </div>    
        @php
        $request_params = request()->all();
        unset( $request_params['order'], $request_params['order_by'] );
        @endphp
                    
        <div class="card">
        <!-- Basic Tables start -->
          <div class="card-body pt-75 pb-0 px-50">
          @if (Auth::guard('dash')->user()->can('masters-invoices-sales-agreement')) 
                @if(count($data) > 0 ) 
                    @if (Auth::guard('dash')->user()->can ('masters-invoices-sales-agreement-delete'))		
                        {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4', ['multiple_delete_url' => route('dashmasters.invoices.sales-agreement.delete-multiple') ] ) }}  
                    @else
                        {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}  
                    @endif
                    <div class="main_table mb-2" id="master-list">
                        @php
                        $heading_array = [
                                        [
                                            'title' => 'id',
                                            'orderby' => 'id',
                                            'classes' => 'width_5'
                                        ] , 
                                        [
                                            'title' => 'sales_agreement',
                                            'orderby' => 'name',
                                            'classes' => 'width_22'
                                        ] , 
                                        [
                                            'title' => 'description',
                                            'orderby' => 'description',
                                            'classes' => 'width_22'
                                        ] ,
                                        [
                                            'title' => 'display_status',
                                            'orderby' => 'display',
                                            'classes' => 'width_15 '
                                        ] , 
                                        [
                                            'title' => 'actions',
                                            'orderby' => null,
                                            'classes' => 'width_12 text-center'
                                        ]  
                                    ];
                        @endphp

                        <x-dash.table.table-heading :headingFields="$heading_array"/>
                        @foreach($data as $item)
                            @include('dash.content.masters.invoices.sales_agreement.item-tr', ['item'=>$item])
                        @endforeach  
                    </div>
                    @if (Auth::guard('dash')->user()->can('masters-invoices-sales-agreement-delete'))		
                        {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4',['multiple_delete_url' => route('dashmasters.invoices.sales-agreement.delete-multiple') ] ) }}  
                    @else
                        {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}  
                    @endif

                    @else    
                        @include('components.dash.alerts.no-record-found')                    
                    @endif   
                @endcan    

            </div>
        </div>    
   
<!-- list section end -->
</section>

{{-- this file include for delete alert box  --}}
@include('components.dash.alerts.delete-alert-box')
@include('components.dash.alerts.multiple-delete-alert-box')
@include('components.dash.filter.order-by')
<!-- users list ends -->

@endsection