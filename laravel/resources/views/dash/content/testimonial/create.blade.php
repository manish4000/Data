@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.edit_testimonial.title') )
@else
@section('title', __('webCaption.add_testimonial.title'))
@endif


@section('content')
<div>
	<form action="{{ route('dashtestimonial.store')}}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="card card-primary">
			<div class="card-header">
				<h4 class="card-title">
		
				<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
				</svg>
				@if(isset($data->id))  {{__('webCaption.edit_testimonial.title')}}  @else {{__('webCaption.add_testimonial.title')}} @endif 
				</h4>  
			</div>
			<hr class="m-0 p-0">
			<div class="card-body">
				<div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="person_name"  maxlength="100" tooltip="{{__('webCaption.person_name.caption')}}" label="{{__('webCaption.person_name.title')}}"  class="form-control" name="person_name"  placeholder="{{__('webCaption.person_name.title')}}" value="{{old('person_name', isset($data->person_name)?$data->person_name:'' )}}"  required="" />
                            @if ($errors->has('person_name'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('person_name') }}" />
                            @endif
                        </div>
                    </div>

                    @php
                    $old_show_person_name =  session()->getOldInput('show_person_name');
                    $show_person_name =   (isset($old_show_person_name) && $old_show_person_name == 1  ) ? 'checked' : ((isset($data->show_person_name) && $data->show_person_name == 1)? 'checked' :'' );
                    @endphp

                    <div class="col-md-4">
                           <x-admin.form.label for="" value="{{__('webCaption.show_person_name.caption')}}" class="" />
                           <div class="form-group">
                               <x-dash.form.inputs.checkbox  name="show_person_name"  for="" label="{{__('webCaption.show_person_name.caption')}}" checked="{{$show_person_name}}"  value="1"  customClass="form-check-input"  />
                               @if ($errors->has('show_person_name'))
                                   <x-dash.form.form_error_messages message="{{ $errors->first('show_person_name') }}" />
                               @endif
                           </div>
                    </div>
                    <div class="col-md-4">
                        <x-dash.form.label for="" tooltip="{{__('webCaption.testimonial_by.caption')}}" value="{{__('webCaption.testimonial_by.title')}}" class="" />
                        <div class="form-group custom-control custom-checkbox">
                          <x-dash.form.inputs.radio for="Buyer" tooltip="{{__('webCaption.buyer.caption')}}"  class="border border-danger" name="testimonial_by" label="{{__('webCaption.buyer.title')}}"  value="Buyer"  required="required" checked="{{ old('testimonial_by') == 'Buyer' ? 'checked' : '' }} {{ isset($data->testimonial_by) ? $data->testimonial_by == 'Buyer' ? 'checked=checked' :'' :'' }} " required="required" />
              
                          <x-dash.form.inputs.radio for="Dealer" class="border border-danger" name="testimonial_by" tooltip="{{__('webCaption.dealer.caption')}}" label="{{__('webCaption.dealer.title')}}" value="Dealer"  required="required"  checked="{{ old('testimonial_by') == 'Dealer' ? 'checked' : '' }} {{ isset($data->testimonial_by) ? $data->testimonial_by == 'Dealer' ? 'checked=checked' :'' :'' }} " required="required" />

                          @if($errors->has('testimonial_by'))
                          <x-dash.form.form_error_messages message="{{ $errors->first('testimonial_by') }}"  />
                          @endif
                       
                        </div>
                    </div>
                   
				</div>

				<div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="title"  maxlength="100" tooltip="{{__('webCaption.title.caption')}}" label="{{__('webCaption.title.title')}}"  class="form-control" name="title"  placeholder="{{__('webCaption.testimonial_title.title')}}" value="{{old('title', isset($data->title)?$data->title:'' )}}"  required="required" />
                            @if ($errors->has('title'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('title') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="email"  maxlength="100" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}"  class="form-control" name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($data->email)?$data->email:'' )}}"  required="" />
                            @if ($errors->has('email'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('email') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.date  for="posted_date"  maxlength="255" tooltip="{{__('webCaption.posted_date.caption')}}" label="{{__('webCaption.posted_date.title')}}"  class="form-control" name="posted_date"  placeholder="{{__('webCaption.posted_date.title')}}" value="{{old('posted_date', isset($data->posted_date)?$data->posted_date:'' )}}"  required="required" />
                            @if ($errors->has('posted_date'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('posted_date') }}" />
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">    
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.country.title')}}"  tooltip="{{__('webCaption.country.caption')}}" for="country_id" name="country_id" 
                            placeholder="{{ __('locale.country.caption') }}" customClass="country"  editSelected="{{(isset($data->country_id) && ($data->country_id != null))?$data->country_id :''; }}"  required="required" :optionData="$country" />
                            @if($errors->has('country_id'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('country_id') }}"  />
                            @endif
                        </div>
                   </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="phone"  maxlength="15" tooltip="{{__('webCaption.phone.caption')}}" label="{{__('webCaption.phone.title')}}"  class="form-control" name="phone"  placeholder="{{__('webCaption.phone.title')}}" value="{{old('phone', isset($data->phone)?$data->phone:'' )}}"  required="" />
                            @if ($errors->has('phone'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('phone') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.rating.title')}}"  tooltip="{{__('webCaption.rating.caption')}}" for="rating" name="rating"
                                                       placeholder="{{ __('locale.rating.caption') }}" customClass="rating"  editSelected="{{(isset($data->rating) && ($data->rating != null))?$data->rating :''; }}"  required=""  />
                            @if($errors->has('rating'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('rating') }}"  />
                            @endif
                        </div>
                    </div>
				</div>

				<div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="description" tooltip="{{__('webCaption.description.caption')}}"  label="{{__('webCaption.description.title')}}" maxlength="1000" class="form-control" name="description"  placeholder="{{__('webCaption.testimonial_description.title')}}" value="{{old('description', isset($data->description)?$data->description:'' )}}"  required="required" />
                            @if($errors->has('description'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('description') }}"  />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="jct_remark" tooltip="{{__('webCaption.jct_remark.caption')}}"  label="{{__('webCaption.jct_remark.title')}}" maxlength="250" class="form-control" name="jct_remark"  placeholder="{{__('webCaption.jct_remark.title')}}" value="{{old('jct_remark', isset($data->jct_remark)?$data->jct_remark:'' )}}"  required="required" />
                            @if($errors->has('jct_remark'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('jct_remark') }}"  />
                            @endif
                        </div>
                    </div>

                    @php
                    $old_show_jct_remark =  session()->getOldInput('show_jct_remark');
                    $show_jct_remark =   (isset($old_show_jct_remark) && $old_show_jct_remark == 1  ) ? 'checked' : ((isset($data->show_jct_remark) && $data->show_jct_remark == 1)? 'checked' :'' );
                    @endphp

                    
                    <div class="col-md-4">
                        <x-admin.form.label for="" value="{{__('webCaption.show_jct_remark.caption')}}" class="" />
                        <div class="form-group">
                            <x-dash.form.inputs.checkbox  name="show_jct_remark"  for="" label="{{__('webCaption.show_jct_remark.caption')}}" checked="{{$show_jct_remark}}"  value="1"  customClass="form-check-input"  />
                            @if ($errors->has('show_jct_remark'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('show_jct_remark') }}" />
                            @endif
                        </div>
                    </div>

                        
				</div>
				<div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="youtube_url" maxlength="250"  tooltip="{{__('webCaption.youtube_url.caption')}}" label="{{__('webCaption.youtube_url.title')}}"  class="form-control" name="youtube_url"  placeholder="{{__('webCaption.youtube_url.title')}}" value="{{old('youtube_url', isset($data->youtube_url)?$data->youtube_url:'' )}}"  required="required" />
                            @if ($errors->has('youtube_url'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('youtube_url') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="stock_number" maxlength="50"  tooltip="{{__('webCaption.stock_number.caption')}}" label="{{__('webCaption.stock_number.title')}}"  class="form-control" name="d_stock_number"  placeholder="{{__('webCaption.stock_number.title')}}" value="{{old('d_stock_number', isset($data->d_stock_number)?$data->d_stock_number:'' )}}"  required="required" />
                            @if ($errors->has('d_stock_number'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('d_stock_number') }}" />
                            @endif
                        </div>
                    </div>
                    
                    @php
                        $old_verified_buyer =  session()->getOldInput('verified_buyer');
                        $verified_buyer =   (isset($old_verified_buyer) && $old_verified_buyer == 1  ) ? 'checked' : ((isset($data->verified_buyer) && $data->verified_buyer == 1)? 'checked' :'' );
                    @endphp

                    <div class="col-md-4">
                        <x-admin.form.label for="" value="{{__('webCaption.verified_buyer.caption')}}" class="" />
                        <div class="form-group">
                            <x-dash.form.inputs.checkbox  name="verified_buyer"  for="" label="{{__('webCaption.verified_buyer.caption')}}" checked="{{$verified_buyer}}"  value="1"  customClass="form-check-input"  />
                            @if ($errors->has('verified_buyer'))
                                <x-dash.form.form_error_messages message="{{ $errors->first('verified_buyer') }}" />
                            @endif
                        </div>
                    </div>

                        
				</div>

				<div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <x-dash.form.inputs.file id="" caption="{{__('webCaption.user_image.title')}}" ImageId="user-image-preview" for="image"  class="form-control" name="image" editImageUrl="{{ isset($data->image)? asset('company_data/'.$imageFolder.'/testimonials/'.$data->image) :''}}"  placeholder="{{__('webCaption.user_image.title')}}" required="required" />
                          @if($errors->has('user_image'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('user_image') }}"  />
                          @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        
                          <x-dash.form.inputs.file id="" caption="{{__('webCaption.vehicle_image.title')}}" ImageId="vehicle-image-preview" for="vehicle_image" editImageUrl="{{ isset($data->vehicle_image)? asset('company_data/'.$imageFolder.'/testimonials/'.$data->vehicle_image) :''}}"  class="form-control"  name="vehicle_image"  placeholder="{{__('webCaption.vehicle_image.title')}}" required="required" />
                          @if($errors->has('vehicle_image'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_image') }}"  />
                          @endif
                        </div>
                    </div>   
                    
                        @php
                        $old_is_paid =  session()->getOldInput('is_paid');
                        $is_paid =   (isset($old_is_paid) && $old_is_paid == 1  ) ? 'checked' : ((isset($data->is_paid) && $data->is_paid == 1)? 'checked' :'' );
                        @endphp

{{--                    <div class="col-md-4">--}}
{{--                        <x-admin.form.label for="" value="{{__('webCaption.is_paid.caption')}}" class="" />--}}
{{--                        <div class="form-group">--}}
{{--                            <x-dash.form.inputs.checkbox  name="is_paid"  for="" label="{{__('webCaption.is_paid.caption')}}" checked="{{$is_paid}}"  value="1"  customClass="form-check-input"  />--}}
{{--                            @if ($errors->has('is_paid'))--}}
{{--                                <x-dash.form.form_error_messages message="{{ $errors->first('is_paid') }}" />--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>                        --}}
				</div>

			</div>
		</div>
		<div class="form-group text-center">
			<input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
			@if(isset($data->id)) 	<x-dash.form.buttons.update /> @else <x-dash.form.buttons.create/> @endif 
		</div>
    </form>
</div>
@endsection
