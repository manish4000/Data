@extends('layouts/contentLayoutMaster')
@section('title', $pageConfigs['moduleName'])
@section('content')
<div>
	<div class="row">
		<div class="col-md-12 m-auto">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" title="{{__('webCaption.search_filter.caption')}}"  data-toggle="tooltip" > {{__('webCaption.search_filter.title')}} </h4>                    
				</div>
				<div class="card-body">
					<form method="GET" action="{{route('users.index')}}">
						<div class="d-flex justify-content-between align-items-center  row pt-0 pb-2">
							<div class="col-md-3">
								<div class="form-group">
									<x-admin.form.inputs.text id="searchKeyword" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}" for="{{__('webCaption.keyword.title')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
								</div>
							</div>
							<div class="col-md-6 offset-md-3 text-md-center">
								<x-admin.form.buttons.search />
								<x-admin.form.buttons.reset href="{{route('users.index')}}" />
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="card card-default">
				<div class="card-body">
					@if(count($users) > 0) 
						<div class="table-responsive">
							<div class="mt-2">
								{{ $users->onEachSide(5)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
							</div>
							<table class="table">
								<thead>
									<tr>
										<th scope="col" class="position-for-filter-heading">#
											<x-admin.filter.order-by-filter-div orderBy="id" />
										</th>
										<th class="position-for-filter-heading" scope="col" data-toggle="tooltip" title="{{__('webCaption.name.caption')}}" >
											{{__('webCaption.name.title')}}
											<x-admin.filter.order-by-filter-div orderBy="name" />
										</th>
										<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.email.caption')}}" >
											{{__('webCaption.email.title')}}
											<x-admin.filter.order-by-filter-div orderBy="email" />
										</th>
										<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.active.caption')}}">{{__('webCaption.active.title')}}
										</th>
										<th scope="col" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}"  > {{__('webCaption.actions.title')}}
										</th>
										<th scope="col" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}"  > OR SCAN
										</th>
									</tr>
								</thead>
								<tbody>
									{{-- @php 
									$i = 1;
									$page = \Request::get('page');
									$currentPage = isset($page) ? $page : "1";
									@endphp --}}
									@foreach ($users as $user)
										<tr>
											<th scope="row">{{$user->id}}</th>
											<td>{{ $user->name; }}</td>
											<td>{{ $user->email }}</td>
											@php 
											  $checked = ($user->status == 1) ? "checked" : "";
											@endphp
											
											<td><x-admin.form.buttons.activeToggle href="{{route('users.update-status',$user->id)}}"  checked="{{$checked}}" /></td>
											<td>
												@can('settings-users-edit')
												<x-admin.form.buttons.edit href="{{ route('users.edit', $user->id) }}" />&ensp;
												@endcan 
												@can('settings-users-delete')
													<x-admin.form.buttons.delete id="{{$user->id}}" name="{{$user->name}}" url="{{route('users.delete')}}" action="{{route('users.delete', $user->id) }}" />   
												@endcan
											</td>
											<td>
												@if(isset($user->google2fa_secret))
													<a  data-toggle="modal" data-id="{{$user->id}}"  data-device_info="{{$user->device_description}}" class="2faModelUpdate"> <i class="fa fa-refresh fa-2x" aria-hidden="true"></i> &nbsp; <i class="fa fa-qrcode text-dark fa-2x"></i>
													</a>
												@else
													<a  data-toggle="modal" data-id="{{$user->id}}"  class="2faModelCreate"> <i class="fa fa-plus fa-2x" aria-hidden="true"></i> &nbsp; <i class="fa fa-qrcode text-dark fa-2x"></i>
													</a>
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							<div class="mt-2">
								{{ $users->onEachSide(5)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
							</div>
						</div>	
					@else
						<div class="text-center my-2">
							<h3>{{__('webCaption.record_not_found.title')}} </h3>
						</div>
					@endif
					
				</div>
			</div>
		</div>
	</div>
</div>

{{-- model popup code  --}}
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLongTitle"></h5>
		  <button type="button" class="close" onclick="resetForm()" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12 ">
					<div class="card card-default">
						<h4 class="card-heading text-center mt-4">Set up Google Authenticator</h4>
		
						<div class="card-body">
							<div class="text-center">
								<p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code 
								  <span id="2fa_secret"><strong></strong> </span> </p>
								<div  id="qr-image">
								   
								</div>
								
							</div>
							<p>You must set up your Google Authenticator app before continuing.</p>

							@if($errors->any())
								<div class="col-md-12">
									<div class="alert alert-danger">
									<strong>{{$errors->first()}}</strong>
									</div>
								</div>
						    @endif

							<form class="" id="verify-form" method="POST" action="{{ route('users.verify-2fa') }}">
								{{ csrf_field() }}

								<div class="form-group">							
									<x-admin.form.inputs.text id="one_time_password" for="one_time_password" label="{{__('webCaption.one_time_password.title')}}" tooltip="{{__('webCaption.one_time_password.caption')}}" for="{{__('webCaption.one_time_password.title')}}"  class="form-control" name="one_time_password"  placeholder="{{__('webCaption.one_time_password.title')}}" value=""  required="" />
									<input value="" id="id" type="hidden" class="form-control" name="id" value="" required >
							    </div>
								<div class="form-group">							
									<x-admin.form.inputs.textarea  for="device_description" label="{{__('webCaption.device_description.title')}}" class="form-control" tooltip="{{__('webCaption.device_description.caption')}}" name="device_description"  placeholder="{{ __('webCaption.device_description.title') }}" value="{{old('device_description')}}"   />
										@if($errors->has('device_description'))
										  <x-admin.form.form_error_messages message="{{ $errors->first('device_description') }}" />
										@endif
							    </div>
								<div class="form-group text-center">
									<x-admin.form.buttons.custom value="{{__('webCaption.verify.title')}}" iconClass="" color="btn-primary" />
								</div>
							</form>

						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" onclick="resetForm()"  data-dismiss="modal">Close</button>
		</div>
	  </div>
	</div>
  </div>

{{--  --}}
{{-- model popup code  --}}
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLongTitle"></h5>
		  <button type="button" class="close" onclick="resetForm()" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12 mt-4">
					<div class="card card-default">
						<h4 class="card-heading text-center mt-4">Set up Google Authenticator</h4>
						
						<div class="card-body" >
							<div class="text-center">
								<p id="device_info" class="text-center">

								</p>
								<div id="qr-image">
									<img src="{{asset('assets/images/qr-code.jpg')}}" alt="">
								</div>

							</div>
							@if($errors->any())
								<div class="col-md-12">
									<div class="alert alert-danger">
									<strong>{{$errors->first()}}</strong>
									</div>
								</div>
						    @endif

							<form class="" id="update-verify-form" method="POST" action="{{ route('users.verify-2fa') }}">
								{{ csrf_field() }}

								<div class="form-group">							
									<x-admin.form.inputs.text id="one_time_password" for="one_time_password" label="{{__('webCaption.one_time_password.title')}}" tooltip="{{__('webCaption.one_time_password.caption')}}" for="{{__('webCaption.one_time_password.title')}}"  class="form-control" name="one_time_password"  placeholder="{{__('webCaption.one_time_password.title')}}" value=""  required="" />
									<input value="" id="update-id" type="hidden" class="form-control" name="id" value="" required >
									<p>Please enter the  <strong>OTP</strong> From last scanned device to update.</p>
							    </div>

	
								<div class="form-group text-center">
									
									{{-- <button type="submit" class="btn btn-primary">
										Verify 
									</button> --}}
									<x-admin.form.buttons.update/>
									<a href="" id="delete-2fa" class="btn btn-danger">Delete</a>
									
								</div>
							</form>

						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" onclick="resetForm()"  data-dismiss="modal">Close</button>
		</div>
	  </div>
	</div>
  </div>

{{--  --}}
@include('components.admin.alerts.delete-alert-box')
@include('components.admin.filter.order-by')


@push('script')

<script>
	$(".2faModelCreate").click(function(){
		let id = $(this).attr("data-id");
		generate(id);
	});


	function generate(id){

		$.ajax({
	        	url: "{{ route('users.2fa') }}",
	        	data: {'id':id },
	        	type: "post",
	        	success: function(data) {
					$('#qr-image').html(data.qr_image);
					$('#2fa_secret').html("<strong>"+data.google2fa_secret + "</strong>");
					$('#id').val(id);
					$('#exampleModalCenter').modal('show');
	        	},
	        	error: function() {}
	        });
	}


	$(".2faModelUpdate").click(function(){
		
		let id = $(this).attr("data-id");
		let device_info = $(this).attr("data-device_info");
		$('#update-id').val(id);

		let url = '{{route('users.delete-2fa',":id")}}';
		url = url.replace(':id', id);

		$('#delete-2fa').attr("href",url)
		$('#device_info').html("Device Details : "+ device_info);
		$('#exampleModal').modal('show');

	});

    function resetForm(){
		$('#verify-form')[0].reset();
	}

	$('#update-verify-form').on('submit' ,function(e){
		event.preventDefault();

         let usrid =	$('#update-verify-form #update-id').val();

			$.ajax({
			type: 'POST',
			url: "{{ route('users.update-verify-2fa') }}",
			data: $('#update-verify-form').serialize(),
			success: function (data) {

				if(data.result.status == true){
					$('#exampleModal').modal('hide');
					generate(usrid);
				}else{

					errorToast(data.result.message);
				}

			}
		});
	
	});



	$('#verify-form').on('submit' ,function(e){
		event.preventDefault();

			$.ajax({
			type: 'POST',
			url: "{{ route('users.verify-2fa') }}",
			data: $('#verify-form').serialize(),
			success: function (data) {

				if(data.result.status == true){
					$('#exampleModalCenter').modal('hide');
					successToast(data.result.message);
					location.reload();
				}else{
					errorToast(data.result.message);
				}

			}
		});
	
	});

</script>

@endpush


@endsection
