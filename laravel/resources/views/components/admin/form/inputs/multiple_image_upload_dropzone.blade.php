@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">

@endsection

<div class="container">
            <div class="dropzone dropzone-area" id="image-upload">
            </div>
</div>

@php
$session_id = Session::getId();

$doc_file = DB::table('company_documents_temp')->where('session_id',$session_id)->get();

   @endphp
<section id="draggable-cards">
<div class="row" id="card-drag-area">

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
         table: "{{$table}}",
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
            url: "{{route('get-images-temp')}}",
            type: 'post',
            data: {table: "{{$table}}"},
            success: function(response){
               $('#card-drag-area').append(response);
            }
            });
        }
      

 
    });


    function deleteTempDocumentImage(imageId,fileName){
        if(imageId){

         $.ajax ({
            type: 'POST',
            url: "{{$deleteTempImage}}",
            
            data: { id : imageId ,
               table: "{{$table}}",
               uploadPath : "{{$uploadPath}}"
            },
            success : function(result) {
               if(result.status == true){
                  $("div#photo"+imageId).remove();
                  successToast(result.message);
               }else{
                  errorToast(result.message);
               }
            }
         });
         
        }
    }


</script>


@endpush