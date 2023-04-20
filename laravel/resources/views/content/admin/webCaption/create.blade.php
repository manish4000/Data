@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.web_caption_edit.title'))
@else
@section('title', __('webCaption.web_caption_add.title'))
@endif

@section('content')
<form action="{{ route('language_translation.web_caption.store')}}" method="POST">
@csrf
<section >
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">

        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
        </svg>
        @if(isset($data->id) && !empty($data->id))  {{__('webCaption.web_caption_edit.title')}} @else {{__('webCaption.web_caption_add.title')}}  @endif
      </h4>  
    </div>
     <hr class="m-0 p-0">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <x-admin.form.inputs.text tooltip="{{__('webCaption.title.caption')}}" label="{{__('webCaption.title.title')}}" maxlength="250" for="title"  name="title"  placeholder="{{__('webCaption.title.title')}}" value="{{old('title', isset($data->title)?$data->title:'' )}}"  required="required" />
          </div>    
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <x-admin.form.inputs.text tooltip="{{__('webCaption.locale_slug.caption')}}" label="{{__('webCaption.locale_slug.title')}}" maxlength="250" for="local_slug"  name="local_slug"  placeholder="{{__('webCaption.locale_slug.title')}}" value="{{old('local_slug', isset($data->local_slug)?$data->local_slug:'' )}}"  required="required" />
          </div>    
        </div>
      </div>       
    </div>
  </div>
 
        @if ( isset($local_translations) && count($local_translations) > 0 )
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">

              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
              </svg>
              {{__('webCaption.menu_main_navigation_masters_site_languages.title')}}
            </h4>  
          </div>
           <hr class="m-0 p-0">

          <div class="card-body">
            <div class="row">
                  @foreach ( $local_translations as $language )
                    @php 
                    $value_title = ""; 
                    $value_caption = "";
                    if ( isset($data->local_translations[$language->id]) ) {
                      $value_title = $data->local_translations[$language->id]['title'];
                      $value_caption = $data->local_translations[$language->id]['caption'];
                    }
                    @endphp

                    <div class="col-md-4">
                      <div class="form-group">
                        <x-admin.form.inputs.text label="{{ $language->language_en }} {{__('webCaption.title.title')}}" for="local_translations{{$language->id}}title"  maxlength="250" customClass="mb-1"  name="local_translations[{{$language->id}}][title]"  placeholder=" {{ $language->language_en }} {{__('webCaption.title.title')}}" value="{{old('local_translations.'.$language->id.'.title', $value_title)}}"  required="" />
                      </div>
                      <div class="form-group">
                        <x-admin.form.inputs.textarea label="{{ $language->language_en }} {{__('webCaption.caption.title')}}" for="local_translations{{$language->id}}caption"  maxlength="250" customClass="mb-1"  name="local_translations[{{$language->id}}][caption]"  placeholder="{{ $language->language_en }} {{__('webCaption.caption.title')}}" value="{{old('local_translations.'.$language->id.'.caption', $value_caption)}}"  required="" />
                      </div>
                    </div>
                  @endforeach
               </div>
            </div>
          </div>    
        @endif
  

  <div class="text-center">
    <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
    @if(isset($data->id)) <x-admin.form.buttons.update />    @else <x-admin.form.buttons.create />     @endif 
  </div>
</section>
</form>
@endsection





