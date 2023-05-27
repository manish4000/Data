
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
			<form method="GET" action="{{route('dashusers.index')}}">
				<div class="row">
					<div class="col-sm-3 col-md-5 col-lg-7 col-xl-7">
						<div class="form-group">
							<x-admin.form.inputs.text id="searchKeyword" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}" for="{{__('webCaption.keyword.title')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
						</div>
					</div>
					<div class="col-7 col-sm-3 col-md-4 col-lg-3">
						<div class="form-group">
							<x-dash.form.inputs.select label="{{__('webCaption.status.title')}}" tooltip="{{__('webCaption.status.caption')}}"   for="{{__('webCaption.status.title')}}" name="search[status]" placeholder="{{ __('locale.status.caption') }}" editSelected="{{ request()->input('search.status')}}"  required="" :optionData="$status" />
						</div>
					</div>
					<div class="col-md-12 pt-0 text-center">
						<x-dash.form.buttons.search />
						<x-dash.form.buttons.reset  href="{{route('dashusers.index')}}"/>
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
          @if (Auth::guard('dash')->user()->can('common-users'))
                @if(count($users) > 0 )
                    @if (Auth::guard('dash')->user()->can('common-users-delete'))		
                        {{ $users->onEachSide(1)->links('vendor.pagination.bootstrap-4',['multiple_delete_url' =>
                         route('dashusers.delete-multiple') ] ) }} 
                    @else
                        {{ $users->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}  
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
                                            'title' => 'name',
                                            'orderby' => 'name',
                                            'classes' => 'width_44'
                                        ] , 
                                        
                                        [
                                            'title' => 'actions',
                                            'orderby' => null,
                                            'classes' => 'width_12 text-center'
                                        ]  
                                    ];
                        @endphp

                        <x-dash.table.table-heading :headingFields="$heading_array"/> 
                      

                            @foreach($users as $user)
                                @include('dash.content.users.item-tr', ['item'=>$user])    
                            @endforeach

                        </tbody> 
                    </div>
                    @if (Auth::guard('dash')->user()->can('common-users-delete'))		
                        {{ $users->onEachSide(1)->links('vendor.pagination.bootstrap-4',['multiple_delete_url' => route('dashusers.delete-multiple') ] ) }}  
                    @else
                        {{ $users->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}  
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

