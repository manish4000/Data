@extends('layouts/contentLayoutMaster')

{{-- @section('title', $pageConfigs['moduleName']) --}}
@if(isset($data->id) && !empty($data->id))
@section('title', 'Company Edit')
@else
@section('title', 'Company Add')
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
<!-- users edit start -->

<form action="{{route('company.store')}}" method="POST">
  @csrf
  <section class="form-control-repeater">
    <div class="card">
      
      <div class="card-body">
          <div class="row">
              <div class="col-md-4">
                  <div class="form-group">
                    <x-admin.form.inputs.text id="" for="name" label="Name" class="form-control" name="name"  placeholder="{{ __('locale.company.name') }}" value="{{old('name', isset($data->name)?$data->name:'' )}}"  required="required" />
                    @if($errors->has('name'))
                      <x-admin.form.form_error_messages message="{{ $errors->first('name') }}" />
                    @endif
                  </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.text id="" label="Short Name" for="short_name" class="form-control"  name="short_name"  placeholder="{{ __('locale.company.short_name') }}" value="{{old('short_name', isset($data->short_name)?$data->short_name:'' )}}"  required="required" />
                  @if($errors->has('short_name'))
                    <x-admin.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                  @endif
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.text id="" for="company_name"  label="Company Name"  class="form-control" name="company_name"  placeholder="{{ __('locale.company.company_name') }}" value="{{old('company_name', isset($data->company_name)?$data->company_name:'' )}}"  required="required" />
                  @if($errors->has('company_name'))
                    <x-admin.form.form_error_messages message="{{ $errors->first('company_name') }}" />
                  @endif
                </div>
              </div>
          </div>  

          <div class="row">

            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.email  label="Email" for="email" class="form-control" name="email"  placeholder="{{ __('locale.company.email') }}" value="{{old('email', isset($data->email)?$data->email:'' )}}"  required="required" />
                @if($errors->has('email'))
                  <x-admin.form.form_error_messages message="{{ $errors->first('email') }}" />
                @endif
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.text id="" label="Password"  for="password" class="form-control" name="password"  placeholder="{{ __('locale.company.password') }}" value="{{old('password', isset($data->password)?$data->password:'' )}}"  required="required" />
                @if($errors->has('password'))
                  <x-admin.form.form_error_messages message="{{ $errors->first('password') }}" />
                @endif
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.text id="" for="phone" label="Phone" class="form-control" name="phone"  placeholder="{{ __('locale.company.phone') }}" value="{{old('phone', isset($data->phone)?$data->phone:'' )}}"  required="" />
                @if($errors->has('phone'))
                  <x-admin.form.form_error_messages message="{{ $errors->first('phone') }}" />
                @endif
              </div>
            </div>
            
          
            
          </div>
      
          <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.text id=""  maxlength="80" for="designation" label="Designation" class="form-control" name="designation"  placeholder="{{ __('locale.company.designation') }}" value="{{old('designation', isset($data->designation)?$data->designation:'' )}}"  required="" />
                  @if($errors->has('designation'))
                    <x-admin.form.form_error_messages message="{{ $errors->first('designation') }}" />
                  @endif
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
            
                  <x-admin.form.inputs.text  for="ip_address"  maxlength="80" label="IP Address" id="" class="form-control" name="ip_address"  placeholder="{{ __('locale.company.ip_address') }}" value="{{old('ip_address', isset($data->ip_address)?$data->ip_address:'' )}}"  required="" />
                  @if($errors->has('ip_address'))
                    <x-admin.form.form_error_messages message="{{ $errors->first('ip_address') }}" />
                  @endif
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.text  for="operating_system" label="Operating System" id="" class="form-control" name="operating_system"  placeholder="{{ __('locale.company.operating_system') }}" value="{{old('operating_system', isset($data->operating_system)?$data->operating_system:'' )}}"  required="" />
                  @if($errors->has('operating_system'))
                    <x-admin.form.form_error_messages message="{{ $errors->first('operating_system') }}" />
                  @endif
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <x-admin.form.inputs.text id="" label="Whatsapp Number" for="whatapp_no" class="form-control" name="whatapp_no"  placeholder="{{ __('locale.company.whatapp_no') }}" value="{{old('whatapp_no', isset($data->whatapp_no)?$data->whatapp_no:'' )}}"  required="" />
                  @if($errors->has('whatapp_no'))
                    <x-admin.form.form_error_messages message="{{ $errors->first('whatapp_no') }}" />
                  @endif
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group"> 
                @php if(isset($data->business_type_id)){
                    $editSelected = $data->business_type_id;
                  } else{
                    $editSelected = '';
                  }
                  @endphp
                  <x-admin.form.inputs.multiple_select label="Business Types" for="business_type_id" id=""  name="business_type_id[]"  :oldValues="old('business_type_id')" value="" required=""   :editSelected="$editSelected"  :optionData="$BusinessTypes" required="" />
                  @if($errors->has('business_type_id'))
                    <x-admin.form.form_error_messages message="{{ $errors->first('business_type_id') }}" />
                  @endif
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
          
                  <x-admin.form.inputs.select  id="country_id" label="Country" for="country_id" name="country_id" value="" editSelected="{{(isset($data->country_id) && ($data->country_id != null))?$data->country_id :''; }}" required="" :optionData="$country" />
                  @if($errors->has('country_id'))
                    <x-admin.form.form_error_messages message="{{ $errors->first('country_id') }}" />
                  @endif
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="form-group">
                  {{-- <x-admin.form.inputs.select  id="type" label="Type" for="type" name="type" value="" editSelected="" required="" :optionData="$types" /> --}}
                  <x-admin.form.inputs.select  id="type_id" label="Type" for="type_id" name="type_id" value="" editSelected="{{(isset($data->type_id) && ($data->type_id != null))?$data->type_id :''; }}" required="" :optionData="$types" />
                </div>
              </div>
            
          </div>
      
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.select label="Status"  id="" for="status" name="status" placeholder="{{ __('locale.Parent.caption') }}" editSelected="{{(isset($data->status) && ($data->status != null))?$data->status :''; }}"  required="required" :optionData="$status" />
                @if($errors->has('status'))
                  <x-admin.form.form_error_messages message="{{ $errors->first('status') }}" />
                @endif
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.text  for="tax_id_no" label="Tax Id No" class="form-control" name="tax_id_no"  placeholder="{{ __('locale.company.tax_id_no') }}" value="{{old('tax_id_no', isset($data->tax_id_no)?$data->tax_id_no:'' )}}" required=""   />
                @if($errors->has('tax_id_no'))
                  <x-admin.form.form_error_messages message="{{ $errors->first('tax_id_no') }}" />
                @endif
              </div>
            </div>
          
            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.date  for="register_on" label="Register On" id="" class="form-control" name="register_on"  placeholder="{{ __('locale.company.register_on') }}" value="{{old('register_on', isset($data->register_on)?$data->register_on:'' )}}"  />
                @if($errors->has('register_on'))
                  <x-admin.form.form_error_messages message="{{ $errors->first('register_on') }}" />
                @endif
              </div>
            </div>
          </div>
        
          <div class="row">
              <div class="col-md-4">
                <div class="form-group">
        
                  <x-admin.form.inputs.textarea  for="address" label="Address" class="form-control" name="address"  placeholder="{{ __('locale.company.address') }}" value="{{old('address', isset($data->address)?$data->address:'' )}}"   />
                  @if($errors->has('address'))
                    <x-admin.form.form_error_messages message="{{ $errors->first('address') }}" />
                  @endif
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
        
                  <x-admin.form.inputs.textarea  for="marketing_status" label="Marketing Status" id="" class="form-control" name="marketing_status"  placeholder="{{ __('locale.company.marketing_status') }}" value="{{old('marketing_status', isset($data->marketing_status)?$data->marketing_status:'' )}}"   />
                  @if($errors->has('marketing_status'))
                    <x-admin.form.form_error_messages message="{{ $errors->first('marketing_status') }}" />
                  @endif
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
      
                  <x-admin.form.inputs.textarea  label="Marketing Memo History" for="marketing_memo_history" class="form-control" name="marketing_memo_history"  placeholder="{{ __('locale.company.marketing_memo_history') }}" value="{{old('marketing_memo_history', isset($data->marketing_memo_history)?$data->marketing_memo_history:'' )}}"   />
                  @if($errors->has('marketing_memo_history'))
                    <x-admin.form.form_error_messages message="{{ $errors->first('marketing_memo_history') }}" />
                  @endif
                </div>
              </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.textarea  label="Admin Comment" for="admin_comment" id="" class="form-control" name="admin_comment"  placeholder="{{ __('locale.company.admin_comment') }}" value="{{old('admin_comment', isset($data->admin_comment)?$data->admin_comment:'' )}}"  />
                @if($errors->has('admin_comment'))
                  <x-admin.form.form_error_messages message="{{ $errors->first('admin_comment') }}" />
                @endif
              </div>
            </div>
          </div>

          <div class="row">
			  		<div class="col-md-12">
					  	<label for="permissions">Permissions:</label>
				    	@if ($permissions)
				    	<div class="jstree-basic">
						    <ul>
						    	@foreach ( $permissions as $permission )
					                @if(count($permission->menuChild) > 0)
					                	<li class="jstree-open">
						                	<label class="form-check-label">
											    <input class="form-check-input" value="{{ $permission->id }}" type="checkbox" name="permissions[]" > {{ $permission->title }}
										    	</label>
                          @include('content.admin.company.child_list',['items' => $permission->menuChild, 'user' => '' ])
						                </li>
						            @else
						            	<li>
						                	<label class="form-check-label">
											    <input class="form-check-input" value="{{ $permission->id }}" type="checkbox" name="permissions[]" > {{ $permission->title }}
											</label>
						                </li>
					                @endif
				                @endforeach
				            </ul>
				        </div>
				    	@endif
				    </div>
				</div>
      </div>
    </div>
  </section>
  <div>
    <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
     @if(isset($data->id)) <x-admin.form.buttons.update />   @else <x-admin.form.buttons.create />    @endif 
  </div>
  </form>
@endsection


@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
@endsection
@push('script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>

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