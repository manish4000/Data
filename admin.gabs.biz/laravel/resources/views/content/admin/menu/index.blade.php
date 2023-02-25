@extends('adminlte::page')

@section('content_header')
	<h1>Menu</h1>
@stop

@section('content')

<div class="container py-3">
	<div class="row">
		<div class="col-md-6">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">List </h3>
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
			@can('add-menu')
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Create</h3>
				</div>
				<div class="card-body">
					<form action="{{ route('menu.store')}}" method="POST">
						@csrf
						<div class="form-group">
							<label for="parent_id">Parent:</label>
							<select class="form-control" name="parent_id">
								<option value="">---Select---</option>
								@foreach($menus as $menu)
									<option value="{{ $menu->id }}">{{ $menu->title }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="title">Title:</label>
							<input type="text" name="title" class="form-control" placeholder="Enter Title" id="title" value="{{ old('title')}}" required>
						</div>
						<div class="form-group">
	                        <label for="icon">Icon:</label>

	                        <div class="input-group">
	                            <input data-placement="bottomRight" name="icon" class="form-control icp icp-auto" value="fas fa-archive"
	                                   type="text"/>
	                            <span class="input-group-addon input-group-text"></span>
	                        </div>
	                    </div>
					  	<div class="form-group">
					    	<label for="uri">URI:</label>
					    	<input type="text" name="uri" class="form-control" placeholder="Enter URI" id="uri" value="{{ old('uri')}}">
					  	</div>

					  	<div class="form-group">
					    	<label for="uri">Permissions:</label>
						  	<select multiple="multiple" id="permissions" name="permissions">
						  		@foreach ( $permissions as $permission )
						  			<option value="{{ $permission->slug }}" data-parent="{{ $permission->parent_id }}" >{{ $permission->name }}</option>
						  		@endforeach
					        </select>
					    </div>
					  	
					  	<div class="form-group">
					  		<button type="submit" class="btn btn-primary">Submit</button>
					  	</div>
					</form>
				</div>
			</div>
			@endcan
		</div>
	</div>
</div>
@endsection

@section('css')
{{-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> --}}
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/treeSortable.css') }}" rel="stylesheet" />
<link href="{{ asset('css/jquery.bootstrap.treeselect.css') }}" rel="stylesheet" />
<link href="{{ asset('css/fontawesome-iconpicker.min.css') }}" rel="stylesheet" />
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.1.0.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/treeSortable.js') }}"></script>
<script src="{{ asset('js/fontawesome-iconpicker.js') }}"></script>
<script src="{{ asset('js/jquery.bootstrap.treeselect.js') }}"></script>
<script>
	$(document).ready(function () {
		$('#permissions').treeselect();

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
	        		alert('Menu update successfully!');
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

	        const confirm = window.confirm('Are you sure you want to delete this branch?');
	        if (!confirm) {
	            return;
	        }

	        $(this).removeBranch();
	        // window.location.href = "/admin/menu/"+id+"/delete";
	    });
	});

	function editMenu(id) {
		window.location.href = "/admin/menu/"+id+"/edit";
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
@stop