<div class="card">
  <div class="card-header p-1"><h4 class="card-title"><i data-feather="phone" class="font-medium-3 mr-1"></i>Contact Information</h4></div>
  <hr class="m-0 p-0" />
  <div class="card-body">
    <div class="">
      <h5 class="mb-75">Phone 1:</h5>
      <p class="card-text">
        @if(isset($data->mobile1) && !empty($data->mobile1)) {{$data->mobile1}} 
          @if(isset($data->mobile1_contact_options) && !empty($data->mobile1_contact_options)) 
            {{' [ '.str_replace(', ', ' | ', $data->mobile1_contact_options).' ] '}} 
          @endif
        @else {{'--'}}          
        @endif
      </p>
    </div>
    <div class="mt-2">
      <h5 class="mb-75">Phone 2:</h5>
      <p class="card-text">
        @if(isset($data->mobile2) && !empty($data->mobile2)) 
          {{$data->mobile2}} 
          @if(isset($data->mobile2_contact_options) && !empty($data->mobile2_contact_options)) 
          {{' [ '.str_replace(', ', ' | ', $data->mobile2_contact_options).' ] '}} 
          @endif
        @else {{'--'}}          
        @endif
      </p>
    </div>
    <div class="mt-2">
      <h5 class="mb-75">Email:</h5>
      <p class="card-text">
        @if(isset($data->email1) && !empty($data->email1)) {{$data->email1}} @endif
        @if(isset($data->email2) && !empty($data->email2)) <br/>{{$data->email2}} @endif
      </p>
    </div>
    <div class="mt-2">
      <h5 class="mb-75">Skype:</h5>
      <p class="card-text">@if(isset($data->skype_id) && !empty($data->skype_id)) {{$data->skype_id}} @else {{'--'}} @endif</p>
    </div>    
    <div class="mt-2">
      <h5 class="mb-50">Social Media:</h5>
      <p class="card-text mb-0">
        @if(isset($data->facebook) && !empty($data->facebook)) <a class="mr-1" href="{{'https://www.facebook.com/'.$data->facebook}}" target="_blank"><i data-feather="facebook"></i></a> @endif
        @if(isset($data->instagram) && !empty($data->instagram)) <a class="mr-1" href="{{'https://www.instagram.com/'.$data->instagram}}" target="_blank"><i data-feather="instagram"></i></a> @endif
        @if(isset($data->linkedin) && !empty($data->linkedin)) <a class="mr-1" href="{{'https://www.linkedin.com/'.$data->linkedin}}" target="_blank"><i data-feather="linkedin"></i></a> @endif
        @if(isset($data->twitter) && !empty($data->twitter)) <a class="mr-1" href="{{'https://www.twitter.com/'.$data->twitter}}" target="_blank"><i data-feather="twitter"></i></a> @endif
        @if(isset($data->youtube) && !empty($data->youtube)) <a class="mr-1" href="{{'https://www.youtube.com/'.$data->youtube}}" target="_blank"><i data-feather="youtube"></i></a> @endif
      </p>
    </div>    
  </div>
</div>