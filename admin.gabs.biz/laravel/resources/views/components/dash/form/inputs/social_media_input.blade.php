@props([
    'data'
])

<div class="input-group input-group-merge">
    <div class="input-group-append">
        <span class="input-group-text bg-primary text-white"><i data-feather="{{strtolower($data->name)}}"></i></span>
        <span class="input-group-text bg-light" id="basic-addon3">{{$data->url}}</span>
    </div>
    <input type="text" class="form-control pl-1 w-25" name="social_profiles[{{$data->id}}]" id="social_profiles[{{$data->id}}]" value="@if(isset($staff_social_profiles) && isset($staff_social_profiles[$data->id])){{$staff_social_profiles[$data->id]}}@endif"/>
</div>