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
          <form method="GET" action="{{route('masters.vehicle.type.index')}}">
            <div class="row">
                <div class="col-md-6 col-lg-3 col-xl-4">
                    <div class="form-group">
                        <x-admin.form.inputs.text id="searchKeyword" for="{{__('webCaption.keyword.title')}}" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
                    </div>
                </div>
                <div class="col-7 col-md-3">
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
                <div class="col-5 col-sm-3 col-md-3 col-lg-2 col-xl-2">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="form-group">
                                <x-admin.form.label for=""  value="{{__('webCaption.parent_only.title')}}" class="" tooltip="{{__('webCaption.parent_only.caption')}}" />

                                <x-admin.form.inputs.checkbox for="searchParentOnlyShowAll"  name="search[parentOnlyShowAll]" tooltip="{{__('webCaption.show_all.caption')}}" label="{{__('webCaption.show_all.title')}}" checked="{{ (request()->input('search.parentOnlyShowAll') == 1)  ?'checked' :''; }}"  value="1"  customClass="form-check-input"  />
                                
                            </div>
                        </div>
                        
                    </div> 
                </div>
                <div class="col-12 col-sm-5 col-md-5 col-lg-4 col-xl-3 pt-1">
                    <x-admin.form.buttons.search />
                    <x-admin.form.buttons.reset href="{{route('masters.vehicle.type.index')}}" />
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
            @can('main-navigation-masters-vehicle-type') 
                @if(count($data) > 0 )
                    <div class="table-responsive">
                        <div class="mt-2">
                            {{ $data->onEachSide(2)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
                        </div>
                        @can('main-navigation-masters-vehicle-type-delete')
                            <div class="px-2 my-2">
                                {{-- deleteMultiple() for delete multiple data pass url here  --}}
                                <x-admin.form.buttons.multipleDelete url="{{route('masters.vehicle.type.delete-multiple')}}" />
                            </div>
                        @endcan

                        @php
                        $heading_array = [
                                                [
                                                    'title' => 'id',
                                                    'orderby' => 'id'
                                                ] , 
                                                [
                                                    'title' => 'name',
                                                    'orderby' => 'name'
                                                ] , 
                                                [
                                                    'title' => 'no_of_children',
                                                    'orderby' => 'children_count'
                                                ] , 
                                                [
                                                    'title' => 'display_status',
                                                    'orderby' => 'display'
                                                ] , 
                                                [
                                                    'title' => 'actions',
                                                    'orderby' => null
                                                ]  
                                         ];
                        @endphp

                        <x-admin.table.table-heading :headingFields="$heading_array"/>



                        <table class="table" id="master-list">

                            <tbody>
                                @foreach($data as $item)
                                    @include('content.admin.masters.vechiles.types.item-tr', ['item'=>$item])    
                                    @if( true || request()->input('search.parentOnlyShowAll') == 1)
                                        @foreach($item->children as $childItem)
                                            @include('content.admin.masters.vechiles.types.item-tr', ['item'=>$childItem])    
                                        @endforeach 
                                    @endif
                                @endforeach   
                                            
                            </tbody>                            
                        </table>
                        
                        <div class="mt-2">
                            {{ $data->onEachSide(2)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
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
   
{{-- model box --}}
<!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="referanceModal" tabindex="-1" aria-labelledby="referanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="referanceModalLabel">Referance Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" >
            <div >
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Module</th>
                        <th scope="col">Count</th>
                      </tr>
                    </thead >
                    <tbody id="referanceData">

                    </tbody>
                  </table>
            </div>
          
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('webCaption.close.caption')}}</button>
        </div> --}}
      </div>
    </div>
  </div>
{{-- model box --}}
<!-- list section end -->
</section>

{{-- this file include for delete alert box  --}}
@include('components.admin.alerts.delete-alert-box')
@include('components.admin.alerts.multiple-delete-alert-box')
@include('components.admin.alerts.reference-model-box')
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







 

