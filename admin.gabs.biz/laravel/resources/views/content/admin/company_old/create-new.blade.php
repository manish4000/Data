@extends('layouts/contentLayoutMaster')

@section('title', 'Company Add')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection

@section('content')
<!-- users edit start -->
{{-- <form id="jquery-val-form" action="@if(isset($data->id) && $data->id>0){{url('company/update')}}@else{{url('company/store')}}@endif" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
  @csrf
  <section class="validations" id="validation">
    <section class="app-user-edit">
      	<x-admin.company.component-account-details :password="$password" :dealerTypes="$DealerTypes" />
      	<x-admin.company.component-contact-details :abbrivation="$abbrivation" />
      	<x-admin.company.component-general-details :ownerShipTypes="$OwnerShipTypes" :languages="$Languages" :dealIns="$DealIns" :businessTypes="$BusinessTypes" :organizations="$Organizations" :paymentTerms="$payment_terms" />
      	<x-admin.company.component-information-details />
      	<x-admin.component-social-media-inputs :socialmedias="$socialmedias" />
    </section>

    <section class="form-control-repeater">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header"><h4 class="card-title"><i data-feather="video" class="font-medium-3 mr-1"></i>{{ __('locale.Year_Established.caption') }}</h4></div>
            <hr class="m-0 p-0" />
            <div class="card-body">
              <div class="video-content-repeater">
                <div data-repeater-list="video_content">
                  @if(isset($data->video_content) && is_array($data->video_content) && count($data->video_content)>0)
                    @foreach($data->video_content as $key=>$vals)
                      @include('components/admin/component-video-gallery-inputs')
                    @endforeach
                  @else
                    @php $key = 0; @endphp
                    @include('components/admin/component-video-gallery-inputs')
                  @endif
                </div>
                <div class="row mt-1">
                  <div class="col-12">
                    <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                      <i data-feather="plus" class="mr-25"></i>
                      <span>{{ __('locale.Add_New.caption') }}</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="row mb-2">
      <div class="col-12">
        <!-- <input type="hidden" name="id" value="@if(isset($data->id)){{$data->id}}@endif"/> -->
        <button class="btn btn-success" name="submitBtn" type="submit">Submit</button>
        <button class="btn btn-danger" type="button">Cancel</button>
      </div>
    </div>
  </section>
</form> --}}

<!-- Modern Horizontal Wizard -->
<section class="modern-horizontal-wizard validations" id="validation">
  <div class="bs-stepper wizard-modern modern-wizard-example">
    <div class="bs-stepper-header">
      <div class="step" data-target="#account-details-modern">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="file-text" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Account Details</span>
            <span class="bs-stepper-subtitle">Setup Account Details</span>
          </span>
        </button>
      </div>
      <div class="line">
        <i data-feather="chevron-right" class="font-medium-2"></i>
      </div>
      <div class="step" data-target="#contact-info-modern">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="user" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Contact Details</span>
            <span class="bs-stepper-subtitle">Add Contact Details</span>
          </span>
        </button>
      </div>
      <div class="line">
        <i data-feather="chevron-right" class="font-medium-2"></i>
      </div>
      <div class="step" data-target="#general-step-modern">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="map-pin" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">General Details</span>
            <span class="bs-stepper-subtitle">Add General Details</span>
          </span>
        </button>
      </div>
      <div class="line">
        <i data-feather="chevron-right" class="font-medium-2"></i>
      </div>
      <div class="step" data-target="#information-step-modern">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="map-pin" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Information</span>
            <span class="bs-stepper-subtitle">Add Information</span>
          </span>
        </button>
      </div>
      <div class="line">
        <i data-feather="chevron-right" class="font-medium-2"></i>
      </div>
      <div class="step" data-target="#social-links-modern">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="link" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Social Links</span>
            <span class="bs-stepper-subtitle">Add Social Links</span>
          </span>
        </button>
      </div>
    </div>
    <form id="jquery-val-form" action="@if(isset($data->id) && $data->id>0){{url('admin/company/update')}}@else{{url('admin/company/store')}}@endif" method="post" enctype="multipart/form-data">
    @csrf
    <div class="bs-stepper-content">
      <div id="account-details-modern" class="content">
        <div class="content-header">
          <h5 class="mb-0">Account Detail</h5>
          <small>Setup the account detail.</small>
        </div>
        <x-admin.company.component-account-details :password="$password" :dealerTypes="$DealerTypes" :status="$status" :membershipTypes="$membershipTypes" />
        <div class="d-flex justify-content-between">
          <button class="btn btn-outline-secondary btn-prev" disabled>
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <button class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Next</span>
            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
          </button>
        </div>
      </div>
      <div id="contact-info-modern" class="content">
        <div class="content-header">
          <h5 class="mb-0">Contact Details</h5>
          <small>Enter Your Contact Info.</small>
        </div>
        <x-admin.company.component-contact-details :abbrivation="$abbrivation" :languages="$Languages"/>
        <div class="d-flex justify-content-between">
          <button class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <button class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Next</span>
            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
          </button>
        </div>
      </div>
      <div id="general-step-modern" class="content">
        <div class="content-header">
          <h5 class="mb-0">General Details</h5>
          <small>Enter Your General Details.</small>
        </div>
        <x-admin.company.component-general-details :ownerShipTypes="$OwnerShipTypes" :languages="$Languages" :dealIns="$DealIns" :businessTypes="$BusinessTypes" :organizations="$Organizations" :paymentTerms="$payment_terms" :services="$services" />
        <div class="d-flex justify-content-between">
          <button class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <button class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Next</span>
            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
          </button>
        </div>
      </div>
      <div id="information-step-modern" class="content">
        <div class="content-header">
          <h5 class="mb-0">Information</h5>
          <small>Enter Your Information.</small>
        </div>
        <x-admin.company.component-information-details />

        <div class="d-flex justify-content-between">
          <button class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <button class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Next</span>
            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
          </button>
        </div>
      </div>
      <div id="social-links-modern" class="content">
        <div class="content-header">
          <h5 class="mb-0">Social Links</h5>
          <small>Enter Your Social Links.</small>
        </div>
        <x-admin.component-social-media-inputs :socialmedias="$socialmedias" />
        <div class="d-flex justify-content-between">
          <button class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <!-- <button class="btn btn-success btn-submit">Submit</button> -->
          <button class="btn btn-success" name="submitBtn" type="submit">Submit</button>
        </div>
      </div>
    </div>
    </form>
  </div>
