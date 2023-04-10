<tr>
    <td>{{$item->id}}</td>

    <td>
        @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->name) @endphp
    </td>
    <td>
        @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->country_code) @endphp
    </td>
    <td>
        {{$item->phone_code}}
    </td>  
    <td>
        {{$item->region}}
    </td>  

    <td>
    @can('main-navigation-common-country-edit')
    <x-admin.form.buttons.edit href="{{ route('common.country.edit', $item->id) }}" />&ensp;
    @endcan
    &nbsp;
    
    @can('main-navigation-common-country-delete')
    <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->title}}" url="{{route('common.country.delete')}}" action="{{route('common.country.delete', $item->id) }}" />  
    @endcan

    </td>
</tr>