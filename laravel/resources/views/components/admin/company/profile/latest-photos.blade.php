<div class="card">
  <div class="card-header p-1"><h4 class="card-title"><i data-feather="camera" class="font-medium-3 mr-1"></i>Photo Gallery</h4></div>
  <hr class="m-0 p-0" />
  <div class="card-body">
    <div class="row">
      @if(isset($dealerPhotos) && count($dealerPhotos)>0)
        @foreach($dealerPhotos as $dPhoto)
        <div class="col-md-4 col-6 profile-latest-img">
          <a href="javascript:void(0)">
            <img src="{{'https://www.japanesecartrade.com/user_images/'.$dPhoto->file_name}}" class="img-fluid rounded" alt="avatar img" />
          </a>
        </div>  
        @endforeach
      @endif
    </div>
  </div>
</div>