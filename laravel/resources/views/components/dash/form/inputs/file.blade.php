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

$editImageUrl = (isset($editImageUrl) && !empty($editImageUrl) )? $editImageUrl :asset('assets/images/portrait/small/no-photo.jpg');

@endphp

<div class="media">
    @php $logo_file = asset('assets/images/portrait/small/avatar-s-11.jpg'); @endphp
    {{-- @if(isset($data->logo_file) && !empty($data->logo_file))
        @php $logo_file = 'https://www.japanesecartrade.com/logo/'.$data->logo_file;  @endphp
    @endif --}}
    <a href="javascript:void(0);" class="mr-25">
        <img src="{{$editImageUrl}}" id="{{$imageId}}" class="rounded mr-50" alt="logo image" height="60" width="60" />
    </a>

    <div class="media-body mt-75 ml-1">
        <label for="{{ $for }}" class="btn btn-sm btn-primary mb-75 mr-75">{{ $caption }}  @if(isset($required) && !empty($required)) &nbsp; <span class="text-danger" style="font-size: 14px;font-weight:bolder"> * </span>  @endif </label>
        <input type="file" name="{{ $name }}" id="{{ $for }}" hidden accept="image/*"  {{$multiple}} {{$required}} />
        <p>Allowed JPEG, JPG, PNG, GIF or BMP. Max size of 5MiB</p>
    </div>

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