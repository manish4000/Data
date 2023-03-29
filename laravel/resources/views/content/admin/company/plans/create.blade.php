@extends('layouts/contentLayoutMaster',['activeUrl' => $menuUrl])
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.edit_company_plan.title') )
@else
@section('title', __('webCaption.add_company_plan.title'))
@endif

@section('content')
<form action="{{ route('company.plans.store')}}" method="POST">
  @csrf
  <section >
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">
    
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map font-medium-3 mr-1"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line>
          </svg>
          @if(isset($data->id) && !empty($data->id))
             {{__('webCaption.edit_company_plan.title')}}
          @else
             {{__('webCaption.add_company_plan.title')}}
          @endif
        </h4>  
      </div>
      <hr class="m-0 p-0">
      <div class="card-body">
        <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.text tooltip="{{__('webCaption.title.caption')}}" label="{{__('webCaption.title.title')}}" maxlength="150" for="title"  name="title"  placeholder="{{ __('webCaption.title.title') }}" value="{{old('title', isset($data->title)?$data->title:'' )}}"  required="required" />
                
              </div>    
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.text tooltip="{{__('webCaption.slug.caption')}}"  label="{{__('webCaption.slug.title')}}" maxlength="150" for="slug"  name="slug"  placeholder="{{ __('webCaption.slug.title') }}" value="{{old('slug', isset($data->slug)?$data->slug:'' )}}"  required="required" />
                
              </div>    
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <x-admin.form.inputs.text tooltip="{{__('webCaption.order.caption')}}"  label="{{__('webCaption.order.title')}}"  for="order_by"  name="order_by"  placeholder="{{ __('webCaption.order.title') }}" value="{{old('order_by', isset($data->order_by)?$data->order_by:'' )}}"  required="" />
                
              </div>    
            </div>
        </div>       
      </div>
    </div>
    
    <div class="text-center">
      <input type="hidden" name="id" value="@if(isset($data->id) && !empty($data->id)){{$data->id}}@endif" />
    @if(isset($data->id))   <x-admin.form.buttons.update />  @else    <x-admin.form.buttons.create />   @endif
    </div>
  </section>
</form>
@endsection
@push('script')
  <script src="{{ asset('assets/js/gabs/master.js') }}"></script>
@endpush