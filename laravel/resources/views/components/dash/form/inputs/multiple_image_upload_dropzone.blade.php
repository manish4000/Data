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

{{--  --}}

{{-- @php 


 $slider_images_array =  isset($editableImages) ?  json_decode(json_encode($editableImages),true) : '' ;

 $slider_images_array = json_encode($slider_images_array);

@endphp --}}

<div class="modal fade bg-transparent " id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" >

   


<div class="modal-dialog modal-dialog-centered bg-transparent modal-lg" role="document">
   <div class="modal-content card">
       <div class="card-body text-center">
           <div id="carousel-example-caption" class="carousel slide" data-ride="false">
               {{-- <ol class="carousel-indicators">
                   @if(isset($editableImages) && count($editableImages)> 0 )
                       @php $i = 0; @endphp
                       @foreach($editableImages as $vPhoto)
                           <li data-target="#carousel-example-caption" data-slide-to="{{$i}}" class="data-slide-{{$vPhoto->orders}}"></li>
                           @php $i++; @endphp
                       @endforeach
                   @endif
               </ol> --}}

               <div class="carousel-inner" role="listbox" id="slider-temp-image">
               </div>
               <a class="carousel-control-prev" href="#carousel-example-caption" role="button" data-slide="prev">
                   <span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span>
               </a>
               <a class="carousel-control-next" href="#carousel-example-caption" role="button" data-slide="next">
                   <span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span>
               </a>
           </div>
       </div>
   </div>
</div>  
  
</div>

{{--  --}}

@php


   $id = (isset($id) &&  !empty($id)) ? $id : ''; 
   $tableImageFiledName = (isset($tableImageFiledName) &&  !empty($tableImageFiledName)) ? $tableImageFiledName : ''; 

   $table_referance_filed_name = (isset($table_referance_filed_name) &&  !empty($table_referance_filed_name)) ? $table_referance_filed_name : ''; 
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
        complete: function(file) {
         dropzone.removeFile(file);
         },
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
                console.log(response);
              $('#card-drag-area').append(response.card);
              $('#slider-temp-image').append(response.slider_div);
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
               
                  $("div#slider-img-"+result.deleted_img_id).remove();
               }else{
                  errorToast(result.message);
               }
            }
         });
         
        }
    }


    function EnLargeSlider(id){

      $.ajax ({
            type: 'POST',
            url: "{{route('dashslider-images')}}",
            data: { 
                  id : "{{$id}}",
                  table : "{{$table}}",
                  table_referance_filed_name : "{{$table_referance_filed_name}}",
                  tableImageFiledName : "{{$tableImageFiledName}}",
                  editableImagesPath:"{{$editableImagesPath}}",
            },
            success : function(result) {
               if(result.status == true){
                  $("div.permanent-data").remove();
                  $('#slider-temp-image').append(result.view);
                  $('#slider-img-'+id).addClass('active')   
               }
               $('#large').modal('show');
            }
         });

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

                   $("#imgId"+imageId).attr("src",result.image_src);

               }else{
                  errorToast(result.message);
               }
            }
         });
         
      }
    }

</script>


@endpush