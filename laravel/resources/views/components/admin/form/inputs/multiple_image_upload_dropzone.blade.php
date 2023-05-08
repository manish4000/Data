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
   {{-- @if(isset($doc_file) && count($doc_file)>0)

      @php $ik =1; @endphp
      @foreach($doc_file as $vPhoto)
      <div class="col-xl-2 col-md-3 col-sm-6 draggable" id="photo{{$vPhoto->id}}">
      <div class="card">
         <div class="card-body m-0 p-0 p-1 image-rotate-manage" id="imgTag{{$vPhoto->id}}">
            @if(file_exists(public_path('gabs_companies').'/documents_temp/'.$vPhoto->file_name))
            <img src="{{asset('gabs_companies/documents_temp/'.$vPhoto->file_name)}}" class="img-fluid rounded"  alt="avatar img" />
            @else 
            <img src="{{'https://cdn.japanesecartrade.com/jct/vehicle_image/'.$vPhoto->file_name}}" class="img-fluid rounded" alt="avatar img" data-index="{{public_path().'uploads/vehicle/large/'.$vPhoto->file_name}}"/>
            @endif
            <div class="form-group mt-1">
               <input type="hidden" name="document[]" value="{{$vPhoto->file_name}}" >
               <x-admin.form.inputs.text id="" for="website"   name="document_name[]"  placeholder="{{__('webCaption.document_name.title')}}"   required="" />
            </div>   
         </div>
         <div class="card-footer row m-0 p-0 p-1">
            <div class="col-3 m-0 p-0 text-left">{{$ik}}</div>
            <div class="col-9 m-0 p-0 text-right">
            <i data-feather="maximize" title="Click to view enlarge" class="cursor-pointer action-icons" onclick="EnLargeSlider({{$vPhoto->order_by}});"></i>
       
            <i data-feather="trash-2" class="text-danger cursor-pointer action-icons"
             onclick="deleteTempDocumentImage('{{$vPhoto->id}}','{{$vPhoto->file_name}}')"></i>
            </div>
         </div>
      </div>
      </div>
      @php $ik++; @endphp
      @endforeach 
   @endif--}}
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