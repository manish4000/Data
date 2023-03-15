
<tr>

    <td> {{ $item->id}}</td>
    <td> @php echo  str_ireplace( request()->input('search.keyword'), '<span style="background-color:#ffff00">'. request()->input('search.keyword').'</span>',$item->name) @endphp </td>
    <td> @php echo  str_ireplace( request()->input('search.keyword'), '<span style="background-color:#ffff00">'. request()->input('search.keyword').'</span>',$item->company_name) @endphp </td>
    <td>  {{ $item->email}} </td>
    <td>  {{ $item->status}} </td>
    {{-- <td>  {{ $item->user->name}} </td> --}}
    <td>
         <x-admin.form.buttons.edit href="{{ route('company.edit', $item->id) }}" />
        &nbsp;
        
         <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('company.delete')}}" action="{{route('company.delete', $item->id) }}" />

        <x-admin.form.buttons.edit href="{{ route('company.edit', $item->id) }}" />

    {{-- <span type="submit" onclick="deleteType('{{$item->id}}','{{$item->name}}')"><i class="fa fa-archive" title="Delete"></i></span>
        <form method="post" action="#" id="delete_form_{{$item->id}}" >
            @csrf
        </form> --}}
    </td>
</tr>