@extends('layouts/contentLayoutMaster')

<!-- @section('content_header')
    <h1>Role</h1>
@stop -->

@section('content')
<div class="py-3">
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Edit</h3>
		</div>
		<div class="card-body">
			@if ($role)
			<form action="{{ route('roles.update', $role->id)}}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="email">Name:</label>
							<input type="text" name="name" class="form-control" placeholder="Enter name" id="name" value="{{ old('name', $role->name) }}" required>
							@if ($errors->has('name'))
			                    <span class="text-danger">{{ $errors->first('name') }}</span>
			                @endif
						</div>
					</div>
				</div>

		    	<label for="email">Permissions:</label>
		  		@if ($permissions)
		  			<ul style="list-style: none;">
				    	@foreach ( $permissions as $permission )
			                <li>
			                	<label class="form-check-label">
						      		<input class="form-check-input" value="{{ $permission->id }}" type="checkbox" name="permissions[]" <?php if ($role->hasPermissionTo($permission)) echo 'checked'; ?> > {{ $permission->name }}
						    	</label>
			                </li>
			                @if(count($permission->child) > 0)
			                    @include('admin.roles.role_permission_child_list',['items' => $permission->child])
			                @endif
		                @endforeach
		            </ul>
		    	@endif
			  	
			  	<div class="form-group">
			  		<button type="submit" class="btn btn-primary">Update</button>
			  	</div>
			</form>
			@endif
		</div>
	</div>
</div>
@endsection