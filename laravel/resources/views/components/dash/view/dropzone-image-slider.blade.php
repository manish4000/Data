
            <div class="carousel-item" id="slider-img-{{$data->id}}" style="height:480px;width:640px">
                {{-- @if(file_exists(public_path($uploadPath.$tempTableImageFieldName))) --}}
                    <img class="img-fluid" src="{{asset($uploadPath.$data->$tempTableImageFieldName)}}"  alt="" />
                {{-- @else 
                    <img class="img-fluid" src="{{'https://cdn.japanesecartrade.com/jct/vehicle_image/'.$vPhoto->file_name}}" alt="{{$vPhoto->file_name}}" />
                @endif --}}
            </div>
