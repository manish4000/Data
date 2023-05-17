@extends('dash/layouts/LayoutMaster')
@if(isset($data->id) && !empty($data->id))
@section('title', __('webCaption.allocation.title') )
@else
@section('title', __('webCaption.allocation.title'))
@endif
@section('content')
<div>
      <div class="row">
          <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header py-75">
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
                    <hr class="m-0 p-0">
                    <div class="card-body">
                        <div class="main_table">
                            <div class="table_header">
                               <div class="header_col">Date</div>
                               <div class="header_col">Order ID</div>
                               <div class="header_col">Cust.</div>
                               <div class="header_col">Terms</div>
                               <div class="header_col">Inv. Amount</div>
                               <div class="header_col">Allocated</div>
                               <div class="header_col">Bal. Due</div>
                               <div class="header_col">Paid %</div>
                               <div class="header_col">Allocate</div>
                            </div>



                        </div>




                        
                    </div>
               </div>
           </div>



           <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header py-75">
                              <div class="row">
                                     <div class="col-md-4"> 
                                            <div class="form-group text-center">
                                               <x-dash.form.buttons.custom color="btn btn-sm btn-danger " id="" value="Allocation"  iconClass=""/>                 
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
                        <div class="card-body">
                        
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