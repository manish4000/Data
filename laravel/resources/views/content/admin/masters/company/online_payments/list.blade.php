@extends('layouts/contentLayoutMaster')
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
          <form method="GET" action="{{route('masters.company.online-payments.index')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <x-admin.form.inputs.text id="searchKeyword" for="{{__('webCaption.keyword.title')}}" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
                    </div>
                </div>
                <div class="col-md-12 pt-0 text-center">
                    <x-admin.form.buttons.search />
                    <x-admin.form.buttons.reset href="{{route('masters.company.online-payments.index')}}" />
                </div>
            </div>
          </form>
        </div>
      </div> 

       @php
 
        //send permission slug and url for multiple update and delete and more... for actions 
        $permission_and_urls = [
                'multiple_delete' => ['url' => route('masters.company.online-payments.delete-multiple') ,
                                    'permission' => 'masters-company-online-payments-delete'],

                'multiple_update' => ['url' => route('masters.company.online-payments.update-multiple') ,
                                     'permission' => 'masters-company-online-payments-update']                               
            ];                          
        @endphp
                    
        <div class="card">
        <!-- Basic Tables start -->
          <div class="card-body pt-75 pb-0 px-50">
          @can('masters-company-online-payments') 
                @if(count($data) > 0 )
                   		
             {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4', [ 'permission_and_urls' => $permission_and_urls  ] )}} 
                  
                {{--check delete permission  --}}          
            <div class="main_table mb-2" id="master-list">
            @php
            $heading_array = [
                            [
                                'title' => 'id',
                                'orderby' => 'id',
                                'classes' => 'width_5'
                            ] , 
                            [
                                'title' => 'online_payments',
                                'orderby' => 'name',
                                'classes' => 'width_80'
                            ] , 
                            [
                                'title' => 'actions',
                                'orderby' => null,
                                'classes' => 'width_15 text-center'
                            ]  
                        ];
            @endphp

            <x-admin.table.table-heading :headingFields="$heading_array"/>                
                         
                @foreach($data as $item)
                    @include('content.admin.masters.company.online_payments.item-tr', ['item'=>$item])    
                        
                @endforeach      
                                                                               
             </div>                   

                {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4', [ 'permission_and_urls' => $permission_and_urls  ] )}} 

                    @else 
                        @include('components.admin.alerts.no-record-found')                    
                    @endif    
                @endcan
            </div>
        </div>
<!-- list section end -->
</section>

{{-- this file include for delete alert box  --}}

@include('components.admin.alerts.delete-alert-box')
@include('components.admin.alerts.reference-model-box')
@include('components.admin.alerts.multiple-delete-alert-box')
@include('components.admin.filter.order-by')
<!-- users list ends -->

@endsection
 
