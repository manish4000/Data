@props([
    'for',
    'caption',
    'name',
    'placeholder',
    'value',
    'multiple',
    'imageId',
    'editImageUrl',
    'required'
])

@php
$multiple = (isset($multiple))? $multiple :'';
$required = (isset($required))? $required :'';
$imageId = (isset($imageId))? $imageId :'';

$editImageUrl = (isset($editImageUrl) && !empty($editImageUrl) )? asset($editImageUrl) :asset('assets/images/portrait/small/no-photo.jpg');

$fileType = ['jpg','png','jpeg','svg','gif','tiff'];
$maxFileSize = isset($maxFileSize) ?  $maxFileSize : '';

@endphp

<div class="media">
    @php $logo_file = asset('assets/images/portrait/small/avatar-s-11.jpg'); @endphp
    {{-- @if(isset($data->logo_file) && !empty($data->logo_file))
        @php $logo_file = 'https://www.japanesecartrade.com/logo/'.$data->logo_file;  @endphp
    @endif --}}
    <div style="border:#ebe9f1 1px solid;">
    <a href="javascript:void(0);" class="mr-0">
        <img src="{{$editImageUrl}}" id="{{$imageId}}" class="rounded mr-0" alt="logo image" height="52" width="51" />
    </a>
    </div>
    <div class="media-body mt-0 ml-1">
       <span style="display:block; position:relative; top:-2px;"> <x-dash.form.label for="" value="{{__('webCaption.upload_image.title')}}" class="align-top fs-6" tooltip="{{__('webCaption.upload_image.caption')}}" /></span>
        <label for="{{ $for }}" class="btn btn-sm btn-primary mb-0 mr-0 ">{{ $caption }}  @if(isset($required) && !empty($required)) &nbsp; <span  style="font-size: 14px;font-weight:bolder"> * </span>  @endif </label>
        <input type="file" name="{{ $name }}" id="{{ $for }}" hidden accept="image/*"  {{$multiple}} {{$required}} /><br/>
        <!-- <p class="input_file_instruction">Allowed <?php echo  (isset($fileType))?implode(',',$fileType) : ''; ?>. Max size of <?php echo $maxFileSize ?> KB</p> -->
    </div>

</div>


@if(isset($name)) 

<div class="m-0">
    @if($errors->has($name))
    <x-admin.form.form_error_messages message="{{ $errors->first($name) }}"  />
    @endif
</div>

@endif 



@push('script')

<script type="text/javascript">
      
$(document).ready(function (e) {
 
   $('#{{$for}}').change(function(){
            
    let reader = new FileReader();
 
    reader.onload = (e) => { 
      $('#{{$imageId}}').attr('src', e.target.result); 
    }
 
    reader.readAsDataURL(this.files[0]); 
   
   });
   
});
 
</script>
@endpush