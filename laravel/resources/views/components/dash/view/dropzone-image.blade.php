
<div class="col-xl-2 col-md-3 col-sm-6 draggable " id="photo{{$data->id}}">
    <div class="card">
       <div class="card-body m-0 p-0 p-1 image-rotate-manage" id="imgTag{{$data->id}}">

         @if(isset($editableImagesPath))
   
            @if(file_exists( public_path($editableImagesPath).$data->$tableImageFiledName))
            <img src="{{asset($editableImagesPath.$data->$tableImageFiledName)}}" id="imgId{{$data->id}}" class="rounded  mx-auto d-block" height="160" width="160"  alt="avatar img" />
            @else 
            <img src="{{'https://cdn.japanesecartrade.com/jct/vehicle_image/'.$data->name}}" height="160" width="160" class="rounded mx-auto d-block" alt="avatar img" data-index="{{public_path().'uploads/vehicle/large/'.$data->name}}"/>
            @endif
      
         @else
            @if(file_exists(public_path($uploadPath).'/'.$data->$tempTableImageFieldName))
            <img src="{{asset($uploadPath.$data->name)}}" class="rounded mx-auto d-block" id="imgId{{$data->id}}"  height="160" width="160" alt="avatar img" />
            @else 
            <img src="{{'https://cdn.japanesecartrade.com/jct/vehicle_image/'.$data->name}}" height="160" width="160" class=" rounded mx-auto d-block" alt="avatar img" data-index="{{public_path().'uploads/vehicle/large/'.$data->name}}"/>
            @endif

         @endif

         @php
            $formfieldValue = (isset($data->$tableImageFiledName)) ? $data->$tableImageFiledName : $data->$tempTableImageFieldName ;
            $formfield = (isset($data->tableImageFiledName)) ? $tableImageFiledName : $tempTableImageFieldName ;
         @endphp

          <div class="form-group mt-1">
             <input type="hidden" name="{{$formFieldName}}" value="{{$formfieldValue}}" >
             {{-- <x-admin.form.inputs.text id="" for="website"   name="document_name[]"  placeholder="{{__('webCaption.document_name.title')}}" value="{{(isset($data->document_name) ? $data->document_name :'')}}"  required="" /> --}}
          </div>   
       </div>
       <div class="card-footer row m-0 p-0 p-1">
          <div class="col-3 m-0 p-0 text-left"></div>
          <div class="col-9 m-0 p-0 text-right">
           
            <i class="fa-solid fa-magnifying-glass-plus"
            onclick="EnLargeSlider({{$data->id}});"></i>
          <i class="fa fa-trash text-danger"
           onclick="deleteTempDocumentImage('{{$data->id}}','{{$formfieldValue}}','{{$formfield}}')"></i>

          <i class="fa-solid fa-rotate text-danger"
           onclick="rotateImage('{{$data->id}}','{{$formfieldValue}}','{{$formfield}}')"></i>
          </div>
       </div>
    </div>
</div>


{{-- slider  --}}