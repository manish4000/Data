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
<div >


	<div class="row">
		<div class="col-md-6">
			
			<div class="card card-primary">
				<div class="card-header">
					
					<h3 class="card-title">{{__('webCaption.create.title')}}</h3>
				</div>
				<div class="card-body">
					<form action="{{ route('company.menu-groups.add-menu')}}" method="POST">
						@csrf
						<input type="hidden" name="company_menu_group_id" id="company_menu_group_id" value="{{ $menuGroupId }}">
						
						<div class="form-group">
							<x-admin.form.inputs.text tooltip="{{__('webCaption.select_parent.caption')}}" label="{{__('webCaption.select_parent.title')}}"  for="justAnInputBox2"  name="sel_parent"  placeholder="{{__('webCaption.select_parent.title')}}" value="{{old('sel_parent', isset($menu->sel_parent)?$menu->sel_parent:'' )}}"  required="" />
					    </div>

						@if(isset($menu->id))
							<div class="form-group">
								<x-admin.form.inputs.select  tooltip="{{__('webCaption.group.caption')}}" label="{{__('webCaption.group.title')}}"  for="company_menu_group_id" name="company_menu_group_id"   required="required" :optionData="$groups" editSelected="{{(isset($menu->company_menu_group_id) && ($menu->company_menu_group_id != null))?$menu->company_menu_group_id :''; }}" />
								
							</div>

						@endif

						<div class="form-group">
							<x-admin.form.inputs.text tooltip="{{__('webCaption.title.caption')}}" label="{{__('webCaption.title.title')}}"  for="title"  maxlength="50" name="title"  placeholder="{{__('webCaption.title.title')}}" value="{{old('title', isset($menu->title)?$menu->title:'' )}}"  required="required" />
							
						</div>
						<div class="form-group">
							<x-admin.form.inputs.text tooltip="{{__('webCaption.order.caption')}}" label="{{__('webCaption.order.title')}}"  for="order"  name="order"  placeholder="{{__('webCaption.order.title')}}" value="{{old('order', isset($menu->order)?$menu->order:'' )}}"  required="" />
							  
					    </div>
						<div class="form-group">
							<x-admin.form.inputs.text tooltip="{{__('webCaption.permission_slug.caption')}}" label="{{__('webCaption.permission_slug.title')}}" maxlength="255"  for="permission_slug"  name="permission_slug"  placeholder="{{__('webCaption.permission_slug.title')}}" value="{{old('permission_slug', isset($menu->permission_slug)?$menu->permission_slug:'' )}}"  required="required" />
							
						</div>
						<div class="form-group">
							<x-admin.form.label for="" tooltip="{{__('webCaption.type.caption')}}"  value="{{__('webCaption.type.title')}}" class="" />
							 
							  <x-admin.form.inputs.radio for="Permission" customClass="type" name="type" tooltip="{{__('webCaption.permission.caption')}}" label="{{__('webCaption.permission.title')}}"  value="permission"  required="required" checked="{{ ((old('type') == 'permission') || ( (isset($menu->type)) && ( $menu->type == 'permission') ) ) ? 'checked' : '' }}" required="required" />
			
							  <x-admin.form.inputs.radio for="Menu" customClass="type" name="type" tooltip="{{__('webCaption.menu.caption')}}" label="{{__('webCaption.menu.title')}}" value="menu"  required="required"  checked="{{ ((old('type') == 'menu') ||  ( (isset($menu->type)) && ( $menu->type == 'menu') ) ) || (!isset($menu->id)) ? 'checked' : '' }}" required="required" />
				  
							  @if($errors->has('type'))
							  <x-admin.form.form_error_messages message="{{ $errors->first('type') }}"  />
							  @endif
				  
						</div>
						<div id="dib" style="display: none" >

							<div class="form-group">
								<x-admin.form.label for="" tooltip="{{__('webCaption.icon.caption')}}"  value="{{__('webCaption.icon.title')}}" class="" />
								{{-- <label for="icon" tooltip="{{__('webCaption.icon.caption')}}">{{__('webCaption.icon.title')}}</label> --}}
	
								<div class="input-group">
									<x-admin.form.inputs.text   class="form-control icp icp-auto" name="icon" maxlength="50" placeholder="{{__('webCaption.icon.title')}}" value="{{old('icon', isset($menu->icon)?$menu->icon:'' )}}"  required="" />
									<span class="input-group-addon input-group-text"></span> 
								</div>
								
							</div>
							  <div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.uri.caption')}}" label="{{__('webCaption.uri.title')}}"  for="uri" maxlength="255"  name="uri"  placeholder="{{__('webCaption.uri.title')}}" value="{{old('uri', isset($menu->uri)?$menu->uri:'' )}}"  required="" />
								
							  </div>
	
							  {{-- <div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.permission.caption')}}" label="{{__('webCaption.permission.title')}}"  for="justAnInputBox1"  name="sel_permission"  placeholder="{{__('webCaption.permission.title')}}" value="{{old('sel_permission', isset($data->sel_permission)?$data->sel_permission:'' )}}"  required="" />
							</div> --}}
							  
							  <div class="form-group">
								<x-admin.form.inputs.text tooltip="{{__('webCaption.language_slug.caption')}}"  label="{{__('webCaption.language_slug.title')}}"  for="slug"  maxlength="255"  name="slug"  placeholder="{{__('webCaption.language_slug.title')}}" value="{{old('slug', isset($menu->slug)?$menu->slug:'' )}}"  required="" />
								
							</div>
							
						</div>
						
						<div class="form-group">
					    	<div class="form-group">
                                <x-admin.form.inputs.select tooltip="{{__('webCaption.module.caption')}}"  label="{{__('webCaption.module.title')}}" for="company_module_id" name="company_module_id" placeholder="{{__('webCaption.module.title')}}" :optionData="$modules" editSelected="{{(isset($menu->company_module_id) && ($menu->company_module_id != null))?$menu->company_module_id :''; }}"   required=""   />
                            </div>
					  	</div>
					  	
					  	<div class="form-group text-center">
							<input type="hidden" name="id" value="@if(isset($menu->id) && !empty($menu->id)){{$menu->id}}@endif" />
					  		<button type="submit" class="btn btn-success">{{__('webCaption.create.title')}}</button>
					  	</div>
					</form>
				</div>
			</div>
			
		</div>
		<div class="col-md-6">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">{{__('webCaption.list.title')}} </h3>
				</div>
				<div class="card-body">
					<ul id="tree"></ul>
				</div>
			</div>
		</ul>
		</div>
		
	</div>
