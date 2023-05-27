
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
					<form method="GET" action="{{route('dashtestimonial.index')}}">
						<div class="d-flex justify-content-between align-items-center  row pt-0 pb-2">
							<div class="col-md-7">
								<div class="form-group">
									<x-admin.form.inputs.text id="searchKeyword" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}" for="{{__('webCaption.keyword.title')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
								</div>
							</div>
							
							<div class="col-md-3">
								<x-dash.form.buttons.search />
								<x-dash.form.buttons.reset href="{{route('dashtestimonial.index')}}" />
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
								{{ $data->onEachSide(1)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
							</div>
							@if (Auth::guard('dash')->user()->can('common-testimonial-delete'))	
								<div class="px-2 my-2">
									{{-- deleteMultiple() for delete multiple data pass url here  --}}
									<x-dash.form.buttons.multipleDelete url="{{route('dashtestimonial.delete-multiple')}}" />
								</div>
							@endif	

							{{--  --}}


							<table class="table">
								<thead>
								<tr>
                                    <th> <x-dash.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>
									<th scope="col" class="position-for-filter-heading">#
										<x-dash.filter.order-by-filter-div orderBy="id" />
									</th>
									<th class="position-for-filter-heading" scope="col" data-toggle="tooltip" title="{{__('webCaption.title.caption')}}" >
										{{__('webCaption.title.title')}}
										<x-dash.filter.order-by-filter-div orderBy="title" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.person_name.caption')}}" >
										{{__('webCaption.person_name.title')}}
										<x-dash.filter.order-by-filter-div orderBy="person_name" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.email.caption')}}" >
										{{__('webCaption.email.title')}}
										<x-dash.filter.order-by-filter-div orderBy="email" />
									</th>
									<th scope="col"  data-toggle="tooltip" title="{{__('webCaption.country.caption')}}" >
										{{__('webCaption.country.title')}}
										
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.posted_date.caption')}}" >
										{{__('webCaption.posted_date.title')}}
										<x-dash.filter.order-by-filter-div orderBy="posted_date" />
									</th>
									
									<th scope="col" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}"  > {{__('webCaption.actions.title')}}</th>
								</tr>
								</thead>
								<tbody>

									@foreach ($data as $details)
                                        @include('dash.content.testimonial.item-tr', ['item'=>$details]) 
									@endforeach

								</tbody>
							</table>
							<div class="mt-2">
								{{ $data->onEachSide(1)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
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


