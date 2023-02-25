<div class="card">
  <div class="card-header">
    <h4 class="card-title"><i data-feather="globe" class="font-medium-3 mr-1"></i>Social Media Profiles</h4>
  </div>
  <hr class="m-0 p-0" />
  <div class="card-body">
    <div class="row">
      @if(isset($socialmedias) && count($socialmedias) > 0 )
        @foreach($socialmedias as $social)
        <div class="col-lg-6 col-md-12 mb-1">
          <!-- <div class="input-group input-group-merge">
            <div class="input-group-append">
              <span class="input-group-text bg-primary text-white"><i data-feather="{{strtolower($social->name)}}"></i></span>
              <span class="input-group-text bg-light" id="basic-addon3">{{$social->url}}</span>
            </div>
            <input type="text" class="form-control pl-1 w-25" name="social_profiles[{{$social->id}}]" id="social_profiles[{{$social->id}}]" value="@if(isset($staff_social_profiles) && isset($staff_social_profiles[$social->id])){{$staff_social_profiles[$social->id]}}@endif"/>
          </div> -->
          <x-admin.form.inputs.social_media_input :data="$social" />
        </div>
        @endforeach
      @endif
    </div>
  </div>
</div>