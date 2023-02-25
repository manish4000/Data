<tr class="">
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
    <td>{{$item->order_by}}</td>
    <td>
        @can('main-navigation-company-plans-add')
         <x-admin.form.buttons.edit href="{{ route('company.plans.edit', $item->id) }}" />
        @endcan
        &nbsp;
       {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}
        @can('main-navigation-company-plans-delete')   
            <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('company.plans.delete')}}" action="{{route('company.plans.delete',$item->id)}}" />   
        @endcan   
    </td>
</tr>