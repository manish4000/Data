<div class="row delete_social{{$id}}">
	<div class="col-md-6">
		<div class="form-group">
			<x-dash.form.inputs.select tooltip="{{__('webCaption.social_media.caption')}}"  label="{{__('webCaption.social_media.title')}}"  id="" for="social_media{{$id}}" name="social_media[]" placeholder="{{ __('locale.social_media.caption') }}" editSelected=""  required="" :optionData="$social_media" />
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.value.caption')}}" label="{{__('webCaption.value.title')}}"  id="" for="value{{$id}}" name="social_value[]" placeholder="{{ __('locale.value.caption') }}" value="" required="" />
		</div>
	</div>
	<div class="col-md-1">
		<div class="form-group"><button type="button" class="btn btn-danger" id="DeleteRow{{$id}}" onclick="delete_social('<?php echo $id; ?>')">Delete</button></div>
	</div>
</div>