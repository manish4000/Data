@props([
    'dealerTypes',
    'status',
    'membershipTypes'
])


<div class="card">
  <div class="card-header"><h4 class="card-title"><i data-feather="user-check" class="font-medium-3 mr-1"></i>{{ __('locale.Account_Details.caption') }}</h4></div>
  <hr class="m-0 p-0" />
  <div class="card-body">
    <div class="row">
      <div class="col-md-8">
        <x-admin.form.inputs.text for="company_name" name="company_name" lable="Company Name" placeholder="{{ __('locale.Company_Name.caption') }}" value="" required="" />
      </div>
      <div class="col-lg-4 col-md-6">
        <x-admin.form.inputs.multiple_select for="dealer_type_id" name="dealer_type_id" placeholder="{{ __('locale.Dealer_Type.caption') }}" value="" required="" :optionData="$dealerTypes" />
      </div>            
      <div class="col-md-4">
        <x-admin.form.inputs.text for="short_name" name="short_name" lable="Short Name" placeholder="{{ __('locale.Short_Name.caption') }}" value="" required="" />
      </div>
      <div class="col-md-4">
        <x-admin.form.inputs.text for="username" name="username" lable="Username" placeholder="{{ __('locale.Login_id.caption') }}" value="" required="" />
      </div>
      <div class="col-md-4">
        <x-admin.form.inputs.text for="password" name="password" lable="Password" placeholder="{{ __('locale.Password.caption') }}" value="" required="" />
      </div>             
      <div class="col-md-4">
        <x-admin.form.inputs.select for="status" name="status" placeholder="{{ __('locale.Status.caption') }}" value="" required="" :optionData="$status" />
      </div>
      <div class="col-md-4">
        <x-admin.form.inputs.text for="email" name="email" lable="Email" placeholder="{{ __('locale.Email.caption') }}" value="" required="" />
      </div> 
      <div class="col-md-4">
        <x-admin.form.inputs.select for="membership_type" name="membership_type" value="" required="" :optionData="$membershipTypes" />
      </div>      
      <div class="col-md-4">
        <x-admin.form.inputs.file for="logo-upload" name="media[logo_file]" caption="Upload Logo" required="" />
      </div>
      <div class="col-md-4">
        <x-admin.form.inputs.file for="profile-upload" name="profile_file" caption="Upload Profile Photo" required="" />  
      </div>
    </div>
  </div>
</div>