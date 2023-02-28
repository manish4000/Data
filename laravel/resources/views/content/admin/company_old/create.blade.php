@extends('layouts/contentLayoutMaster')

@section('title', $pageConfigs['moduleName'])

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
@endsection

@section('page-style')
  <!-- Page css files -->
@endsection

@section('content')
<!-- users edit start -->
<form id="jquery-val-form" action="@if(isset($data->id) && $data->id>0){{url('company/update')}}@else{{url('company/store')}}@endif" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
  @csrf
  <section class="validations" id="validation">
    <section class="app-user-edit">
      @include('content/components/admin/company/component-account-details')
      @include('content/components/admin/company/component-contact-details')
      @include('content/components/admin/company/component-general-details')
      @include('content/components/admin/company/component-information-details')
      @include('content/components/admin/component-social-media-inputs')
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
                      @include('content/components/admin/component-video-gallery-inputs')
                    @endforeach
                  @else
                    @php $key = 0; @endphp
                    @include('content/components/admin/component-video-gallery-inputs')
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
        <input type="hidden" name="id" value="@if(isset($data->id)){{$data->id}}@endif"/>
        <button class="btn btn-success" name="submitBtn" type="submit">Submit</button>
        <button class="btn btn-danger" type="button">Cancel</button>
      </div>
    </div>
  </section>
</form>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/repeater/jquery.repeater.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-repeater.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-validation.js')) }}"></script>
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
