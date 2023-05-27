@extends('dash/layouts/LayoutMaster')
@if (isset($data->id) && !empty($data->id))
    @section('title', __('webCaption.testimonial.title') . ' ' . __('webCaption.edit.title'))
@else
    @section('title', __('webCaption.testimonial.title') . ' ' . __('webCaption.add.title'))
@endif

<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-ratings.css')) }}">

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/dragula.min.css')) }}">

@endsection

@section('content')
    <div>
        @if ($errors->any())
            {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif

        <form action="{{ route('dashtestimonial.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary">
                <div class="card-header">
                    <h4 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1">
                            <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                            <line x1="8" y1="2" x2="8" y2="18"></line>
                            <line x1="16" y1="6" x2="16" y2="22"></line>
                        </svg>
                        @if (isset($data->id))
                            {{ __('webCaption.testimonial.title') }}
                        @else
                            {{ __('webCaption.testimonial.title') }}
                        @endif
                    </h4>
                </div>

                <hr class="m-0 p-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group text-center">
                                <x-dash.form.buttons.custom color="btn btn-sm btn-success " id=""
                                    value="{{ __('webCaption.choose_from_stock.title') }}" iconClass="" />

                                <x-dash.form.buttons.custom color="btn btn-sm btn-success " id=""
                                    value="{{ __('webCaption.choose_from_invoices.title') }}" iconClass="" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            @php
                                $editImageUrl = isset($data->user_image) ? 'company_data/testimonials/user_image/' . $data->user_image : '';
                            @endphp
                            <div class="form-group">
                                <x-dash.form.inputs.file id="" caption="{{ __('webCaption.user_image.title') }}"
                                    ImageId="user-image-preview" for="user_image" name="user_image"
                                    editImageUrl="{{ $editImageUrl }}"
                                    placeholder="{{ __('webCaption.user_image.title') }}" required="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            @php
                                $editImageUrl = isset($data->vehicle_image) ? 'company_data/testimonials/vehicle_image/' . $data->vehicle_image : '';
                            @endphp
                            <div class="form-group">
                                <x-dash.form.inputs.file id=""
                                    caption="{{ __('webCaption.vehicle_image.title') }}" ImageId="vehicle-image-preview"
                                    for="vehicle_image" editImageUrl="{{ $editImageUrl }}" name="vehicle_image"
                                    placeholder="{{ __('webCaption.vehicle_image.title') }}" required="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            @php
                                $editImageUrl = isset($data->buyer_image) ? 'company_data/testimonials/buyer_image/' . $data->buyer_image : '';
                            @endphp
                            <div class="form-group">
                                <x-dash.form.inputs.file id="" caption="{{ __('webCaption.buyer_image.title') }}"
                                    ImageId="buyer-image-preview" for="buyer_image" editImageUrl="{{ $editImageUrl }}"
                                    name="buyer_image" placeholder="{{ __('webCaption.buyer_image.title') }}"
                                    required="" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <x-dash.form.inputs.text for="youtube_url" maxlength="100"
                                    tooltip="{{ __('webCaption.youtube_url.caption') }}"
                                    label="{{ __('webCaption.youtube_url.title') }}" name="youtube_url"
                                    placeholder="{{ __('webCaption.youtube_url.title') }}"
                                    value="{{ old('youtube_url', isset($data->youtube_url) ? $data->youtube_url : '') }}" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <x-dash.form.label for="" value="{{ __('webCaption.rating.title') }}" class=""
                                tooltip="{{ __('webCaption.rating.caption') }}" required="" />
                            @php
                                $rating = isset($data->rating) ? $data->rating : 0;
                            @endphp
                            <div class="form-group">
                                <div class="full-star-ratings" id="rateYo" data-rateyo-full-star="true"
                                    data-rateyo-rating="{{ $rating }}"></div>
                                    @php
                                        $ratingValue = isset($data->rating)?$data->rating : '';
                                    @endphp
                                <input name="rating" type="hidden" id="val" value="{{$ratingValue}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-dash.form.label for="" value="{{ __('webCaption.display_status.title') }}"
                                    class="" tooltip="{{ __('webCaption.display_status.caption') }}"
                                    required="" />
                                <div>
                                    <div class="form-check-inline">
                                        <x-dash.form.inputs.radio for="yes"
                                            tooltip="{{ __('webCaption.yes.caption') }}" class="border border-danger"
                                            name="display_status" label="{{ __('webCaption.yes.title') }}"
                                            value="Yes" required="required"
                                            checked="{{ isset($data->status) && $data->status == 'Yes' ? 'checked' : 'checked' }}" />
                                        &ensp;

                                        <x-dash.form.inputs.radio for="no" class="border border-danger"
                                            name="display_status" tooltip="{{ __('webCaption.no.caption') }}"
                                            label="{{ __('webCaption.no.title') }}" value="No" required="required"
                                            checked="{{ isset($data->status) && $data->status == 'No' ? 'checked' : '' }}" />
                                        &ensp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-dash.form.inputs.text for="title" maxlength="250"
                                    tooltip="{{ __('webCaption.title.caption') }}"
                                    label="{{ __('webCaption.title.title') }}" name="title"
                                    placeholder="{{ __('webCaption.title.title') }}"
                                    value="{{ old('title', isset($data->title) ? $data->title : '') }}"
                                    required="required" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-dash.form.inputs.textarea id="" for="description"
                                    tooltip="{{ __('webCaption.description.caption') }}"
                                    label="{{ __('webCaption.description.title') }}" maxlength="1000" name="description"
                                    placeholder="{{ __('webCaption.description.title') }}"
                                    value="{{ old('description', isset($data->description) ? $data->description : '') }}"
                                    required="required" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3 col-4">
                                    <div class="form-group">
                                        <x-dash.form.inputs.name_prefix label="{{ __('webCaption.title.title') }}"
                                            tooltip="{{ __('webCaption.title.caption') }}" for="name_title"
                                            name="name_title" placeholder="{{ __('locale.title.caption') }}"
                                            value="{{ old('name_title', isset($data->name_title) ? $data->name_title : '') }}"
                                            editSelected="{{ old('name_title', isset($data->name_title) ? $data->name_title : '') }}"
                                            required="" />
                                    </div>
                                </div>
                                <div class="col-md-9 col-8 pl-0">
                                    <div class="form-group">
                                        <x-dash.form.inputs.text for="person_name" maxlength="100"
                                            tooltip="{{ __('webCaption.person_name.caption') }}"
                                            label="{{ __('webCaption.person_name.title') }}" name="person_name"
                                            placeholder="{{ __('webCaption.person_name.title') }}"
                                            value="{{ old('person_name', isset($data->person_name) ? $data->person_name : '') }}"
                                            required="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $old_show_person_name = session()->getOldInput('show_person_name');
                            $show_person_name = isset($old_show_person_name) && $old_show_person_name == 1 ? 'checked' : (isset($data->show_person_name) && $data->show_person_name == 1 ? 'checked' : '');
                        @endphp
                        <div class="col-md-2">
                            <x-dash.form.label for="show_person_name" value="{{ __('webCaption.show_name.title') }}"
                                class="" />
                            <div class="form-group">
                                <x-dash.form.inputs.checkbox name="show_person_name" for="show_person_name"
                                    label="{{ __('webCaption.show_name.title') }}" checked="{{ $show_person_name }}"
                                    value="1" />
                                @if ($errors->has('show_person_name'))
                                    <x-dash.form.form_error_messages message="{{ $errors->first('show_person_name') }}" />
                                @endif
                            </div>
                        </div>
                        @php
                            $old_verified_buyer = session()->getOldInput('verified_buyer');
                            $verified_buyer = isset($old_verified_buyer) && $old_verified_buyer == 1 ? 'checked' : (isset($data->verified_buyer) && $data->verified_buyer == 1 ? 'checked' : '');
                        @endphp
                        <div class="col-md-2 col-6">
                            <x-dash.form.label for="" value="{{ __('webCaption.verified_buyer.caption') }}"
                                class="" />
                            <div class="form-group">
                                <x-dash.form.inputs.checkbox name="verified_buyer" for=""
                                    label="{{ __('webCaption.verified_buyer.caption') }}"
                                    checked="{{ $verified_buyer }}" value="1" customClass="form-check-input" />
                                @if ($errors->has('verified_buyer'))
                                    <x-dash.form.form_error_messages message="{{ $errors->first('verified_buyer') }}" />
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            @php
                                $date =  now()->format('Y-m-d');
                            @endphp
                            <div class="form-group">
                                <x-dash.form.inputs.date for="posted_date" onload="currentDate()" id="date"
                                    tooltip="{{ __('webCaption.posted_date.caption') }}"
                                    label="{{ __('webCaption.posted_date.title') }}" name="posted_date"
                                    placeholder="{{ __('webCaption.posted_date.title') }}"
                                    value="{{ old('posted_date', isset($data->posted_date) ? $data->posted_date : $date) }}"
                                    required="required" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-dash.form.inputs.select onChange="stateLists(this.id,'state')"
                                    label="{{ __('webCaption.country.title') }}"
                                    tooltip="{{ __('webCaption.country.caption') }}" for="country" name="country"
                                    placeholder="{{ __('locale.country.caption') }}"  :optionData="$country"
                                    editSelected="{{ old('country', isset($data->country_id) ? $data->country_id : '') }}"
                                    required="required" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-dash.form.inputs.select onChange="cityList('state','city')"
                                    label="{{ __('webCaption.state.title') }}"
                                    tooltip="{{ __('webCaption.state.caption') }}" for="state" name="state"
                                    placeholder="{{ __('locale.state.caption') }}" :optionData="[]"
                                    editSelected="{{ old('state', isset($data->state_id) ? $data->state_id : '') }}"
                                    required="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-dash.form.inputs.select for="city"
                                    tooltip="{{ __('webCaption.city.caption') }}"
                                    label="{{ __('webCaption.city.title') }}" name="city"
                                    placeholder="{{ __('webCaption.city.title') }}" :optionData="[]"
                                    editSelected="{{ old('city', isset($data->city_id) ? $data->city_id : '') }}"
                                    required="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-dash.form.inputs.email for="email" maxlength="50"
                                    tooltip="{{ __('webCaption.email.caption') }}"
                                    label="{{ __('webCaption.email.title') }}" name="email"
                                    placeholder="{{ __('webCaption.email.title') }}"
                                    value="{{ old('email', isset($data->email) ? $data->email : '') }}" required="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4 col-5 pr-0">
                                    <div class="form-group">
                                        <x-dash.form.inputs.select tooltip="{{ __('webCaption.country_code.caption') }}"
                                            label="{{ __('webCaption.country_code.title') }}" id=""
                                            for="country_code" name="country_code" required="" :optionData="$country_phone_code"
                                            editSelected="{{ isset($country_code) && $country_code != null ? $country_code : '' }}" />
                                    </div>
                                </div>
                                <div class="col-md-8 col-7">
                                    <div class="form-group">
                                        <x-dash.form.inputs.number id="" for="Mobile"
                                            tooltip="{{ __('webCaption.mobile.caption') }}"
                                            label="{{ __('webCaption.mobile.title') }}" maxlength="15" name="phone"
                                            placeholder="{{ __('webCaption.mobile.title') }}"
                                            value="{{ old('phone', isset($data->phone) ? $data->phone : '') }}"
                                            required="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <x-dash.form.label for="" value="{{ __('webCaption.testimonial_by.title') }}"
                                    class="" tooltip="{{ __('webCaption.testimonial_by.caption') }}" />
                                <div>
                                    <div class="form-check-inline">
                                        <x-dash.form.inputs.radio for="Buyer"
                                            tooltip="{{ __('webCaption.buyer.caption') }}" class="border border-danger"
                                            name="testimonial_by" label="{{ __('webCaption.buyer.title') }}"
                                            placeholder="" value="Buyer" required="required"
                                            checked="{{ isset($data->testimonial_by) && $data->testimonial_by == 'Buyer' ? 'checked' : 'checked' }}" />
                                        &ensp;
                                        <x-dash.form.inputs.radio for="Dealer" class="border border-danger"
                                            name="testimonial_by" tooltip="{{ __('webCaption.dealer.caption') }}"
                                            label="{{ __('webCaption.dealer.title') }}" placeholder="" value="Dealer"
                                            required="required"
                                            checked="{{ isset($data->testimonial_by) && $data->testimonial_by == 'Dealer' ? 'checked' : '' }}" />
                                        &ensp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-dash.form.inputs.textarea id="" for="admin_memo"
                                    tooltip="{{ __('webCaption.admin_memo.caption') }}"
                                    label="{{ __('webCaption.admin_memo.title') }}" maxlength="250" name="admin_memo"
                                    placeholder="{{ __('webCaption.admin_memo.title') }}"
                                    value="{{ old('admin_memo', isset($data->admin_memo) ? $data->admin_memo : '') }}"
                                    required="" />
                            </div>
                        </div>

                        @php
                            $old_is_paid = session()->getOldInput('is_paid');
                            $is_paid = isset($old_is_paid) && $old_is_paid == 1 ? 'checked' : (isset($data->is_paid) && $data->is_paid == 1 ? 'checked' : '');
                        @endphp

                        {{--                    <div class="col-md-4"> --}}
                        {{--                        <x-dash.form.label for="" value="{{__('webCaption.is_paid.caption')}}" class="" /> --}}
                        {{--                        <div class="form-group"> --}}
                        {{--                            <x-dash.form.inputs.checkbox  name="is_paid"  for="" label="{{__('webCaption.is_paid.caption')}}" checked="{{$is_paid}}"  value="1"  customClass="form-check-input"  /> --}}
                        {{--                            @if ($errors->has('is_paid')) --}}
                        {{--                                <x-dash.form.form_error_messages message="{{ $errors->first('is_paid') }}" /> --}}
                        {{--                            @endif --}}
                        {{--                        </div> --}}
                        {{--                    </div>                        --}}
                    </div>
                </div>

                {{-- <div class="card card-primary">
			<hr class="m-0 p-0">
			<div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                    @if (isset($data->id))             
                     
                        @include('components.dash.form.inputs.multiple_image_upload_dropzone',
                                            [ 'action' => route('dashmultiple-image-upload-temp') ,
                                                'deleteTempImage' => route('dashdelete-temp-image'),
                                                'acceptedFiles' => ".jpeg,.jpg,.png,.gif",
                                                'tempTable' => "dash_images_temp",
                                                'table' => "company_testimonial_images",
                                                'table_referance_filed_name' => "company_testimonial_id",
                                                'editableImagesPath' => 'company_data/'.$imageFolder.'/testimonials/',
                                                'uploadPath'   => "dash/documents_temp/",
                                                'editableImages' => $data->images,
                                                'id' => $data->id,
                                                'tempTableImageFieldName' => 'name',
                                                'tableImageFiledName' => 'image',
                                                'formFieldName' => 'document[]'                           
                                            ])

                    @else

                    @include('components.dash.form.inputs.multiple_image_upload_dropzone',
                    [ 'action' => route('dashmultiple-image-upload-temp') ,
                        'deleteTempImage' => route('dashdelete-temp-image'),
                        'acceptedFiles' => ".jpeg,.jpg,.png,.gif",
                        'tempTable' => "dash_images_temp",
                        'table' => "",
                        'editableImagesPath'=> '',
                        'uploadPath'   => "dash/documents_temp/",
                        'tempTableImageFieldName' => 'name',
                        'tableImageFiledName' => 'image',
                        'formFieldName' => 'document[]'                           
                    ])               
                    
                    @endif            
                            </div>
                        </div>
            </div>            
        </div>     --}}

                <div class="form-group text-center">
                    <input type="hidden" name="id"
                        value="@if (isset($data->id) && !empty($data->id)) {{ $data->id }} @endif" />
                    @if (isset($data->id))
                        <x-dash.form.buttons.update />
                    @else
                        <x-dash.form.buttons.create />
                    @endif
                </div>
        </form>
    </div>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->

@endsection

@php
    
    $state_id = session()->getOldInput('state');
    $city_id = session()->getOldInput('city');
    
    $country_id = isset($country_id) ? $country_id : (isset($data->country_id) ? $data->country_id : old('country'));
    
    $state_id = isset($state_id) ? $state_id : (isset($data->state_id) ? $data->state_id : old('state'));
    
    $city_id = isset($city_id) ? $city_id : (isset($data->city_id) ? $data->city_id : old('city'));
    
@endphp

@push('script')
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-ratings.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/jquery.rateyo.min.js')) }}"></script>
    <script src="{{ asset('assets/dash/assets/js/dash/master.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dragula.min.js')) }}"></script>
    <script>
        dragula([document.getElementById('card-drag-area')])
            .on('drag', function(el) {
                console.log('Drag ' + el);
                console.log();
                el.className = el.className.replace('ex-moved', '');
                console.log(el);
            }).on('drop', function(el) {
                console.log('Drop ' + el);
                el.className += ' ex-moved';
                console.log(el);
            }).on('over', function(el, container) {
                console.log('Over' + el);
                el.className = el.className.replace('ex-over', '');

                console.log(container);
            }).on('out', function(el, container) {
                console.log('Out' + el);
                el.className += ' ex-over';
                console.log(container);
            });

        $('#rateYo').rateYo({
            rating: 1 - 5
        });

        $('#rateYo').click(function() {
            var rating = $('#rateYo').rateYo("rating");

            $('#val').val(rating);
        });

        let country_id = "{{ $country_id }}";
        let state_id = "{{ $state_id }}";
        let city_id = "{{ $city_id }}";

        if (country_id != '') {
            stateLists('country', 'state', state_id);
        }
        if (city_id != '') {
            cityList('state', 'city', city_id, state_id);
        }

        $(document).ready(function(){
            function currentDate(){
            var date = new date();
            $('#date').value = date.getFullYear();
        }
        });
    </script>
@endpush
@include('components.dash.form.country_state_city')