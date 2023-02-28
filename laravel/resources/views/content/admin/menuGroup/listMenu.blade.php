@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])

@section('title', $pageConfigs['moduleName'])

@section('page-style')
	<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="{{ asset('css/treeSortable.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/tree-select.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/fontawesome-iconpicker.min.css') }}" rel="stylesheet" />
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@endsection

@section('content')
<div>
	<div class="row">
		<div class="col-md-6">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">{{__('webCaption.list.title')}}   </h3>
				</div>
				<div class="card-body">
					<ul id="tree"></ul>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<form action="{{ route('menu-groups.add-menu')}}" method="POST">
					@csrf
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">{{__('webCaption.create.title')}}</h3>
					</div>
					<div class="card-body">
							<input type="hidden" name="menu_group_id" id="menu_group_id" value="{{ $menu_group->id }}">
							<div class="form-group">

								<x-admin.form.inputs.text tooltip="{{__('webCaption.select_parent.caption')}}" label="{{__('webCaption.select_parent.title')}}"  for="justAnInputBox2" class="form-control" name="sel_parent"  placeholder="{{__('webCaption.select_parent.title')}}" value="{{old('sel_parent', isset($data->sel_parent)?$data->sel_parent:'' )}}"  required="" />
									
							</div>
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.title.caption')}}" label="{{__('webCaption.title.title')}}" maxlength="50"  for="title" class="form-control" name="title"  placeholder="{{__('webCaption.title.title')}}" value="{{old('title', isset($data->title)?$data->title:'' )}}"  required="required" />
								@if ($errors->has('title'))
									<x-admin.form.form_error_messages message="{{ $errors->first('title') }}"  />
								@endif
							</div>
							<div class="form-group">
								<x-admin.form.label for="" tooltip="{{__('webCaption.icon.caption')}}"  value="{{__('webCaption.icon.title')}}" class="" />
								<div class="input-group">
									<x-admin.form.inputs.text   class="form-control icp icp-auto" maxlength="50" name="icon"  placeholder="{{__('webCaption.icon.title')}}" value="{{old('icon', isset($data->icon)?$data->icon:'' )}}"  required="" />
									{{-- <input data-placement="bottomRight" name="icon" class="form-control icp icp-auto" value="fas fa-archive"
										type="text"/> --}}
									<span class="input-group-addon input-group-text"></span> 
								</div>
								@if ($errors->has('icon'))
								<x-admin.form.form_error_messages message="{{ $errors->first('icon') }}"  />
								@endif
							</div>
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.uri.caption')}}"  label="{{__('webCaption.uri.title')}}" maxlength="255" for="uri" class="form-control" name="uri"  placeholder="{{__('webCaption.uri.title')}}" value="{{old('uri', isset($data->uri)?$data->uri:'' )}}"  required="" />
								@if ($errors->has('uri'))
									<x-admin.form.form_error_messages message="{{ $errors->first('uri') }}"  />
								@endif
							</div>

							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.permission.caption')}}"  label="{{__('webCaption.permission.title')}}"  for="justAnInputBox1" class="form-control" name="sel_permission"  placeholder="{{__('webCaption.permission.title')}}" value="{{old('sel_permission', isset($data->sel_permission)?$data->sel_permission:'' )}}"  required="" />
							</div>
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.order.caption')}}"  label="{{__('webCaption.order.title')}}"  for="order" class="form-control" name="order"  placeholder="{{__('webCaption.order.title')}}" value="{{old('order', isset($data->order)?$data->order:'' )}}"  required="" />
								@if ($errors->has('order'))
								<x-admin.form.form_error_messages message="{{ $errors->first('order') }}"  />
								@endif
							</div>
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.slug.caption')}}"  label="{{__('webCaption.slug.title')}}" maxlength="255"  for="slug" class="form-control" name="slug"  placeholder="{{__('webCaption.slug.title')}}" value="{{old('slug', isset($data->slug)?$data->slug:'' )}}"  required="" />
								@if ($errors->has('slug'))
								<x-admin.form.form_error_messages message="{{ $errors->first('slug') }}"  />
								@endif
							</div>
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.permission_slug.caption')}}"  label="{{__('webCaption.permission_slug.title')}}" maxlength="255"  for="permission_slug" class="form-control" name="permission_slug"  placeholder="{{__('webCaption.permission_slug.title')}}" value="{{old('permission_slug', isset($data->permission_slug)?$data->permission_slug:'' )}}"  required="required" />
								@if ($errors->has('permission_slug'))
								 <x-admin.form.form_error_messages message="{{ $errors->first('permission_slug') }}"  />
								@endif
							</div>
							<div class="form-group">
								  <x-admin.form.label for="" tooltip="{{__('webCaption.type.caption')}}" value="{{__('webCaption.type.title')}}" class="" />
								 
								  <x-admin.form.inputs.radio tooltip="{{__('webCaption.permission.caption')}}" for="Permission" class="border border-danger" name="type" label="{{__('webCaption.permission.title')}}"  value="permission"  required="required" checked="{{ old('type') == 'permission' ? 'checked' : '' }} " required="required" />
				
								  <x-admin.form.inputs.radio for="Menu" tooltip="{{__('webCaption.menu.caption')}}" class="border border-danger" name="type" label="{{__('webCaption.menu.title')}}" value="menu"  required="required"  checked="{{ old('type') == 'menu' ? 'checked' : '' }}" required="required" />
					  
								  @if($errors->has('type'))
								  <x-admin.form.form_error_messages message="{{ $errors->first('type') }}"  />
								  @endif
					  
							</div>
							
					</div>
				</div>
				<div class="form-group text-center">
					<x-admin.form.buttons.create />
				</div>
		    </form>
		</div>
	</div>
