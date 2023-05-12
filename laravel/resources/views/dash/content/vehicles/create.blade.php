@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.vehicles.title') )
@else
@section('title', __('webCaption.vehicles.title'))
@endif
@section('content')
  

<div>
   <form action="" method="POST" enctype="multipart/form-data">
      @csrf


            <div class="card card-primary">
                <div class="card-header py-75">
                    <h4 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-target"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                            {{__('webCaption.purchase_information.title')}}
                  </h4>
                </div>
               <hr class="m-0 p-0">
                <div class="card-body py-75">
                   <div class="row">
                                  <div class="col-md-4 col-6">
                                        <div class="form-group mb-0">
                                            <x-dash.form.inputs.select label="{{__('webCaption.purchase_from.title')}}" tooltip="{{__('webCaption.purchase_from.caption')}}" for="purchase_from" name="purchase_from" placeholder="{{ __('locale.purchase_from.caption') }}" customClass="status"  editSelected="{{(isset($data->status) && ($data->status != null)) ? $data->status :'' }}"  required=""  />
                                            @if($errors->has('status'))
                                            <x-admin.form.form_error_messages message="{{ $errors->first('status') }}"  />
                                            @endif
                                       </div>
                                    </div>


                                    <div class="col-md-4 col-6">
                                         <div class="form-group mb-0">
                                           <x-dash.form.inputs.date  for="purchase_date"  maxlength="255" tooltip="{{__('webCaption.purchase_date.caption')}}" label="{{__('webCaption.purchase_date.title')}}"   name="purchase_date"  placeholder="{{__('webCaption.purchase_date.title')}}" value="{{old('purchase_date', isset($data->purchase_date)?$data->purchase_date:'' )}}"  required="" />
                                      </div>
                                  </div>


                                          <div class="col-md-2 col-6">
                                              <div class="form-group mb-0">
                                                   <x-dash.form.inputs.text  for="lot_number"  maxlength="10" tooltip="{{__('webCaption.lot_number.caption')}}" label="{{__ ('webCaption.lot_number.title')}}"  class="form-control" name="lot_number"  placeholder="{{__('webCaption.lot_number.title')}}" value="{{old('lot_number', isset($data->title)?  $data->lot_number:'' )}}"  required="" />
                                                    @if ($errors->has('title'))
                                                    <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                                    @endif
                                               </div>
                                            </div>


                                            <div class="col-md-2 col-6">
                                              <div class="form-group mb-0">
                                                   <x-dash.form.inputs.text  for="purchase_price"  maxlength="10" tooltip="{{__('webCaption.purchase_price.caption')}}" label="{{__ ('webCaption.purchase_price.title')}}"  class="form-control" name="purchase_price"  placeholder="{{__('webCaption.purchase_price.title')}}" value="{{old('purchase_price', isset($data->title)?  $data->purchase_price:'' )}}"  required="" />
                                                    @if ($errors->has('title'))
                                                    <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                                    @endif
                                               </div>
                                            </div>
                      </div>
              </div>                   
         </div>     






       <div class="card card-primary">
           <div class="card-header py-75">
               <h4 class="card-title">
               <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info font-medium-5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    {{__('webCaption.general_information.title')}}
                </h4>
            </div>
             <hr class="m-0 p-0">

           <div class="card-body py-75">           
               <div class="row">
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <x-dash.form.inputs.select label="{{__('webCaption.stock_type.title')}}" 
                                    tooltip="{{__('webCaption.stock_type.caption')}}" for="stock_type" name="stock_type"
                                    placeholder="{{ __('locale.country.caption') }}" customClass="status"  editSelected="{{(isset($data->status) && ($data->status != null)) ? $data->status :'' }}"  required=""  />
                                @if($errors->has('status'))
                                <x-admin.form.form_error_messages message="{{ $errors->first('status') }}"  />
                                @endif
                            </div>
                        </div>


                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <x-dash.form.inputs.select label="{{__('webCaption.stock_sources.title')}}" 
                                    tooltip="{{__('webCaption.stock_sources.caption')}}" for="stock_sources" name="stock_sources" placeholder="{{ __('locale.stock_sources.caption') }}" customClass="status"  editSelected="{{(isset($data->status) && ($data->status != null)) ? $data->status :'' }}"  required=""  />
                                @if($errors->has('status'))
                                <x-admin.form.form_error_messages message="{{ $errors->first('status') }}"  />
                                @endif
                            </div>
                        </div>
                           
                              <div class="col-md-4 col-12">
                                 <div class="row">
                                        <div class="col-md-7 col-6">
                                            <div class="form-group">
                                                <x-dash.form.inputs.text  for="stock_number"  maxlength="20" tooltip="{{__('webCaption.stock_number.caption')}}" label="{{__('webCaption.stock_number.title')}}"  class="form-control" name="stock_number"  placeholder="{{__('webCaption.stock_number.title')}}" value="{{old('stock_number', isset($data->title)?$data->stock_number:'' )}}"  required="required" />
                                                    @if ($errors->has('title'))
                                                    <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                                    @endif
                                            </div>
                                        </div>

                                            <div class="col-md-5 col-6 pt-2 pr-0 mt-50">                     
                                                <div class="form-group">
                                                    <!-- <x-dash.form.label for="" value="{{__('webCaption.auto_increment.title')}}" class="" tooltip="{{__('webCaption.auto_increment.caption')}}" /> -->

                                                    <x-dash.form.inputs.checkbox for="auto_increment" class="mt-3" tooltip="{{__('webCaption.auto_increment.caption')}}"  label="{{__('webCaption.auto_increment.title')}}" name="auto_increment"  placeholder="{{__('webCaption.auto_increment.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->two_step_verification) && $user->companySalesTeam->two_step_verification == '1') ? 'checked' : ''}}" required="" />								
                            
                                                    </div>
                                            </div>
                                  </div>                   
                              </div> 

                     <div class="col-md-4 col-6">
                           <div class="form-group">
                               <x-dash.form.inputs.select label="{{__('webCaption.stock_location.title')}}" 
                               tooltip="{{__('webCaption.stock_location.caption')}}" for="stock_location" name="membership"
                               placeholder="{{ __('locale.stock_location.caption') }}" customClass="stock_location"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->stock_location :'' }}"  required=""  />
                               @if($errors->has('membership'))
                               <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                @endif
                          </div>
                      </div>


                      <div class="col-md-4 col-6">
                           <div class="form-group">
                               <x-dash.form.inputs.select label="{{__('webCaption.stock_port.title')}}" 
                               tooltip="{{__('webCaption.stock_port.caption')}}" for="stock_port" name="membership"
                               placeholder="{{ __('locale.stock_port.caption') }}" customClass="stock_port"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->stock_port :'' }}"  required=""  />
                               @if($errors->has('membership'))
                               <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                @endif
                          </div>
                      </div>


                      <div class="col-md-4 col-12">
                        <div class="row">
                             <div class="col-md-7 col-6">
                                  <div class="form-group">
                                     <x-dash.form.inputs.select label="{{__('webCaption.price_type.title')}}" 
                                      tooltip="{{__('webCaption.price_type.caption')}}" for="price_type" name="membership"
                                      placeholder="{{ __('locale.price_type.caption') }}" customClass="price_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->price_type :'' }}"  required=""  />
                                      @if($errors->has('membership'))
                                       <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                         @endif
                                  </div>
                              </div>

                              <div class="col-md-5 col-6">
                                  <div class="form-group">
                                     <x-dash.form.inputs.select label="{{__('webCaption.currency.title')}}" 
                                      tooltip="{{__('webCaption.currency.caption')}}" for="currency" name="membership"
                                      placeholder="{{ __('locale.currency.caption') }}" customClass="currency"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->currency :'' }}"  required=""  />
                                      @if($errors->has('membership'))
                                       <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                         @endif
                                    </div>
                                </div> 
                           </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <div class="form-group mb-0">
                                        <x-dash.form.inputs.text  for="price" tooltip="{{__('webCaption.price.caption')}}" label="{{__('webCaption.price.title')}}"  class="form-control" name="price"  placeholder="{{__('webCaption.price.title')}}" value="{{old('price', isset($data->title)?$data->price:'' )}}"  required="" />
                                            @if ($errors->has('title'))
                                        <x-dash.form.form_error_messages message="{{ $errors->first('price') }}" />
                                        @endif
                                    </div>
                                    </div>

                                    <div class="col-md-6 col-6">
                                    <div class="form-group mb-0">
                                        <x-dash.form.inputs.text  for="special_offer_price" tooltip="{{__('webCaption.price.caption')}}" label="{{__('webCaption.special_offer.title')}}"  class="form-control" name="special_offer_price"  placeholder="{{__('webCaption.price.title')}}" value="{{old('price', isset($data->title)?$data->price:'' )}}"  required="" />
                                            @if ($errors->has('title'))
                                        <x-dash.form.form_error_messages message="{{ $errors->first('price') }}" />
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            </div>



                              <div class="col-md-4 col-6">
                                  <div class="form-group mb-0">
                                     <x-dash.form.inputs.select label="{{__('webCaption.vehicle_status.title')}}" 
                                      tooltip="{{__('webCaption.vehicle_status.caption')}}" for="vehicle_status" name="vehicle_status"
                                      placeholder="{{ __('locale.vehicle_status.caption') }}" customClass="yard_location"  editSelected="{{(isset($data->membership) && ($data->vehicle_status!= null)) ? $data->vehicle_status :'' }}"  required="required"  />
                                      @if($errors->has('membership'))
                                       <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                         @endif
                                  </div>
                              </div> 


                               <div class="col-md-4 col-6">
                                  <div class="form-group mb-0">
                                     <x-dash.form.inputs.select label="{{__('webCaption.yard_location.title')}}" 
                                      tooltip="{{__('webCaption.yard_location.caption')}}" for="yard_location" name="membership"
                                      placeholder="{{ __('locale.yard_location.caption') }}" customClass="yard_location"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->yard_location :'' }}"  required=""  />
                                      @if($errors->has('membership'))
                                       <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                         @endif
                                  </div>
                              </div> 

                </div>
           </div>
      </div>


