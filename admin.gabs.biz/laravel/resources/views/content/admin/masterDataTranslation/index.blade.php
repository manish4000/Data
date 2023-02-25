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
                    <form method="GET" action="{{route('language_translation.master_data_translation.index')}}">
                        <div class="d-flex justify-content-between align-items-center  row pt-0 pb-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <x-admin.form.inputs.text id="searchKeyword" for="{{__('webCaption.keyword.title')}}" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />

                                </div>
                            </div>
                            <div class="col-md-3">
                                <x-admin.form.buttons.search /> 
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
                    @if(count($data) > 0)
                    <div class="table-responsive">
                        <tr>
                            <td colspan="5">
                                {{ $data->onEachSide(5)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
                            </td>
                        </tr>  
    
                        <table class="table" id="master-list">
                            <thead>
                                <tr>
                                    <th class="position-for-filter-heading" > #  
                                        <x-admin.filter.order-by-filter-div orderBy="id" /> 
                                    </th>
                                    <th class="position-for-filter-heading"  title="{{__('webCaption.value.caption')}}"  data-toggle="tooltip"> {{__('webCaption.value.title')}}
                                        <x-admin.filter.order-by-filter-div orderBy="value" />
                                    </th>
                                    <th class="position-for-filter-heading"  title="{{__('webCaption.created_at.caption')}}"  data-toggle="tooltip"> {{__('webCaption.created_at.title')}}
                                        <x-admin.filter.order-by-filter-div orderBy="created_at" />
                                    </th>
                                    
                                    <th data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}" >{{__('webCaption.actions.title')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @can('main-navigation-masters-language-translation-master')
                                    @foreach($data as $item)
                                        @include('content.admin.masterDataTranslation.item-tr', ['item'=>$item])    
                                    @endforeach
                                @endcan                        
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        {{ $data->onEachSide(5)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}          
                                    </td>
                                </tr>                            
                            </tfoot>
                        </table>
                        
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

@include('components.admin.filter.order-by')
@endsection



 

