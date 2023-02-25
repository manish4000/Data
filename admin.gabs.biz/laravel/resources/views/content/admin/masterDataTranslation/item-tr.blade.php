<tr>
    <td>{{$item->id}}</td>

    <td>
        @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->value) @endphp
    </td>
    <td>
        {{$item->created_at}}
    </td>  

    <td>
        @can('main-navigation-masters-language-translation-master-edit')
        <x-admin.form.buttons.edit href="{{ route('language_translation.master_data_translation.edit', $item->id) }}" />
        @endcan
        &nbsp;
    </td>
</tr>