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
	<form action="{{ route('users.store')}}" method="POST">
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
								<x-admin.form.inputs.text  for="name"  maxlength="100" tooltip="{{__('webCaption.name.caption')}}"  label="{{__('webCaption.name.title')}}"  class="form-control" name="name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('name', isset($user->name)?$user->name:'' )}}"  required="required" />
								@if ($errors->has('name'))
									<x-admin.form.form_error_messages message="{{ $errors->first('name') }}"  />
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.email for="email" tooltip="{{__('webCaption.email.caption')}}"  maxlength="100" label="{{__('webCaption.email.title')}}"  class="form-control" name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($user->email)?$user->email:'' )}}"  required="required" />
								@if ($errors->has('email'))
								  <x-admin.form.form_error_messages message="{{ $errors->first('email') }}"  />
								@endif
							</div>
						</div>
					</div>
					<div class="row">
						{{-- <div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text  for="username" tooltip="{{__('webCaption.username.caption')}}"   maxlength="50" label="{{__('webCaption.username.title')}}"  class="form-control" name="username"  placeholder="{{__('webCaption.username.title')}}" value="{{old('username', isset($user->username)?$user->username:'' )}}"  required="required" />
								@if ($errors->has('username'))
									<x-admin.form.form_error_messages message="{{ $errors->first('username') }}"  />
								@endif
							</div>
						</div> --}}
					</div>
					@if(isset($user))
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<x-admin.form.inputs.password  maxlength="15"  for="password" tooltip="{{__('webCaption.password.caption')}}"   label="{{__('webCaption.password.title')}}"  class="form-control" name="password"  placeholder="{{__('webCaption.password.title')}}" value=""  required="" />
									@if ($errors->has('password'))
									<x-admin.form.form_error_messages message="{{ $errors->first('password') }}"  />
								    @endif
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<x-admin.form.inputs.password tooltip="{{__('webCaption.password_confirm.caption')}}"   maxlength="15" for="password_confirmation"  label="{{__('webCaption.password_confirm.title')}}"  class="form-control" name="password_confirmation"  placeholder="{{__('webCaption.password_confirm.title')}}" value=""  required="" />
									@if ($errors->has('password_confirmation'))
									<x-admin.form.form_error_messages message="{{ $errors->first('password_confirmation') }}"  />
								    @endif
								</div>
							</div>
						</div>
					@else
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<x-admin.form.inputs.password  :passwordGenerator="true"  maxlength="15"  for="password" tooltip="{{__('webCaption.password.caption')}}"   label="{{__('webCaption.password.title')}}"  class="form-control" name="password"  placeholder="{{__('webCaption.password.title')}}" value=""  required="required" />
									@if ($errors->has('password'))
										<x-admin.form.form_error_messages message="{{ $errors->first('password') }}"  />
									@endif
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<x-admin.form.inputs.password tooltip="{{__('webCaption.password_confirm.caption')}}"   maxlength="15" for="password_confirmation"  label="{{__('webCaption.password_confirm.title')}}"  class="form-control" name="password_confirmation"  placeholder="{{__('webCaption.password_confirm.title')}}" value=""  required="required" />
									@if ($errors->has('password_confirmation'))
										<x-admin.form.form_error_messages message="{{ $errors->first('password_confirmation') }}"  />
									@endif
								</div>
								
							</div>
						</div>	
					@endif
					<div class="row">
						<div class="col-md-6">
							<div class="form-group"> 
								@php if(isset($user->department_id)){
									$editSelected = $user->department_id;
								} else{
									$editSelected = '';
								}
								
								@endphp
								<x-admin.form.inputs.multiple_select label="{{__('webCaption.department.title')}}" tooltip="{{__('webCaption.department.caption')}}"  for="department_id" id=""  name="department_id[]"  :oldValues="old('department_id')" value=""   :editSelected="$editSelected"  :optionData="$departments" required="" />
								@if($errors->has('department_id'))
									<x-admin.form.form_error_messages message="{{ $errors->first('department_id') }}" />
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text  for="phone"  maxlength="15" tooltip="{{__('webCaption.phone.caption')}}"  label="{{__('webCaption.phone.title')}}"  class="form-control" name="phone"  placeholder="{{__('webCaption.phone.title')}}" value="{{old('phone', isset($user->phone)?$user->phone:'' )}}"  required="required" />
								@if ($errors->has('phone'))
									<x-admin.form.form_error_messages message="{{ $errors->first('phone') }}"  />
								@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.checkbox for="two_step_verification" tooltip="{{__('webCaption.required_two_step_verification.caption')}}" name="allow_2fa" label="{{__('webCaption.required_two_step_verification.title')}}" checked="{{ old('allow_2fa') == '1' ? 'checked' : '' }} {{ isset($user->allow_2fa) ? $user->allow_2fa == '1' ? 'checked=checked' :'' :'' }}"  value="1"  customClass="form-check-input"  />
									@if($errors->has('allow_2fa'))
									<x-admin.form.form_error_messages message="{{ $errors->first('allow_2fa') }}" />
									@endif		
							</div>
						</div>
						
					</div>

					{{-- <div class="row">
						<div class="col-md-12">
							<x-admin.form.label for="" tooltip="{{__('webCaption.roles.caption')}}" value="{{__('webCaption.roles.title')}}" class="" />
							<br>
							@if ($roles)
								@foreach ( $roles as $role )
									<div class="form-group form-check-inline">
										<label class="form-check-label">
											<input class="form-check-input" value="{{ $role->id }}" type="checkbox" name="roles[]" <?php if ($user->hasRole($role->slug)) echo 'checked'; ?>> {{ $role->name }}
										</label>
									</div>
								@endforeach
							@endif
						</div>
					</div> --}}

					{{-- <div class="row">
						<div class="col-md-12">
							<x-admin.form.label for="" value="{{__('webCaption.permission.title')}}" class="" />
							@if ($permissions)
							<div class="jstree-basic">
								<ul>
									@foreach ( $permissions as $permission )
										@if(count($permission->child) > 0)
											<li class="jstree-open">
												<label class="form-check-label">
													<x-admin.form.inputs.checkbox  name="permissions[]" label="{{ $permission->name }}" checked="{{ ( isset($user) && $user->can($permission->slug)) ?'checked' :''; }} "  value="{{ $permission->id }}"  customClass="form-check-input"  />
												</label>
												 @include('content.admin.user.child_list',['items' => $permission->child ]) 												
											</li>
										@else
											<li>
												<label class="form-check-label">
													<x-admin.form.inputs.checkbox  name="permissions[]" label="{{ $permission->name }}" checked="{{ ( isset($user) && $user->can($permission->slug)) ?'checked' :''; }} "  value="{{ $permission->id }}"  customClass="form-check-input"  />
												</label>
											</li>
										@endif
									@endforeach
								</ul>
							</div>
							@endif
						</div>
					</div> --}}

					<div class="row mt-2">
						<div class="col-md-12">
							<x-admin.form.label for="" tooltip="{{__('webCaption.permission.caption')}}" value="{{__('webCaption.permission.title')}}" class="" />
							@if ($permissions)
								<div class="jstree-basic">
									<ul>
										@foreach ( $permissions as $permission )
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

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>

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
@endsection
