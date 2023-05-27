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
          <form method="GET" action="{{route('dashmasters.common.yards.index')}}">
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
                <div class="col-5 col-sm-3 col-md-3 col-lg-2 col-xl-2">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <x-dash.form.label for=""  value="{{__('webCaption.parent_only.title')}}" class="" tooltip="{{__('webCaption.parent_only.caption')}}" />

                                <x-dash.form.inputs.checkbox for="searchParentOnlyShowAll"  name="search[parentOnlyShowAll]" tooltip="{{__('webCaption.show_all.caption')}}" label="{{__('webCaption.show_all.title')}}" checked="{{ (request()->input('search.parentOnlyShowAll') == 1)  ?'checked' :''; }}"  value="1"  customClass="form-check-input"  />
                                
                            </div>
                        </div>
                        
                    </div> 
                </div>
                <div class="col-md-12 pt-0 text-center">
                    <x-dash.form.buttons.search />
                    <x-dash.form.buttons.reset href="{{route('dashmasters.common.yards.index')}}" />
                </div>
            </div>
          </form>
        </div>
      </div>    
        @php
        $request_params = request()->all();
        unset( $request_params['order'], $request_params['order_by'] );

        $permission_and_urls = [
                                  'multiple_delete' => ['url' => route('dashmasters.common.yards.delete-multiple'), 'permission' => 'masters-common-yards-delete']                               
                                ]; 
        @endphp
                    
        <div class="card">
        <!-- Basic Tables start -->
          <div class="card-body pt-75 pb-0 px-50">
            @if (Auth::guard('dash')->user()->can('masters-common-yards'))
                @if(count($data) > 0 )
                    {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4-dash', [ 'permission_and_urls' => $permission_and_urls  ] ) }}
                    <div class="main_table mb-2" id="master-list">
                        @php
                        $heading_array = [
                                        [
                                            'title' => 'id',
                                            'orderby' => 'id',
                                            'classes' => 'width_5'
                                        ] , 
                                        [
                                            'title' => 'yards',
                                            'orderby' => 'name',
                                            'classes' => 'width_50'
                                        ] , 
                                        [
                                            'title' => 'no_of_children',
                                            'orderby' => 'children_count',
                                            'classes' => 'width_15 text-center'
                                        ] , 
                                        [
                                            'title' => 'display_status',
                                            'orderby' => 'display',
                                            'classes' => 'width_15 text-center'
                                        ] , 
                                        [
                                            'title' => 'actions',
                                            'orderby' => null,
                                            'classes' => 'width_15 text-center'
                                        ]  
                                    ];
                        @endphp

                        <x-dash.table.table-heading :headingFields="$heading_array"/> 
                        @foreach($data as $item)
                            @include('dash.content.masters.common.yards.item-tr', ['item'=>$item])    
                            @if( true || request()->input('search.parentOnlyShowAll') == 1)
                                @foreach($item->children as $childItem)
                                    @include('dash.content.masters.common.yards.item-tr', ['item'=>$childItem])    
                                @endforeach 
                            @endif
                        @endforeach  
                    </div>
                    @if (Auth::guard('dash')->user()->can('masters-common-yards-delete'))		
                    {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4-dash', [ 'permission_and_urls' => $permission_and_urls  ] ) }}  
                    @else
                
                        {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4-dash') }}  
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