<!---------vehicle-information-------->

      <div class="card card-primary">
           <div class="card-header py-75">
               <h4 class="card-title">
                   <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check font-medium-3 mr-1">
                  <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="8.5" cy="7" r="4"></circle>
                  <polyline points="17 11 19 13 23 9"></polyline>
                   </svg>
                    {{__('webCaption.vehicle_information.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">

              <div class="card-body py-75">
                    <div class="row">
                              <div class="col-md-5 mb-2"> 
                                         <div class="custom-control custom-control-primary custom-radio pl-0" >              
                                             <x-dash.form.inputs.radio for="used" tooltip="{{__('webCaption.used.caption')}}"  class="border border-danger mr-2" name="brand_new" label="{{__('webCaption.used.title')}}" placeholder="" value="used"  required=""  checked="{{ (isset($user->companySalesTeam->status) && $user->companySalesTeam->status == 'Yes') ? 'checked' : 'checked' }}" />&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;

                                             <x-dash.form.inputs.radio for="brand_new" tooltip="{{__('webCaption.brand_new.caption')}}"  class="border border-danger pl-2" name="brand_new" label="{{__('webCaption.brand_new.title')}}" placeholder="" value="brand_new"  required="required"  checked="{{ (isset($user->companySalesTeam->status) && $user->companySalesTeam->status == 'Yes') ? 'checked' : 'checked' }}" />&ensp;
                                        </div>
                                  </div>

                                    <div class="col-md-7 pb-1">

                                        <div class="custom-control custom-control-primary custom-radio pl-0" >              
                                        <x-dash.form.inputs.radio for="none" tooltip="{{__('webCaption.none.caption')}}"  class="border border-danger" name="none" label="{{__('webCaption.none.title')}}" placeholder="" value="used"  required=""  checked="{{ (isset($user->companySalesTeam->status) && $user->companySalesTeam->status == 'Yes') ? 'checked' : 'checked' }}" />
                                        &ensp;&ensp;&ensp;  
                                                                     

                                         <x-dash.form.inputs.radio for="accident" tooltip="{{__('webCaption.accident.caption')}}"  class="border border-danger" name="none" label="{{__('webCaption.accident.title')}}" placeholder="" value="accident"  required="required"  checked="{{ (isset($user->companySalesTeam->status) && $user->companySalesTeam->status == 'Yes') ? 'checked' : 'checked' }}" /> &ensp;&ensp;&ensp;

                                         <x-dash.form.inputs.radio for="damaged" tooltip="{{__('webCaption.damaged.caption')}}"  class="border border-danger " name="none"  label="{{__('webCaption.damaged.title')}}" placeholder="" value="damaged"  required="required"  checked="{{ (isset($user->companySalesTeam->status) && $user->companySalesTeam->status == 'Yes') ? 'checked' : 'checked' }}" />&ensp;&ensp;&ensp;                                          


                                         <x-dash.form.inputs.radio for="salvaged" tooltip="{{__('webCaption.salvaged.caption')}}"  class="border border-danger" name="none" label="{{__('webCaption.salvaged.title')}}" placeholder="" value="salvaged"  required="required"  checked="{{ (isset($user->companySalesTeam->status) && $user->companySalesTeam->status == 'Yes') ? 'checked' : 'checked' }}" />&ensp;
                                     </div>
                                  </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                      <x-dash.form.inputs.text  for="vehicle_title"  maxlength="100" tooltip="{{__('webCaption.vehicle_title.caption')}}" label="{{__('webCaption.vehicle_title.title')}}"  class="form-control" name="vehicle_title"  placeholder="{{__('webCaption.vehicle_title.title')}}" value="{{old('vehicle_title', isset($data->title)?$data->vehicle_title:'' )}}"  required="" />
                                      @if ($errors->has('title'))
                                      <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                      @endif
                                  </div>
                              </div>

                              <div class="col-md-4 col-6">
                                    <div class="form-group">
                                      <x-dash.form.inputs.text label="{{__('webCaption.chassis_bin_number.title')}}"  for="chassis" maxlength="30"  tooltip="{{__('webCaption.chassis_vin_number.caption')}}"   class="form-control" name="vehicle_title"  placeholder="{{__('webCaption.chassis_vin_number.title')}}" value="{{old('vehicle_title', isset($data->title)?$data->vehicle_title:'' )}}"  required="" />
                                      @if ($errors->has('title'))
                                      <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                      @endif
                                  </div>
                              </div>

                              <div class="col-md-4 col-6">
                                  <div class="form-group">
                                     <x-dash.form.inputs.select label="{{__('webCaption.vehicle_type.title')}}" 
                                      tooltip="{{__('webCaption.vehicle_type.caption')}}" for="vehicle_type" name="membership"
                                      placeholder="{{ __('locale.vehicle_type.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->vehicle_type != null)) ? $data->vehicle_type :'' }}"  required="required"  />
                                      @if($errors->has('membership'))
                                       <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_type') }}"  />
                                         @endif
                                  </div>
                              </div>  

                              <div class="col-md-4 col-6">
                                  <div class="form-group">
                                     <x-dash.form.inputs.select label="{{__('webCaption.sub_type.title')}}" 
                                      tooltip="{{__('webCaption.sub_type.caption')}}" for="sub_type" name="membership"
                                      placeholder="{{ __('locale.sub_type.caption') }}" customClass="sub_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->sub_type :'' }}"  required=""  />
                                      @if($errors->has('membership'))
                                       <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                         @endif
                                  </div>
                              </div> 

                              <div class="col-md-4 col-6">
                                    <div class="form-group">
                                      <x-dash.form.inputs.text label="{{__('webCaption.engine_cc.title')}}"  for="engine_cc" maxlength="10"  tooltip="{{__('webCaption.chassis_vin_number.caption')}}"   class="form-control" name="engine_cc"  placeholder="{{__('webCaption.engine_cc.title')}}" value="{{old('engine_cc', isset($data->title)?$data->engine_cc:'' )}}"  required="" />
                                      @if ($errors->has('title'))
                                      <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                      @endif
                                  </div>
                              </div>

                              <div class="col-md-4 col-6">
                                  <div class="form-group">
                                     <x-dash.form.inputs.select label="{{__('webCaption.maker.title')}}" 
                                      tooltip="{{__('webCaption.maker.caption')}}" for="make" name="membership"
                                      placeholder="{{ __('locale.maker.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->vehicle_type :'' }}"  required="required"  />
                                      @if($errors->has('membership'))
                                       <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                         @endif
                                  </div>
                              </div>
                              
                              
                              <div class="col-md-4 col-6">
                                  <div class="form-group">
                                     <x-dash.form.inputs.select label="{{__('webCaption.model.title')}}" 
                                      tooltip="{{__('webCaption.model.caption')}}" for="model" name="membership"
                                      placeholder="{{ __('locale.model.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->model :'' }}"  required="required"  />
                                      @if($errors->has('membership'))
                                       <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                         @endif
                                  </div>
                              </div> 


                              <div class="col-md-4">
                                  <div class="form-group">
                                     <x-dash.form.inputs.select label="{{__('webCaption.model_code.title')}}" 
                                      tooltip="{{__('webCaption.model_code.caption')}}" for="model_code" name="membership"
                                      placeholder="{{ __('locale.model_code.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->model_code :'' }}"  required=""  />
                                      @if($errors->has('membership'))
                                       <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                         @endif
                                  </div>
                              </div> 

                              
                              <div class="col-md-4 col-12">
                                     <div class="row">
                                                <div class="col-md-3 pr-0 col-3">
                                                    <div class="form-group">
                                                    <x-dash.form.inputs.text label="{{__('webCaption.length.title')}}"  for="length"  tooltip="{{__('webCaption.chassis_vin_number.caption')}}"   class="form-control" name="length"  placeholder="{{__('webCaption.length.title')}}" value="{{old('length', isset($data->title)?$data->length:'' )}}"  required="" />
                                                    @if ($errors->has('title'))
                                                    <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-3 pr-0 col-3">
                                                    <div class="form-group">
                                                    <x-dash.form.inputs.text label="{{__('webCaption.width.title')}}"  for="width"  tooltip="{{__('webCaption.width.caption')}}"   class="form-control" name="width"  placeholder="{{__('webCaption.width.title')}}" value="{{old('engine_cc', isset($data->title)?$data->width:'' )}}"  required="" />
                                                    @if ($errors->has('title'))
                                                    <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-3 pr-0 col-3">
                                                    <div class="form-group">
                                                    <x-dash.form.inputs.text label="{{__('webCaption.height.title')}}"  for="height"  tooltip="{{__('webCaption.height.caption')}}"   class="form-control" name="height"  placeholder="{{__('webCaption.height.title')}}" value="{{old('height', isset($data->title)?$data->height:'' )}}"  />
                                                    @if ($errors->has('title'))
                                                    <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-3">
                                                    <div class="form-group">
                                                    <x-dash.form.inputs.text label="{{__('webCaption.m3.title')}}"  for="m3"  tooltip="{{__('webCaption.m3.caption')}}"   class="form-control" name="m3"  placeholder="{{__('webCaption.m3.title')}}" value="{{old('m3', isset($data->title)?$data->m3:'' )}}"   />
                                                    @if ($errors->has('title'))
                                                    <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div> 
                                              <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.text label="{{__('webCaption.mileage.title')}}" maxlength="10"  for="mileage"  tooltip="{{__('webCaption.mileage.caption')}}"   class="form-control" name="mileage"  placeholder="{{__('webCaption.mileage.title')}}" value="{{old('m3', isset($data->title)?$data->mileage:'' )}}"   />
                                                        @if ($errors->has('title'))
                                                        <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                                         @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.text label="{{__('webCaption.engine_number.title')}}" maxlength="30"  for="engine_number"  tooltip="{{__('webCaption.engine_number.caption')}}"   class="form-control" name="engine_number"  placeholder="{{__('webCaption.engine_number.title')}}" value="{{old('engine_number', isset($data->title)?$data->doors:'' )}}"   />
                                                        @if ($errors->has('title'))
                                                        <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                                         @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.text label="{{__('webCaption.grade.title')}}" maxlength="50"  for="grade"  tooltip="{{__('webCaption.grade.caption')}}"   class="form-control" name="grade"  placeholder="{{__('webCaption.grade.title')}}" value="{{old('m3', isset($data->title)?$data->grade:'' )}}"   />
                                                        @if ($errors->has('title'))
                                                        <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                                         @endif
                                                    </div>
                                                </div>


                                        <div class="col-md-4 col-12">
                                           <div class="row">
                                                <div class="col-md-6 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.mfg_year.title')}}" 
                                                        tooltip="{{__('webCaption.mfg_year.caption')}}" for="mfg_year" name="mfg_year"
                                                         placeholder="{{ __('locale.mfg_year.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->mfg_year != null)) ? $data->mfg_year :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('mfg_year') }}"  />
                                                        @endif
                                                   </div>
                                              </div> 

                                              <div class="col-md-6 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.mfg_month.title')}}" 
                                                        tooltip="{{__('webCaption.mfg_month.caption')}}" for="mfg_month" name="mfg_month"
                                                         placeholder="{{ __('locale.mfg_month.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->mfg_month :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                                        @endif
                                                   </div>
                                              </div> 
                                         </div>
                                     </div>


                                     <div class="col-md-4 col-12">
                                           <div class="row">
                                                <div class="col-md-6 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.reg_year.title')}}" 
                                                        tooltip="{{__('webCaption.reg_year.caption')}}" for="reg_year" name="membership"
                                                         placeholder="{{ __('locale.mfg_year.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->reg_year :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                                        @endif
                                                   </div>
                                              </div> 

                                              <div class="col-md-6 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.reg_month.title')}}" 
                                                        tooltip="{{__('webCaption.reg_month.caption')}}" for="reg_month" name="membership"
                                                         placeholder="{{ __('locale.reg_month.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->mfg_month :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                                        @endif
                                                   </div>
                                              </div> 
                                         </div>
                                     </div>

                                             

                                                <div class="col-md-2 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.odometer.title')}}" 
                                                        tooltip="{{__('webCaption.odometer.caption')}}" for="odometer" name="membership"
                                                         placeholder="{{ __('locale.odometer.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->odometer :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                                        @endif
                                                   </div>
                                              </div>                                            


                                              <div class="col-md-2 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.transmission.title')}}" 
                                                        tooltip="{{__('webCaption.transmission.caption')}}" for="transmission" name="membership"
                                                         placeholder="{{ __('locale.transmission.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->transmission :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                                        @endif
                                                   </div>
                                              </div> 


                                              <div class="col-md-2 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.fuel.title')}}" 
                                                        tooltip="{{__('webCaption.fuel.caption')}}" for="fuel" name="membership"
                                                         placeholder="{{ __('locale.fuel.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->fuel :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                                        @endif
                                                   </div>
                                              </div>

                                              <div class="col-md-2 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.color.title')}}" 
                                                        tooltip="{{__('webCaption.color.caption')}}" for="color" name="color"
                                                         placeholder="{{ __('locale.color.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->fuel :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                                        @endif
                                                   </div>
                                              </div>
                                              
                                              <div class="col-md-2 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.steering.title')}}" 
                                                        tooltip="{{__('webCaption.steering.caption')}}" for="steering" name="steering"
                                                         placeholder="{{ __('locale.steering.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->steering :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                                        @endif
                                                   </div>
                                              </div>

                                                <div class="col-md-2 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.wheel_drive.title')}}" 
                                                        tooltip="{{__('webCaption.wheel_drive.caption')}}" for="wheel_drive" name="wheel_drive"
                                                         placeholder="{{ __('locale.wheel_drive.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->wheel_drive :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                                        @endif
                                                   </div>
                                              </div>

                                              <div class="col-md-2 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.text label="{{__('webCaption.doors.title')}}" maxlength="3"  for="doors"  tooltip="{{__('webCaption.doors.caption')}}"   class="form-control" name="mileage"  placeholder="{{__('webCaption.doors.title')}}" value="{{old('doors', isset($data->title)?$data->doors:'' )}}"   />
                                                        @if ($errors->has('title'))
                                                        <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                                         @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-2 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.text label="{{__('webCaption.seating.title')}}" maxlength="3"  for="seating"  tooltip="{{__('webCaption.seating.caption')}}"   class="form-control" name="seating"  placeholder="{{__('webCaption.seating.title')}}" value="{{old('seating', isset($data->title)?$data->seating:'' )}}"   />
                                                        @if ($errors->has('title'))
                                                        <x-dash.form.form_error_messages message="{{ $errors->first('vehicle_title') }}" />
                                                         @endif
                                                    </div>
                                                </div>


                                                <div class="col-md-2 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.interior_grade.title')}}" 
                                                        tooltip="{{__('webCaption.interior_grade.caption')}}" for="interior_grade" name="interior_grade"
                                                         placeholder="{{ __('locale.interior_grade.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->interior_grade :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                                        @endif
                                                   </div>
                                              </div>


                                              <div class="col-md-2 col-6">
                                                    <div class="form-group">
                                                       <x-dash.form.inputs.select label="{{__('webCaption.exterior_grade.title')}}" 
                                                        tooltip="{{__('webCaption.exterior_grade.caption')}}" for="exterior_grade" name="exterior_grade"
                                                         placeholder="{{ __('locale.exterior_grade.caption') }}" customClass="vehicle_type"  editSelected="{{(isset($data->membership) && ($data->membership != null)) ? $data->exterior_grade :'' }}"    />
                                                         @if($errors->has('membership'))
                                                         <x-dash.form.form_error_messages message="{{ $errors->first('membership') }}"  />
                                                        @endif
                                                   </div>
                                              </div>


                                              <div class="col-md-4 col-12">
                                                  <div class="row">
                                                     <div class="col-md-4 col-6">
                                                         <div class="form-group">
                                                             <x-dash.form.inputs.text label="{{__('webCaption.deck_l.title')}}"  for="deck_l"  tooltip="{{__('webCaption.deck_l.caption')}}"   class="form-control" name="deck_l"  placeholder="{{__('webCaption.deck_l.title')}}" value="{{old('m3', isset ($data->title)?$data->deck_l:'' )}}"   />
                                                             @if ($errors->has('title'))
                                                              <x-dash.form.form_error_messages message="{{    $errors->first('vehicle_title') }}" />
                                                               @endif
                                                          </div>
                                                       </div> 
                                                       <div class="col-md-4 col-6">
                                                         <div class="form-group">
                                                             <x-dash.form.inputs.text label="{{__('webCaption.deck_w.title')}}"  for="deck_w"  tooltip="{{__('webCaption.deck_w.caption')}}"   class="form-control" name="deck_w"  placeholder="{{__('webCaption.deck_w.title')}}" value="{{old('m3', isset ($data->title)?$data->deck_w:'' )}}"   />
                                                             @if ($errors->has('title'))
                                                              <x-dash.form.form_error_messages message="{{    $errors->first('vehicle_title') }}" />
                                                               @endif
                                                          </div>
                                                       </div> 
                                                       <div class="col-md-4">
                                                         <div class="form-group">
                                                             <x-dash.form.inputs.text label="{{__('webCaption.deck_h.title')}}"  for="deck_h"  tooltip="{{__('webCaption.deck_h.caption')}}"   class="form-control" name="deck_h"  placeholder="{{__('webCaption.deck_h.title')}}" value="{{old('m3', isset ($data->title)?$data->deck_h:'' )}}"   />
                                                             @if ($errors->has('title'))
                                                              <x-dash.form.form_error_messages message="{{    $errors->first('vehicle_title') }}" />
                                                               @endif
                                                          </div>
                                                       </div> 
                                                    </div>
                                              </div>


                                                      <div class="col-md-2 col-6">
                                                         <div class="form-group">
                                                             <x-dash.form.inputs.text label="{{__('webCaption. tire_size.title')}}" maxlength="10"  for="tire_size"  tooltip="{{__('webCaption.tire_size.caption')}}"   class="form-control" name="tire_size"  placeholder="{{__('webCaption.tire_size.title')}}" value="{{old('m3', isset ($data->title)?$data->tire_size:'' )}}"   />
                                                             @if ($errors->has('title'))
                                                              <x-dash.form.form_error_messages message="{{    $errors->first('vehicle_title') }}" />
                                                               @endif
                                                          </div>
                                                       </div> 



                                                       <div class="col-md-2 col-6">
                                                         <div class="form-group">
                                                             <x-dash.form.inputs.text label="{{__('webCaption. front_tire_condition.title')}}"  for="front_tire_condition"  tooltip="{{__('webCaption.front_tire_condition.caption')}}"   class="form-control" name="front_tire_condition"  placeholder="{{__('webCaption.front_tire_condition.title')}}" value="{{old('m3', isset ($data->title)?$data->front_tire_condition:'' )}}"   />
                                                             @if ($errors->has('title'))
                                                              <x-dash.form.form_error_messages message="{{    $errors->first('vehicle_title') }}" />
                                                               @endif
                                                          </div>
                                                       </div> 


                                                       <div class="col-md-2 col-6">
                                                         <div class="form-group">
                                                             <x-dash.form.inputs.text label="{{__('webCaption.rear_tire_condition.title')}}"  for="rear_tire_condition"  tooltip="{{__('webCaption.rear_tire_condition.caption')}}"   class="form-control" name="rear_tire_condition"  placeholder="{{__('webCaption.rear_tire_condition.title')}}" value="{{old('m3', isset ($data->title)?$data->rear_tire_condition:'' )}}"   />
                                                             @if ($errors->has('title'))
                                                              <x-dash.form.form_error_messages message="{{    $errors->first('vehicle_title') }}" />
                                                               @endif
                                                          </div>
                                                       </div> 

                                                       <div class="col-md-2 col-6">
                                                         <div class="form-group">
                                                             <x-dash.form.inputs.text label="{{__('webCaption. rear_tire_type.title')}}"  for="rear_tire_type"  tooltip="{{__('webCaption.rear_tire_type.caption')}}"   class="form-control" name="rear_tire_type"  placeholder="{{__('webCaption.rear_tire_type.title')}}" value="{{old('m3', isset ($data->title)?$data->rear_tire_type:'' )}}"   />
                                                             @if ($errors->has('title'))
                                                              <x-dash.form.form_error_messages message="{{    $errors->first('vehicle_title') }}" />
                                                               @endif
                                                          </div>
                                                       </div> 


                                                       <div class="col-md-4 col-6">
                                                         <div class="form-group mb-0">
                                                             <x-dash.form.inputs.text label="{{__('webCaption.hours.title')}}" maxlength="20"  for="hours"  tooltip="{{__('webCaption.hours.caption')}}"   class="form-control" name="hours"  placeholder="{{__('webCaption.hours.title')}}" value="{{old('m3', isset ($data->title)?$data->hours:'' )}}"   />
                                                             @if ($errors->has('title'))
                                                              <x-dash.form.form_error_messages message="{{    $errors->first('vehicle_title') }}" />
                                                               @endif
                                                          </div>
                                                       </div>


                                                       <div class="col-md-4 col-6">
                                                         <div class="form-group mb-0">
                                                             <x-dash.form.inputs.text label="{{__('webCaption.horse_power.title')}}"  for="horse_power"  tooltip="{{__('webCaption.horse_power.caption')}}"   class="form-control" name="horse_power"  placeholder="{{__('webCaption.horse_power.title')}}" value="{{old('m3', isset ($data->title)?$data->horse_power:'' )}}"   />
                                                             @if ($errors->has('title'))
                                                              <x-dash.form.form_error_messages message="{{    $errors->first('vehicle_title') }}" />
                                                               @endif
                                                          </div>
                                                       </div>  
                    </div>
              </div>
       </div>



       <div class="card card-primary">
           <div class="card-header py-75">
               <h4 class="card-title">
               <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings font-medium-3"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> {{__('webCaption.accessories_and_options.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">

              <div class="card-body py-75">
                    <div class="row">
                            <div class="col-md-12 mb-2">
                               <x-dash.form.inputs.checkbox for="comfort" tooltip="{{__('webCaption.comfort.caption')}}" labelClass="fw-bolder fs-5"   label="{{__('webCaption.comfort.title')}}" name="comfort"  placeholder="{{__('webCaption.comfort.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />
                          
                          
                               <div class="row pl-2 ">
                               @for($i=1; $i<=13; $i++)
                                  <div class="col-md-3 col-6">
                                      <x-dash.form.inputs.checkbox for="comfort" tooltip="{{__('webCaption.comfort.caption')}}"  label="{{__('webCaption.comfort.title')}}" name="comfort"  placeholder="{{__('webCaption.comfort.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />
                                  </div>

                               @endfor
                               </div>                         
                            </div>
                          
                            <div class="col-md-12 mb-2">
                               <x-dash.form.inputs.checkbox for="saftey" tooltip="{{__('webCaption.saftey.caption')}}" labelClass="fw-bolder fs-5"   label="{{__('webCaption.saftey.title')}}" name="saftey"  placeholder="{{__('webCaption.comfort.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />
                          
                          
                               <div class="row pl-2">
                               @for($i=1; $i<=13; $i++)
                                  <div class="col-md-3 col-6">
                                      <x-dash.form.inputs.checkbox for="saftey" tooltip="{{__('webCaption.comfort.caption')}}"  label="{{__('webCaption.comfort.title')}}" name="comfort"  placeholder="{{__('webCaption.comforttitle')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />
                                  </div>

                               @endfor
                               </div>                         
                            </div>

                            <div class="col-md-12 mb-2">
                               <x-dash.form.inputs.checkbox for="sound_system" tooltip="{{__('webCaption.sound_system.caption')}}" labelClass="fw-bolder fs-5"  label="{{__('webCaption.sound_system.title')}}" name="saftey"  placeholder="{{__('webCaption.sound_system.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />
                          
                          
                               <div class="row pl-2">
                               @for($i=1; $i<=13; $i++)
                                  <div class="col-md-3 col-6">
                                      <x-dash.form.inputs.checkbox for="sound_system" tooltip="{{__('webCaption.sound_system.caption')}}"    label="{{__('webCaption.sound_system.title')}}" name="sound_system"  placeholder="{{__('webCaption.sound_system.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />
                                  </div>

                               @endfor
                               </div>                         
                            </div>

                            <div class="col-md-12 mb-2">
                               <x-dash.form.inputs.checkbox for="windows" tooltip="{{__('webCaption.windows.caption')}}" labelClass="fw-bolder fs-5"  label="{{__('webCaption.windows.title')}}" name="seats"  placeholder="{{__('webCaption.windows.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />
                          
                          
                               <div class="row pl-2">
                               @for($i=1; $i<=13; $i++)
                                  <div class="col-md-3 col-6">
                                      <x-dash.form.inputs.checkbox for="windows" tooltip="{{__('webCaption.windows.caption')}}"  label="{{__('webCaption.windows.title')}}" name="windows"  placeholder="{{__('webCaption.windows.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->windows) && $user->companySalesTeam->windows == '1') ? 'checked' : ''}}" required="" />
                                  </div>

                               @endfor
                               </div>                         
                            </div>

                            <div class="col-md-12">
                               <x-dash.form.inputs.checkbox for="other_features" tooltip="{{__('webCaption.other_features.caption')}}"  labelClass="fw-bolder fs-5" label="{{__('webCaption.other_features.title')}}" name="saftey"  placeholder="{{__('webCaption.other_features.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />
                          
                          
                               <div class="row pl-2">
                               @for($i=1; $i<=13; $i++)
                                  <div class="col-md-3 col-6">
                                      <x-dash.form.inputs.checkbox for="other_features" tooltip="{{__('webCaption.other_features.caption')}}"  label="{{__('webCaption.other_features.title')}}" name="other_features"  placeholder="{{__('webCaption.other_features.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />
                                  </div>

                               @endfor
                               </div>                         
                            </div>
                     </div>
            </div>
      </div>



      <div class="card card-primary">
           <div class="card-header py-75">
               <h4 class="card-title">
               <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info font-medium-3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    {{__('webCaption.more_information.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">

            <div class="card-body py-75">
                 <div class="row">
                    
                            <div class="col-md-12 pb-25 ">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up font-medium-3 text-success"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                                <x-dash.form.label class="fw-bold fs-5" for="" value="{{__('webCaption.good_points.title')}}"  tooltip="{{__('webCaption.good_points.caption')}}" /></div>

                               @for($i=1; $i<=13; $i++)
                                  <div class="col-md-3 col-6 pl-2">
                                      <x-dash.form.inputs.checkbox for="good_points" tooltip="{{__('webCaption.good_points.caption')}}"  label="{{__('webCaption.good_points.title')}}" name="good_points"  placeholder="{{__('webCaption.good_points.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />
                                  </div>

                               @endfor


                               <div class="col-md-12 pb-25 pt-2 ">
                                
                               <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down font-medium-3 text-danger"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                               
                               <x-dash.form.label class="fw-bold fs-5" for="" value="{{__('webCaption.bad_points.title')}}"  tooltip="{{__('webCaption.bad_points.caption')}}" /></div>


                               @for($i=1; $i<=13; $i++)
                                  <div class="col-md-3 col-6 pl-2">
                                      <x-dash.form.inputs.checkbox for="bad_points" tooltip="{{__('webCaption.bad_points.caption')}}"  label="{{__('webCaption.bad_points.title')}}" name="other_features"  placeholder="{{__('webCaption.bad_points.title')}}" value="1" checked="{{ (isset($user->companySalesTeam->verification) && $user->companySalesTeam->verification == '1') ? 'checked' : ''}}" required="" />
                                  </div>

                               @endfor

                        </div>
                 </div>
        </div>


        <div class="card card-primary">
           <div class="card-header py-75">
               <h4 class="card-title">
                   <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info font-medium-3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    {{__('webCaption.other_information.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">
              
           <div class="card-body pt-75 pb-75">
               <div class="row">
                  
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                    <x-dash.form.inputs.textarea for="other_options" maxlength="2000" rows="8" tooltip="{{__('webCaption.other_options.caption')}}"  label="{{__('webCaption.other_options.title')}}" name="other_options"  placeholder="{{__('webCaption.other_options.title')}}" value="{{ old('other_options', isset($user->companySalesTeam->other_options) ? $user->companySalesTeam->other_options :'') }}" required="" />
                                    <small><x-dash.form.label for="" value="{{__('webCaption.other_options_detail.title')}}" class="" tooltip="{{__('webCaption.other_options_detail.caption')}}" /></small>
                                </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                    <x-dash.form.inputs.textarea for="remarks" maxlength="1000" rows="8" tooltip="{{__('webCaption.remarks.caption')}}"  label="{{__('webCaption.remarks.title')}}" name="remarks"  placeholder="{{__('webCaption.remarks.title')}}" value="{{ old('remarks', isset($user->companySalesTeam->remarks) ? $user->companySalesTeam->remarks :'') }}" required="" />
                                    <small><x-dash.form.label for="" value="{{__('webCaption.remarks_internal.title')}}" class="" tooltip="{{__('webCaption.remarks_internal.caption')}}" /></small>
                                </div>
                        </div>
                </div>
            </div>
        </div> 
        
        <div class="card card-primary">
           <div class="card-header py-75">
               <h4 class="card-title">
                 <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu font-medium-3"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                    {{__('webCaption.inspection_sheet_information.title')}}
                </h4>
            </div>

            <hr class="m-0 p-0">

            <div class="card-body py-75 ">
               <div class="row">
                      <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-sm " border="1" style="border:#ebe9f1 1px solid;">
                                  <thead>
                                    <tr>
                                        <th width="97%" class="text-left">Name</th>
                                        <th width="3%" class="text-center">Alias</th>
                                    </tr>
                                    </thead>
                                      <tbody>
                                          <tr>
                                             <td class="text-left">Scratch (fist size) <small></small></td>
                                             <td class="text-center" onmouseover="selectMyNode(this)">A1</td>
                                          </tr>
                                           <tr>
                                              <td class="text-left">Scratch (2palm size) <small></small></td>
                                              <td class="text-center" onmouseover="selectMyNode(this)">A2</td>
                                           </tr>
                                            <tr>
                                              <td class="text-left">Scratch (larger than A2) <small></small></td>
                                              <td class="text-center" onmouseover="selectMyNode(this)">A3</td>
                                            </tr>
                                            <tr>
                                               <td class="text-left">Corrosion (hole) <small></small></td>
                                               <td class="text-center" onmouseover="selectMyNode(this)">C2</td>
                                            </tr>
                                            <tr>
                                               <td class="text-left">Chap Repaired <small></small></td>
                                               <td class="text-center" onmouseover="selectMyNode(this)">R</td>
                                            </tr>
                                            <tr>
                                               <td class="text-left">Chap Repaired Needs Replacing <small></small></td>
                                               <td class="text-center" onmouseover="selectMyNode(this)">RX</td>
                                            </tr>
                                            <tr>
                                               <td class="text-left">Rust <small></small></td>
                                               <td class="text-center" onmouseover="selectMyNode(this)">S</td>
                                            </tr>
                                            <tr>
                                               <td class="text-left">Dent (thumb size) <small></small></td>
                                               <td class="text-center" onmouseover="selectMyNode(this)">U1</td>
                                            </tr>
                                            <tr>
                                               <td class="text-left">Dent (palm size) <small></small></td>
                                               <td class="text-center" onmouseover="selectMyNode(this)">U2</td>
                                            </tr>
                                            <tr>
                                               <td class="text-left">Dent (larger than U2) <small></small></td>
                                               <td class="text-center" onmouseover="selectMyNode(this)">U3</td> 
                                            </tr>
                                            <tr>
                                               <td class="text-left">Wavy Panel (fine) <small></small></td>
                                               <td class="text-center" onmouseover="selectMyNode(this)">W1</td>
                                            </tr>
                                            <tr>
                                               <td class="text-left">Wavy Panel <small></small></td>
                                               <td class="text-center" onmouseover="selectMyNode(this)">W2</td>
                                            </tr>
                                            <tr>
                                               <td class="text-left">Wavy Panel (conspicuous) <small></small></td>
                                               <td class="text-center" onmouseover="selectMyNode(this)">W3</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Needs Replacing <small></small></td>
                                                <td class="text-center" onmouseover="selectMyNode(this)">X</td>
                                            </tr>
                                            <tr>
                                                 <td class="text-left">Replaced <small></small></td>
                                                 <td class="text-center" onmouseover="selectMyNode(this)">XX</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Crack (thumb size) <small></small></td>
                                                <td class="text-center" onmouseover="selectMyNode(this)">Y1</td>
                                            </tr>
                                            <tr>
                                               <td class="text-left">Crack (palm size) <small></small></td>
                                               <td class="text-center" onmouseover="selectMyNode(this)">Y2</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Crack (larger than Y2) <small></small></td>
                                                <td class="text-center" onmouseover="selectMyNode(this)">Y3</td>
                                            </tr>
                                     </tbody>
                                 </table>
                             </div>
                     </div>

                     <div class="col-md-6">

                          <img src="{{asset('assets/dash/assets/images/image/inspection-sheet-img.jpg')}}"  alt="rating" class="img-fluid mx-auto d-block mb-2" required="" />
                           
                           <p class="mb-0"><strong class="fs-6"><x-dash.form.label for="" value="{{__('webCaption.instruction_to_use.title')}}" class=""  /></strong></p>
                           <p><x-dash.form.label for="" value="{{__('webCaption.mark_steps.title')}}" class=""  /></p>
                          <ol>
                              <li class="pb-1"><x-dash.form.label for="" value="{{__('webCaption.bring_mouse.title')}}" class=""  /></li>
                              <li class="pb-1"><x-dash.form.label for="" value="{{__('webCaption.now_drag.title')}}" class=""  /></li>
                              <li> <x-dash.form.label for="" value="{{__('webCaption.mark_delete.title')}}" class=""  /></li>
                          </ol>
                     </div>
 
               </div>
            </div>
       </div> 





       <div class="card card-primary">
           <div class="card-header py-75">
              <h4 class="card-title">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video font-medium-3"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                    {{__('webCaption.video_gallery.title')}}
                </h4>
            </div>
             
            <hr class="m-0 p-0">
            <div class="card-body py-75">
                <div class="row">
                     <div class="col-md-12">
                           <div class="form-group mb-0">
                               <x-admin.form.inputs.text_with_icon id="" for="youtube" tooltip="{{__('webCaption.youtube.caption')}}" label="{{__('webCaption.youtube.title')}}" maxlength="100" class="form-control" name="youtube" iconColorClass="text-danger"  iconClass="fab fa-youtube" placeholder="{{__('webCaption.youtube.title')}}" value="{{old('youtube', isset($data->youtube)?$data->youtube:'' )}}"  required="" />
                           </div>
                     </div> 
                </div>
            </div>        
       </div>     

             <div class="row mb-2 text-center">
                  <div class="col-12">
                        <div class="form-group text-center">
			               <input type="hidden" name="id" value="@if(isset($user->id) && !empty($user->id)){{$user->id}}@endif" />
		             	   @if(isset($user->id)) <x-dash.form.buttons.update /> @else <x-dash.form.buttons.create/> @endif                            
		              </div>
                   </div>
             </div>

 </form>

</div>      

@endsection