@props([
    'for',
    'caption',
    'name',
    'placeholder',
    'value',
    'multiple',
    'imageId',
    'editImageUrl',
    'fileType',
    'maxFileSize'

])

@php
$multiple = (isset($multiple))? $multiple :'';
$imageId = (isset($imageId))? $imageId :'';

if(isset($editImageUrl)){
    if(!is_file($editImageUrl )){
      $editImageUrl = '';
    }
}
$Types = isset($fileType) ?  $fileType : '';
$maxFileSize = isset($maxFileSize) ?  $maxFileSize : '';

$editImageUrl = ((isset($editImageUrl)) &&  !empty($editImageUrl) )? $editImageUrl : asset('assets/images/portrait/small/no-photo.jpg');

@endphp



<div>
    <div class="media">
        @php $logo_file = asset('assets/images/portrait/small/no-photo.jpg'); @endphp

        <a href="javascript:void(0);" class="mr-25">
            <img src="{{$editImageUrl}}" id="{{$imageId}}" class="rounded mr-50" alt="logo image" height="60" width="60" />
        </a>
    
        <div class="media-body mt-75 ml-1">
            <label for="{{ $for }}" class="btn btn-sm btn-primary mb-75 mr-75">{{ $caption }}</label>
            <input type="file" name="{{ $name }}" id="{{ $for }}" hidden accept="image/*"  {{$multiple}} onchange='imageValidation("{{$for}}","{{$maxFileSize}}",<?php echo json_encode($Types); ?>)' />
            <p>Allowed <?php echo  (isset($fileType))?implode(',',$fileType) : ''; ?>. Max size of <?php echo $maxFileSize ?> KB</p>
        </div>
    </div>
    <p id='selected-file' class="text-success"></p>
    <span class="text-danger" style="display:none;" id="image-ext-error"> Invalid Image Format! Image Format Must Be <?php echo  (isset($fileType))?implode(',',$fileType) : ''; ?>. </span>
    <span class="text-danger" id="image-size-error" style="display:none;"> Maximum File Size Limit is 1MB. </span>

</div>

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