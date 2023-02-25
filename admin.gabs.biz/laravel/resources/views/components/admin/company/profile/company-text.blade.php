<div class="card">
  <div class="card-header p-1"><h4 class="card-title"><i data-feather="layers" class="font-medium-3 mr-1"></i>General Information</h4></div>
  <hr class="m-0 p-0" />
  <div class="card-body">
    <div class="w-100">
      <h5 class="mb-75">Languages:</h5>
      <p class="card-text">
        @if(isset($data->languages) && !empty($data->languages)) {!! nl2br(e($data->languages)) !!} @else {{'--'}} @endif
      </p>
    </div>
    <div class="w-100 mt-2">
      <h5 class="mb-75">Deals In:</h5>
      <p class="card-text">
        @if(isset($data->deals_in) && !empty($data->deals_in)) {!! nl2br(e($data->deals_in)) !!} @else {{'--'}} @endif
      </p>
    </div>
    <div class="w-100 mt-2">
      <h5 class="mb-75">Dealer Types:</h5>
      <p class="card-text">
        @if(isset($data->dealer_types) && !empty($data->dealer_types)) {!! nl2br(e($data->dealer_types)) !!} @else {{'--'}} @endif
      </p>
    </div>
    <div class="w-100 mt-2">
      <h5 class="mb-75">Business Types:</h5>
      <p class="card-text">
        @if(isset($data->business_type) && !empty($data->business_type)) {!! nl2br(e($data->business_type)) !!} @else {{'--'}} @endif
      </p>
    </div>

    <div class="w-100 mt-2">
      <h5 class="mb-75">Organizations:</h5>
      <p class="card-text">
        @if(isset($data->organizations) && !empty($data->organizations)) {!! nl2br(e($data->organizations)) !!} @else {{'--'}} @endif
      </p>
    </div>

    <div class="w-100  mt-2">
      <h5 class="mb-75">Payment Terms:</h5>
      <p class="card-text">
        @if(isset($data->payment_terms) && !empty($data->payment_terms)) {{$data->payment_terms}} @else {{'--'}} @endif
      </p>
    </div>

    <div class="w-100  mt-2">
      <h5 class="mb-75">Holidays:</h5>
      <p class="card-text">
        @if(isset($data->holidays) && !empty($data->holidays)) {{$data->holidays}} @else {{'--'}} @endif
      </p>
    </div>

    <div class="w-100 mt-2">
      <h5 class="mb-75">Permit Number:</h5>
      <p class="card-text">
        @if(isset($data->dealer_permit_number) && !empty($data->dealer_permit_number)) {{$data->dealer_permit_number}} @else {{'--'}} @endif
      </p>
    </div>

  </div>
</div>