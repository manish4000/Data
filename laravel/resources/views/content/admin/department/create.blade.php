@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.edit_department.title') )
@else
@section('title', __('webCaption.add_department.title'))
@endif


@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('fonts/font-awesome/css/font-awesome.min.css'))}}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css'))}}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-tree.css')) }}">
@endsection

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
              <x-admin.form.inputs.text tooltip="{{__('webCaption.title.caption')}}" label="{{__('webCaption.title.title')}}" maxlength="150" for="title" name="title"  placeholder="{{ __('webCaption.title.title') }}" value="{{old('title', isset($data->title)?$data->title:'' )}}"  required="required" />
            </div>    
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <x-admin.form.inputs.text tooltip="{{__('webCaption.slug.caption')}}" label="{{__('webCaption.slug.title')}}" maxlength="150" for="slug" name="slug"  placeholder="{{ __('webCaption.slug.title') }}" value="{{old('slug', isset($data->slug)?$data->slug:'' )}}"  required="required" />
            </div>    
          </div>
      </div>  
      <div class="row">
        <div class="row mt-2">
          <div class=" m-2 col-md-12">

            <x-admin.form.label for="" tooltip="{{__('webCaption.permission.caption')}}" value="{{__('webCaption.permission.title')}}" class="" />
            <div>             
              @if ($permissions)
                @foreach($permissions as $key => $per_data)

                <?php 
                $group_name =  DB::table('menu_groups')->where('id', $key)->value('title');
                ?>
                  <div class="m-1 ">   <h4 class="text-primary">{{$group_name}} </h4>  </div>
                  
                  
                    <div class="jstree-basic"> 
                      @foreach ( $per_data as $permission )
                          <ul>
                            <?php
                              $checked_permission =  ( isset($data->permissions) && in_array($permission->id ,$data->permissions))? 'checked' : '';
                            ?>
                              @if(count($permission->menuChild) > 0)
  
                                <li class="jstree-open" data-jstree='{ "icon" : "fa fa-key"}'>
                                  <label class="form-check-label">
                                  
                                    <x-admin.form.inputs.checkbox  for="{{$permission->id}}permission" name="permissions[]" label="{{ $permission->title }}" checked="{{$checked_permission}}"  value="{{ $permission->id }}"  customClass="form-check-input"  />													
                                  </label>
                                  @include('content.admin.department.child_list',['items' => $permission->menuChild ]) 												
                                </li>
                              @else
                                <li>
                                  <label class="form-check-label">
                                    <x-admin.form.inputs.checkbox  for="{{$permission->id}}permission" name="permissions[]" label="{{ $permission->title }}" checked="{{$checked_permission}}"  value="{{ $permission->id }}"  customClass="form-check-input"  />
                                  </label>
                                </li>
                              @endif
                          
                          </ul>
                      @endforeach
                    </div>
                  
                @endforeach    

              @endif
            </div>
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

@push('script')
<script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>

  <script src="{{ asset('assets/js/gabs/master.js') }}"></script>
				
  <script type="text/javascript">
  	$(document).ready(function() {
  		$(".jstree-basic ul li a, .jstree-basic ul li ul li a").each(function() {
        

  		  var attributes = $.map(this.attributes, function(item) {
		    return item.name;

		  });

      
		  var img = $(this);
		  $.each(attributes, function(i, item) {
		    img.removeAttr(item);
		  });
		});
  	})
  </script>
@endpush
