@extends('layouts/contentLayoutMaster')
@section('title', $pageConfigs['moduleName'])
@section('content')
<!-- users list start -->
<section class="app-user-list">
  <div class="row">
    <div class="col-12">
            <!-- filter  -->
      <div class="card">
        <div class="card-header">
          <h4 class="card-title" data-toggle="tooltip" data-placement="right" title="{{__('webCaption.search_filter.caption')}}">{{__('webCaption.search_filter.title')}}</h4>                    
        </div>
        <div class="card-body">
          <form method="GET" action="{{route('company.plans.index')}}">
            <div class="d-flex justify-content-between align-items-center row pt-0 pb-2">
                <div class="col-md-3">
                    <div class="form-group">
                        <x-admin.form.inputs.text id="searchKeyword" for="searchKeyword" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
                    </div>
                </div>
                <div class="col-md-3">
                    <x-admin.form.buttons.search />
                    <x-admin.form.buttons.reset  href="{{route('company.plans.index')}}"/>
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
          <div class="card-body">
          
            @if(count($data) > 0 )
                <div class="table-responsive">
                    <div class="mt-2">
                        {{ $data->onEachSide(5)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
                    </div>
                    <div class="px-2 my-2">
                        {{-- deleteMultiple() for delete multiple data pass url here  --}}
                        <x-admin.form.buttons.multipleDelete url="{{route('company.plans.delete-multiple')}}" />
                    </div>
                    <table class="table" id="master-list">
                        <thead>
                          <tr>
                                <th> <x-admin.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>
                                <th class="position-for-filter-heading"># 
                                    <x-admin.filter.order-by-filter-div orderBy="id" />
                                </th>                                                
                                <th  data-toggle="tooltip" title="{{__('webCaption.title.caption')}}" class="position-for-filter-heading"> {{__('webCaption.title.title')}}   <x-admin.filter.order-by-filter-div orderBy="title" />
                                </th>
                                <th  data-toggle="tooltip" title="{{__('webCaption.slug.caption')}}" class="position-for-filter-heading"> {{__('webCaption.slug.title')}}   <x-admin.filter.order-by-filter-div orderBy="slug" />
                                </th>
                                <th data-toggle="tooltip" title="{{__('webCaption.order.caption')}}" class="position-for-filter-heading" l> {{__('webCaption.order.title')}} 
                                    <x-admin.filter.order-by-filter-div orderBy="order_by" />
                                </th>
                                <th data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}" >{{__('webCaption.actions.title')}}
                                </th>
                          </tr>
                        </thead>
                        <tbody>
                        
                            @foreach($data as $item)
                                @include('content.admin.company.plans.itemTr', ['item'=>$item])    
                            @endforeach   
                                        
                        </tbody>                            
                    </table>
                    <div class="mt-2">
                        {{ $data->onEachSide(5)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
                    </div>
                </div>
            @else
                <div class="text-center my-2">
                    <h3>{{__('webCaption.record_not_found.title')}} </h3>
                </div>
            @endif    
        
           </div>
        </div>    
    </div>
  </div>     
   
<!-- list section end -->
</section>

{{-- this file include for delete alert box  --}}
@include('components.admin.alerts.delete-alert-box')
@include('components.admin.alerts.multiple-delete-alert-box')
@include('components.admin.filter.order-by')
<!-- users list ends -->

@endsection



 

