@extends('layouts/contentLayoutMaster')
@section('title', $pageConfigs['moduleName'])

@section('content')
<div>
	<div class="row">
		<div class="col-md-12 m-auto">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" title="{{__('webCaption.search_filter.caption')}}"   data-toggle="tooltip" > {{__('webCaption.search_filter.title')}} </h4>                    
				</div>
				<div class="card-body">
					<form method="GET" action="{{route('menu-groups.index')}}" id="myform" name="form">
						<div class="row pt-0 pb-2">
							<div class="col-md-3">
								<div class="form-group">		
									<x-admin.form.inputs.text id="searchKeyword" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
								</div>
							</div>
							
							<div class="col-md-6 offset-md-3 text-md-center">
								<x-admin.form.buttons.search />
								<x-admin.form.buttons.reset href="{{route('menu-groups.index')}}" />
							</div>
						</div>
					</form>
				</div>
			</div> 
			<div class="card">

				<div class="card-body">
					@if(count($groups) > 0) 
					<div class="table-responsive"> 
						<div class="mt-2">
							{{ $groups->onEachSide(2)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
						</div>
						@can('settings-menu-group-delete')
								<div class="px-2 my-2">
									{{-- deleteMultiple() for delete multiple data pass url here  --}}
									<x-admin.form.buttons.multipleDelete url="{{route('menu-groups.delete-multiple')}}" />
								</div>
						@endcan
						<table class="table">
							<thead>
								<tr>
									<th> <x-admin.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>
									<th scope="col" class="position-for-filter-heading">#
										<x-admin.filter.order-by-filter-div orderBy="id" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.title.caption')}}" >
										{{__('webCaption.title.title')}}
										<x-admin.filter.order-by-filter-div orderBy="title" />
									</th>
									<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.order.caption')}}">
										{{__('webCaption.order.title')}}
										<x-admin.filter.order-by-filter-div orderBy="order" />
									</th>
									<th scope="col" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}">{{__('webCaption.actions.title')}} 
									</th>
								</tr>
							</thead>
							<tbody>
								
								@foreach ($groups as $group)
									<tr>
										<td>
											<x-admin.form.inputs.multiple_select_checkbox id="select{{$group->id}}"   value="{{$group->id}}"  customClass="checkbox"  />            
										</td>
										<th scope="row">{{$group->id}}</th>
										<td>{{ $group->title; }}</td>
										<td>{{ $group->order; }}</td>
										<td>
											@can('settings-menu-group-menu-list')
												<x-admin.form.buttons.list href="{{ route('menu-groups.menus', $group->id) }}" /> &ensp;
												{{-- <a href="{{ route('menu-groups.menus', $group->id) }}"><i class="fa fa-plus text-dark mx-2" data-toggle="tooltip" title="{{__('webCaption.menu_list.title')}}"></i></a> --}}
											@endcan
											@can('settings-menu-group-edit') 
												<x-admin.form.buttons.edit href="{{ route('menu-groups.edit', $group->id) }}" /> &ensp;
											{{-- <a href="{{ route('menu-groups.edit', $group->id) }}"><i data-toggle="tooltip" title="{{__('webCaption.edit.title')}}" class="fa fa-edit text-dark mx-2" ></i></a> --}}
											@endcan
											@can('settings-menu-group-delete')
												<x-admin.form.buttons.delete id="{{$group->id}}" name="{{$group->title}}" url="{{route('menu-groups.destroy')}}" action="{{route('menu-groups.destroy',$group->id)}}" /> 
											{{-- <span type="submit" onclick="deleteSingleData('{{$group->id}}','{{$group->title}}' ,'{{route('menu-groups.destroy')}}')"><i class="fa fa-archive" data-toggle="tooltip" title="{{__('webCaption.delete.title')}}"></i></span> --}}
											@endcan
										</td>
									</tr>
									
								@endforeach
								
							</tbody>
						</table>
						<div class="mt-2">
							{{ $groups->onEachSide(2)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
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
@include('components.admin.alerts.delete-alert-box')
@include('components.admin.alerts.multiple-delete-alert-box')
{{-- this file include for short data asc and desc   --}}
@include('components.admin.filter.order-by')
<!-- users list ends -->
@endsection

