@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])

@section('title', $pageConfigs['moduleName'])

@section('content')

<div>
	<div class="row">
		<div class="col-md-6">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">{{__('webCaption.list.title')}}</h3>
				</div>
				<div class="card-body">
					{{-- @if ($menus) --}}
						<ul id="tree"></ul>
					{{-- @endif --}}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			{{-- @can('add-permission') --}}
		  <form action="{{ route('permissions.store')}}" method="POST">
				@csrf
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">{{__('webCaption.add.title')}}</h3>
				</div>
				<div class="card-body">
					
						<div class="form-group">
							<x-admin.form.inputs.text label="{{__('webCaption.select_parent.title')}}"  for="justAnInputBox" class="form-control" name="sel_parent"  placeholder="{{__('webCaption.select_parent.title')}}" value="{{old('sel_parent', isset($data->sel_parent)?$data->sel_parent:'' )}}"  required="" />
						</div>
						<div class="form-group">
							<x-admin.form.inputs.text label="{{__('webCaption.name.title')}}"  maxlength="50" for="name" class="form-control" name="name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('name', isset($data->name)?$data->name:'' )}}"  required="required" />
							@if ($errors->has('name'))
			                    <span class="text-danger">{{ $errors->first('name') }}</span>
			                @endif
						</div>
					  	<div class="form-group">
							<x-admin.form.inputs.text label="{{__('webCaption.slug.title')}}"  maxlength="50" for="slug" class="form-control" name="slug"  placeholder="{{__('webCaption.slug.title')}}" value="{{old('slug', isset($data->slug)?$data->slug:'' )}}"  required="required" />
					    	@if ($errors->has('slug'))
			                    <span class="text-danger">{{ $errors->first('slug') }}</span>
			                @endif
					  	</div>
					  	
				</div>
			</div>

			<div class="form-group">
				<x-admin.form.buttons.create />
			</div>
		  </form>
			{{-- @endcan --}}
		</div>
	</div>
</div>
@include('components.admin.alerts.delete-alert-box')
@endsection

@section('page-style')
{{-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> --}}
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/treeSortable.css') }}" rel="stylesheet" />
<link href="{{ asset('css/tree-select.css') }}" rel="stylesheet" />
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@stop

@section('page-script')
<script src="https://code.jquery.com/jquery-3.1.0.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/treeSortable.js') }}"></script>
<script src="{{ asset('js/comboTreePlugin.js') }}"></script>
<script>
	$(document).ready(function () {
		// $('#permissions').treeselect();

		const data = <?php print_r(json_encode($data)); ?>

	    const sortable = new TreeSortable();

	    const $tree = $('#tree');
	    const $content = data.map(sortable.createBranch);

	    $tree.html($content);
	    sortable.run();

	    const delay = () => {
	        return new Promise(resolve => {
	            setTimeout(() => {
	                resolve();
	            }, 1000);
	        });
	    };

	    sortable.onSortCompleted(async (event, ui) => {
	        await delay();
	        console.log(ui.item[0].dataset);

	        $.ajax({
	        	url: "{{ route('update.permission.position') }}",
	        	data: ui.item[0].dataset,
	        	type: "post",
	        	success: function(data) {
	        		if(data.result.status == true){
						successToast(data.result.message);
					}else if(data.result.status == false){
						errorToast(data.result.message);
					}
	        	},
	        	error: function() {}
	        });
	    });

	    // $(document).on('click', '.add-child', function (e) {
	    //     e.preventDefault();
	    //     $(this).addChildBranch();
	    // });

	    $(document).on('click', '.add-sibling', function (e) {
	        e.preventDefault();
	        $(this).addSiblingBranch();
	    });

	    $(document).on('click', '.remove-branch', function (e) {
	        e.preventDefault();
			var id = $(this).data('id');
	        var action = "{{ url('admin/permissions/delete') }}";
			deleteSingleData(id,'' ,action);
	    });
	});

	function editMenu(id) {
		window.location.href = "/admin/permissions/"+id+"/edit";
	}

</script>
<script type="text/javascript">

	var permissionData = <?php print_r(json_encode($permissions)) ?>;
	var selPermission = [];

	var comboTree1, comboTree2;

	jQuery(document).ready(function($) {

		comboTree1 = $('#justAnInputBox').comboTree({
			source : permissionData,
			isMultiple: false,
			cascadeSelect: false,
			collapse: false,
			selectableLastNode: true

		});
	});
</script>
@stop