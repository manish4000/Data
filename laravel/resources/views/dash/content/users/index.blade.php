
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
							<div class="col-md-7">
								{{-- <div class="form-group">
									<label for="keyword" title="{{__('webCaption.keyword.caption')}}"  data-toggle="tooltip"> {{__('webCaption.keyword.title')}} </label>
									<input type="text" class="form-control" id="searchKeyword" placeholder="Keyword" name="search[keyword]" value="{{ request()->input('search.keyword') }}" />
								</div> --}}

								<div class="form-group">
									<x-admin.form.inputs.text id="searchKeyword" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}" for="{{__('webCaption.keyword.title')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
								</div>

							</div>
							<div class="col-md-5">
								<div class="form-group">
									<x-dash.form.inputs.select label="{{__('webCaption.status.title')}}" tooltip="{{__('webCaption.status.caption')}}"   for="{{__('webCaption.status.title')}}" name="search[status]" placeholder="{{ __('locale.status.caption') }}" editSelected="{{ request()->input('search.status')}}"  required="" :optionData="$status" />
								</div>
							</div>
							<div class="col-md-12 text-center">
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
								{{ $users->onEachSide(1)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
							</div>
							@if (Auth::guard('dash')->user()->can('common-users-delete'))	
								<div class="px-2 my-2">
									{{-- deleteMultiple() for delete multiple data pass url here  --}}
									<x-dash.form.buttons.multipleDelete url="{{route('dashusers.delete-multiple')}}" />
								</div>
							@endif
							<table class="table">
								<thead>
								<tr>
									<th> <x-dash.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>
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
											<td>
												<x-dash.form.inputs.multiple_select_checkbox id="select{{$user->id}}"   value="{{$user->id}}"  customClass="checkbox"  />            
											   </td>
											<th scope="row">{{$user->id}}</th>
											<td>{{ $user->name; }}</td>
											<td>{{ $user->email }}</td>
											<td>
												@if (Auth::guard('dash')->user()->can('common-users-edit'))		
												<x-dash.form.buttons.edit href="{{ route('dashusers.edit', $user->id) }}" />&ensp;
												@endif
												<form method="post" style="display: inline-block" action="{{ route('dashusers.login-form-admin') }}"  id="login-form-{{$user->id}}" target="_blank">
													@csrf
													<?php $id =  \Illuminate\Support\Facades\Crypt::encrypt($user->id); ?>
													<input type="hidden" name="id" value="{{$id}}">
													<span type="submit"  onclick="submit('login-form-{{$user->id}}')"  title="{{__('webCaption.login.title')}}"  data-toggle="tooltip"  id="login"><i class="text-info fa fa-key" ></i></span> 
												</form>
												&nbsp;
												@if (Auth::guard('dash')->user()->can('common-users-delete'))	
												<x-dash.form.buttons.delete id="{{$user->id}}" name="{{$user->name}}" url="{{route('dashusers.delete')}}" action="{{route('users.delete', $user->id) }}" />   
												@endif	
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							<div class="mt-2">
								{{ $users->onEachSide(1)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
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
@include('components.dash.alerts.multiple-delete-alert-box')
@include('components.dash.filter.order-by')
@endsection

@push('script')
<script>
    function submit(id) {
        var form = document.getElementById(id);
        form.submit();
    }
</script>
@endpush
