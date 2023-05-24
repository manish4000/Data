
    @if(isset($data) && count($data) > 0)
        
        @foreach($data as $key => $vPhoto)

            @php $rend =  rand(100,999) @endphp
       
            <div class="carousel-item   permanent-data" id="slider-img-{{$vPhoto->id}}" style="height:480px;width:640px"> 
                
                    <img class="img-fluid"  src="{{asset($editableImagesPath.$vPhoto->$tableImageFiledName)}}?{{$rend}}"   alt="{{$vPhoto->$tableImageFiledName}}" />
                
            </div>
            
        @endforeach
    @endif
