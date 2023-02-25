@extends('adminlte::page')

@section('content_header')
<h1>Edit Menu</h1>
@stop
@section('content')
<div class="container py-3">
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Edit </h3>
		</div>
		<div class="card-body">
			<form action="{{ route('menu.update', $menu->id)}}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="parent_id">Parent:</label>
							<select class="form-control" name="parent_id">
								<option value="">---Select---</option>
								@foreach($menuList as $value)
									<option value="{{ $value->id }}" <?php if ($menu->parent_id == $value->id) echo 'selected'; ?>>{{ $value->title }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Title:</label>
							<input type="text" name="title" class="form-control" placeholder="Enter Title" id="title" value="{{ old('title', $menu->title )}}" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
					  	<div class="form-group">
					    	<label for="uri">URI:</label>
					    	<input type="text" name="uri" class="form-control" placeholder="Enter URI" id="uri" value="{{ old('uri', $menu->uri) }}">
					  	</div>
				  	</div>
			  	</div>

			  	<div class="form-group">
			  		<button type="submit" class="btn btn-primary">Update</button>
			  	</div>
			</form>
		</div>
	</div>
</div>
@stop