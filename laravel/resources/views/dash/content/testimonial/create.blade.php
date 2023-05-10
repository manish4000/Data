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
                          <x-dash.form.inputs.file id="" caption="{{__('webCaption.user_image.title')}}" ImageId="user-image-preview" for="image"   name="image" editImageUrl="{{ isset($data->image)? asset('company_data/'.$imageFolder.'/testimonials/'.$data->image) :''}}"  placeholder="{{__('webCaption.user_image.title')}}" required="" />
                          @if($errors->has('user_image'))
                            <x-dash.form.form_error_messages message="{{ $errors->first('user_image') }}"  />
                          @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <x-dash.form.inputs.file id="" caption="{{__('webCaption.vehicle_image.title')}}" ImageId="vehicle-image-preview" for="vehicle_image" editImageUrl="{{ isset($data->vehicle_image)? asset('company_data/'.$imageFolder.'/testimonials/'.$data->vehicle_image) :''}}"    name="vehicle_image"  placeholder="{{__('webCaption.vehicle_image.title')}}" required="" />
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                          <x-dash.form.inputs.file id="" caption="{{__('webCaption.buyer_image.title')}}" ImageId="buyer-image-preview" for="buyer_image" editImageUrl="{{ isset($data->buyer_image)? asset('company_data/'.$imageFolder.'/testimonials/'.$data->buyer_image) :''}}"    name="buyer_image"  placeholder="{{__('webCaption.buyer_image.title')}}" required="" />
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="YouTube_url" maxlength="250"  tooltip="{{__('webCaption.youtube_url.caption')}}" label="{{__('webCaption.youtube_url.title')}}"   name="youtube_url"  placeholder="{{__('webCaption.youtube_url.title')}}" value="{{old('youtube_url', isset($data->youtube_url)?$data->youtube_url:'' )}}"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                       <x-dash.form.label for="" value="{{__('webCaption.rating.title')}}" class=""
                        tooltip="{{__('webCaption.rating.caption')}}" required="" />  
                        <div class="form-group">
                         
                        <img src="{{asset('assets/dash/assets/images/image/star_rating_testimonial.png')}}" width="" height="60%" alt="rating" name="rating" for="rating" value="{{old('rating', isset($data->rating)?$data->rating:'' )}}" required="">
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.label for="" value="{{__('webCaption.display_status.title')}}" class="" 
                            tooltip="{{__('webCaption.display_status.caption')}}"/>
                            <div>
                                <div class=" form-check-inline">
                                <x-dash.form.inputs.radio for="Yes" tooltip="{{__('webCaption.yes.caption')}}"  class="border border-danger" name="display_status" label="{{__('webCaption.yes.title')}}" placeholder="" value="yes"  required="required"  checked="{{ (isset($user->companySalesTeam->display_status) && $user->companySalesTeam->display_status == 'Active') ? 'checked' : 'checked' }}" />&ensp;
                                    
                                <x-dash.form.inputs.radio for="No" class="border border-danger" name="display_status" tooltip="{{__('webCaption.no.caption')}}" label="{{__('webCaption.no.title')}}" placeholder="" value="no"  required="required"  checked="{{ (isset($user->companySalesTeam->display_status) && $user->companySalesTeam->display_status == 'Blocked') ? 'checked' : '' }}" />&ensp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="title"  maxlength="250" tooltip="{{__('webCaption.title.caption')}}" label="{{__('webCaption.title.title')}}"   name="title"  placeholder="{{__('webCaption.title.title')}}" value="{{old('title', isset($data->title)?$data->title:'' )}}"  required="required" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="description" tooltip="{{__('webCaption.description.caption')}}"  label="{{__('webCaption.description.title')}}" maxlength="1000"  name="description"  placeholder="{{__('webCaption.description.title')}}" value="{{old('description', isset($data->description)?$data->description:'' )}}"  required="required" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <x-dash.form.inputs.date  for="posted_date"  maxlength="255" tooltip="{{__('webCaption.posted_date.caption')}}" label="{{__('webCaption.posted_date.title')}}"   name="posted_date"  placeholder="{{__('webCaption.posted_date.title')}}" value="{{old('posted_date', isset($data->posted_date)?$data->posted_date:'' )}}"  required="required" />
                                </div>
                            </div>
                            @php
                            $old_verified_buyer =  session()->getOldInput('verified_buyer');
                            $verified_buyer =   (isset($old_verified_buyer) && $old_verified_buyer == 1  ) ? 'checked' : ((isset($data->verified_buyer) && $data->verified_buyer == 1)? 'checked' :'' );
                            @endphp
                        
                            <div class="col-md-6 col-6">
                                <x-dash.form.label for="" value="{{__('webCaption.verified_buyer.caption')}}" class="" />
                                <div class="form-group">
                                    <x-dash.form.inputs.checkbox  name="verified_buyer"  for="" label="{{__('webCaption.verified_buyer.caption')}}" checked="{{$verified_buyer}}"  value="1"  customClass="form-check-input"  />
                                    @if ($errors->has('verified_buyer'))
                                        <x-dash.form.form_error_messages message="{{ $errors->first('verified_buyer') }}" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select label="{{__('webCaption.country.title')}}"  tooltip="{{__('webCaption.country.caption')}}" for="country_id" name="country_id" 
                            placeholder="{{ __('locale.country.caption') }}" customClass="country"  editSelected="{{(isset($data->country_id) && ($data->country_id != null))?$data->country_id :''; }}"  required="required" :optionData="$country" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.select  for="city"  maxlength="50" tooltip="{{__('webCaption.city.caption')}}" label="{{__('webCaption.city.title')}}"   name="city"  placeholder="{{__('webCaption.city.title')}}" value="{{old('city', isset($data->city)?$data->city:'' )}}"  required="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="person_name"  maxlength="100" tooltip="{{__('webCaption.person_name.caption')}}" label="{{__('webCaption.person_name.title')}}"   name="person_name"  placeholder="{{__('webCaption.person_name.title')}}" value="{{old('person_name', isset($data->person_name)?$data->person_name:'' )}}"  required="" />
                        </div>
                    </div>
                    
                    @php
                    $old_show_person_name = session()->getOldInput('show_person_name');
                    $show_person_name =   (isset($old_show_person_name) && $old_show_person_name == 1  ) ? 'checked' : ((isset($data->show_person_name) && $data->show_person_name == 1)? 'checked' :'' );
                    @endphp

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-5">
                                <x-dash.form.label for="show_person_name" value="{{__('webCaption.show_name.title')}}"  class="" />
                                <div class="form-group">
                                    <x-dash.form.inputs.checkbox  name="show_person_name"  for="show_person_name" label="{{__('webCaption.show_name.title')}}" checked="{{$show_person_name}}"  value="1"  customClass="form-check-input"/>
                                    @if ($errors->has('show_person_name'))
                                        <x-dash.form.form_error_messages message="{{ $errors->first('show_person_name') }}" />
                                    @endif
                                </div>
                            </div>
                                    
                            <div class="col-md-7">
                                <div class="form-group">
                                  <x-dash.form.label for="" value="{{__('webCaption.testimonial_by.title')}}" class="" tooltip="{{__('webCaption.testimonial_by.caption')}}" />
                                <div>
								<div class=" form-check-inline">
								<x-dash.form.inputs.radio for="Buyer" tooltip="{{__('webCaption.buyer.caption')}}"  class="border border-danger" name="testimonial_by" label="{{__('webCaption.buyer.title')}}" placeholder="" value="buyer"  required="required"  checked="{{ (isset ($user->companySalesTeam->testimonial_by) && $user->companySalesTeam->testimonial_by == 'Active') ? 'checked' : 'checked' }}" />&ensp;
									
								<x-dash.form.inputs.radio for="Dealer" class="border border-danger" name="testimonial_by" tooltip="{{__('webCaption.dealer.caption')}}" label="{{__('webCaption.dealer.title')}}" placeholder="" value="dealer"  required="required"  checked="{{ (isset($user->companySalesTeam->testimonial_by) && $user->companySalesTeam->testimonial_by == 'Blocked') ? 'checked' : '' }}" />&ensp;
								</div>
							</div>
						</div>
					</div>
                    </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.email  for="email"  maxlength="100" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}"   name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($data->email)?$data->email:'' )}}"  required="" />
                        </div>
                    </div>     
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4 col-5 pr-0">
                                <div class="form-group">
                                    <x-dash.form.inputs.select  tooltip="{{__('webCaption.country_code.caption')}}"  label="{{__('webCaption.country_code.title')}}"  id="" for="country_code" name="country_code"  required="" :optionData="$country_phone_code"  editSelected="{{(isset($country_code) && ($country_code != null)) ? $country_code : ''; }}" />
                                </div>
                            </div>
                            <div class="col-md-8 col-7">
                                <div class="form-group">
                                    <x-dash.form.inputs.number id="" for="Mobile"  tooltip="{{__('webCaption.mobile.caption')}}" label="{{__('webCaption.mobile.title')}}" maxlength="20"  name="mobile"  placeholder="{{__('webCaption.mobile.title')}}" value="{{old('mobile', isset($data->mobile)?$data->mobile:'' )}}"  required="" />
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-dash.form.inputs.text  for="stock_number" maxlength="50"  tooltip="{{__('webCaption.stock_number.caption')}}" label="{{__('webCaption.stock_number.title')}}"  name="d_stock_number"  placeholder="{{__('webCaption.stock_number.title')}}" value="{{old('d_stock_number', isset($data->d_stock_number)?$data->d_stock_number:'' )}}"  required="" />
                        </div>
                    </div>    
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-dash.form.inputs.textarea id="" for="dealer_remark" tooltip="{{__('webCaption.dealer_remark.caption')}}"  label="{{__('webCaption.dealer_remark.title')}}" maxlength="250"  name="dealer_remark"  placeholder="{{__('webCaption.dealer_remark.title')}}" value="{{old('dealer_remark', isset($data->dealer_remark)?$data->dealer_remark:'' )}}"  required="" />
                        </div>
                    </div>    
                
                        @php
                        $old_is_paid =  session()->getOldInput('is_paid');
                        $is_paid =   (isset($old_is_paid) && $old_is_paid == 1  ) ? 'checked' : ((isset($data->is_paid) && $data->is_paid == 1)? 'checked' :'' );
                        @endphp

{{--                    <div class="col-md-4">--}}
{{--                        <x-dash.form.label for="" value="{{__('webCaption.is_paid.caption')}}" class="" />--}}
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


@push('script')
<script src="{{ asset('assets/dash/assets/js/dash/master.js') }}"></script>
@endpush
