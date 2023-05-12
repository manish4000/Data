@extends('dash/layouts/LayoutMaster')
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
          <form method="GET" action="{{route('dashmasters.crm.rating.index')}}">
            <div class="row">
                <div class="col-sm-3 col-md-5 col-lg-7 col-xl-7">
                    <div class="form-group">
                        <x-dash.form.inputs.text id="searchKeyword" for="{{__('webCaption.keyword.title')}}" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
                    </div>
                </div>
                <div class="col-7 col-sm-3 col-md-4 col-lg-3" >
                    <div class="form-group">
                        <x-dash.form.label for="" value="{{__('webCaption.display_status.title')}}" class="" tooltip="{{__('webCaption.display_status.caption')}}" />
                        <div>
                                <div class="form-check form-check-inline">
                                <x-dash.form.inputs.radio for="searchDisplayStatusOn" class="border border-danger" name="search[displayStatus]" tooltip="{{__('webCaption.yes.caption')}}" label="{{__('webCaption.yes.title')}}" value="Yes"  required=""  checked="{{ (request()->input('search.displayStatus') ) == 'Yes' ? 'checked' : '' }}" required="" />&ensp;
                                    
                                <x-dash.form.inputs.radio for="searchDisplayStatusOff" class="border border-danger" name="search[displayStatus]" label="{{__('webCaption.no.title')}}" tooltip="{{__('webCaption.no.caption')}}" value="No"  required=""  checked="{{ (request()->input('search.displayStatus') ) == 'No' ? 'checked' : '' }}" required="" />&ensp;

                                <x-dash.form.inputs.radio for="searchDisplayStatusAll" class="border border-danger" name="search[displayStatus]" label="{{__('webCaption.all.title')}}" tooltip="{{__('webCaption.all.caption')}}" value=""  required=""  checked="{{  ( (request()->input('search.displayStatus') ) == null ) || ( (request()->input('search.displayStatus') ) == '' )  ? 'checked' : '' }}" required="" />&ensp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5 col-sm-3 col-md-3 col-lg-2 col-xl-2">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <x-dash.form.label for=""  value="{{__('webCaption.parent_only.title')}}" class="" tooltip="{{__('webCaption.parent_only.caption')}}" />

                                <x-dash.form.inputs.checkbox for="searchParentOnlyShowAll"  name="search[parentOnlyShowAll]" tooltip="{{__('webCaption.show_all.caption')}}" label="{{__('webCaption.show_all.title')}}" checked="{{ (request()->input('search.parentOnlyShowAll') == 1)  ?'checked' :''; }}"  value="1"  customClass="form-check-input"  />
                                
                            </div>
                        </div>
                        
                    </div> 
                </div>
                <div class="col-md-12 pt-1 text-center">
                    <x-dash.form.buttons.search />
                    <x-dash.form.buttons.reset href="{{route('dashmasters.crm.rating.index')}}" />
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

                @if(count($data) > 0 )
                    <div class="table-responsive">
                        <div class="mt-2">
                            {{ $data->onEachSide(1)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
                        </div>
                            <div class="px-2 my-2">
                                {{-- deleteMultiple() for delete multiple data pass url here  --}}
                                <x-dash.form.buttons.multipleDelete url="{{route('dashmasters.crm.rating.delete-multiple')}}" />
                            </div>
                        <table class="table" id="master-list">
                            <thead>
                                <tr>
                                        <th> <x-dash.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>
                                        <th class="position-for-filter-heading"># <x-dash.filter.order-by-filter-div orderBy="id" />
                                        </th>                                                
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.rating.caption')}}"> {{__('webCaption.rating.title')}}<x-dash.filter.order-by-filter-div orderBy="name" />
                                        </th>
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.no_of_children.caption')}}" >{{__('webCaption.no_of_children.title')}}<x-dash.filter.order-by-filter-div orderBy="children_count" />
                                        </th>
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.display_status.caption')}}"  >
                                            {{__('webCaption.display_status.title')}} <x-dash.filter.order-by-filter-div orderBy="display" />
                                        </th>
                                        <th data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}" >{{__('webCaption.actions.title')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    @include('dash.content.masters.crm.rating.item-tr', ['item'=>$item])    
                                    @if( true || request()->input('search.parentOnlyShowAll') == 1)
                                        @foreach($item->children as $childItem)
                                            @include('dash.content.masters.crm.rating.item-tr', ['item'=>$childItem])    
                                        @endforeach 
                                    @endif
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

            </div>
        </div>    
    </div>
  </div>     
</div>
   
<!-- list section end -->
</section>

{{-- this file include for delete alert box  --}}
@include('components.dash.alerts.delete-alert-box')
@include('components.dash.alerts.multiple-delete-alert-box')
@include('components.dash.filter.order-by')
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


 