</div>
@include('components.admin.alerts.delete-alert-box')
@endsection

@push('script')
  <script src="{{ asset('assets/js/gabs/master.js') }}"></script>
  
<script>

	var checkedRadio = 	$(".type:checked").val();

	if(checkedRadio == 'menu'){
		$("#dib").css("display", "block");
	}

	$(".type").change(function(){
        var val = $(".type:checked").val();

		if(val == 'permission'){
			$("#dib").css("display", "none");
		}else{
			$("#dib").css("display", "block");
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
	        	url: "{{ route('company.menu-groups.update-menu-position') }}",
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
	        var action = "{{ url('admin/company/menu-groups/delete-menu') }}";
			deleteSingleData(id,'' ,action);		

	    });
	});

	function editMenu(id) {
		window.location.href = "/admin/company/menu-groups/menu/"+id+"/edit";
	}

</script>

<script type="text/javascript">
	
	var menuData = <?php print_r(json_encode($selectableMenuData)) ?>;
	var selectedParent = <?php echo '['.$sel.']'; ?> ;
	var  comboTree2;

	jQuery(document).ready(function($) {
		
		comboTree2 = $('#justAnInputBox2').comboTree({
			source : menuData,
			isMultiple: false,
			selected: selectedParent
		});
	});
</script>
@endsection