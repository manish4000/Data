@extends('layouts/contentLayoutMaster')

@section('content')

<div class="py-3">
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
		</ul>
		</div>
		<div class="col-md-6">
			{{-- @can('add-permission') --}}
			<form action="{{ route('company.permission.store')}}" method="POST">
				@csrf	
				<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">{{__('webCaption.add.title')}}</h3>
						</div>
					<div class="card-body">
							<div class="form-group">
								<x-admin.form.inputs.text label="{{__('webCaption.select_parent.title')}}"  for="justAnInputBox" class="form-control" name="sel_parent"  placeholder="{{__('webCaption.select_parent.title')}}" value="{{old('sel_parent')}}"  required="" />
							</div>
							<div class="form-group">
								<x-admin.form.inputs.text maxlength="80" label="{{__('webCaption.name.title')}}"  for="name" class="form-control" name="name"  placeholder="{{__('webCaption.name.title')}}" value="{{old('name')}}"  required="required" />
								@if ($errors->has('name'))
									<span class="text-danger">{{ $errors->first('name') }}</span>
								@endif
							</div>
							<div class="form-group">
								<x-admin.form.inputs.text maxlength="80" label="{{__('webCaption.slug.title')}}"  for="slug" class="form-control" name="slug"  placeholder="{{__('webCaption.slug.title')}}" value="{{old('slug')}}"  required="required" />
								@if ($errors->has('slug'))
								<span class="text-danger">{{ $errors->first('slug') }}</span>
								@endif
							</div>
							<div class="form-group">
								<div class="form-group">
									<x-admin.form.inputs.select  label="{{__('webCaption.module.title')}}" for="company_module_id" name="company_module_id" placeholder="{{__('webCaption.module.title')}}" :optionData="$modules" editSelected="{{(isset($data->company_module_id) && ($data->company_module_id != null))?$data->company_module_id :''; }}"   required=""   />
								</div>
							</div>
					</div>
				</div>
				<div class="form-group">
					<x-admin.form.buttons.create /> 
				</div>
		    </form>
			{{-- @endcan --}}
			<form method="post" action="" id="delete-form">
	      		@csrf
	      		@method('DELETE')
	      	</form>
		</div>
	</div>
</div>
@include('components.admin.alerts.delete-alert-box')
@endsection
{{-- this file include for delete alert box  --}}


@section('page-style')
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/treeSortable.css') }}" rel="stylesheet" />
<link href="{{ asset('css/tree-select.css') }}" rel="stylesheet" />
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

@stop

@push('script')

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
	        	url: "{{ route('company.permission.update-position') }}",
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
            
	        // const confirm = window.confirm('Are you sure you want to delete this branch?');
	        // if (!confirm) {
	        //     return;
	        // }

	        // $(this).removeBranch();

	         var id = $(this).data('id');
	        // var action = "{{ url('admin/permissions') }}/"+id;
	         var url = "{{ route('company.permission.delete') }}";
            
			// var form = document.getElementById("delete-form");
            deleteSingleData(id, name ='',url);   


	  		form.action = action;
	  		form.submit();
	    });
	});

	function editMenu(id) {
		window.location.href = "/admin/company/permission/edit/"+id;
	}

</script>
<script type="text/javascript">

	var permissionData = <?php print_r(json_encode($permissions)) ?>;
	var selPermission = [];

	var comboTree1;

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
@endpush