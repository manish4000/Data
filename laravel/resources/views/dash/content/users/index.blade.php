
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
					<form method="GET" action="{{route('dashusers.index')}}">
						<div class="d-flex justify-content-between align-items-center  row pt-0 pb-2">
							<div class="col-md-3">
								{{-- <div class="form-group">
									<label for="keyword" title="{{__('webCaption.keyword.caption')}}"  data-toggle="tooltip"> {{__('webCaption.keyword.title')}} </label>
									<input type="text" class="form-control" id="searchKeyword" placeholder="Keyword" name="search[keyword]" value="{{ request()->input('search.keyword') }}" />
								</div> --}}

								<div class="form-group">
									<x-admin.form.inputs.text id="searchKeyword" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}" for="{{__('webCaption.keyword.title')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
								</div>

							</div>
							<div class="col-md-3">
								<div class="form-group">
									<x-dash.form.inputs.select label="{{__('webCaption.status.title')}}" tooltip="{{__('webCaption.status.caption')}}"   for="{{__('webCaption.status.title')}}" name="search[status]" placeholder="{{ __('locale.status.caption') }}" editSelected="{{ request()->input('search.status')}}"  required="" :optionData="$status" />
								</div>
							</div>
							<div class="col-md-3">
								<x-dash.form.buttons.search />
								<x-dash.form.buttons.reset  href="{{route('dashusers.index')}}"/>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="card card-default">
				<div class="card-body">
					@if(count($users) > 0) 
						<div class="table-responsive">
							<div class="mt-2">
								{{ $users->onEachSide(5)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
							</div>
							<table class="table">
								<thead>
								<tr>
									<th scope="col" class="position-for-filter-heading">#
										<x-dash.filter.order-by-filter-div orderBy="id" />
									</th>
									<th class="position-for-filter-heading" scope="col" data-toggle="tooltip" title="{{__('webCaption.name.caption')}}" >
										{{__('webCaption.name.title')}}
										<x-dash.filter.order-by-filter-div orderBy="name" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.email.caption')}}" >
										{{__('webCaption.email.title')}}
										<x-dash.filter.order-by-filter-div orderBy="email" />
									</th>
									<th scope="col" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}"  > {{__('webCaption.actions.title')}}</th>
								</tr>
								</thead>
								<tbody>

									@foreach ($users as $user)
										<tr>
											<th scope="row">{{$user->id}}</th>
											<td>{{ $user->name; }}</td>
											<td>{{ $user->email }}</td>
											<td>
												@if (Auth::guard('dash')->user()->can('common_users_edit'))		
												<x-dash.form.buttons.edit href="{{ route('dashusers.edit', $user->id) }}" />&ensp;
												@endif
												@if (Auth::guard('dash')->user()->can('common_users_delete'))	
												<x-dash.form.buttons.delete id="{{$user->id}}" name="{{$user->name}}" url="{{route('dashusers.delete')}}" action="{{route('users.delete', $user->id) }}" />   
												@endif	
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							<div class="mt-2">
								{{ $users->onEachSide(5)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
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
@include('components.dash.alerts.delete-alert-box')
@include('components.dash.filter.order-by')
@stop
