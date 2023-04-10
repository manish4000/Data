@props([
    'activeSiteLanguages',
    'data',
    'name',
    'readonly'
])

@php    
    $readonly = (isset($readonly))? $readonly :'';

@endphp

@if ( isset($activeSiteLanguages) && count($activeSiteLanguages) > 0 )
<div class="card">
  <div class="card-header">
    <h4 class="card-title">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
      </svg>
      {{__('webCaption.site_languages.title')}}
    </h4>  
  </div>
  <hr class="m-0 p-0">

  <div class="card-body">
    <div class="row">
          @foreach ( $activeSiteLanguages as $language )
            @php 
              $value = ""; 
              if ( isset($data[$language->id]) ) {
                $value = $data[$language->id]['title'];
              }
            @endphp

            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.text label="{{ $language->language_en }} {{__('webCaption.title.title')}}" for="title_languages{{$language->id}}title"  maxlength="80" class="form-control"  name="{{$name}}[{{$language->id}}][title]"  placeholder="{{ $language->language_en }} {{__('webCaption.title.title')}}" value="{{old('title_languages.'.$language->id.'.title', $value)}}"  required="" readonly="{{$readonly}}"  />
               
              </div>
            </div>
          @endforeach
    </div>
  </div>
</div>    
@endif

@push('script')
<script src="{{ asset('assets/js/gabs/master.js') }}"></script>
@endpush