<tr>
    <td>
        <x-admin.form.inputs.multiple_select_checkbox id="select{{$item->id}}"   value="{{$item->id}}"  customClass="checkbox"  />
    </td>
    <td>{{$item->id}}</td>
    <td>
         @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->title) @endphp
    </td>
    <td>
         @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->slug) @endphp
    </td>
    <td>
        @can('main-navigation-master-department-edit')
            <x-admin.form.buttons.edit href="{{ route('department.edit', $item->id) }}" />
        @endcan    
        &nbsp;
       {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}
        @can('main-navigation-master-department-delete')
            <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('department.delete')}}" action="{{route('department.delete',$item->id)}}" />   
        @endcan    
    </td>
</tr>