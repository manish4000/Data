

<div class="col-xl-2 col-md-3 col-sm-6 draggable" id="photo{{$data->id}}">
    <div class="card">
       <div class="card-body m-0 p-0 p-1 image-rotate-manage" id="imgTag{{$data->id}}">
          @if(file_exists(public_path('gabs_companies').'/documents_temp'.'/'.$data->file_name))
          <img src="{{asset('gabs_companies/documents_temp/'.$data->file_name)}}" class="img-fluid rounded"  alt="avatar img" />
          @else 
          <img src="{{'https://cdn.japanesecartrade.com/jct/vehicle_image/'.$data->file_name}}" class="img-fluid rounded" alt="avatar img" data-index="{{public_path().'uploads/vehicle/large/'.$data->file_name}}"/>
          @endif
          <div class="form-group mt-1">
             <input type="hidden" name="document[]" value="{{$data->file_name}}" >
             <x-admin.form.inputs.text id="" for="website"   name="document_name[]"  placeholder="{{__('webCaption.document_name.title')}}"   required="" />
          </div>   
       </div>
       <div class="card-footer row m-0 p-0 p-1">
          <div class="col-3 m-0 p-0 text-left">1</div>
          <div class="col-9 m-0 p-0 text-right">
     
          <i data-feather="trash-2" class="text-danger cursor-pointer action-icons"
           onclick="deleteTempDocumentImage('{{$data->id}}','{{$data->file_name}}')"></i>
          </div>
       </div>
    </div>
    </div>