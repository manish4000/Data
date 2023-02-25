<div class="card">
  <div class="card-header p-1"><h4 class="card-title"><i data-feather="layers" class="font-medium-3 mr-1"></i>Profile Text</h4></div>
  <hr class="m-0 p-0" />
  <div class="card-body">
    <div class="row">
      <div class="col-6">
        <h5>HP Welcome Text:</h5>
        <p class="card-text">
          @if(isset($data->hp_welcome_text) && !empty($data->hp_welcome_text)) {!! nl2br(e($data->hp_welcome_text)) !!} @else {{'--'}} @endif
        </p>
      </div>
      <div class="col-6">
        <h5>Members of Text:</h5>
        <p class="card-text">
          @if(isset($data->members_of_text) && !empty($data->members_of_text)) {!! nl2br(e($data->members_of_text)) !!} @else {{'--'}} @endif
        </p>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <h5>About Company Text:</h5>
        <p class="card-text">
          @if(isset($data->about_company_text) && !empty($data->about_company_text)) {!! nl2br(e($data->about_company_text)) !!} @else {{'--'}} @endif
        </p>
      </div>
    </div>
  </div>
</div>
