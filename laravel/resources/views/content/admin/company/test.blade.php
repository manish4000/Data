@extends('layouts/contentLayoutMaster')
@section('title', __('webCaption.company_add.title'))
@section('content')
<!-- users edit start -->

<form action="{{route('company.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    
  <section class="form-control-repeater">
            <div class="card">
                   <div class="card-header">
                   <h4 class="card-title">
                   <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check font-medium-3 mr-1"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                   {{__('webCaption.account_details.title')}}
                   </h4>
            </div>
           <hr class="m-0 p-0">
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-8">
                     <div class="form-group">
                        <x-admin.form.inputs.text id="" for="company_name" tooltip="{{__('webCaption.company_name.caption')}}" label="{{__('webCaption.company_name.title')}}" maxlength="100" class="form-control" name="company_name"  placeholder="{{__('webCaption.company_name.title')}}" value="{{old('company_name', isset($data->company_name)?$data->company_name:'' )}}"  required="required" />
                        @if($errors->has('company_name'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('company_name') }}"  />
                        @endif
                     </div>
                  </div>

                    <div class="col-md-4">
                     <div class="form-group">
                        <x-admin.form.inputs.text id="" label="{{__('webCaption.gabs_uuid.title')}}" tooltip="{{__('webCaption.gabs_uuid.caption')}}" for="gabs_uuid" class="form-control" maxlength="6" name="gabs_uuid"  placeholder="{{__('webCaption.gabs_uuid.title')}}" value="{{old('gabs_uuid', isset($data->gabs_uuid)?$data->gabs_uuid:'' )}}"  required="required" />
                        @if($errors->has('gabs_uuid'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('gabs_uuid') }}"  />
                        @endif
                     </div>
                  </div>
                 </div>

                <div class="row">
                        <div class="col-md-4">
                        <div class="form-group">
                            <x-admin.form.inputs.email id="" for="email" tooltip="{{__('webCaption.email.caption')}}" label="{{__('webCaption.email.title')}}" maxlength="45" class="form-control" name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($data->email)?$data->email:'' )}}"  required="required" />
                             @if($errors->has('email'))
                                 <x-admin.form.form_error_messages message="{{ $errors->first('email') }}"  />
                            @endif
                        </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                               <x-admin.form.inputs.password id="" tooltip="{{__('webCaption.password.caption')}}"    label="{{__('webCaption.password.title')}}" for="password" class="form-control"    maxlength="15" name="password"  placeholder="{{__('webCaption.password.title')}}"    value=""  required="required" />
                               @if($errors->has('password'))
                               <x-admin.form.form_error_messages message="{{ $errors->first('password') }}"  />
                               @endif
                            </div>
                         </div> 


                        <div class="col-md-4">
                        <div class="form-group">
                            <x-admin.form.inputs.select label="{{__('webCaption.status.title')}}" tooltip="{{__('webCaption.status.caption')}}"  id="" for="status" name="status" placeholder="{{ __('locale.status.caption') }}" editSelected=""  required="required" />
                            @if($errors->has('status'))
                            <x-admin.form.form_error_messages message="{{ $errors->first('status') }}"  />
                            @endif
                        </div>
                        </div> 

                        
                </div>


                
                <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <x-admin.form.inputs.textarea id="" for="address" tooltip="{{__('webCaption.address.caption')}}" label="{{__('webCaption.address.title')}}" maxlength="250" class="form-control" name="address"  placeholder="{{__('webCaption.address.title')}}" value="{{old('address', isset($data->address)?$data->address:'' )}}"  required="" />
                        @if($errors->has('address'))
                           <x-admin.form.form_error_messages message="{{ $errors->first('address') }}"  />
                        @endif
                     </div>
                  </div>
               </div>
                
                




</form>

@endsection