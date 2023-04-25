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
          <form method="GET" action="{{route('masters.vehicle.make.index')}}">
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
                <div class="col-md-12  pt-1 text-center">
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
          <div class="card-body">
            @can('main-navigation-masters-vehicle-make') 
                @if(count($data) > 0 )
                    <div class="">
                      
                            <div class="mt-2">
                                {{ $data->onEachSide(2)->links('vendor.pagination.bootstrap-4') }}       
                            </div>
                         {{--check delete permission  --}}
                       
                        @can('main-navigation-masters-vehicle-make-delete')
                            <!-- <div class="px-0 my-2">
                                {{-- deleteMultiple() for delete multiple data pass url here  --}}
                                <x-admin.form.buttons.multipleDelete url="{{route('masters.vehicle.make.delete-multiple')}}" />
                            </div> -->
                        @endcan

                        

               
                        <div class="divTable" id="master-list">
                          <div class="divTableBody">
                            
                                        <div class="divTableHeading ">
                                            
                                            <div class="divTableCell"><x-admin.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /></div>

                                            <div class="divTableCell position-for-filter-heading"># <x-admin.filter.order-by-filter-div orderBy="id" /></div>

                                            
                                            <div class="divTableCell  position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.make.caption')}}">{{__('webCaption.make.title')}} <x-admin.filter.order-by-filter-div orderBy="name" /></div>

                                         <div class="divTableCell  position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.no_of_children.caption')}}" >{{__('webCaption.no_of_children.title')}}<x-admin.filter.order-by-filter-div orderBy="children_count" /></div>

                                            <div class="divTableCell position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.display_status.caption')}}">{{__('webCaption.display_status.title')}} <x-admin.filter.order-by-filter-div orderBy="display" /></div>

                                            <!-- <div class="divTableCell" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}">{{__('webCaption.actions.title')}}</div>

                                            <div class="divTableCell" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}">{{__('webCaption.actions.title')}}</div> -->

                                            <!-- <div class="divTableCell" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}">{{__('webCaption.actions.title')}}</div>

                                            <div class="divTableCell" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}">{{__('webCaption.actions.title')}}</div>

                                            <div class="divTableCell" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}">{{__('webCaption.actions.title')}}</div> -->

                                     

                                           

                                        </div>



                                        @foreach($data as $item)

                                            @include('content.admin.masters.vechiles.makes.item-tr', ['item'=>$item])    
                                            @if(true || request()->input('search.parentOnlyShowAll') == 1)
                                                    <div style="display:none;" class="divinnertable parent-id-{{$item->id}}">
                                                   
                                                    @foreach($item->children as $childItem)
                                                        @include('content.admin.masters.vechiles.makes.item-tr', ['item'=>$childItem]) 
                                                    @endforeach 
                                              
                                                    </div>                                       
                                            @endif
                                        @endforeach 

                          </div>
                        </div>
   






                        <!-- <table class="table" id="master-list">
                            <thead>
                            <tr>
                                        <th> <x-admin.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>

                                        <th class="position-for-filter-heading"># <x-admin.filter.order-by-filter-div orderBy="id" /></th>                                                
                                        <th class="position-for-filter-heading " data-toggle="tooltip" title="{{__('webCaption.make.caption')}}"> {{__('webCaption.make.title')}}<x-admin.filter.order-by-filter-div orderBy="name" />
</th>
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.no_of_children.caption')}}" >{{__('webCaption.no_of_children.title')}}<x-admin.filter.order-by-filter-div orderBy="children_count" />
</th>
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.display_status.caption')}}"  >{{__('webCaption.display_status.title')}} <x-admin.filter.order-by-filter-div orderBy="display" />
</th>
                                        <th data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}" >{{__('webCaption.actions.title')}}</th>
                                    </tr>
                            </thead>
                            <tbody>

                                @foreach($data as $item)
                                    @include('content.admin.masters.vechiles.makes.item-tr', ['item'=>$item])    
                                    @if(true || request()->input('search.parentOnlyShowAll') == 1)
                                            @foreach($item->children as $childItem)
                                                @include('content.admin.masters.vechiles.makes.item-tr', ['item'=>$childItem])    
                                            @endforeach                                        
                                    @endif
                                @endforeach   
                                            
                            </tbody>                            
                        </table>
 -->







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


<style>

/* .gabs_table {width:100%;height:auto;display:table;}
.gabs_table-row {width:100%;height:4.8vw;display:table-row;border-bottom:1px solid #ebe9f1;}
.gabs_table-header {font-weight:bold;background:#f3f2f7; border-top:1px solid #ebe9f1;}

.gabs_table-row-column {display:table-cell;align-items:center;justify-content:center;word-break: break-word;}
.custom-control-inline { margin-right:.5rem !important;}
.gabs_table-center { text-align:center;}

@media only screen and ( min-width:1024px ) and ( max-width:1050px ) {
    .gabs_table-row { height:8vw;}
}

@media only screen and ( min-width:767px ) and ( max-width:1023px ) {
    .gabs_table-row { height:auto; display:block; width:auto;}
    .gabs_table-row-column { float:left; width:20%; padding:10px 0px;}
   
}


@media only screen and ( min-width:320px ) and ( max-width:767px ) {
.gabs_table-header { display:none;}
.gabs_table-row { height:auto; display:block; width:auto; }
.gabs_table-row-column { float: left; padding:10px 0px;}
.gabs_table-row div:first-child {width:13% !important; justify-content:center; padding-bottom:10px;padding-top: 10px;}
.gabs_table-row div:nth-child(2) {width:15% !important;justify-content:center; padding-bottom:10px;padding-top: 10px;} */




.divTable{display:table;width:100%;text-align:center;}
.divTableRow {display:table-row;}
.divTableHeading {background-color:#f3f2f7;display:table-row;border:2px solid #ebe9f1;}
.divTableCell, .divTableHead {border-bottom:1px solid #f3f2f7;display:table-cell;padding: 12px 10px;
    vertical-align: middle;}
.divTableCell:nth-child(3), .divTableHead:nth-child(3) { text-align:left;}
.divTableHeading {background-color:#f3f2f7;display:table-row;font-weight:bold; border:2px solid #ebe9f1;}
.divTableFoot {background-color:#ffffff;display:table-footer-group;font-weight:bold;}
.divTableBody {display:table-row-group;}

.divTableCell > a > i.fa-edit, .fa-archive {position:relative;top:7px;}

.short-by-filter { display:inline-block;}


.divinnertable{display:table;width:100%;text-align:center;}
.divinnertable > div { display:table-row; width:100%;}
.divinnertable > div > div { width:30%; display:table-cell;}

@media only screen and ( min-width:767px ) and ( max-width:1023px ) {
.divTable { text-align:start !important;}
.divTableHeading { float:left;}
.divTableRow {float:left; border-bottom:#f3f2f7 1px solid;}
.divTableCell, .divTableHead {padding: 6px 48px; float: left; border-bottom:none; }
  .divTableCell > a > i.fa-edit, .fa-archive {position:relative;top:6px;}
.divTableCell:nth-child(4), .divTableHead:nth-child(4) { text-align:left;}
.divTableCell:nth-child(5), .divTableHead:nth-child(5) { text-align:left;}


} 



@media only screen and ( min-width:320px ) and ( max-width:767px ) {
.divTable { text-align:left;}

.divTableCell, .divTableHead{ float:left; border-bottom:none; padding:5px 16px 5px 17px;}
.divTableRow {display:table;border-bottom:#ebe9f1 1px solid;}
.divTableCell > a > i.fa-edit, .fa-archive {position:relative;top:0px;}


}

   </style>
