@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@section('title', __('webCaption.edit_company_permission.title') )
@section('content')
<div class="py-3">
	<form action="{{ route('company.permission.store')}}" method="POST">
		@csrf
		<div class="card card-primary">
				<div class="card-header">
					<h4 class="card-title">
					<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
					</svg>
					{{__('webCaption.edit_company_permission.title')}}
					</h4>  
				</div>
			<hr class="m-0 p-0">
			<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text label="{{__('webCaption.select_parent.title')}}"  for="justAnInputBox" class="form-control" name="sel_parent"  placeholder="{{__('webCaption.select_parent.title')}}" value="{{old('sel_parent')}}"  required="" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text label="{{__('webCaption.name.title')}}"  maxlength="80" for="name" class="form-control" name="name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('name',isset($permission->name)?$permission->name:'')}}"  required="required" />
								@if ($errors->has('name'))
									<span class="text-danger">{{ $errors->first('name') }}</span>
								@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text label="{{__('webCaption.slug.title')}}" maxlength="80" for="slug" class="form-control" name="slug"  placeholder="{{__('webCaption.slug.title')}}" value="{{old('slug', isset($permission->slug)?$permission->slug:'' )}}"  required="required" />
								@if ($errors->has('slug'))
									<span class="text-danger">{{ $errors->first('slug') }}</span>
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div class="form-group">
									<x-admin.form.inputs.select  label="{{__('webCaption.module.title')}}" for="company_module_id" name="company_module_id" placeholder="{{__('webCaption.module.title')}}"  required="" :optionData="$modules" editSelected="{{(isset($permission->company_module_id) && ($permission->company_module_id != null))?$permission->company_module_id :''; }}" />
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div class="form-group">
			<input type="hidden" name="id" value="{{$permission->id}}">
			<x-admin.form.buttons.update /> 
		</div>
	</form>	
</div>
@stop

@section('page-style')
<link href="{{ asset('css/tree-select.css') }}" rel="stylesheet" />
@stop

@section('page-script')
<script src="{{ asset('js/comboTreePlugin.js') }}"></script>
<script type="text/javascript">

	var permissionData = <?php print_r(json_encode($permissions)) ?>;
	var selPermission = {{ $permission->parent_id }};
	var selected_parent = <?php echo (isset($permission->parent_id) && !empty($permission->parent_id) ) ?  '['.$permission->parent_id.']'  :  '[]' ; ?>;	

	var comboTree1, comboTree2;

	jQuery(document).ready(function($) {

		comboTree1 = $('#justAnInputBox').comboTree({
			source : permissionData,
			isMultiple: false,
			selected:selected_parent
			

		});
	});
</script>
@stop