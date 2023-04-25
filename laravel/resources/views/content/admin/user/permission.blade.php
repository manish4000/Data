@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@section('title', $pageConfigs['moduleName'])
@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('fonts/font-awesome/css/font-awesome.min.css'))}}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css'))}}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-tree.css')) }}">
@endsection

@section('content')
<div>
	<form action="{{ route('users.update-permission')}}" method="POST">
		@csrf
		<div class="card card-primary">
			<div class="card-header">
				<h4 class="card-title">
				<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
				</svg>
				 {{$user->name}}   {{__('webCaption.permission.title')}}   
				</h4>  
			</div>
			<hr class="m-0 p-0">
			<div class="card-body">

					<div class="row">
						<div class="col-md-12">
							@if ($permissions )

							 @foreach($permissions as $key => $per_data)

							 <?php 
							 $group_name =  DB::table('menu_groups')->where('id', $key)->value('title');
							 ?>
							   <div class="m-1 ">   <h4 class="text-primary">{{$group_name}} </h4>  </div>
							   
								<div class="jstree-basic">
									<ul>
										@foreach ( $per_data as $permission )
											@if(count($permission->menuChild) > 0)
												<li class="jstree-open">
													<label class="form-check-label">
														<x-admin.form.inputs.checkbox  for="{{$permission->id}}permission" name="permissions[]" label="{{ $permission->title }}" checked="{{( isset($user) && (!empty($permission->permission_slug)) && $user->can($permission->permission_slug)) ?'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />													
													</label>
													@include('content.admin.user.child_list',['items' => $permission->menuChild ]) 												
												</li>
											@else
												<li>
													<label class="form-check-label">
														<x-admin.form.inputs.checkbox  for="{{$permission->id}}permission" name="permissions[]" label="{{ $permission->title }}" checked="{{ ( isset($user) && (!empty($permission->permission_slug)) && $user->can($permission->permission_slug)) ?'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />
													</label>
												</li>
											@endif
										@endforeach
									</ul>
								</div>
							 @endforeach	
							@endif
						</div>
					</div>
			</div>
		</div>
		<div class="form-group text-center">
			<input type="hidden" name="id" value="@if(isset($user->id) && !empty($user->id)){{$user->id}}@endif" />
			@if(isset($user->id)) 	<x-admin.form.buttons.update /> @else <x-admin.form.buttons.create/> @endif 
		</div>
    </form>
</div>
@endsection

@push('script')
<script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>
				
  <script type="text/javascript">
  	$(document).ready(function() {
  		$(".jstree-basic ul li a").each(function() {

  		  var attributes = $.map(this.attributes, function(item) {
		    return item.name;
		  });
		  var img = $(this);
		  $.each(attributes, function(i, item) {
		    img.removeAttr(item);
		  });
		});
  	})
  </script>
@endpush
