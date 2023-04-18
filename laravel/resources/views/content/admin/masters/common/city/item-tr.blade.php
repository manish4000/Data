<tr>
    <td>
        <x-admin.form.inputs.multiple_select_checkbox id="select{{$item->id}}"   value="{{$item->id}}"  customClass="checkbox"  />            
    </td>
    <td>{{$item->id}}</td>

    <td>
        @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->name) @endphp
    </td>
    <td>
        @if(isset($item->state->name)) {{$item->state->name}} @endif
    </td>  

    <td>
    @can('main-navigation-common-city-edit')
    <x-admin.form.buttons.edit href="{{ route('common.city.edit', $item->id) }}" />&ensp;
    @endcan
    &nbsp;
    
    @can('main-navigation-common-city-delete')
    <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->title}}" url="{{route('common.city.delete')}}" action="{{route('common.city.delete', $item->id) }}" />  
    @endcan

    </td>
</tr>