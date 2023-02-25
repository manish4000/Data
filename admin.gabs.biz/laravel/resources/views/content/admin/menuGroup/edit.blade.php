@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])

<!-- @section('content_header')
    <h1>Menu Group</h1>
@stop -->

@section('content')
<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">Edit</h3>
	</div>
	<div class="card-body">
		<form action="{{ route('menu-groups.store')}}" method="POST">
			@csrf
			{{-- @method('PUT') --}}
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="email">Title:</label>
						<input type="hidden" name="id"  value="{{$group->id}}" id="id">
						<input type="text" name="title" class="form-control" placeholder="Enter Title" id="title" value="{{ old('title', $group->title)}}" required>
						@if ($errors->has('title'))
		                    <span class="text-danger">{{ $errors->first('title') }}</span>
		                @endif
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="email">Order:</label>
						<input type="text" name="order" class="form-control" placeholder="Enter Order" id="order" value="{{ old('order',$group->order)}}" required>
						@if ($errors->has('order'))
		                    <span class="text-danger">{{ $errors->first('order') }}</span>
		                @endif
					</div>
				</div>
				@if ( isset($activeSiteLanguages) && count($activeSiteLanguages) > 0 )
					<!-- @php $i=0; @endphp -->
			 		@foreach ( $activeSiteLanguages as $language )
			 			@php 
			 			$value = ""; 
			 			if ( isset($group->title_languages[$language->id]) ) {
			 				$value = $group->title_languages[$language->id]['title'];
			 			}
			 			@endphp
			 			<div class="col-md-6">
							<div class="form-group">
								<label for="title_languages">{{ $language->language_en }} Title:</label>
								<input type="text" name="title_languages[{{$language->id}}][title]" class="form-control" placeholder="Enter Title" id="title" value="{{ old('title', $value)}}" >
								@if ($errors->has('title_languages[{{$language->id}}][title]'))
				                    <span class="text-danger">{{ $errors->first('title_languages[$language->id][title]') }}</span>
				                @endif
							</div>
						</div>
						<!-- @php $i++; @endphp -->
			 		@endforeach
			 	@endif
			</div>
		  	
		  	<div class="form-group">
		  		<button type="submit" class="btn btn-primary">Update</button>
				  <a href="{{ route('menu-groups.index') }}" class="btn btn-primary btn float-right">List</a>
		  	</div>
		</form>
	</div>
</div>
@endsection