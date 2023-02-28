<tr>
    <td>{{$item->id}}</td>

    <td>
        @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->title) @endphp
    </td>
    <td>
        @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->local_slug) @endphp
    </td>
    <td>
        {{$item->created_at}}
    </td>  

    <td>
    @can('main-navigation-masters-language-translation-caption-edit')
    <x-admin.form.buttons.edit href="{{ route('language_translation.web_caption.edit', $item->id) }}" />&ensp;
    {{-- <a href="{{ route('language_translation.web_caption.edit', $item->id) }}"><i class="fa fa-edit" title="{{__('webCaption.edit.title')}}"  data-toggle="tooltip"></i> </a> --}}
    @endcan
    &nbsp;
    
    @can('main-navigation-masters-language-translation-caption-delete')
    {{-- <span type="submit" onclick="deleteSingleData('{{$item->id}}','{{$item->title}}' ,'{{route('language_translation.web_caption.delete')}}')"><i class="fa fa-archive" title="{{__('webCaption.delete.title')}}"  data-toggle="tooltip"></i></span> --}}

    <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->title}}" url="{{route('language_translation.web_caption.delete')}}" action="{{route('language_translation.web_caption.delete', $item->id) }}" />  
    @endcan

    </td>
</tr>