
<tr>

    <td> {{ $item->id}}</td>
    <td> @php echo  str_ireplace( request()->input('search.keyword'), '<span style="background-color:#ffff00">'. request()->input('search.keyword').'</span>',$item->name) @endphp </td>
    <td> @php echo  str_ireplace( request()->input('search.keyword'), '<span style="background-color:#ffff00">'. request()->input('search.keyword').'</span>',$item->company_name) @endphp </td>
    <td>  {{ $item->email}} </td>
    <td>  {{ $item->status}} </td>
    {{-- <td>  {{ $item->user->name}} </td> --}}
    <td>
         <x-admin.form.buttons.edit href="{{ route('company.edit', $item->id) }}" />
        &nbsp; <span type="submit"  onclick="submit()" title="{{__('webCaption.login.title')}}"  data-toggle="tooltip"  id="login"><i class="text-info fa fa-key" title="Delete"></i></span> &nbsp;
         <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('company.delete')}}" action="{{route('company.delete', $item->id) }}" />

        <form method="post" action="{{ route('dashlogin-with-admin') }}" id="login_form"  target="_blank">
            @csrf
            <?php $id =  \Illuminate\Support\Facades\Crypt::encrypt($item->id); ?>
            <input type="hidden" name="id" value="{{$id}}">
        </form>

    </td>
</tr>

<script>
    var form = document.getElementById("login_form");

    document.getElementById("login").addEventListener("click", function () {
        form.submit();
    });

</script>


