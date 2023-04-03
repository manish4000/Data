    @php

        $parentOnlyShowAll  = (request()->input('search.parentOnlyShowAll') != null) ? 1 : 0;
        
         $display = ( ($item->parent_id != null) && $parentOnlyShowAll != 1  ) ? "item-tr-display-none" :'';
         $childTdColor = ( $item->parent_id > 0 )? "child-td-color" :'';

         $marginLeft = '0';
            if( $item->parent_id > 0 ) {
                $marginLeft = "1.5rem;";
            }
    @endphp

    <tr class="parent-id-{{$item->parent_id}} {{$display}}">
        <td>
            <x-admin.form.inputs.multiple_select_checkbox id="select{{$item->id}}"   value="{{$item->id}}"  customClass="checkbox"  />            
        </td>
        <td @if($childTdColor != '') class="{{$childTdColor}}" @endif >
            <span style=" margin-left: {{$marginLeft}}">{{$item->id}}</span>
        </td>
        <td @if($childTdColor != '') class="{{$childTdColor}}" @endif>
             @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->name) @endphp
        </td>

        <td> 
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
        </td>
        <td>
            @php
                $displayStatusChecked = '';
                if( strcasecmp($item->display, 'Yes') == 0) {
                    $displayStatusChecked = 'checked'; 
                }
            @endphp
    
            <x-admin.form.inputs.listing_checkbox id="list{{$item->id}}"  onclick="changeDisplayStatus('{{$item->id}}','{{route('masters-vehicle-make-update-status')}}')"  dataItemId="{{$item->id}}" dataUrl="{{route('masters-vehicle-make-update-status')}}" 
               value="{{$item->id}}" checked="{{$displayStatusChecked}}"  /> 
        </td>
        <td>
            @can('main-navigation-masters-vehicle-make-edit')
             <x-admin.form.buttons.edit href="{{ route('masters-vehicle-make-edit', $item->id) }}" />
            @endcan
            &nbsp;

           {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}

           @can('main-navigation-masters-vehicle-make-delete')
            <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('masters-vehicle-make-delete')}}" action="{{route('masters-vehicle-make-delete',$item->id)}}" /> 
           @endcan
        </td>
    </tr>

   