</div>
@include('components.admin.alerts.delete-alert-box')
@endsection


@section('page-script')
{{-- <script src="https://code.jquery.com/jquery-3.1.0.js"></script> --}}

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/treeSortable.js') }}"></script>
<script src="{{ asset('js/fontawesome-iconpicker.js') }}"></script>
<script src="{{ asset('js/comboTreePlugin2.js') }}"></script>


<script>
	$(document).ready(function () {

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
	        // console.log(ui.item[0].dataset);

	        $.ajax({
	        	url: "{{ route('update.menu.position') }}",
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
	        var action = "{{ url('admin/menu-groups/delete-menu') }}";
			deleteSingleData(id,'' ,action);
	    });
	});

	function editMenu(id) {
		window.location.href = "/admin/menu-groups/menu/"+id+"/edit";
	}

</script>
<script>
	$(function () {
		$('.icp-auto').on('click', function () {
			$('.icp-auto').iconpicker();

			$('.icp-dd').iconpicker({
        
    		});
			$('.icp-opts').iconpicker({
				title: 'With custom options',
				icons: [
				{
					title: "fab fa-github",
					searchTerms: ['repository', 'code']
				},
				{
					title: "fas fa-heart",
					searchTerms: ['love']
				},
				{
					title: "fab fa-html5",
					searchTerms: ['web']
				},
				{
					title: "fab fa-css3",
					searchTerms: ['style']
				}
				],
				selectedCustomClass: 'label label-success',
				mustAccept: true,
				placement: 'bottomRight',
				showFooter: true,
        // note that this is ignored cause we have an accept button:
        hideOnSelect: true,
        // fontAwesome5: true,
        templates: {
        	footer: '<div class="popover-footer">' +
        	'<div style="text-align:left; font-size:12px;">Placements: \n\
        	<a href="#" class=" action-placement">inline</a>\n\
        	<a href="#" class=" action-placement">topLeftCorner</a>\n\
        	<a href="#" class=" action-placement">topLeft</a>\n\
        	<a href="#" class=" action-placement">top</a>\n\
        	<a href="#" class=" action-placement">topRight</a>\n\
        	<a href="#" class=" action-placement">topRightCorner</a>\n\
        	<a href="#" class=" action-placement">rightTop</a>\n\
        	<a href="#" class=" action-placement">right</a>\n\
        	<a href="#" class=" action-placement">rightBottom</a>\n\
        	<a href="#" class=" action-placement">bottomRightCorner</a>\n\
        	<a href="#" class=" active action-placement">bottomRight</a>\n\
        	<a href="#" class=" action-placement">bottom</a>\n\
        	<a href="#" class=" action-placement">bottomLeft</a>\n\
        	<a href="#" class=" action-placement">bottomLeftCorner</a>\n\
        	<a href="#" class=" action-placement">leftBottom</a>\n\
        	<a href="#" class=" action-placement">left</a>\n\
        	<a href="#" class=" action-placement">leftTop</a>\n\
        	</div><hr></div>'
        }
    }).data('iconpicker').show();
		}).trigger('click');


    // Events sample:
    // This event is only triggered when the actual input value is changed
    // by user interaction
    $('.icp').on('iconpickerSelected', function (e) {
    	$('.lead .picker-target').get(0).className = 'picker-target fa-3x ' +
    	e.iconpickerInstance.options.iconBaseClass + ' ' +
    	e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue);
    });
});
</script>


<script type="text/javascript">

	var permissionData = <?php print_r(json_encode($permissionData)) ?>;
	var menuData = <?php print_r(json_encode($selectableMenuData))?>;
	var selectedParent	 =	<?php echo (isset(session('_old_input')['item_id']) && !empty(session('_old_input')['item_id']) ) ? '['. session('_old_input')['item_id'] .']': '[]'  ?>;
	var selectedPermission = 	<?php echo (isset(session('_old_input')['items']) && !empty(session('_old_input')['items']) ) ?  json_encode(session('_old_input')['items']) :  '[]' ; ?>;	
	var selItem = [];


	var comboTree1, comboTree2;

	jQuery(document).ready(function($) {

		// comboTree1 = $('#justAnInputBox').comboTree({
		// 	source : SampleJSONData,
		// 	isMultiple: true,
		// 	cascadeSelect: false,
		// 	collapse: true,
		// 	selectableLastNode: true

		// });
		
		comboTree1 = $('#justAnInputBox1').comboTree({
			source : permissionData,
			isMultiple: true,
			cascadeSelect: true,
			collapse: false,
			selected: selectedPermission
		});

		comboTree2 = $('#justAnInputBox2').comboTree({
			source : menuData,
			isMultiple: false,
			selected: selectedParent
		});

		// comboTree3.setSource(permissionData);


		// comboTree2 = $('#justAnotherInputBox').comboTree({
		// 	source : SampleJSONData,
		// 	isMultiple: false
		// });
	});
</script>
@endsection