@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@section('title', $pageConfigs['moduleName'])
@section('content')
<div class="py-3">
	<form action="{{ route('permissions.update', $permission->id)}}" method="POST">
		@csrf
		@method('PUT')
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">{{__('webCaption.edit.title')}}</h3>
			</div>
			<div class="card-body">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text label="{{__('webCaption.select_parent.title')}}"  for="justAnInputBox" class="form-control" name="sel_parent"  placeholder="{{__('webCaption.select_parent.title')}}" value="{{old('sel_parent', isset($permission->sel_parent)?$permission->sel_parent:'' )}}"  required="" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text label="{{__('webCaption.name.title')}}" maxlength="50" for="name" class="form-control" name="name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('name', isset($permission->name)?$permission->name:'' )}}"  required="required" />
								@if ($errors->has('name'))
									<span class="text-danger">{{ $errors->first('name') }}</span>
								@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<x-admin.form.inputs.text label="{{__('webCaption.slug.title')}}"  maxlength="50" for="slug" class="form-control" name="slug"  placeholder="{{__('webCaption.slug.title')}}" value="{{old('slug', isset($permission->slug)?$permission->slug:'' )}}"  required="required" />
								@if ($errors->has('slug'))
									<span class="text-danger">{{ $errors->first('slug') }}</span>
								@endif
							</div>
						</div>
					</div>				
				
			</div>
		</div>
	 <x-admin.form.buttons.update/>
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