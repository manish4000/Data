<div class="video-data">
  <div class="row mt-1">
    <div class="col-lg-12 col-md-12">
      <div class="input-group input-group-merge">
        <div class="input-group-prepend"><span class="input-group-text bg-light"><i data-feather="youtube" class="text-danger font-medium-4"></i></span></div>
        <input type="text" maxlength="100" class="form-control pl-1" id="video_url" name="video_content[{{$key}}][video_url]" placeholder="{{__('info.Video_URL.caption')}}" value="@isset($vals){{$vals['video_url']}}@endisset" placeholder=""/>
        @isset($vals['video_url'])
        <div class="input-group-append" data-toggle="tooltip" data-original-title="Click to update video gallery" data-animation="false">
          <span data-href="@isset($vals){{$vals['video_url']}}@endisset" class="input-group-text bg-light videoEnLarge"><i data-feather="play" class="text-primary font-medium-4"></i></span>
        </div>
        @endisset 
      </div>
    </div>
    <div class="col-lg-3 col-md-3 col-12 d-none">
      <div class="form-group">
        <button class="btn btn-outline-danger text-nowrap" data-repeater-delete type="button">
          <i data-feather="x" class=""></i>
          <span>Delete</span>
        </button>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 mt-1 d-none">
      <div class="form-group">
        <label>{{__('info.Video_Title.caption')}}</label>{{ App\Helpers\Helper::__alertInformationPopupHover('Video_Title') }}
        <input type="text" maxlength="255" class="form-control" id="video_title" name="video_content[{{$key}}][video_title]" value="@isset($vals){{$vals['video_title']}}@endisset" placeholder="" />
      </div>
    </div>
    <div class="col-lg-12 col-md-12 d-none">
      <label>{{__('info.Video_Description.caption')}}</label>{{ App\Helpers\Helper::__alertInformationPopupHover('Video_Description') }}
      <div class="form-group">
        <textarea data-length="250" class="form-control char-textarea-input" id="video_description" name="video_content[{{$key}}][video_description]" rows="3" placeholder="">@isset($vals){{$vals['video_description']}}@endisset</textarea>
      </div>
      <small class="video_description-textarea-counter-value float-right"><span class="video_description-char-count">0</span> / 250 </small>
    </div>    
  </div>
</div>
