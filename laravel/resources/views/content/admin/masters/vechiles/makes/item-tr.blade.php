    @php

        $parentOnlyShowAll  = (request()->input('search.parentOnlyShowAll') != null) ? 1 : 0;
        
        //  $display = ( ($item->parent_id != null) && $parentOnlyShowAll != 1  ) ? "item-tr-display-none" :'';    
         $display = ( ($item->parent_id != null) && $parentOnlyShowAll != 1  ) ? "display:none;" :'';  
            $childTdColor = ( $item->parent_id > 0 )? "child-td-color" :'';

         
         $marginLeft = '-16px';
            if( $item->parent_id > 0 ) {
                $marginLeft = "0rem;";
            }
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
            
            @if($status)
                <span class="show-referance-data" onclick="showReferanceData('{{$referance_json}}')">   &#x2605;  </span> 
            @else
            <x-admin.form.inputs.multiple_select_checkbox id="select{{$item->id}}"   value="{{$item->id}}"  customClass="checkbox"  />        
            @endif        
        </div>

        <div class="make_col  width_5 xs_width_50 @if($childTdColor != '')  {{$childTdColor}}  @endif ">
            <div style="" class="div-mobile">ID</div>
            <span style="">{{$item->id}}</span>
        </div>

          <div  class="make_col width_45 xs_width_50 @if($childTdColor != '') {{$childTdColor}}  @endif" >
               <div style="" class="div-mobile">Make</div>

               @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->name) @endphp
          </div>
       

        <div class="make_col width_15 xs_width_50 text-xl-center text-lg-center text-md-center"> 
              <div style="" class="div-mobile">No. Of Child</div>
              @if( $item->children_count > 0 )
                @php
                    $collapsedClass = 'collasped';
                    $caretClass = 'fa-caret-right';
               
                    if(request()->input('search.parentOnlyShowAll') != null){
                        $collapsedClass = 'expanded';
                        $caretClass = 'fa-caret-down';
                    }
                @endphp

                <a href="#" class="load-child-records {{$collapsedClass}}" data-itemId="{{$item->id}}">{{$item->children_count}} <i class="fa {{$caretClass}}"></i> </a>
            @else
                {{$item->children_count}}
            @endif                                        
        </div>
        <div class="make_col width_13 xs_width_50 text-xl-center text-lg-center text-md-center">
           <div style="" class="div-mobile">Display Status</div>

            @php
                $displayStatusChecked = '';
                if( strcasecmp($item->display, 'Yes') == 0) {
                    $displayStatusChecked = 'checked'; 
                }
            @endphp
    
            <x-admin.form.inputs.listing_checkbox id="list{{$item->id}}"  onclick="changeDisplayStatus('{{$item->id}}','{{route('masters.vehicle.make.update-status')}}')"  dataItemId="{{$item->id}}" dataUrl="{{route('masters.vehicle.make.update-status')}}" 
               value="{{$item->id}}" checked="{{$displayStatusChecked}}"  /> 
        </div>


        <div class="make_col width_12 xs_width_50  width_md_15 text-xl-center text-lg-center text-md-center">
           <div style="position: relative; top: -3px;" class="div-mobile">Action</div>
                @can('main-navigation-masters-vehicle-make-edit')
                <x-admin.form.buttons.edit href="{{ route('masters.vehicle.make.edit', $item->id) }}" />
                @endcan
                &nbsp;

            {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}

            @can('main-navigation-masters-vehicle-make-delete')
                <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('masters.vehicle.make.delete')}}" action="{{route('masters.vehicle.make.delete',$item->id)}}" /> 
            @endcan
        </div>


            
</div>










    