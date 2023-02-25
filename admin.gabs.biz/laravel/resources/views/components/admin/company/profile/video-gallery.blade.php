<div class="card">
  <div class="card-header p-1"><h4 class="card-title"><i data-feather="video" class="font-medium-3 mr-1"></i>Video Gallery</h4></div>
  <hr class="m-0 p-0" />
  <div class="card-body">
    <div class="row">
      @if(isset($data->video_content) && is_array($data->video_content) && count($data->video_content)>0)
        @foreach($data->video_content as $video)
          @if(!empty($video['video_url'])) 
            @php $video['video_url'] = str_replace('https://', '', $video['video_url']); 
            $video['video_url'] = str_replace('http://', '', $video['video_url']);@endphp
          <div class="col-md-2 col-4">
            <iframe width="160" height="120" src="https://{{$video['video_url']}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>  
          @endif
        @endforeach
      @endif
    </div>
  </div>
</div>