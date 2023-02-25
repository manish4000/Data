@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.edit_master_data_translation.title') )
@else
@section('title', __('webCaption.value_edit.title'))
@endif

@section('content')
<form action="{{ route('language_translation.master_data_translation.update',$data->id)}}" method="POST">
  @csrf
  <section >
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
                </svg>
                {{__('webCaption.edit_master_data_translation.title')}}
              </h4>  
            </div>
            <hr class="m-0 p-0">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                      <x-admin.form.inputs.text tooltip="{{__('webCaption.value.caption')}}" label="{{__('webCaption.value.title')}}" for="value"  maxlength="255" class="form-control" name="value"  placeholder="{{ __('webCaption.value.title') }}" value="{{old('value', isset($data->value)?$data->value:'' )}}"  required="required" readonly />
                      @if($errors->has('value'))
                      <x-admin.form.form_error_messages message="{{ $errors->first('value') }}"  />
                      @endif
                  </div>    
                </div>
              </div>       
            </div>
          </div>
    
          @if ( isset($activeSiteLanguages) && count($activeSiteLanguages) > 0 )
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
                      @foreach ( $activeSiteLanguages as $language )
                        @php 
                        $value = ""; 
                        if ( isset($data->language_data[$language->id]) ) {
                          $value = $data->language_data[$language->id]['title'];
                        }
                        @endphp

                        <div class="col-md-4">
                          <div class="form-group">
                            <x-admin.form.inputs.text label="{{ $language->language_en }} {{__('webCaption.title.title')}} " for="title_languages{{$language->id}}title"  maxlength="80" class="form-control"  name="title_languages[{{$language->id}}][title]"  placeholder="{{ $language->language_en }} {{__('webCaption.title.title')}}" value="{{old('title_languages.'.$language->id.'.title', $value)}}"  required="" />
                            @if ($errors->has('title_languages[{{$language->id}}][title]'))
                            <x-admin.form.form_error_messages message="{{ $errors->first('title_languages[$language->id][title]') }}"  />
                            @endif
                          </div>
                        </div>
                      @endforeach
                  </div>
              </div>
          </div>    
          @endif


          @if ( isset($data->db_models) && count($data->db_models) > 0 )
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
                </svg>
                {{__('webCaption.db_models.title')}}
              </h4>  
            </div>
            <hr class="m-0 p-0">

              <div class="card-body">
                  <div class="row">
                        @foreach ( $data->db_models as $key=> $modal )
                          <div class="col-md-4">
                            <div class="form-group">
                              <x-admin.form.inputs.text label="{{__('webCaption.db_models.title')}} [{{$key}}]" for="" class="form-control"   name="db_models[{{$key}}]"  placeholder="{{__('webCaption.db_models.title')}}" value="{{old('db_models.'.$key,$modal)}}"  required=""  readonly/>
                              @if ($errors->has('db_models[{{$key}}]'))
                              <x-admin.form.form_error_messages message="{{ $errors->first('db_models[$key]') }}"  />
                              @endif
                            </div>
                          </div>
                        @endforeach
                  </div>
              </div>
          </div>    
          @endif
    
          <div class="text-center">
            @if(isset($data->id)) <x-admin.form.buttons.update />   @else <x-admin.form.buttons.create />    @endif 
          </div>
  </section>
</form>
@endsection