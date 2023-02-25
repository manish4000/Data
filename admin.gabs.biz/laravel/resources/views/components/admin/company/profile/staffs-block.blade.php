<div class="card">
  <div class="card-header p-1"><h4 class="card-title"><i data-feather="users" class="font-medium-3 mr-1"></i>Teams</h4></div>
  <hr class="m-0 p-0" />
  <div class="card-body">
    @if(isset($data->staffs))
      @foreach($data->staffs as $stf)
        <div class="d-flex justify-content-start align-items-center mt-1">
          <div class="avatar mr-75">
            @php $profile_file = asset('images/portrait/small/avatar-s-9.jpg'); @endphp
            @if(isset($stf->profile_file) && !empty($stf->profile_file))
              @php $profile_file = asset('uploads/staff/profile/'.$stf->profile_file);  @endphp
            @endif 
            <img src="{{$profile_file}}" alt="avatar" height="40" width="40" />
          </div>
          <div class="profile-user-info">
            <h6 class="mb-0">{{$stf->staff_name}}</h6>
            <small class="text-muted">{{$stf->roles}}</small>
          </div>
        </div>
      @endforeach
    @endif            
  </div>
</div>