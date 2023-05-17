@extends('layouts/contentLayoutMaster')
@section('title', $pageConfigs['moduleName'])


@section('content')
<!-- users list start -->
<section>
  <div class="row">
    <div class="col-12">
            <!-- filter  -->
      <div class="card">
        <div class="card-header py-75 px-50">
          <h4 class="card-title " data-toggle="tooltip" data-placement="right" title="{{__('webCaption.search_filter.caption')}}">{{__('webCaption.search_filter.title')}}</h4>                    
        </div>
        <hr class="m-0 p-0">
        <div class="card-body pt-75 pb-75 px-50">
          <form method="GET" action="{{route('masters.vehicle.make.index')}}" style="margin-bottom:0px !important;">
            <div class="row">
                <div class="col-sm-3 col-md-5 col-lg-7 col-xl-7">
                    <div class="form-group">
                        <x-admin.form.inputs.text id="searchKeyword" for="{{__('webCaption.keyword.title')}}" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
                    </div>
                </div>
                <div class="col-7 col-sm-3 col-md-4 col-lg-3">
                    <div class="form-group">
                        <x-admin.form.label for="" value="{{__('webCaption.display_status.title')}}" class="" tooltip="{{__('webCaption.display_status.caption')}}" />
                        {{-- <label for="displayStatusLabel" data-toggle="tooltip" title="{{__('webCaption.display_status.caption')}}" >{{__('webCaption.display_status.title')}}</label> --}}
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
                        <div class="col-md-10 ">
                            <div class="form-group">
                                <x-admin.form.label for=""  value="{{__('webCaption.parent_only.title')}}" class="" tooltip="{{__('webCaption.parent_only.caption')}}" />

                                <x-admin.form.inputs.checkbox for="searchParentOnlyShowAll"  name="search[parentOnlyShowAll]" tooltip="{{__('webCaption.show_all.caption')}}" label="{{__('webCaption.show_all.title')}}" checked="{{ (request()->input('search.parentOnlyShowAll') == 1)  ?'checked' :''; }}"  value="1"  customClass="form-check-input"  />
                                
                            </div>
                        </div>
                        
                    </div> 
                </div>
                <div class="col-md-12  pt-0 text-center">
                    <x-admin.form.buttons.search />
                    <x-admin.form.buttons.reset href="{{route('masters.vehicle.make.index')}}" />
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
          <div class="card-body pt-75 pb-0 px-50">
            @can('main-navigation-masters-vehicle-make') 
                @if(count($data) > 0 )
                    <div >
                      
                                                       
                               <div class="pt-25 pb-1">

                                   @if (Auth::guard('web')->user()->can('main-navigation-masters-vehicle-make-delete'))		
                                       {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4',['multiple_delete_url' => route('masters.vehicle.make.delete-multiple') ] ) }}  
                                   @else
                                        {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}  
                                   @endif
                               </div>
                          
                         {{--check delete permission  --}}


          
          <div class="main_table" id="master-list">
            @php
            $heading_array = [
                                    [
                                        'title' => 'id',
                                        'orderby' => 'id',
                                        'classes' => 'width_5 text-center'
                                    ] , 
                                    [
                                        'title' => 'make',
                                        'orderby' => 'name',
                                        'classes' => 'width_45'
                                    ] , 
                                    [
                                        'title' => 'no_of_children',
                                        'orderby' => 'children_count',
                                        'classes' => 'width_15 '
                                    ] , 
                                    [
                                        'title' => 'display_status',
                                        'orderby' => 'display',
                                        'classes' => 'width_14 '
                                    ] , 
                                    [
                                        'title' => 'actions',
                                        'orderby' => null,
                                        'classes' => 'width_12  text-center width_md_15'
                                    ]  
                             ];
            @endphp

            <x-admin.table.table-heading :headingFields="$heading_array"/>                
                         
                   @foreach($data as $item)
                      @include('content.admin.masters.vechiles.makes.item-tr', ['item'=>$item])    
                        @if(true || request()->input('search.parentOnlyShowAll') == 1)
                          @foreach($item->children as $childItem)
                             @include('content.admin.masters.vechiles.makes.item-tr', ['item'=>$childItem])    
                         @endforeach                                        
                       @endif
              @endforeach   
                                                                               
             </div>
                   

                        <div class="mt-75">
                            @if (Auth::guard('web')->user()->can('main-navigation-masters-vehicle-make-delete'))		
                            {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4',['multiple_delete_url' => route('masters.vehicle.make.delete-multiple') ] ) }}  
                            @else
                                {{ $data->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}  
                            @endif
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


{{-- include these files for change display status  functionality --}}
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


