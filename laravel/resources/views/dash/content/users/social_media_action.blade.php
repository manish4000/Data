@php
if(isset($_POST['randval'])) $id = $_POST['id'].'_'.$_POST['randval'];
//if(isset($_POST['id'])) $id = $_POST['id'];
if(isset($_POST['name'])) $name = $_POST['name'];
@endphp
<div class="row delete_social_{{$id}}">
@include('components.dash.form.inputs.social_media')
</div>