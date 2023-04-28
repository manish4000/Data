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
                    <form method="GET" action="{{route('company.index')}}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <x-admin.form.inputs.text id="searchKeyword" for="{{__('webCaption.keyword.title')}}" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
        
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <x-admin.form.inputs.select tooltip="{{__('webCaption.country.caption')}}" label="{{__('webCaption.country.title')}}" id="search[country]"  for="search[country]" name="search[country]" value="" editSelected="{{request()->input('search.country')}}" required="" :optionData="$country" />
        
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <x-admin.form.inputs.select tooltip="{{__('webCaption.status.caption')}}" label="{{__('webCaption.status.title')}}" id="search[status]"  for="search[status]" name="search[status]" value="" editSelected="{{request()->input('search.status')}}" required="" :optionData="$status" />
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-6 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <x-admin.form.inputs.select tooltip="{{__('webCaption.plan.caption')}}" label="{{__('webCaption.plan.title')}}" id="search[plan]"  for="search[plan]" name="search[plan]" value="" editSelected="{{request()->input('search.plan')}}" required="" :optionData="$plans" />
        
                                        </div>
                                        </div>

                                        <div class="col-6 col-md-6 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <x-admin.form.inputs.select tooltip="{{__('webCaption.business_type.caption')}}" label="{{__('webCaption.business_type.title')}}" id="search[business_type]"  for="search[business_type]" name="search[business_type]" value="" editSelected="{{request()->input('search.business_type')}}" required="" :optionData="$BusinessTypes" />
                                        </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                                            <x-admin.form.buttons.search /> 
                                            <x-admin.form.buttons.reset href="{{route('company.index')}}"/>
                                       </div>

                                </div>
                               
                            </div>
                            
                           
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">    
                <div class="card-body">
                    @if(count($data) > 0 )
                        <!-- Basic Tables start -->
                        <div class="table-responsive">
                            <div class="mt-2">
                                {{ $data->onEachSide(2)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
                            </div>
                            @can('main-navigation-company-delete')
									<div class="px-2 my-2">
										{{-- deleteMultiple() for delete multiple data pass url here  --}}
										<x-admin.form.buttons.multipleDelete url="{{route('company.delete-multiple')}}" />
									</div>
							@endcan
                            <table class="table" id="master-list">
                                <thead>
                                    <tr>
                                        <th> <x-admin.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>	
                                        <th class="position-for-filter-heading"># 
                                            <x-admin.filter.order-by-filter-div orderBy="id" />

                                        {{-- <th data-toggle="tooltip" title="{{__('webCaption.name.caption')}}" class="position-for-filter-heading"> {{__('webCaption.name.title')}}   <x-admin.filter.order-by-filter-div orderBy="name" />  --}}
                                         
                                        <th data-toggle="tooltip" title="{{__('webCaption.company_name.caption')}}" class="position-for-filter-heading"> {{__('webCaption.company_name.title')}}   <x-admin.filter.order-by-filter-div orderBy="company_name" />    

                                        <th data-toggle="tooltip" title="{{__('webCaption.email.caption')}}" class="position-for-filter-heading"> {{__('webCaption.email.title')}}   <x-admin.filter.order-by-filter-div orderBy="email" />    

                                        <th data-toggle="tooltip" title="{{__('webCaption.status.caption')}}" class="position-for-filter-heading"> {{__('webCaption.status.title')}}   <x-admin.filter.order-by-filter-div orderBy="status" />  

                                        {{-- <th data-toggle="tooltip" title="{{__('webCaption.created_by.caption')}}" class="position-for-filter-heading"> {{__('webCaption.created_by.title')}}   <x-admin.filter.order-by-filter-div orderBy="created_by" />     --}}

                                        <th data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}" >{{__('webCaption.actions.title')}}
                                        </th>   
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($data as $item)
                                        @include('content.admin.company.item-tr', ['item'=>$item])           
                                    @endforeach                        

                                </tbody>
                                
                            </table>
                            <div class="mt-2">
                                {{ $data->onEachSide(2)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
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

@include('components.admin.alerts.delete-alert-box')
@include('components.admin.filter.order-by')
@include('components.admin.alerts.multiple-delete-alert-box')

<!-- users list ends -->
@endsection


@push('script')
<script>
    function submitLogin(id) {
        var form = document.getElementById(id);
        form.submit();
    }
</script>

@endpush
