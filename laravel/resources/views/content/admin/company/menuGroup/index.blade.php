@extends('layouts/contentLayoutMaster')

<!-- @section('content_header')
    <h1>Menu Groups</h1>
@stop -->
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
					<form method="GET" action="{{route('company.menu-groups.index')}}">
						<div class="d-flex justify-content-between align-items-center  row pt-0 pb-2">
							<div class="col-md-3">
								<div class="form-group">
									<x-admin.form.inputs.text id="searchKeyword" for="" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
								</div>
							</div>
							<div class="col-md-3">
								<x-admin.form.buttons.search /> 
								<x-admin.form.buttons.reset href="{{route('company.menu-groups.index')}}" />
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="card ">
				<div class="card-body">
					@if(count($groups) > 0)
					<div class="table-responsive">
						<div class="mt-2">
							{{ $groups->onEachSide(2)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
						</div>	

						@can('main-navigation-company-menu-group-delete')	
								<div class="px-2 my-2">
									{{-- deleteMultiple() for delete multiple data pass url here  --}}
									<x-dash.form.buttons.multipleDelete url="{{route('company.menu-groups.delete-multiple')}}" />
								</div>
						@endif

						<table class="table">
							<thead>
								<tr>
									<th> <x-admin.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>
									<th class="position-for-filter-heading" scope="col">#
										<x-admin.filter.order-by-filter-div orderBy="id" />
									</th>
									<th class="position-for-filter-heading" scope="col" data-toggle="tooltip" title="{{__('webCaption.title.caption')}}" >
										{{__('webCaption.title.title')}}
										<x-admin.filter.order-by-filter-div orderBy="title" />
									</th>
									<th class="position-for-filter-heading" scope="col" data-toggle="tooltip" title="{{__('webCaption.order.caption')}}">
										{{__('webCaption.order.title')}}
										<x-admin.filter.order-by-filter-div orderBy="order" />
									</th>
									{{-- <th scope="col">Items</th> --}}
									<th scope="col" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}">{{__('webCaption.actions.title')}}</th>
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
											{{-- <td></td> --}}
											<td>		
												@can('main-navigation-company-menu-group-listmenu') 
										
												<x-admin.form.buttons.list href="{{ route('company.menu-groups.menus', $group->id) }}" /> &ensp;
												@endcan
												{{-- <a href="{{ route('company.menu-groups.edit', $group->id) }}"><i data-toggle="tooltip" title="{{__('webCaption.edit.title')}}" class="fa fa-edit text-dark mx-2" ></i></a> --}}
												@can('main-navigation-company-menu-group-edit') 
												<x-admin.form.buttons.edit href="{{ route('company.menu-groups.edit', $group->id) }}" /> &ensp;
												@endcan
												@can('main-navigation-company-menu-group-delete') 	
												{{-- <span type="submit" onclick="deleteSingleData('{{$group->id}}','{{$group->title}}' ,'{{route('company.menu-groups.delete')}}')"><i class="fa fa-archive" data-toggle="tooltip" title="{{__('webCaption.delete.title')}}"></i></span> --}}

												<x-admin.form.buttons.delete id="{{$group->id}}" name="{{$group->title}}" url="{{route('company.menu-groups.delete')}}" action="{{route('company.menu-groups.delete',$group->id)}}" /> 
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