</section>
<!-- /Modern Horizontal Wizard -->
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/repeater/jquery.repeater.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-repeater.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-validation.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
  <script>
    var city_id     = '';
    var state_id    = '';
    var country_id  = '';
    @if(isset($data->city_id))    city_id     = {{$data->city_id}}; @endif
    @if(isset($data->state_id))   state_id    = {{$data->state_id}}; @endif
    @if(isset($data->country_id)) country_id  = {{$data->country_id}}; @endif
    
    function checkInsertDataAlreadyExistsOrNot(thisObj){
      var dataColumnValue = $(thisObj).val();
      if(dataColumnValue!=''){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':jQuery('meta[name="csrf-token"]').attr('content')}});  
      }
    }
    function checkShortNameExistsOrNot(thisObj){
      var short_name = $(thisObj).val();
      if(short_name!=''){      
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':jQuery('meta[name="csrf-token"]').attr('content')}});  
        $.post('/company/check-shortname-exists', {
          short_name:short_name
        }, function(returnedData){
          if(returnedData['status'] == true){
            var icon = returnedData['icon'];
            var msg  = returnedData['message'];
          }
          else{
            if(returnedData['status'] == false){
              var icon = returnedData['icon'];
              var msg  = returnedData['message']; 
            }
          }
          ___bottomEndSweetAlert(msg, icon, false);
        });
      }
    }
    var masterRoute = '/masters';
    (function (window, document, $) {
      'use strict';
      $('.attributes-ajax').on('change', function(){
        var selectAjax  = $(this);  
        $.post(masterRoute+'/get-master', { 
          obj_value: $('#'+$(this).attr('id')+' option:selected').val(),
          mode: selectAjax.attr('data-model'),          
          ajax_call_type: 'attributes-ajax'  
        },
        function(returnData){
          if(returnData['status'] == true){
            var JsonFormatData = returnData['data'];
            $('#mobile1_abbrivation').val(returnData['data']['country_code']+' | '+returnData['data']['phone_code']);
            $('#mobile2_abbrivation').val(returnData['data']['country_code']+' | '+returnData['data']['phone_code']);
          }
        });      
      });
      $('.selectdrop-data-change').on('change', function(){
        var selectAjax = $(this);
        var selected_data_name = selectAjax.attr('id');
        var mode_text = selectAjax.attr('data-index-model');
        var mode_arr  = mode_text.split('|');
        var mode      = mode_arr[0];
        var selectObj = mode_arr[1];
        var newSelectObj = selected_data_name.replace('same_', '');        
        
        var isMultiple = 'false';
        if($('#'+selectObj).prop('multiple') === 'true')  isMultiple = 'true'; 

        var dataRelation = 'false';
        if(typeof $(this).attr('data-relation') !== 'undefined'){
          if($(this).attr('data-relation')=='true') dataRelation = 'true';
        } 
        $('#'+selectObj).empty();  
        $.ajaxSetup({ headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')} });
        $.post(masterRoute+'/get-master', { 
            on_change_mode:selectAjax.attr('data-model'),
            on_change_obj_value:selectAjax.val(),
            ignore_obj_id:selected_data_name,
            mode:mode,
            is_parent_master:$('#'+selected_data_name).attr('data-is-parent'),
            is_multiple:isMultiple,
            data_relation:dataRelation,
            obj_id:newSelectObj,
            obj_value:selectAjax.val()
          }, 
          function(returnedData){            
            var JsonFormatData = returnedData['data'];
            $('#'+selectObj).wrap().select2({
              dropdownAutoWidth: true,
              dropdownParent: $('#'+selectObj).parent(),              
              data: JsonFormatData
            });
            if($('#'+selectObj).attr('data-value') != 'undefined' && parseInt($('#'+selectObj).attr('data-value'))>0) {
              $('#'+selectObj).val($('#'+selectObj).attr('data-value'));
              $('#select2-'+selectObj+'-container').html($('#'+selectObj+' option:selected').text());

              if($('#'+selectObj).attr('data-index-model') !== 'undefined'){
                const e = new Event("change");
                const element = document.querySelector('#'+selectObj)
                element.dispatchEvent(e);
              }
            }
        });
      }); 
      $('.selectdrop-data-ajax').each(function(){
        var selectAjax = $(this);
        if(selectAjax.attr('data-autofill') == 'true'){
          var isMultiple = false;
          if(selectAjax.prop('multiple') === true)  isMultiple = true;
          
          var dataRelation = false;
          if(typeof $(this).attr('data-relation') !== 'undefined' && $(this).attr('data-relation') !== false) dataRelation = true;

          $.ajaxSetup({ headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')} });
          $.post(masterRoute+'/get-master', 
            { 
              mode: selectAjax.attr('data-model'),
              is_parent_master: selectAjax.attr('data-is-parent'),
              is_multiple: isMultiple,
              data_relation: dataRelation
            }, 
            function(returnedData){          
              $(this).empty();
              var JsonFormatData = returnedData['data'];
              //var AddClass = 'position-relative-100';
              //if(selectAjax.attr('add-master-data') == 'Yes') AddClass = 'position-relative';  
              selectAjax.wrap().select2({
                dropdownAutoWidth: true,
                dropdownParent: selectAjax.parent(),
                data: JsonFormatData
              });
              
              if(selectAjax.attr('data-value') != 'undefined' && parseInt(selectAjax.attr('data-value'))>0) {
                selectAjax.val(selectAjax.attr('data-value'));
                $('#select2-'+selectAjax.attr('id')+'-container').html($('#'+selectAjax.attr('id')+' option:selected').text());
                if(selectAjax.attr('data-index-model') !== 'undefined'){
                  const e = new Event("change");
                  const element = document.querySelector('#'+selectAjax.attr('id'))
                  element.dispatchEvent(e);
                }
              }
            }
          );             
        } 
      });
      $('#email1').on('keyup', function(){
        var txt = $(this).val().replace(/\s/g, "");
        $('#email1').val(txt);
      });
      $('#short_name').on('keyup', function(){
        var txt = $(this).val().replace(/\s/g, "");
        $('#short_name').val(txt);
      });
      $('#postcode').on('keyup', function(){
        var txt = $(this).val().replace(/[a-zA-z]/g, "");
        $('#postcode').val(txt);
      });
      $('#year_established').on('keyup', function(){
        var txt = $(this).val().replace(/[a-zA-z]/g, "");
        $('#year_established').val(txt);
      });
      $('#mobile1').on('keyup', function(){
        var txt = $(this).val().replace(/[a-zA-z]/g, "");
        $('#mobile1').val(txt);
      });
      $('#mobile2').on('keyup', function(){
        var txt = $(this).val().replace(/[a-zA-z]/g, "");
        $('#mobile2').val(txt);
      });
      
      var form = $('.validate-form'),
        logoUploadImg     = $('#logo-upload-img'),
        logoUploadBtn     = $('#logo-upload'),
        profileUploadImg  = $('#profile-upload-img'),
        profileUploadBtn  = $('#profile-upload');
        
      if(logoUploadBtn) {
        logoUploadBtn.on('change', function (e) {
          var reader = new FileReader(),
            files = e.target.files;
          reader.onload=function(){if(logoUploadImg) logoUploadImg.attr('src', reader.result);};
          reader.readAsDataURL(files[0]);
        });
      }
      if(profileUploadBtn) {
        profileUploadBtn.on('change', function (e) {
          var reader  = new FileReader(),
              files   = e.target.files;
          reader.onload=function(){if(profileUploadImg) profileUploadImg.attr('src', reader.result);};
          reader.readAsDataURL(files[0]);
        });
      }
    })(window, document, jQuery); 
  </script>
@endsection
