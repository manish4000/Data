@extends('layouts/contentLayoutMaster')
@section('title', $pageConfigs['moduleName'])
@section('content')
<section class="app-user-list">
  <div class="card">
    <!--  DATALIST START FROM HERE  -->
    @include('content/admin/masters/datalist/list') 
    <!-- DATALIST END HERE -->

    <!-- RIGHT MODAL START FROM HERE -->
    @if($pageConfigs['isParentModal'] == false) @include('content/admin/masters/modals/withoutparent')
    @else @include('content/admin/masters/modals/withparent')
    @endif
    <!-- RIGHT MODAL END HERE -->
  </div>
</section>
@endsection

@section('page-script')
  <script src="{{ asset(mix('js/scripts/pages/masters/master-data-save-and-dropdown.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/masters/master-data-save-and-dropdown.js')) }}"></script>
  <script>
    $(function () {
      var profileUploadImg  = $('#upload-img');
      $('#img-upload').on('change', function (e) {
          var reader  = new FileReader(),
              files   = e.target.files;    
          reader.onload=function(){
            $('#upload-img').attr('src', reader.result);
            $('#binary_file').val(reader.result);
          };
          reader.readAsDataURL(files[0]);
        });
    });
  </script>  
@endsection