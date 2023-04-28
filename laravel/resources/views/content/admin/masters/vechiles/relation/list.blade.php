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
          <form method="GET" action="{{route('masters.vehicle.relation.index')}}">
            <div class="row">
                <div class="col-sm-4 col-md-5 col-lg-3 col-xl-4">
                    <div class="form-group">
                        <x-admin.form.inputs.select  tooltip="{{__('webCaption.type.caption')}}"  label="{{__('webCaption.type.title')}}"  id="" for="type_id" name="type_id" required="" :optionData="$types" editSelected="{{ request()->input('type_id') }}" />
                    </div>
                </div>
                <div class="col-sm-4 col-md-5 col-lg-3 col-xl-4">
                    <div class="form-group">
                        <x-admin.form.inputs.select  tooltip="{{__('webCaption.subtype.caption')}}"  label="{{__('webCaption.subtype.title')}}"  id="subtype_id" for="" name="subtype_id" required="" :optionData="$subtypes" editSelected="{{ request()->input('subtype_id') }}" />
                    </div>
                </div>
                <div class="col-sm-4 col-md-5 col-lg-3 col-xl-4">
                    <div class="form-group">
                        <x-admin.form.inputs.select  tooltip="{{__('webCaption.make.caption')}}"  label="{{__('webCaption.make.title')}}"  id="" for="make_id" name="make_id" required="" :optionData="$makes" editSelected="{{ request()->input('make_id') }}" />
                    </div>
                </div>
                <div class="col-sm-4 col-md-5 col-lg-3 col-xl-4">
                    <div class="form-group">
                        <x-admin.form.inputs.select  tooltip="{{__('webCaption.model.caption')}}"  label="{{__('webCaption.model.title')}}"  id="" for="model_id" name="model_id" required="" :optionData="$models" editSelected="{{ request()->input('model_id') }}" />
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 pt-1 ">
                    <x-admin.form.buttons.search />
                    <x-admin.form.buttons.reset href="{{route('masters.vehicle.relation.index')}}" />
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
            @can('masters-vehicle-relation') 
                @if(count($data) > 0 )
                    <div class="table-responsive">
                        <div class="mt-2">
                            {{ $data->onEachSide(1)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
                        </div>
                        @can('masters-vehicle-relation-delete')
                            <div class="px-2 my-2">
                                {{-- deleteMultiple() for delete multiple data pass url here  --}}
                                <x-admin.form.buttons.multipleDelete url="{{route('masters.vehicle.relation.delete-multiple')}}" />
                            </div>
                        @endcan
                        <table class="table" id="master-list">
                            <thead>
                                <tr>
                                        <th> <x-admin.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>
                                        <th class="position-for-filter-heading"># <x-admin.filter.order-by-filter-div orderBy="id" />
                                        </th>                                                
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.type.caption')}}"> {{__('webCaption.type.title')}}<x-admin.filter.order-by-filter-div orderBy="type_id" />
                                        </th>
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.subtype.caption')}}" >{{__('webCaption.subtype.title')}}<x-admin.filter.order-by-filter-div orderBy="subtype_id" />
                                        </th>
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.make.caption')}}">
                                            {{__('webCaption.make.title')}} <x-admin.filter.order-by-filter-div orderBy="make_id" />
                                        </th>
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.model.caption')}}">
                                            {{__('webCaption.model.title')}} <x-admin.filter.order-by-filter-div orderBy="model_id" />
                                        </th>
                                        <th class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.display.caption')}}">
                                            {{__('webCaption.display.title')}} <x-admin.filter.order-by-filter-div orderBy="is_confirmed" />
                                        </th>
                                        <th data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}" >{{__('webCaption.actions.title')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    @include('content.admin.masters.vechiles.relation.item-tr', ['item'=>$item])    
                                    
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


 

