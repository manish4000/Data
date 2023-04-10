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
                    <form method="GET" action="{{route('common.country.index')}}">

                        <div class="d-flex justify-content-between align-items-center  row pt-0 pb-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <x-admin.form.inputs.text id="searchKeyword" for="{{__('webCaption.keyword.title')}}" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
                                </div>
                            </div>

                            <div class="col-md-3">
                                <x-admin.form.buttons.search /> 
                                <x-admin.form.buttons.reset href="{{route('common.country.index')}}" />
                            </div>
                            
                        </div>

                        
                    </form>
                </div>
            </div>    
                @php
                $request_params = request()->all();
                unset( $request_params['order'], $request_params['order_by'] );
                @endphp

            <div class="card" >
                <!-- Basic Tables start -->
                <div class="card-body">
                    @can('main-navigation-masters-language-translation-caption')
                        @if(count($data) > 0 )
                        <div class="table-responsive">
                                    @php
                                    $request_params = request()->all();
                                    unset( $request_params['perPage'] );
                                    @endphp

                                    <div class="mb-1 mx-3">
                                        
                                    {{ $data->onEachSide(5)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}   

                                </div>

                            <table class="table" id="master-list">
                                <thead>
                                    <tr>
                                        <th class="position-for-filter-heading">#
                                            <x-admin.filter.order-by-filter-div orderBy="id" /> 
                                        </th>
                                        
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.name.caption')}}">  {{__('webCaption.name.title')}}
                                            <x-admin.filter.order-by-filter-div orderBy="name" /> 
                                        </th>
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.country_code.caption')}}">
                                            {{__('webCaption.country_code.title')}}
                                            <x-admin.filter.order-by-filter-div orderBy="country_code" /> 
                                        </th>
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.phone_code.caption')}}">{{__('webCaption.phone_code.title')}}
                                            <x-admin.filter.order-by-filter-div orderBy="phone_code" /> 
                                        </th>
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.region.caption')}}">{{__('webCaption.region.title')}}
                                            <x-admin.filter.order-by-filter-div orderBy="region" /> 
                                        </th>

                                        <th data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}">{{__('webCaption.actions.title')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($data as $item)
                                            @include('content.admin.common.country.item-tr', ['item'=>$item])    
                                        @endforeach               
                                </tbody>
                                
                            </table>

                                    <div class="my-1 mx-3">
                                        {{ $data->onEachSide(5)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}   
                                    </div>
                                                        
                        </div>
                        @else
                        <div class="text-center my-2">
                            <h3>{{__('webCaption.record_not_found.title')}} </h3>
                        </div>
                        @endif
                    @endcan    
                </div>

            </div>

            </div>
        </div>     
    </div>
   
<!-- list section end -->
</section>

{{-- this file include for delete alert box  --}}
@include('components.admin.alerts.delete-alert-box')
@include('components.admin.filter.order-by')
<!-- users list ends -->

@endsection



 

