@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">

@endsection

<div class="container">
            <div class="dropzone dropzone-area" id="image-upload">
            </div>
</div>

<section id="draggable-cards my-2">
<div class="row" id="card-drag-area">
   @if(isset($editableImages))

      @foreach($editableImages as $data)
         @include('components.dash.view.dropzone-image',['data' => $data ,'formFieldName' => $formFieldName,'tempTableImageFieldName' => $tableImageFiledName,'tableImageFiledName' =>$tableImageFiledName,'uploadPath' => $uploadPath ,'editableImagesPath' => $editableImagesPath ])
      @endforeach

   @endif
</div>
</section>

@php
   $acceptedFiles = (isset($acceptedFiles) &&  !empty($acceptedFiles)) ? $acceptedFiles : ''; 
   $max_size = (isset($maxFilesize) &&  !empty($maxFilesize)) ? $maxFilesize : ''; 
   $maxFiles = (isset($maxFiles) &&  !empty($maxFiles)) ? $maxFiles : ''; 
   $dictDefaultMessage = (isset($dictDefaultMessage) &&  !empty($dictDefaultMessage)) ? $dictDefaultMessage : ''; 
  
@endphp


@push('script')


<script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
<script type="text/javascript">

  let acceptableFiles = "{{$acceptedFiles}}";
  let max_size = "{{$max_size}}";
  let DefaultMessage = "Drop Files here or click to upload.";

   Dropzone.autoDiscover = false;
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
     var dropzone = new Dropzone('#image-upload', {
        url: "{{$action}}",
        method: "POST",
        headers: {
            'x-csrf-token': CSRF_TOKEN
        },
        params: {
         tempTable: "{{$tempTable}}",
         uploadPath : "{{$uploadPath}}"
         },
        clickable:true,
        maxFilesize: max_size,
        acceptedFiles: '.png,.jpg,.jpeg',
        dictDefaultMessage :DefaultMessage,
        parallelUploads: 1,
        uploadMultiple: false,
        success: function(){
        
            $.ajax({
            url: "{{route('dashget-images-temp')}}",
            type: 'post',
            data: { tempTable: "{{$tempTable}}",
                    uploadPath : "{{$uploadPath}}",
                    tempTableImageFieldName :"{{$tempTableImageFieldName}}",
                    tableImageFiledName:"{{$tableImageFiledName}}",
                    formFieldName:"{{$formFieldName}}"
               },
            success: function(response){
               $('#card-drag-area').append(response);
            }
            });
        },
   
      
 
    });


    function deleteTempDocumentImage(imageId,fileName,fieldName){
        if(imageId){

         $.ajax ({
            type: 'POST',
            url: "{{$deleteTempImage}}",
            
            data: { id : imageId ,
               tempTable: "{{$tempTable}}",
               name : fileName,
               fieldName:fieldName,
               table : "{{$table}}",
               editableImagesPath:"{{$editableImagesPath}}",
               uploadPath : "{{$uploadPath}}"
            },
            success : function(result) {
               if(result.status == true){
                  $("div#photo"+imageId).remove();
               }else{
                  errorToast(result.message);
               }
            }
         });
         
        }
    }

    function rotateImage(imageId,fileName,fieldName){
        if(imageId){

         $.ajax ({
            type: 'POST',
            url: "{{route('dashrotate-image')}}",
            
            data: { id : imageId ,
               tempTable: "{{$tempTable}}",
               name : fileName,
               fieldName:fieldName,
               table : "{{$table}}",
               editableImagesPath:"{{$editableImagesPath}}",
               uploadPath : "{{$uploadPath}}"
            },
            success : function(result) {
               if(result.status == true){
                  $("div#photo"+imageId).remove();
               }else{
                  errorToast(result.message);
               }
            }
         });
         
        }
    }

</script>


@endpush