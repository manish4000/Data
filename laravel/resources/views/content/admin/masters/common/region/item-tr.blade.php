@php
    $parentOnlyShowAll  = (request()->input('search.parentOnlyShowAll') != null) ? 1 : 0;   
    $display = ( ($item->parent_id != null) && $parentOnlyShowAll != 1  ) ? "display:none;" :'';  
    $childTdColor = ( $item->parent_id > 0 )? "child-td-color child-master-class" :'';
@endphp


@php
    $referance = [   
                    // demo send data like this to find relation  
                    // [ 'table' => 'subtype','field' => 'type_id','value' => $item->id ,'module' => 'SubType' ,
                    //   'url' => route('masters.vehicle.subtype.index',['search[type]' => $item->id ])  
                    // ]
                ];    
    $status   = (count($referance) > 0 ) ?  Helper::__checkReferanceDataExist($referance) : false ;  
    $referance_json    = json_encode($referance);            
@endphp

<div class="table_row parent-id-{{$item->parent_id}} " style="{{$display}}">
    <div class="make_col width_5 xs_width_50">
        <div class="div-mobile">{{__('webCaption.master_checkbox_text.title')}}</div>
        @if($status)
            <span class="show-referance-data" onclick="showReferanceData('{{$referance_json}}')">   &#x2605;  </span> 
        @else
        <x-admin.form.inputs.multiple_select_checkbox id="select{{$item->id}}"   value="{{$item->id}}"  customClass="checkbox"  />        
        @endif        
    </div>

    <div class="make_col width_5 xs_width_50 @if($childTdColor != '')  {{$childTdColor}}  @endif ">
        <div class="div-mobile">{{__('webCaption.id.title')}}</div>
        <span>{{$item->id}}</span>
    </div>

    <div class="make_col width_45 xs_width_50 @if($childTdColor != '') {{$childTdColor}}  @endif" >
        <div class="div-mobile">{{__('webCaption.region.title')}}</div>
        @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->name) @endphp
    </div>
       
    <div class="make_col width_15 xs_width_50 text-xl-center text-lg-center text-md-center"> 
        <div class="div-mobile">{{__('webCaption.no_of_children.title')}}</div>
        @if( $item->children_count > 0 )
            @php
                $collapsedClass = 'collasped';
                $caretClass = 'fa-caret-right';
            
                if(request()->input('search.parentOnlyShowAll') != null){
                    $collapsedClass = 'expanded';
                    $caretClass = 'fa-caret-down';
                }
            @endphp
            <a href="javascript:void(0);" class="load-child-records {{$collapsedClass}}" data-itemId="{{$item->id}}">{{$item->children_count}} <i class="fa {{$caretClass}}"></i> </a>
        @else
            {{$item->children_count}}
        @endif                                     
    </div>
    <div class="make_col width_13 xs_width_50 text-xl-center text-lg-center text-md-center">
        <div class="div-mobile">{{__('webCaption.display_status.title')}}</div>
        @php
            $displayStatusChecked = '';
            if( strcasecmp($item->display, 'Yes') == 0) {
                $displayStatusChecked = 'checked'; 
            }
        @endphp

        <x-admin.form.inputs.listing_checkbox id="list{{$item->id}}"  onclick="changeDisplayStatus('{{$item->id}}','{{route('common.region.update-status')}}')"  dataItemId="{{$item->id}}" dataUrl="{{route('common.region.update-status')}}" 
            value="{{$item->id}}" checked="{{$displayStatusChecked}}" /> 
    </div>

    <div class="make_col width_12 xs_width_50 text-xl-center text-lg-center text-md-center">
        <div class="div-mobile">{{__('webCaption.actions.title')}}</div>
        @can('common-region-edit')
        <x-admin.form.buttons.edit href="{{ route('common.region.edit', $item->id) }}" />
        @endcan
        &nbsp;

        {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}

        @can('common-region-delete')
            <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('common.region.delete')}}" action="{{route('common.region.delete',$item->id)}}" /> 
        @endcan
    </div>           
</div>    