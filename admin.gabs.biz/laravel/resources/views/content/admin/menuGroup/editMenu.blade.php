@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])

@section('content_header')
<h1> {{__('webCaption.edit_menu.title')}}</h1>
@endsection

@section('title', __('webCaption.edit_menu.title') )

@section('content')
<div>
	<form action="{{ route('menu-groups.menu.update', $menu->id)}}" method="POST">
		@csrf
		<div class="card card-primary">
			<div class="card-header">
				<h4 class="card-title">
				<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
				</svg>
				{{__('webCaption.edit_menu.title')}}
				</h4>  
			</div>
			<hr class="m-0 p-0">
			<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.select tooltip="{{__('webCaption.group.caption')}}"  class="form-control" label="{{__('webCaption.group.title')}}"  for="menu_group_id" name="menu_group_id"   required="required" :optionData="$groups" editSelected="{{(isset($menu->menu_group_id) && ($menu->menu_group_id != null))?$menu->menu_group_id :''; }}" />
								@if ($errors->has('menu_group_id'))
								   <x-admin.form.form_error_messages message="{{ $errors->first('menu_group_id') }}"  />
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.title.caption')}}" label="{{__('webCaption.title.title')}}"  for="title" class="form-control" maxlength="50" name="title"  placeholder="{{__('webCaption.title.title')}}" value="{{old('title', isset($menu->title)?$menu->title:'' )}}"  required="required" />
								@if ($errors->has('title'))
									<x-admin.form.form_error_messages message="{{ $errors->first('title') }}"  />
								@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.select_parent.caption')}}" label="{{__('webCaption.select_parent.title')}}"  for="justAnInputBox2" class="form-control" name="sel_parent"  placeholder="{{__('webCaption.select_parent.title')}}" value="{{old('sel_parent')}}"  required="" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.uri.caption')}}" label="{{__('webCaption.uri.title')}}" maxlength="255" for="uri" class="form-control" name="uri"  placeholder="{{__('webCaption.uri.title')}}" value="{{old('uri', isset($menu->uri)?$menu->uri:'' )}}"  required="" />				
									@if($errors->has('uri'))
									<x-admin.form.form_error_messages message="{{ $errors->first('uri') }}"  />
									@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.permission.caption')}}" label="{{__('webCaption.permission.title')}}"  for="justAnInputBox1" class="form-control" name="sel_permission"  placeholder="{{__('webCaption.select_permission.title')}}" value="{{old('sel_permission', isset($menu->sel_permission)?$menu->sel_permission:'' )}}"  required="" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							<x-admin.form.inputs.text tooltip="{{__('webCaption.order.caption')}}" label="{{__('webCaption.order.title')}}"  for="order" class="form-control" name="order"  placeholder="{{__('webCaption.order.title')}}" value="{{old('order')}}"  required="" />						
									@if ($errors->has('order'))
									<x-admin.form.form_error_messages message="{{ $errors->first('order') }}"  />
									@endif
						</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.slug.caption')}}" label="{{__('webCaption.slug.title')}}" maxlength="255" for="slug" class="form-control" name="slug"  placeholder="{{__('webCaption.slug.title')}}" value="{{old('slug', isset($menu->slug)?$menu->slug:'' )}}"  required="" />		
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.icon.caption')}}" label="{{__('webCaption.icon.title')}}" maxlength="50"  for="icon" class="form-control" name="icon"  placeholder="{{__('webCaption.icon.title')}}" value="{{old('icon', isset($menu->icon)?$menu->icon:'' )}}"  required="" />
								@if ($errors->has('icon'))
								<x-admin.form.form_error_messages message="{{ $errors->first('icon') }}"  />
								@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text  tooltip="{{__('webCaption.permission_slug.caption')}}" label="{{__('webCaption.permission_slug.title')}}" maxlength="255"  for="permission_slug" class="form-control" name="permission_slug"  placeholder="{{__('webCaption.permission_slug.title')}}" value="{{old('permission_slug', isset($menu->permission_slug)?$menu->permission_slug:'' )}}"  required="required" />
								@if($errors->has('permission_slug'))
								<x-admin.form.form_error_messages message="{{ $errors->first('permission_slug') }}"  />
								@endif	
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.label for="" tooltip="{{__('webCaption.type.caption')}}" value="{{__('webCaption.type.title')}}" class="" />
								  <x-admin.form.inputs.radio for="Permission" class="border border-danger" tooltip="{{__('webCaption.permission.caption')}}" name="type" label="{{__('webCaption.permission.title')}}"  value="permission"  required="required" checked="{{ old('type') == 'permission' ? 'checked' : '' }} {{ isset($menu->type) ? $menu->type == 'permission' ? 'checked=checked' :'' :'' }} " required="required" />
								  <x-admin.form.inputs.radio for="Menu" class="border border-danger" name="type" tooltip="{{__('webCaption.menu.caption')}}" label="{{__('webCaption.menu.title')}}" value="menu"  required="required"  checked="{{ old('type') == 'menu' ? 'checked' : '' }} {{ isset($menu->type) ? $menu->type == 'menu' ? 'checked=checked' :'' :'' }} " required="required" />
								  
								  @if($errors->has('type'))
								  <x-admin.form.form_error_messages message="{{ $errors->first('type') }}"  />
								  @endif
							</div>
						</div>
					</div>
				
			</div>
		</div>
		<div class="form-group text-center">
			<x-admin.form.buttons.update />
		</div>
	</form>
</div>
@endsection

@section('page-style')
<link href="{{ asset('css/tree-select.css') }}" rel="stylesheet" />
@endsection


@section('script')

<script src="{{ asset('js/comboTreePlugin2.js') }}"></script>

<script type="text/javascript">

	var permissionData = <?php echo (isset($permissionData) && !empty($permissionData) ) ? json_encode($permissionData) : '[]' ?>;
	var menuData = <?php echo (isset($selectableMenuData) && !empty($selectableMenuData) )? json_encode($selectableMenuData) : '[]' ; ?>;
	var selected_permission = 	<?php echo (isset($menu->permissions) && !empty($menu->permissions) ) ?  json_encode($menu->permissions) :  '[]' ; ?>;	
	var selected_parent = <?php echo (isset($menu->parent_id) && !empty($menu->parent_id) ) ?  '['.$menu->parent_id.']'  :  '[]' ; ?>;	
 
	var comboTree3,comboTree2;

	jQuery(document).ready(function($) {
		
		comboTree2 = $('#justAnInputBox2').comboTree({
			source : menuData,
			isMultiple: false,
			selected: selected_parent
		});

		comboTree3 = $('#justAnInputBox1').comboTree({
			source : permissionData,
			isMultiple: true,
			selected: selected_permission
			
		});

	});
</script>

@endsection