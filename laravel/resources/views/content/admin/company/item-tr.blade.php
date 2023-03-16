
<tr>

    <td> {{ $item->id}}</td>
    <td> @php echo  str_ireplace( request()->input('search.keyword'), '<span style="background-color:#ffff00">'. request()->input('search.keyword').'</span>',$item->name) @endphp </td>
    <td> @php echo  str_ireplace( request()->input('search.keyword'), '<span style="background-color:#ffff00">'. request()->input('search.keyword').'</span>',$item->company_name) @endphp </td>
    <td>  {{ $item->email}} </td>
    <td>  {{ $item->status}} </td>
    {{-- <td>  {{ $item->user->name}} </td> --}}
    <td>
         <x-admin.form.buttons.edit href="{{ route('company.edit', $item->id) }}" />
        &nbsp;<x-admin.form.buttons.login href="{{ route('dashlogin-with-admin',['id'=>$item->id]) }}"  />&nbsp;
        
         <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('company.delete')}}" action="{{route('company.delete', $item->id) }}" />



    </td>
</tr>


