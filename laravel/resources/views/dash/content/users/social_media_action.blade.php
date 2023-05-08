@php
if(isset($_POST['randval'])) $id = $_POST['id'].'_'.$_POST['randval'];
//if(isset($_POST['id'])) $id = $_POST['id'];
if(isset($_POST['name'])) $name = $_POST['name'];
@endphp
{{-- <div class="row delete_social{{$id}}">
	<div class="col-md-4">
		<div class="form-group">
			<x-dash.form.inputs.select  onChange="onChangeSocialMedia(this.id)" data_attr="icon" tooltip="{{__('webCaption.social_media.caption')}}"  label="{{__('webCaption.social_media.title')}}" for="social_media_{{$id}}" name="social_media[]" placeholder="{{ __('locale.social_media.caption') }}" editSelected=""  required="" :optionData="$socialMedia" />
		</div>
	</div>
	<div class="col-md-1 text-center pt-1">
		@php $image_src =  asset('assets/images/globe.png'); @endphp
		<span class="display-6"><img src="{{$image_src}}" class="img_social_media_{{$id}}" width="30"
			height="30" alt="social_media_icon"/></span>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.value.caption')}}" label="{{__('webCaption.value.title')}}"  id="" for="value{{$id}}" name="social_value[]" placeholder="{{ __('locale.value.caption') }}" value="" required="" />
		</div>
	</div>
	<div class="col-md-1 mt-2">
		<x-dash.form.buttons.custom color="bg-danger" id="DeleteRow{{$id}}" value="" onClick="delete_social('{{ $id }}')" iconClass="fa fa-xmark"/>
	</div>
</div> --}}
<div class="row delete_social_{{$id}}">
@include('components.dash.form.inputs.social_media')
</div>