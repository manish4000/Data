<div class="card">
    <div class="card-header">
      <h4 class="card-title"><i data-feather="info" class="font-medium-3 mr-1"></i>{{ __('locale.Information.caption') }}</h4>
    </div>
    <hr class="m-0 p-0" />
    <div class="card-body">
      <div class="row">        
        <div class="col-lg-12 col-md-12">
          <!--<label>Slogan</label>-->
          <!-- <div class="form-group">
            <input type="text" class="form-control" name="slogan" placeholder="{{ __('locale.Slogan.caption') }}" id="slogan" value="@if(old('slogan')){{old('slogan')}}@elseif(isset($data->slogan)){{$data->slogan}}@endif"/>
          </div> -->
          <x-admin.form.inputs.text for="slogan" name="slogan" lable="Slogan" placeholder="{{ __('locale.Slogan.caption') }}" value="" required="" />
        </div>
        <div class="col-lg-6 col-md-12">
          <!--<label>HP Welcome Text</label>-->
          <!-- <div class="form-label-group mb-0">
            <textarea data-length="250" class="form-control char-textarea-input" placeholder="{{ __('locale.HP_Welcome_Text.caption') }}" id="hp_welcome_text" name="hp_welcome_text" rows="9" placeholder="">@if(old('hp_welcome_text')){{old('hp_welcome_text')}}@elseif(isset($data->hp_welcome_text)){{$data->hp_welcome_text}}@endif</textarea>
          </div> -->
          <x-admin.form.inputs.textarea for="hp_welcome_text" name="hp_welcome_text" lable="HP Welcome Text" placeholder="{{ __('locale.HP_Welcome_Text.caption') }}" value="" required="" />
          <small class="hp_welcome_text-textarea-counter-value float-right"><span class="hp_welcome_text-char-count">0</span> / 250 </small>
        </div>
        <div class="col-lg-6 col-md-12">
          <!--<label>Members of</label>-->
          <!-- <div class="form-label-group mb-0">
            <textarea data-length="250" class="form-control char-textarea-input"  placeholder="{{ __('locale.Members_of.caption') }}" id="members_of_text" name="members_of_text" rows="9" placeholder="">@if(old('members_of_text')){{old('members_of_text')}}@elseif(isset($data->members_of_text)){{$data->members_of_text}}@endif</textarea>
          </div> -->
          <x-admin.form.inputs.textarea for="members_of_text" name="members_of_text" lable="Members of" placeholder="{{ __('locale.Members of.caption') }}" value="" required="" />
          <small class="members_of_text-textarea-counter-value float-right"><span class="members_of_text-char-count">0</span> / 250 </small>
        </div>
        <div class="col-lg-12 col-md-12">
          <!--<label>About Company Text</label>-->
          <!-- <div class="form-label-group mb-0">
            <textarea data-length="5000" class="form-control char-textarea-input"  placeholder="{{ __('locale.About_Company_Text.caption') }}" id="about_company_text" name="about_company_text" rows="12" placeholder="">@if(old('about_company_text')){{old('about_company_text')}}@elseif(isset($data->about_company_text)){{$data->about_company_text}}@endif</textarea>
          </div> -->
          <x-admin.form.inputs.textarea for="about_company_text" name="about_company_text" lable="About Company Text" placeholder="{{ __('locale.About_Company_Text.caption') }}" value="" required="" />
          <small class="about_company_text-textarea-counter-value float-right"><span class="about_company_text-char-count">0</span> / 5000 </small>
        </div>
      </div>
    </div>
  </div>