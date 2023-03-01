
@extends('dash/layouts/LayoutMaster')
@section('title', $pageConfigs['moduleName'])
@section('content')
<div >
	<div class="row">
		<div class="col-md-12 m-auto">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" title="{{__('webCaption.search_filter.caption')}}"  data-toggle="tooltip" > {{__('webCaption.search_filter.title')}} </h4>                    
				</div>
				<div class="card-body">
					<form method="GET" action="{{route('dashbank-details.index')}}">
						<div class="d-flex justify-content-between align-items-center  row pt-0 pb-2">
							<div class="col-md-3">
								<div class="form-group">
									<x-admin.form.inputs.text id="searchKeyword" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}" for="{{__('webCaption.keyword.title')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
								</div>
							</div>
							
							<div class="col-md-3">
								<x-dash.form.buttons.search />
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="card card-default">
				<div class="card-body">
					@if(count($data) > 0) 
						<div class="table-responsive">
							<div class="mt-2">
								{{ $data->onEachSide(5)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
							</div>
                            <div class="px-2 my-2">
                                {{-- deleteMultiple() for delete multiple data pass url here  --}}
                                <x-dash.form.buttons.multipleDelete url="{{route('dashbank-details.delete-multiple')}}" />
                            </div>
							<table class="table">
								<thead>
								<tr>
                                    <th> <x-dash.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>
									<th scope="col" class="position-for-filter-heading">#
										<x-dash.filter.order-by-filter-div orderBy="id" />
									</th>
									<th class="position-for-filter-heading" scope="col" data-toggle="tooltip" title="{{__('webCaption.bank_name.caption')}}" >
										{{__('webCaption.bank_name.title')}}
										<x-dash.filter.order-by-filter-div orderBy="bank_name" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.dealer_name.caption')}}" >
										{{__('webCaption.dealer_name.title')}}
										<x-dash.filter.order-by-filter-div orderBy="dealer_name" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.dealer_name.caption')}}" >
										{{__('webCaption.branch_name.title')}}
										<x-dash.filter.order-by-filter-div orderBy="branch_name" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.branch_name.caption')}}" >
										{{__('webCaption.account_name.title')}}
										<x-dash.filter.order-by-filter-div orderBy="account_name" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.account_name.caption')}}" >
										{{__('webCaption.account_number.title')}}
										<x-dash.filter.order-by-filter-div orderBy="account_number" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.jumvea_account.caption')}}" >
										{{__('webCaption.jumvea_account.title')}}
										<x-dash.filter.order-by-filter-div orderBy="jumvea_account" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.swift_code.caption')}}" >
										{{__('webCaption.swift_code.title')}}
										<x-dash.filter.order-by-filter-div orderBy="swift_code" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.status.caption')}}" >
										{{__('webCaption.status.title')}}
										<x-dash.filter.order-by-filter-div orderBy="status" />
									</th>
									<th scope="col" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}"  > {{__('webCaption.actions.title')}}</th>
								</tr>
								</thead>
								<tbody>

									@foreach ($data as $details)
                                        @include('dash.content.bankDetails.item-tr', ['item'=>$details]) 
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
</div>

{{-- this file include for delete alert box  --}}
@include('components.dash.alerts.delete-alert-box')
@include('components.dash.alerts.multiple-delete-alert-box')
@include('components.dash.filter.order-by')
<!-- users list ends -->
@stop


@push('script')
<script src="{{ asset('assets/js/gabs/master.js') }}"></script>
@endpush
