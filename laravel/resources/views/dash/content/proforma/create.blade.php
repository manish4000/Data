@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.proforma.title') )
@else
@section('title', __('webCaption.proforma.title'))
@endif
@section('content')
<div>
    <form action="{{route('dashmembers.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

     
       <div class="card card-primary">
                  
    
                <div class="card-body">
                    <div class="row">
                         <div class="col-md-6">
                              <div> <img src="{{asset('assets/dash/assets/images/image/logo_cp.jpg')}}"  alt="rating" class="img-fluid mb-2" required="" /></div> 
                           
                             

                                   <div class="row">                                  
                                     <div class="col-12 mb-1">
                                         <div class="row">
                                           <div class="col-md-4"><x-dash.form.label for="" value="{{__('webCaption.buyer_information.title')}}" class="" tooltip="{{__('webCaption.buyer_information.caption')}}" /></div>

                                           <div class="col-md-8 text-end"> 
                                              <x-dash.form.buttons.custom color="btn-primary" id="add_btn_{{isset($id) ? $id : ''}}" value="ADD" onClick="addNewInput('{{isset($id) ? $id : ''}}','{{isset($name) ? $name : ''}}')" />
                                           </div>
                                       </div>
                                    </div>


                                   <div class="col-12">
                                      <div class="form-group mb-1">
                                        <x-dash.form.inputs.text  for="company_1"  tooltip="{{__('webCaption.company_1.caption')}}"  class="form-control" name="company_1"  placeholder="{{__('webCaption.company_1.title')}}" value="{{old('company_1', isset($data->title)?  $data->company_1:'' )}}"  required="" />
                                        @if ($errors->has('title'))
                                         <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                        @endif
                                      </div>  
                                   </div>

                                   <div class="col-12">
                                     <div class="row">
                                          <div class="col-md-3">
                                          <x-dash.form.inputs.name_prefix for="title" tooltip="{{__('webCaption.title.caption')}}"  name="title"  placeholder="{{__('webCaption.title.title')}}" editSelected="{{ old('title', isset($user->companySalesTeam->title) ? $user->companySalesTeam->title :'') }}" required="required" />

                                          </div>
                                         <div class="col-md-9">
                                            <div class="form-group mb-1">
                                             <x-dash.form.inputs.text  for="consignee_name"  tooltip="{{__('webCaption.consignee_name.caption')}}"  class="form-control" name="consignee_name"  placeholder="{{__('webCaption.consignee_name.title')}}" value="{{old('consignee_name', isset($data->title)?  $data->consignee_name:'' )}}"  required="" />
                                              @if ($errors->has('title'))
                                             <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                             @endif
                                         </div>  
                                        </div>
                                     </div>
                                   </div>

                                   <div class="col-12">
                                      <div class="form-group mb-1">
                                        <x-dash.form.inputs.text  for="street_address"  tooltip="{{__('webCaption.street_address.caption')}}"  class="form-control" name="street_address"  placeholder="{{__('webCaption.street_address.title')}}" value="{{old('street_address', isset($data->title)?  $data->lot_number:'' )}}"  required="" />
                                        @if ($errors->has('title'))
                                         <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                        @endif
                                      </div>  
                                   </div>
                                   <div class="col-12">
                                      <div class="form-group mb-1">
                                        <x-dash.form.inputs.text  for="city_1"  tooltip="{{__('webCaption.city_1.caption')}}"  class="form-control" name="city_1"  placeholder="{{__('webCaption.city_1.title')}}" value="{{old('country', isset($data->title)? $data->city_1:'' )}}"  required="" />
                                        @if ($errors->has('title'))
                                         <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                        @endif
                                      </div>  
                                   </div>

                                   <div class="col-12">
                                      <div class="form-group mb-1">
                                        <x-dash.form.inputs.select  for="country_6"  tooltip="{{__('webCaption.country_6.caption')}}"  class="form-control" name="country_6"  placeholder="{{__('webCaption.country_6.title')}}" value="{{old('country_6', isset($data->title)? $data->country_6:'' )}}"  required="" />
                                        @if ($errors->has('title'))
                                         <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                        @endif
                                      </div>  
                                   </div>

                                   <div class="col-12">
                                      <div class="form-group mb-1">
                                        <x-dash.form.inputs.text  for="email"  tooltip="{{__('webCaption.email.caption')}}"  class="form-control" name="email"  placeholder="{{__('webCaption.email.title')}}" value="{{old('email', isset($data->title)? $data->email:'' )}}"  required="" />
                                        @if ($errors->has('title'))
                                         <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                        @endif
                                      </div>  
                                   </div>  

                                </div>

                               

                               <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group mb-1">
                                      <x-dash.form.inputs.text  for="tele_1"  tooltip="{{__('webCaption.tele_1.caption')}}"  class="form-control" name="tele_1"  placeholder="{{__('webCaption.tele_1.title')}}" value="{{old('tele_1', isset($data->title)?  $data->tele_1:'' )}}"  required="" />
                                      @if ($errors->has('title'))
                                      <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                      @endif
                                    </div>
                                 </div>

                                 <div class="col-md-6">
                                    <div class="form-group mb-1">
                                      <x-dash.form.inputs.text  for="tele_2"  tooltip="{{__('webCaption.tele_2.caption')}}"  class="form-control" name="tele_2"  placeholder="{{__('webCaption.tele_2.title')}}" value="{{old('tele_2', isset($data->title)?  $data->tele_2:'' )}}"  required="" />
                                      @if ($errors->has('title'))
                                      <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                      @endif
                                    </div>
                                 </div>
                               </div>
                            </div>


                         <div class="col-md-6">
                           <div class="row justify-content-end mb-3">
                               <div class="col-md-4"><x-dash.form.label for="" value="{{__('webCaption.proforma_no.title')}}" class="" tooltip="{{__('webCaption.proforma_no.caption')}}" /></div>

                                <div class="col-md-4 ">
                                   <div class="form-group mb-1">
                                      <x-dash.form.inputs.text  for="tele_2"  tooltip="{{__('webCaption.tele_2.caption')}}"  class="form-control" name="tele_2"  placeholder="{{__('webCaption.tele_2.title')}}" value="{{old('tele_2', isset($data->title)?  $data->tele_2:'' )}}"  required="" />
                                      @if ($errors->has('title'))
                                      <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                      @endif
                                   </div>
                               </div>

                               <div class="col-md-4">
                                        <div class="form-group mb-0">
                                           <x-dash.form.inputs.date  for="purchase_date"  tooltip="{{__('webCaption.purchase_date.caption')}}"  name="purchase_date"  placeholder="{{__('webCaption.purchase_date.title')}}" value="{{old('purchase_date', isset($data->purchase_date)?$data->purchase_date:'' )}}"  required="" />
                                      </div>
                               </div> 
                           </div>  


                              

                              <div class="row">
                                    <div class="col-md-4"><x-dash.form.label for="" value="{{__('webCaption.shipper_information.title')}}" class="" tooltip="{{__('webCaption.shipper_information.caption')}}" /></div>
                                    <div class="col-md-8">
                                      <div class="form-group mb-1">
                                       <x-dash.form.inputs.text  for="company_name"  tooltip="{{__('webCaption.company_name.caption')}}"  class="form-control" name="company_name"  placeholder="{{__('webCaption.company_name.title')}}" value="{{old('company_name', isset($data->title)?  $data->company_name:'' )}}"  required="" />
                                       @if ($errors->has('title'))
                                       <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                       @endif
                                     </div>
                                   </div>
                               </div>
                               <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                      <div class="form-group mb-1">
                                       <x-dash.form.inputs.text  for="address_3"  tooltip="{{__('webCaption.address_3.caption')}}"  class="form-control" name="address_3"  placeholder="{{__('webCaption.address_3.title')}}" value="{{old('address_3', isset($data->title)?  $data->address_3:'' )}}"  required="" />
                                       @if ($errors->has('title'))
                                       <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                       @endif
                                     </div>
                                   </div>
                               </div>

                               <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                       <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <x-dash.form.inputs.text  for="address_4"  tooltip="{{__('webCaption.address_4.caption')}}"  class="form-control" name="address_4"  placeholder="{{__('webCaption.address_4.title')}}" value="{{old('address_4', isset($data->title)?  $data->address_4:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                          </div> 
                                          
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <x-dash.form.inputs.text  for="city"  tooltip="{{__('webCaption.city.caption')}}"  class="form-control" name="city"  placeholder="{{__('webCaption.city.title')}}" value="{{old('city', isset($data->title)?  $data->city:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                          </div>  
                                        </div> 
                                     </div>
                                 </div>


                                 <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                       <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <x-dash.form.inputs.text  for="state"  tooltip="{{__('webCaption.state.caption')}}"  class="form-control" name="address_4"  placeholder="{{__('webCaption.state.title')}}" value="{{old('state', isset($data->title)?  $data->state:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                          </div> 
                                          
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <x-dash.form.inputs.select  for="country_new"  tooltip="{{__('webCaption.country_new.caption')}}"  class="form-control" name="country_new"  placeholder="{{__('webCaption.country_new.title')}}" value="{{old('country_new', isset($data->title)?  $data->country_new:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                          </div>  
                                        </div> 
                                     </div>
                                 </div>


                                 <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                       <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <x-dash.form.inputs.text  for="zip_code"  tooltip="{{__('webCaption.zip_code.caption')}}"  class="form-control" name="zip_code"  placeholder="{{__('webCaption.zip_code.title')}}" value="{{old('zip_code', isset($data->title)?  $data->zip_code:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                          </div> 
                                          
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <x-dash.form.inputs.text  for="telephone_no"  tooltip="{{__('webCaption.telephone_no.caption')}}"  class="form-control" name="telephone_no"  placeholder="{{__('webCaption.telephone_no.title')}}" value="{{old('telephone_no', isset($data->title)?  $data->telephone_no:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                          </div>  
                                        </div> 
                                     </div>
                                 </div>


                                 <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                       <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <x-dash.form.inputs.text  for="fax"  tooltip="{{__('webCaption.fax.caption')}}"  class="form-control" name="fax"  placeholder="{{__('webCaption.fax.title')}}" value="{{old('fax', isset($data->title)?  $data->fax:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                          </div> 
                                          
                                          <div class="col-md-6"></div>  
                                        </div> 
                                     </div>
                                 </div>


                                 <div class="row">
                                    <div class="col-md-4">
                                      <x-dash.form.label for="from" value="{{__('webCaption.from.title')}}" class="" tooltip="{{__('webCaption.from.caption')}}" /></div>
                                    <div class="col-md-8">
                                       <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <x-dash.form.inputs.select  for="country_1"  tooltip="{{__('webCaption.country_1.caption')}}"  class="form-control" name="country_1"  placeholder="{{__('webCaption.country_1.title')}}" value="{{old('country_1', isset($data->title)?  $data->country_1:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                          </div> 
                                          
                                          <div class="col-md-5">
                                             <div class="form-group">
                                               <x-dash.form.inputs.select  for="port_1"  tooltip="{{__('webCaption.port_1.caption')}}"  class="form-control" name="fax"  placeholder="{{__('webCaption.port_1.title')}}" value="{{old('fax', isset($data->title)?  $data->port_1:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                           </div> 

                                           <div class="col-md-1">+</div>
                                                                                      
                                        </div> 
                                     </div>
                                 </div>


                                 <div class="row">
                                    <div class="col-md-4">
                                      <x-dash.form.label for="" value="{{__('webCaption.to.title')}}" class="" tooltip="{{__('webCaption.to.caption')}}" /></div>
                                    <div class="col-md-8">
                                       <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <x-dash.form.inputs.select  for="country_3"  tooltip="{{__('webCaption.country_3.caption')}}"  class="form-control" name="country_3"  placeholder="{{__('webCaption.country_3.title')}}" value="{{old('country_3', isset($data->title)?  $data->country_3:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                          </div> 
                                          
                                          <div class="col-md-5">
                                             <div class="form-group">
                                               <x-dash.form.inputs.select  for="port_2"  tooltip="{{__('webCaption.port_2.caption')}}"  class="form-control" name="fax"  placeholder="{{__('webCaption.port_2.title')}}" value="{{old('fax', isset($data->title)?  $data->port_2:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                           </div> 

                                           <div class="col-md-1">+</div>
                                                                                      
                                        </div> 
                                     </div>
                                 </div>


                                 <div class="row">
                                    <div class="col-md-4">
                                      <x-dash.form.label for="" value="{{__('webCaption.payment_due.title')}}" class="" tooltip="{{__('webCaption.payment_due.caption')}}" /></div>
                                    <div class="col-md-8">
                                       <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <x-dash.form.inputs.text  for="payment_due"  tooltip="{{__('webCaption.payment_due.caption')}}"  class="form-control" name="payment_due"  placeholder="{{__('webCaption.payment_due.title')}}" value="{{old('payment_due', isset($data->title)?  $data->payment_due:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                          </div> 

                                            <div class="col-md-6">
                                             <div class="form-group">
                                               <x-dash.form.inputs.text  for="payment_terms"  tooltip="{{__('webCaption.payment_terms.caption')}}"  class="form-control" name="payment_terms"  placeholder="{{__('webCaption.payment_terms.title')}}" value="{{old('payment_terms', isset($data->title)?  $data->payment_terms:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                             </div>
                                           </div>                                            
                                                                                      
                                        </div> 
                                     </div>
                                 </div>                       
                             </div>                  
                        </div>

                         <div class="row bg-light pb-3 pt-2">
                               <div class="col-md-6"> <x-dash.form.buttons.custom color="btn-primary" id="add_btn_{{isset($id) ? $id : ''}}" value="Reset" onClick="addNewInput('{{isset($id) ? $id : ''}}','{{isset($name) ? $name : ''}}')" /></div>
                                <div class="col-md-6 text-end pr-0">
                              <x-dash.form.buttons.custom color="btn-primary" id="add_btn_{{isset($id) ? $id : ''}}" value="Stock" onClick="addNewInput('{{isset($id) ? $id : ''}}','{{isset($name) ? $name : ''}}')" /></div>
                          </div>


                          <div class="row bg-light">
                               <div class="col-md-4">
                                  <div class="form-group">
                                      <x-dash.form.inputs.file id="" caption="{{__('webCaption.upload_image.title')}}" ImageId="user-image-preview" for="image" name="image" editImageUrl="{{ isset($user->companySalesTeam->image)? asset('dash/sales_team/'.$user->companySalesTeam->image) :''}}" maxFileSize="5000" placeholder="{{__('webCaption.upload_image.title')}}" required="" />
                                      @if($errors->has('upload_image'))
                                      <x-dash.form.form_error_messages message="{{ $errors->first('upload_image') }}"  />
                                      @endif
                                    </div>
                               </div>

                               <div class="col-md-8">
                                 <div class="row">
                                    <div class="col-md-3"><x-dash.form.label for="" value="{{__('webCaption.make.title')}}" class="" tooltip="{{__('webCaption.make.caption')}}" /></div>
                                         <div class="col-md-5">
                                             <div class="form-group">
                                               <x-dash.form.inputs.select  for="make_new"  tooltip="{{__('webCaption.make_new.caption')}}"  class="form-control" name="make_new"  placeholder="{{__('webCaption.make_new.title')}}" value="{{old('make_new', isset($data->title)?  $data->make_new:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                            </div>
                                         </div>
                                         <div class="col-md-4">
                                             <div class="form-group">
                                               <x-dash.form.inputs.text  for="enter_new"  tooltip="{{__('webCaption.enter_new.caption')}}"  class="form-control" name="enter_new"  placeholder="{{__('webCaption.enter_new.title')}}" value="{{old('enter_new', isset($data->title)?  $data->enter_new:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                            </div>
                                         </div>
                                 </div>


                                 <div class="row">
                                    <div class="col-md-3"><x-dash.form.label for="" value="{{__('webCaption.model.title')}}" class="" tooltip="{{__('webCaption.model.caption')}}" /></div>
                                         <div class="col-md-5">
                                             <div class="form-group">
                                               <x-dash.form.inputs.select  for="model"  tooltip="{{__('webCaption.model.caption')}}"  class="form-control" name="model"  placeholder="{{__('webCaption.model.title')}}" value="{{old('model', isset($data->title)?  $data->model:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                            </div>
                                         </div>
                                         <div class="col-md-4">
                                             <div class="form-group">
                                               <x-dash.form.inputs.text  for="enter_new_1"  tooltip="{{__('webCaption.enter_new_1.caption')}}"  class="form-control" name="enter_new_1"  placeholder="{{__('webCaption.enter_new_1.title')}}" value="{{old('enter_new_1', isset($data->title)?  $data->enter_new_1:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                            </div>
                                         </div>
                                  </div>


                                  <div class="row">
                                    <div class="col-md-3"><x-dash.form.label for="" value="{{__('webCaption.model_code.title')}}" class="" tooltip="{{__('webCaption.model_code.caption')}}" /></div>
                                         <div class="col-md-5">
                                             <div class="form-group">
                                               <x-dash.form.inputs.text  for="model_code"  tooltip="{{__('webCaption.model_code.caption')}}"  class="form-control" name="model_code"  placeholder="{{__('webCaption.model_code.title')}}" value="{{old('model_code', isset($data->title)?  $data->model:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                            </div>
                                         </div>                                         
                                  </div>


                                  <div class="row">
                                    <div class="col-md-3"><x-dash.form.label for="" value="{{__('webCaption.chassis_no.title')}}" class="" tooltip="{{__('webCaption.chassis_no.caption')}}" /></div>
                                         <div class="col-md-5">
                                             <div class="form-group">
                                               <x-dash.form.inputs.text  for="chassis_no"  tooltip="{{__('webCaption.chassis_no.caption')}}"  class="form-control" name="chassis_no"  placeholder="{{__('webCaption.chassis_no.title')}}" value="{{old('chassis_no', isset($data->title)?  $data->chassis_no:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                            </div>
                                         </div>                                         
                                  </div>


                                  <div class="row">
                                    <div class="col-md-3"><x-dash.form.label for="" value="{{__('webCaption.grade.title')}}" class="" tooltip="{{__('webCaption.grade.caption')}}" /></div>
                                         <div class="col-md-5">
                                             <div class="form-group">
                                               <x-dash.form.inputs.text  for="grade"  tooltip="{{__('webCaption.grade.caption')}}"  class="form-control" name="grade"  placeholder="{{__('webCaption.grade.title')}}" value="{{old('chassis_no', isset($data->title)?  $data->grade:'' )}}"  required="" />
                                               @if ($errors->has('title'))
                                                <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                               @endif
                                            </div>
                                         </div>                                         
                                  </div>


                                  <div class="row">
                                    <div class="col-md-3"><x-dash.form.label for="" value="{{__('webCaption.mfg_year.title')}}" class="" tooltip="{{__('webCaption.mfg_year.caption')}}" /></div>
                                         <div class="col-md-5">
                                           <div class="row">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                   <x-dash.form.inputs.select  for="year"  tooltip="{{__('webCaption.year.caption')}}"  class="form-control" name="year"  placeholder="{{__('webCaption.year.title')}}" value="{{old('year', isset($data->title)?  $data->grade:'' )}}"  required="" />
                                                   @if ($errors->has('title'))
                                                   <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                                   @endif
                                                 </div>
                                              </div>

                                              <div class="col-md-6">
                                                <div class="form-group">
                                                   <x-dash.form.inputs.select  for="month"  tooltip="{{__('webCaption.month.caption')}}"  class="form-control" name="month"  placeholder="{{__('webCaption.month.title')}}" value="{{old('month', isset($data->title)?  $data->month:'' )}}"  required="" />
                                                   @if ($errors->has('title'))
                                                   <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                                   @endif
                                                 </div>
                                              </div>
                                           </div>                                            
                                         </div>                                         
                                  </div>


                                  <div class="row">
                                    <div class="col-md-3"><x-dash.form.label for="" value="{{__('webCaption.reg_year_Month.title')}}" class="" tooltip="{{__('webCaption.reg_year_Month.caption')}}" /></div>
                                         <div class="col-md-5">
                                           <div class="row">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                   <x-dash.form.inputs.select  for="reg_year"  tooltip="{{__('webCaption.reg_year.caption')}}"  class="form-control" name="reg_year"  placeholder="{{__('webCaption.reg_year.title')}}" value="{{old('reg_year', isset($data->title)?  $data->reg_year:'' )}}"  required="" />
                                                   @if ($errors->has('title'))
                                                   <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                                   @endif
                                                 </div>
                                              </div>

                                              <div class="col-md-6">
                                                <div class="form-group">
                                                   <x-dash.form.inputs.select  for="reg_month"  tooltip="{{__('webCaption.reg_month.caption')}}"  class="form-control" name="reg_month"  placeholder="{{__('webCaption.reg_month.title')}}" value="{{old('reg_month', isset($data->title)?  $data->reg_month:'' )}}"  required="" />
                                                   @if ($errors->has('title'))
                                                   <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                                   @endif
                                                 </div>
                                              </div>
                                           </div>                                            
                                         </div>                                         
                                  </div>


                                  <div class="row">
                                    <div class="col-md-3"><x-dash.form.label for="" value="{{__('webCaption.reg_year_Month.title')}}" class="" tooltip="{{__('webCaption.reg_year_Month.caption')}}" /></div>
                                             <div class="col-md-5">
                                                 <div class="form-group">
                                                   <x-dash.form.inputs.select  for="reg_year"  tooltip="{{__('webCaption.reg_year.caption')}}"  class="form-control" name="reg_year"  placeholder="{{__('webCaption.reg_year.title')}}" value="{{old('reg_year', isset($data->title)?  $data->reg_year:'' )}}"  required="" />
                                                   @if ($errors->has('title'))
                                                   <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                                   @endif
                                                 </div>
                                              </div>

                                              <div class="col-md-6">
                                                <div class="form-group">
                                                   <x-dash.form.inputs.select  for="reg_month"  tooltip="{{__('webCaption.reg_month.caption')}}"  class="form-control" name="reg_month"  placeholder="{{__('webCaption.reg_month.title')}}" value="{{old('reg_month', isset($data->title)?  $data->reg_month:'' )}}"  required="" />
                                                   @if ($errors->has('title'))
                                                   <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />
                                                   @endif
                                                 </div>
                                            
                                           </div>                                            
                                         </div>                                         
                                  </div>









                               </div>

                          </div>




                </div>
      </div>




      

    </form>
</div>
@endsection