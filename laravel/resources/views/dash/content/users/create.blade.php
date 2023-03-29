@extends('dash/layouts/LayoutMaster')
@if(isset($user->id) && !empty($user->id))
@section('title', __('webCaption.edit_user.title') )
@else
@section('title', __('webCaption.add_user.title'))
@endif

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
	<form action="{{ route('dashusers.store')}}" method="POST">
		@csrf

		<div class="card card-primary">
			<div class="card-header">
				<h4 class="card-title">
		
				<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
				</svg>
				@if(isset($user->id))  {{__('webCaption.edit_user.title')}}  @else {{__('webCaption.add_user.title')}} @endif 
				</h4>  
			</div>
			<hr class="m-0 p-0">
			<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-dash.form.inputs.text  for="name"  maxlength="255" tooltip="{{__('webCaption.name.caption')}}"  label="{{__('webCaption.name.title')}}"  name="name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('name', isset($user->name)?$user->name:'' )}}"  required="required" />
								
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<x-dash.form.inputs.email  for="email"  maxlength="255" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}"  name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($user->email)?$user->email:'' )}}"  required="required" />
								
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.password  maxlength="255"  for="password" tooltip="{{__('webCaption.password.caption')}}" label="{{__('webCaption.password.title')}}"   name="password"  placeholder="{{__('webCaption.password.title')}}" value=""  required="<?php echo (!isset($user->id))? 'required' :''; ?>" />
								
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<x-dash.form.inputs.password  maxlength="255" for="password_confirmation" tooltip="{{__('webCaption.password_confirm.caption')}}"  label="{{__('webCaption.password_confirm.title')}}"   name="password_confirmation"  placeholder="{{__('webCaption.password_confirm.title')}}" value=""  required="<?php echo (!isset($user->id))? 'required' :''; ?>" />
								
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-dash.form.inputs.select tooltip="{{__('webCaption.status.caption')}}" label="{{__('webCaption.status.title')}}"  id="" for="status" name="status" placeholder="{{ __('locale.Parent.caption') }}" editSelected="{{(isset($user->status) && ($user->status != null))?$user->status :''; }}"  required="required" :optionData="$status" />
								
							</div>

						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<x-admin.form.label for="" value="{{__('webCaption.permission.title')}}" class="" />
							@if ($permissions)

							<div class="jstree-basic">
								<ul>
									@foreach ( $permissions as $permission )
										@if(count($permission->menuChild) > 0)
											<li class="jstree-open">

													<x-dash.form.inputs.checkbox  name="permissions[]"  for="{{$permission->id}}permission" label="{{$permission->title }}" checked="{{( isset($user) && (!empty($permission->permission_slug)) && $user->can($permission->permission_slug)) ? 'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />	

												 @include('dash.content.users.child_list',['items' => $permission->menuChild ]) 												
											</li>
										@else
											<li>
												
													<x-dash.form.inputs.checkbox  name="permissions[]"  for="{{$permission->id}}permission" label="{{ $permission->title }}" checked="{{ ( isset($user) && (!empty($permission->permission_slug)) && $user->can($permission->permission_slug)) ? 'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />
												
											</li>
										@endif
									@endforeach
								</ul>
							</div>
							@endif
						</div>
					</div>
						

					{{-- <div class="row">
						<div class="col-md-12">
							<x-dash.form.label for="" value="{{__('webCaption.permission.title')}}" class="" />
							@if ($permissions)
							<div class="jstree-basic">
								<ul>
									@foreach ( $permissions as $permission )
										@if(count($permission->menuChild) > 0)
											<li class="jstree-open">
												<label class="form-check-label">
													<x-dash.form.inputs.checkbox  name="permissions[]" label="{{ $permission->title }}" checked="{{( isset($user) && $user->can($permission->permission_slug)) ?'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />
													
												</label>
												 @include('content.admin.user.child_list',['items' => $permission->menuChild ]) 												
											 
											</li>
										@else
											<li>
												<label class="form-check-label">
													<x-dash.form.inputs.checkbox  name="permissions[]" label="{{ $permission->title }}" checked="{{ ( isset($user) && $user->can($permission->permission_slug)) ?'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />
												</label>
											</li>
										@endif
									@endforeach
								</ul>
							</div>
							@endif
						</div>
					</div> --}}
			</div>
		</div>
		<div class="form-group text-center">
			<input type="hidden" name="id" value="@if(isset($user->id) && !empty($user->id)){{$user->id}}@endif" />
			@if(isset($user->id)) 	<x-dash.form.buttons.update /> @else <x-dash.form.buttons.create/> @endif 
		</div>
    </form>
</div>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
@endsection
@push('script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>
  <script src="{{ asset('assets/dash/assets/js/dash/master.js') }}"></script>
  <script type="text/javascript">
  	$(document).ready(function() {
  		$(".jstree-basic ul li a, .jstree-basic ul li ul li a").each(function() {
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