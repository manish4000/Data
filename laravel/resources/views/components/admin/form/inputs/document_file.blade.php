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
    'maxFileSize',
    'label'

])

@php 

$Types = ['pdf','xls','docx','csv','xlsx'];
$maxFileSize = 5000;

@endphp



<div>
    @if (isset($label) && isset($for)) 
    <label  @if (isset($tooltip)) title="{{$tooltip}}"  @endif   data-toggle="tooltip" for='{{ $for }}'>{{ $label }}  @if(isset($required) && !empty($required)) <span class="text-danger" style="font-size: 14px;font-weight: bolder"> * </span>  @endif </label>
    @endif
    <input type="file" class="form-control" name="{{ $name }}" id="{{ $for }}" onchange='documentValidation("{{$for}}","{{$maxFileSize}}",<?php echo json_encode($Types); ?>)' />
    <p>Allowed <?php echo  (isset($Types))?implode(',',$Types) : ''; ?>. Max size of <?php echo $maxFileSize ?> KB</p>

{{--  --}}

    <p id='{{$for}}-selected-file' class="text-success"></p>
    <span class="text-danger" style="display:none;" id="{{$for}}-doc-ext-error"> Invalid Image Format! Image Format Must Be <?php echo  (isset($Types))?implode(',',$Types) : ''; ?>. </span>
    <span class="text-danger" id="{{$for}}-doc-size-error" style="display:none;"> Maximum File Size Limit <?php echo $maxFileSize ?> KB </span>

</div>



@if(isset($name)) 

<div class="m-0">
    @if($errors->has($name))
    <x-admin.form.form_error_messages message="{{ $errors->first($name) }}"  />
    @endif
</div>

@endif 

