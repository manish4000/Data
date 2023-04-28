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
        <td>
            <span style=" margin-left: {{$marginLeft}}">{{$item->id}}</span>
        </td>
        <td>   
            @if(isset($item->type_id)) {{$item->type->name}} @endif 
        </td>
        <td>
            @if(isset($item->subtype_id)) {{$item->subtype->name}} @endif
        </td>
        <td>
            @if(isset($item->make_id)) {{$item->make->name}} @endif
        </td>
        <td>
            @if(isset($item->model_id) ) {{$item->vehicleModel->name }} @endif
        </td>
        <td>
            @if(isset($item->is_confirmed) && $item->is_confirmed == '1') {{ "Yes" }} @else {{"No"}} @endif
        </td>
        <td>
            @can('masters-vehicle-relation-edit')
             <x-admin.form.buttons.edit href="{{ route('masters.vehicle.relation.edit', $item->id) }}" />
            @endcan
            &nbsp;

           {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}

           @can('masters-vehicle-relation-delete')
            <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('masters.vehicle.relation.delete')}}" action="{{route('masters.vehicle.relation.delete',$item->id)}}" /> 
           @endcan
        </td>
    </tr>