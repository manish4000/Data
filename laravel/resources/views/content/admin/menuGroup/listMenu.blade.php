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

@if(isset($menu->id))
	<style>
	.remove-branch {  display: none;}
	</style>	
@endif

@section('content')
<div>
	<div class="row">
		<div class="col-md-6">
			<form action="{{ route('menu-groups.add-menu')}}" method="POST">
					@csrf
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title"> 	@if(isset($menu->id)) {{__('webCaption.edit.title')}}   @else {{__('webCaption.create.title')}} @endif  </h3>
					</div>
					<div class="card-body">
							<input type="hidden" name="menu_group_id" id="menu_group_id" value="{{ $menuGroupId }}">
							<div class="form-group">
	
								<x-admin.form.inputs.text tooltip="{{__('webCaption.select_parent.caption')}}" label="{{__('webCaption.select_parent.title')}}"  for="justAnInputBox2"  name="sel_parent"  placeholder="{{__('webCaption.select_parent.title')}}" value="{{old('sel_parent', isset($menu->sel_parent)?$menu->sel_parent:'' )}}"  required="" />
									
							</div>
							@if(isset($menu->id))
								<div class="form-group">
									<x-admin.form.inputs.select tooltip="{{__('webCaption.group.caption')}}"  label="{{__('webCaption.group.title')}}"  for="menu_group_id" name="menu_group_id"   required="required" :optionData="$groups" editSelected="{{(isset($menu->menu_group_id) && ($menu->menu_group_id != null))?$menu->menu_group_id :''; }}" />
								</div>
							@endif
							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.title.caption')}}" label="{{__('webCaption.title.title')}}" maxlength="50"  for="title"  name="title"  placeholder="{{__('webCaption.title.title')}}" value="{{old('title', isset($menu->title)?$menu->title:'' )}}"  required="required" />
							</div>
							

							<div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.permission_slug.caption')}}"  label="{{__('webCaption.permission_slug.title')}}" maxlength="255"  for="permission_slug"  name="permission_slug"  placeholder="{{__('webCaption.permission_slug.title')}}" value="{{old('permission_slug', isset($menu->permission_slug)?$menu->permission_slug:'' )}}"  required="required" />
								
							</div>

							<div class="form-group">
								<x-admin.form.label for="" tooltip="{{__('webCaption.type.caption')}}" value="{{__('webCaption.type.title')}}" class="" />
							   
								<x-admin.form.inputs.radio tooltip="{{__('webCaption.permission.caption')}}" for="Permission" customClass="type" name="type" label="{{__('webCaption.permission.title')}}"  value="permission"  required="required"
								 checked="{{ ((old('type') == 'permission') || ( (isset($menu->type)) && ( $menu->type == 'permission') ) ) ? 'checked' : '' }} " required="required" />
			  
								<x-admin.form.inputs.radio for="Menu" tooltip="{{__('webCaption.menu.caption')}}" customClass="type" name="type" 
								label="{{__('webCaption.menu.title')}}" value="menu"  required="required"
								  checked="{{ ((old('type') == 'menu') ||  ( (isset($menu->type)) && ( $menu->type == 'menu') ) ) || (!isset($menu->id)) ? 'checked' : '' }}" required="required" />
					
								@if($errors->has('type'))
								<x-admin.form.form_error_messages message="{{ $errors->first('type') }}"  />
								@endif
					
						  	</div>

							<div id="extra-fields" style="display: none">

								<div class="form-group">
									<x-admin.form.inputs.text tooltip="{{__('webCaption.order.caption')}}"  label="{{__('webCaption.order.title')}}"  for="order"  name="order"  placeholder="{{__('webCaption.order.title')}}" value="{{old('order', isset($menu->order)?$menu->order:'' )}}"  required="" />
									
								</div>
								<div class="form-group">
									<x-admin.form.label for="" tooltip="{{__('webCaption.icon.caption')}}"  value="{{__('webCaption.icon.title')}}" class="" />
									<div class="input-group">
										<x-admin.form.inputs.text   maxlength="50" name="icon"  placeholder="{{__('webCaption.icon.title')}}" value="{{old('icon', isset($menu->icon)?$menu->icon:'' )}}"  required="" />
										<span class="input-group-addon input-group-text"></span> 
									</div>
								</div>
								<div class="form-group">
									<x-admin.form.inputs.text tooltip="{{__('webCaption.uri.caption')}}"  label="{{__('webCaption.uri.title')}}" maxlength="255" for="uri" class="form-control" name="uri"  placeholder="{{__('webCaption.uri.title')}}" value="{{old('uri', isset($menu->uri)?$menu->uri:'' )}}"  required="" />
									
								</div>
		
								{{-- <div class="form-group">
									<x-admin.form.inputs.text tooltip="{{__('webCaption.permission.caption')}}"  label="{{__('webCaption.permission.title')}}"  for="justAnInputBox1"  name="sel_permission"  placeholder="{{__('webCaption.permission.title')}}" value="{{old('sel_permission', isset($data->sel_permission)?$data->sel_permission:'' )}}"  required="" />
								</div> --}}
								
								<div class="form-group">
									<x-admin.form.inputs.text tooltip="{{__('webCaption.language_slug.caption')}}"  label="{{__('webCaption.language_slug.title')}}" maxlength="255"  for="language_slug" name="slug"  placeholder="{{__('webCaption.language_slug.title')}}" value="{{old('slug', isset($menu->slug)?$menu->slug:'' )}}"  required="" />
									
								</div>
							</div>
							
					</div>
				</div>
				<div class="form-group text-center">
					<input type="hidden" name="id" value="@if(isset($menu->id) && !empty($menu->id)){{$menu->id}}@endif" />
					@if(isset($menu->id)) 	<x-admin.form.buttons.update /> @else <x-admin.form.buttons.create/> @endif 
				</div>
			</form>
		</div>
		

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
		
	</div>
</div>
@include('components.admin.alerts.delete-alert-box')
@endsection

@push('script')

<script>

	var checkedRadio = 	$(".type:checked").val();

	if(checkedRadio == 'menu'){
		$("#extra-fields").css("display", "block");
	}

	$(".type").change(function(){
        var val = $(".type:checked").val();

		if(val == 'permission'){
			$("#extra-fields").css("display", "none");
		}else{
			$("#extra-fields").css("display", "block");
		}
    });



</script>
@endpush

<?php
	if(isset(session('_old_input')['item_id']) && !empty(session('_old_input')['item_id']) ){
		$sel = session('_old_input')['item_id'];
	}else if(isset($menu->parent_id) && !empty($menu->parent_id)){
		$sel = $menu->parent_id;
	}else{
		$sel = '';
	}

?>

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
		
		url = "{{route('menu-groups.menu.edit',':id' )}}";
		url = url.replace(':id', id);
		window.location.href = url ;
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

	var menuData = <?php print_r(json_encode($selectableMenuData))?>;
	
	var selectedParent = <?php echo '['.$sel.']'; ?>
	
	jQuery(document).ready(function($) {
		comboTree2 = $('#justAnInputBox2').comboTree({
			source : menuData,
			isMultiple: false,
			selected: selectedParent
		});
	});
</script>
@endsection