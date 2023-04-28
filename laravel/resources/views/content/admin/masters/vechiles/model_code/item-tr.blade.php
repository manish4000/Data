@php
        
         $display = ( ($item->parent_id != null) && request()->input('search.parentOnlyShowAll') != 1  ) ? "item-tr-display-none" :'';
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
               
                    if(request()->input('search.parentOnlyShowAll') == 1){
                        $collapsedClass = 'expanded';
                        $caretClass = 'fa-caret-down';
                    }
                @endphp

                <a href="#" class="load-child-records {{$collapsedClass}}" data-itemId="{{$item->id}}">{{$item->children_count}} <i class="fa {{$caretClass}}"></i> </a>
            @else
                {{$item->children_count}}
            @endif                                        
        </td>
        <td @if($childTdColor != '') class="{{$childTdColor}}" @endif>
            <span>{{ isset($item->model_name->name) ? $item->model_name->name :'' }}</span>
       </td>
        <td @if($childTdColor != '') class="{{$childTdColor}}" @endif>
            <span>{{ isset($item->length) ? $item->length :'' }}</span>
        </td>
        <td @if($childTdColor != '') class="{{$childTdColor}}" @endif>
            <span>{{ isset($item->width) ? $item->width :'' }}</span>
        </td>
        <td @if($childTdColor != '') class="{{$childTdColor}}" @endif>
            <span>{{ isset($item->height) ? $item->height:'' }}</span>
        </td>
        <td>
            <span>{{ round(($item->length*$item->width*$item->height)/1000000,3) }}</span>
        </td>
        <td>
            @php
                $displayStatusChecked = '';
                if( strcasecmp($item->display, 'Yes') == 0) {
                    $displayStatusChecked = 'checked'; 
                }
            @endphp
    
            <x-admin.form.inputs.listing_checkbox id="list{{$item->id}}"  onclick="changeDisplayStatus('{{$item->id}}','{{route('masters.vehicle.model-code.update-status')}}')"  dataItemId="{{$item->id}}" dataUrl="{{route('masters.vehicle.model-code.update-status')}}" 
               value="{{$item->id}}" checked="{{$displayStatusChecked}}"  /> 
        </td>
        <td>
            @can('masters-vehicle-model-code-edit')
             <x-admin.form.buttons.edit href="{{ route('masters.vehicle.model-code.edit', $item->id) }}" />
            @endcan
            &nbsp;

           {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}

           @can('masters-vehicle-model-code-delete')
            <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('masters.vehicle.model-code.delete')}}" action="{{route('masters.vehicle.model-code.delete',$item->id)}}" /> 
           @endcan
        </td>
    </tr>

















