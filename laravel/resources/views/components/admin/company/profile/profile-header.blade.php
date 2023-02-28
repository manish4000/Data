<div class="row">
  <div class="col-12">
    <div class="card profile-header mb-2">
      <!-- profile cover photo -->
      @if(isset($data->banner_file) && !empty($data->banner_file))
        <img class="card-img-top" src="{{'https://www.japanesecartrade.com/icon/'.$data->banner_file}}" alt="User Banner Image" />
      @else
        <img class="card-img-top" src="{{asset('images/profile/user-uploads/timeline.jpg')}}" alt="User Banner Image" />
      @endif
      <!--/ profile cover photo -->
      <div class="position-relative">
        @if(Auth::user()->user_type!='Admin')
        <div class="float-right">
          <a class="nav-link font-weight-bold" href="{{url('company-profile/edit')}}">
            <button class="btn btn-primary">
              <i data-feather="edit" class="d-block d-md-none"></i>
              <span class="font-weight-bold d-none d-md-block">Edit</span>
            </button>
          </a>
        </div>
        @endif
      </div>      
    </div>
  </div>
</div>