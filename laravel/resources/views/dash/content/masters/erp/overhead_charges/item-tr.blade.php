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
            <x-dash.form.inputs.multiple_select_checkbox id="select{{$item->id}}"   value="{{$item->id}}"  customClass="checkbox"  />            
        </td>
        <td @if($childTdColor != '') class="{{$childTdColor}}" @endif >
            <span style=" margin-left: {{$marginLeft}}">{{$item->id}}</span>
        </td>
        <td @if($childTdColor != '') class="{{$childTdColor}}" @endif>
             @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->name) @endphp
        </td>
        <td>
            @php
                $displayStatusChecked = '';
                if( strcasecmp($item->display, 'Yes') == 0) {
                    $displayStatusChecked = 'checked'; 
                }
            @endphp
    
            <x-dash.form.inputs.listing_checkbox id="list{{$item->id}}"  onclick="changeDisplayStatus('{{$item->id}}','{{route('dashmasters.erp.overhead-charges.update-status')}}')"  dataItemId="{{$item->id}}" dataUrl="{{route('dashmasters.erp.overhead-charges.update-status')}}" 
               value="{{$item->id}}" checked="{{$displayStatusChecked}}"  /> 
        </td>
        <td>

             <x-dash.form.buttons.edit href="{{ route('dashmasters.erp.overhead-charges.edit', $item->id) }}" />

            &nbsp;

           {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}


            <x-dash.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('dashmasters.erp.overhead-charges.delete')}}" action="{{route('dashmasters.erp.overhead-charges.delete',$item->id)}}" /> 

        </td>
    </tr>