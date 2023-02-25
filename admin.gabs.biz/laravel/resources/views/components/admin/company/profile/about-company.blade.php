<div class="card">
  <div class="card-header p-1"><h4 class="card-title"><i data-feather="user-check" class="font-medium-3 mr-1"></i>About Company</h4></div>
  <hr class="m-0 p-0" />
  <div class="card-body">
    <p class="card-text">@if(isset($data->slogan) && !empty($data->slogan)) {{$data->slogan}} @endif </p>

    <div class="mt-2">
      <h5 class="mb-75">Membership Type:</h5>
      <p class="card-text">
        @if(isset($data->membership_type) && !empty($data->membership_type)) {{$data->membership_type}} @else {{'--'}}  @endif
      </p>
    </div>

    <div class="mt-2">
      <h5 class="mb-75">Ownership Type:</h5>
      <p class="card-text">
        @if(isset($data->ownership_type) && !empty($data->ownership_type)) {{$data->ownership_type}}  @else {{'--'}} @endif
      </p>
    </div>

    <div class="mt-2">
      <h5 class="mb-75">Status:</h5>
      <p class="card-text">
        @if(isset($data->status) && !empty($data->status)) {{$data->status}} @else {{'--'}} @endif
      </p>
    </div>

    <div class="mt-2">
      <h5 class="mb-75">Joined:</h5>
      <p class="card-text">November 15, 2015</p>
    </div>

    <div class="mt-2">
      <h5 class="mb-75">Year Established:</h5>
      <p class="card-text">
        @if(isset($data->year_established) && !empty($data->year_established)) {{$data->year_established}} @else {{'--'}} @endif
      </p>
    </div>

    <div class="mt-2">
      <h5 class="mb-75">Employees:</h5>
      <p class="card-text">
        @if(isset($data->number_of_staffs) && !empty($data->number_of_staffs)) {{$data->number_of_staffs}} @else {{'--'}} @endif
      </p>
    </div>

    <div class="mt-2">
      <h5 class="mb-75">Office Timing:</h5>
      <p class="card-text">
        @if(isset($data->office_timing) && !empty($data->office_timing)) {{$data->office_timing}} @else {{'--'}} @endif
      </p>
    </div>

    <div class="mt-2">
      <h5 class="mb-50">Website:</h5>
      <p class="card-text">
        @if(isset($data->website) && !empty($data->website)) {{$data->website}} @else {{'--'}} @endif
      </p>
    </div>

    <div class="mt-2">
      <h5 class="mb-75">Location:</h5>
      <p class="card-text">
        @if(isset($data->city) && !empty($data->city)){{$data->city}} @endif
        @if(isset($data->country) && !empty($data->country)){{', '.$data->country}} @endif
      </p>
    </div>
    
  </div>
</div>