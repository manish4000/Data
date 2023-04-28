@extends('layouts/contentLayoutMaster')

<!-- @section('content_header')
    <h1>Roles</h1>
@stop -->
@section('title', $pageConfigs['moduleName'])

@section('content')
<div>
	<div class="row">
		<div class="col-md-12 m-auto">
			<div class="card">
				<div class="card-header">
				  <h4 class="card-title" data-toggle="tooltip" data-placement="right" title="{{__('webCaption.search_filter.caption')}}">{{__('webCaption.search_filter.title')}}</h4>                    
				</div>
				<div class="card-body">
				  <form method="GET" action="{{route('roles.index')}}">
					<div class="d-flex justify-content-between align-items-center mx-50 row pt-0 pb-2">
						<div class="col-md-3">
							<div class="form-group">
								<label for="keyword" data-toggle="tooltip" data-placement="left" title="{{__('webCaption.keyword.caption')}}">{{__('webCaption.keyword.title')}}</label>
								<input type="text" class="form-control" id="searchKeyword" placeholder="{{__('webCaption.keyword.title')}}" name="search[keyword]" value="{{ request()->input('search.keyword') }}" />
							</div>
						</div>
						<div class="col-md-3">
							<x-admin.form.buttons.search />
						</div>
					</div>
				  </form>
				</div>
			</div>
			<div class="card card-default">
				<div class="card-body">
				  	@if(count($roles) > 0)
						<div class="table-responsive">
							<div class="mt-2">
								{{ $data->onEachSide(1)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
							</div>
							<table class="table">
								<thead>
									<tr>
									<th style="position: relative;" scope="col">#
										<x-admin.filter.order-by-filter-div orderBy="id" />
									</th>
									<th style="position: relative;" scope="col" data-toggle="tooltip" title="{{__('webCaption.name.caption')}}">
										{{__('webCaption.name.title')}}
										<x-admin.filter.order-by-filter-div orderBy="name" />
									</th>
									<th style="position: relative;" scope="col" data-toggle="tooltip" title="{{__('webCaption.slug.caption')}}">
										{{__('webCaption.slug.title')}}
										<x-admin.filter.order-by-filter-div orderBy="slug" />
									</th>
									<th scope="col"  data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}">{{__('webCaption.actions.title')}}</th>
									</tr>
								</thead>
								<tbody>
										@foreach ($roles as $role)
											<tr>
											<th scope="row">{{$role->id}}</th>
											<td>{{ $role->name; }}</td>
											<td>{{ $role->slug; }}</td>
											<td>
												@can('update-role', $role)
													<a href="{{ route('roles.edit', $role->id) }}"><i class="fa fa-edit text-dark mx-2" title="Edit"></i></a>
												@endcan
												@can('delete-role', $role)
													<span type="submit" onclick="deleteRole({{$role->id}})"><i class="fa fa-trash" title="Delete"></i></span>
													<form method="post" action="{{ route('roles.destroy', $role->id) }}" id="delete_form_{{$role->id}}">
														@csrf
														@method('DELETE')

													</form>
												@endcan
											</td>
											</tr>

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
@include('components.admin.filter.order-by')
@endsection

@section('page-script')
    <script>
    	function deleteRole(id) {
    		$confirm = confirm("Are to sure to delete this role?");
    		if ($confirm) {
			    document.getElementById("delete_form_"+id).submit();
		  	} 
    	}
    </script>
@stop