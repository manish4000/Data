@extends('layouts/contentLayoutMaster')
@section('title', $pageConfigs['moduleName'])

@section('content')
<!-- users list start -->
<section>
  <div class="row">
    <div class="col-12">
            <!-- filter  -->
      <div class="card">
        <div class="card-header">
          <h4 class="card-title" data-toggle="tooltip" data-placement="right" title="{{__('webCaption.search_filter.caption')}}">{{__('webCaption.search_filter.title')}}</h4>                    
        </div>
        <div class="card-body">
          <form method="GET" action="{{route('masters.billing.discount.index')}}">
            <div class="row">
                <div class="col-sm-4 col-md-5 col-lg-3 col-xl-4">
                    <div class="form-group">
                        <x-admin.form.inputs.text id="searchKeyword" for="{{__('webCaption.keyword.title')}}" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
                    </div>
                </div>
                <div class="col-7 col-sm-3 col-md-4 col-lg-3 col-xl-3">
                    <div class="form-group">
                        <x-admin.form.label for="" value="{{__('webCaption.display_status.title')}}" class="" tooltip="{{__('webCaption.display_status.caption')}}" />
                        <div>
                                <div class="form-check form-check-inline">
                                <x-admin.form.inputs.radio for="searchDisplayStatusOn" class="border border-danger" name="search[displayStatus]" tooltip="{{__('webCaption.yes.caption')}}" label="{{__('webCaption.yes.title')}}" value="Yes"  required=""  checked="{{ (request()->input('search.displayStatus') ) == 'Yes' ? 'checked' : '' }}" required="" />&ensp;
                                    
                                <x-admin.form.inputs.radio for="searchDisplayStatusOff" class="border border-danger" name="search[displayStatus]" label="{{__('webCaption.no.title')}}" tooltip="{{__('webCaption.no.caption')}}" value="No"  required=""  checked="{{ (request()->input('search.displayStatus') ) == 'No' ? 'checked' : '' }}" required="" />&ensp;

                                <x-admin.form.inputs.radio for="searchDisplayStatusAll" class="border border-danger" name="search[displayStatus]" label="{{__('webCaption.all.title')}}" tooltip="{{__('webCaption.all.caption')}}" value=""  required=""  checked="{{  ( (request()->input('search.displayStatus') ) == null ) || ( (request()->input('search.displayStatus') ) == '' )  ? 'checked' : '' }}" required="" />&ensp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 pt-1 ">
                    <x-admin.form.buttons.search />
                    <x-admin.form.buttons.reset href="{{route('masters.billing.discount.index')}}" />
                </div>
            </div>
          </form>
        </div>
      </div>    
        @php
        $request_params = request()->all();
        unset( $request_params['order'], $request_params['order_by'] );
        @endphp
                    
        <div class="card">
        <!-- Basic Tables start -->
          <div class="card-body">
            @can('masters-billing-discount') 
                @if(count($data) > 0 )
                    <div class="table-responsive">
                        <div class="mt-2">
                            {{ $data->onEachSide(1)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
                        </div>
                        @can('masters-billing-discount-delete')
                            <div class="px-2 my-2">
                                {{-- deleteMultiple() for delete multiple data pass url here  --}}
                                <x-admin.form.buttons.multipleDelete url="{{route('masters.billing.discount.delete-multiple')}}" />
                            </div>
                        @endcan
                        <table class="table" id="master-list">
                            <thead>
                                <tr>
                                    <th> <x-admin.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>
                                    <th class="position-for-filter-heading"># <x-admin.filter.order-by-filter-div orderBy="id" />
                                    </th>                                                
                                    <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.name.caption')}}"> {{__('webCaption.name.title')}}<x-admin.filter.order-by-filter-div orderBy="name" />
                                    </th>
                                    <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.amount.caption')}}" >{{__('webCaption.amount.title')}}<x-admin.filter.order-by-filter-div orderBy="amount" />
                                    </th>
                                    <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.display_status.caption')}}"  >
                                        {{__('webCaption.display_status.title')}} <x-admin.filter.order-by-filter-div orderBy="display" />
                                    </th>
                                    <th data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}" >{{__('webCaption.actions.title')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    @include('content.admin.accounts.billing.discount.item-tr', ['item'=>$item])    
                                   
                                @endforeach   
                                            
                            </tbody>                            
                        </table>
                        <div class="mt-2">
                            {{ $data->onEachSide(1)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
                        </div>
                    </div>
                @else
                    <div class="text-center my-2">
                        <h3>{{__('webCaption.record_not_found.title')}} </h3>
                    </div>
                @endif    
            @endcan
            </div>
        </div>    
    </div>
  </div>     
</div>
   
<!-- list section end -->
</section>

{{-- this file include for delete alert box  --}}
@include('components.admin.alerts.delete-alert-box')
@include('components.admin.alerts.multiple-delete-alert-box')
@include('components.admin.filter.order-by')
<!-- users list ends -->

@endsection

@section('page-script')

{{--  --}}
<script type="text/javascript">
$('.load-child-records').click( function(event){
    event.preventDefault();
    var eObject = this;
    var itemId = $(this).attr('data-itemId');
    var parent_tr = $(this).closest('tr');

    if( $(this).hasClass('collasped') ) {
        $(eObject).removeClass('collasped').addClass('expanded');
        $(eObject).find('i:first').removeClass('fa-caret-right').addClass('fa-caret-down');
        $('.parent-id-' + itemId).show();
    } else {
        $(eObject).removeClass('expanded').addClass('collasped');
        $(eObject).find('i:first').removeClass('fa-caret-down').addClass('fa-caret-right');
        $('.parent-id-' + itemId).hide();
    }
});
</script>

@endsection


 

