@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.allocation.title') )
@else
@section('title', __('webCaption.allocation.title'))
@endif
@section('content')
<div>
      <div class="row">
          <div class="col-md-7" style="padding-right:5px;">
                <div class="card card-primary">
                    <div class="card-header py-25">
                          <div class="row w-100">
                              <div class="col-md-8 pt-50">
                                    <h4 class="card-title">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-user-check font-medium-3 mr-25">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="8.5" cy="7" r="4"></circle>
                                        <polyline points="17 11 19 13 23 9"></polyline>
                                       </svg>
                                        {{__('webCaption.invoices.title')}}
                                  </h4>
                              </div>
                                
                              <div class="col-md-4">
                                  <div class="form-group mb-0">
                                      <x-dash.form.inputs.select  
                                       tooltip="{{__('webCaption.stock_type.caption')}}" for="" name="stock_type"
                                       placeholder="{{ __('locale.country.caption') }}" customClass="status"  editSelected="{{(isset($data->status) && ($data->status != null)) ? $data->status :'' }}"  required=""  />
                                      @if($errors->has('status'))
                                      <x-admin.form.form_error_messages message="{{ $errors->first('status') }}"  />  @endif
                                   </div>                              
                              </div>
                          </div>   

                        
                    </div>
                    <hr class="m-0 p-0">
                    <div class="card-body pl-25 pr-25 py-25">
                        <div class="main_table">
                            <div class="table_header">
                               <div class="header_col width_1 padding">Date</div>
                               <div class="header_col width_5 padding">Order ID</div>
                               <div class="header_col width_2 padding">Cust.</div>
                               <div class="header_col width_1 padding">Terms</div>
                               <div class="header_col width_2 padding">Inv. Amount</div>
                               <div class="header_col width_2 padding">Allocated</div>
                               <div class="header_col width_2 padding">Bal. Due</div>
                               <div class="header_col width_1 padding">Paid %</div>
                               <div class="header_col width_2 padding">Allocate</div>
                            </div>

                            <div class="table_row">
                               <div class="make_col width_1 pad_col">2023-03-24</div>
                               <div class="make_col width_5 pad_col">11343 HARRIER | MXUA80-0052517</div>
                               <div class="make_col width_2 pad_col">PMSK SDN BHD</div>
                               <div class="make_col width_1 pad_col">CIF</div>
                               <div class="make_col width_2 pad_col">4,070,000</div>
                               <div class="make_col width_1 pad_col">0</div>
                               <div class="make_col width_2 pad_col">4,070,000</div>
                               <div class="make_col width_1 pad_col">0 %</div>
                               <div class="make_col width_2 pad_col">
                                <div class="form-group mb-0">
                                    <x-dash.form.inputs.text  for="allocate" tooltip="{{__('webCaption.purchase_price.caption')}}" name="allocate"  placeholder="{{__('webCaption.allocate.title')}}" value="{{old('allocate', isset($data->title)?  $data->purchase_price:'' )}}"  required="" />
                                    @if ($errors->has('title'))
                                    <x-dash.form.form_error_messages message="{{ $errors->first('short_name') }}" />@endif
                                 </div>
                             </div>
                            </div>
                        </div>                        
                    </div>
               </div>
           </div>



           <div class="col-md-5 " style="padding-left:5px;">
                <div class="card card-primary">
                    <div class="card-header py-50">
                              <div class="row">
                                     <div class="col-md-4"> 
                                            <div class="form-group text-center mb-0 pt-25">
                                               <x-dash.form.buttons.custom color="btn btn-sm btn-danger " id="allocation" value="Allocation"  iconClass=""/>                 
                                           </div>
                                       </div>
                                   <div class="col-md-8">
                                        <h4 class="card-title">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-user-check font-medium-3 mr-25">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <polyline points="17 11 19 13 23 9"></polyline>
                                           </svg>
                                          {{__('webCaption.deposited_payment.title')}}
                                      </h4>  
                                   </div>
                               </div>                       
                         </div>
                          <hr class="m-0 p-0">
                           <div class="card-body px-25 py-25">
   
                               <div class="main_table">
                                    <div class="table_header">
                                        <div class="header_col  padding">Ref No.</div>
                                        <!-- <div class="header_col padding">TT Ref No.</div> -->
                                        <div class="header_col  padding">Date</div>
                                        <div class="header_col  padding">Amount</div>
                                        <div class="header_col  padding">Allocated</div>
                                        <div class="header_col  padding">Available</div>
                                        <div class="header_col  padding">Remark</div>
                                       
                                    </div>

                                    <div class="table_row">
                                        <div class="make_col  pad_col">TT-12609</div>
                                        <!-- <div class="make_col " style="text-align:left;">JPY 4,610,500 SAFA <br>GLOBAL HOLDING SDN BHD/INV/3304165970/MY/<br>1264 JLN PERUSAHAAN<br> PERAI/13600</div> -->
                                        <div class="make_col  pad_col">2023-05-08</div>
                                        <div class="make_col  pad_col">4,610,500</div>
                                        <div class="make_col  pad_col">4,610,500</div>
                                        <div class="make_col  pad_col">0</div>
                                        <div class="make_col  pad_col">-</div>
                                       
                                    </div>
                                </div>

                             </div>                        
                    </div>
               </div>
           </div>          



        </div>



   </div>
 

    <form action="{{route('dashaccounts.payments.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        
</div>



</form>
</div>
@endsection