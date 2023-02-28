@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.edit_department.title') )
@else
@section('title', __('webCaption.add_department.title'))
@endif

@section('content')
<form action="{{ route('department.store')}}" method="POST">
@csrf
<section >
  <div class="card">
    <div class="card-header">
			<h4 class="card-title">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
			</svg>
			@if(isset($data->id))  {{__('webCaption.edit_department.title')}}  @else {{__('webCaption.add_department.title')}} @endif 
			</h4>  
		</div>
		<hr class="m-0 p-0">

    <div class="card-body">
      <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <x-admin.form.inputs.text tooltip="{{__('webCaption.title.caption')}}" label="{{__('webCaption.title.title')}}" maxlength="150" for="title" class="form-control" name="title"  placeholder="{{ __('webCaption.title.title') }}" value="{{old('title', isset($data->title)?$data->title:'' )}}"  required="required" />
              @if($errors->has('title'))
                <x-admin.form.form_error_messages message="{{ $errors->first('title') }}"  />
              @endif
            </div>    
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <x-admin.form.inputs.text tooltip="{{__('webCaption.slug.caption')}}" label="{{__('webCaption.slug.title')}}" maxlength="150" for="slug" class="form-control" name="slug"  placeholder="{{ __('webCaption.slug.title') }}" value="{{old('slug', isset($data->slug)?$data->slug:'' )}}"  required="required" />
              @if($errors->has('slug'))
              <x-admin.form.form_error_messages message="{{ $errors->first('slug') }}"  />
              @endif
            </div>    
          </div>
      </div>       
    </div>
  </div>
  
  <div class="text-center">
    <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
  @if(isset($data->id))   <x-admin.form.buttons.update />  @else    <x-admin.form.buttons.create />   @endif
  </div>
</section>
</form>
@endsection