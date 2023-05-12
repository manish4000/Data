
            
    <tr>
        <td>
            <x-admin.form.inputs.multiple_select_checkbox id="select{{$item->id}}"   value="{{$item->id}}"  customClass="checkbox"/>            
        </td>
        <td>
            <span>{{$item->id}}</span>
        </td>
        <td>
           {{$item->name}}
        </td>
        <td>
           {{$item->url}}
        </td>
        <td>
            @if(!empty($item->icon) && isset($item->icon) && is_file(public_path('social_media').'/'.$item->icon))
            <img src="{{asset('social_media')}}/{{$item->icon}}" alt="icon" class="rounded" id="icon-preview" width="40" height="40">
            @else
            <img src="{{asset('assets/images/portrait/small/no-photo.jpg')}}" alt="icon" class="rounded" id="icon-preview" width="40" height="40">
            @endif
        </td>
        <td>
            @php
                $displayStatusChecked = '';
                if( strcasecmp($item->display, 'Yes') == 0) {
                    $displayStatusChecked = 'checked'; 
                }
            @endphp
    
            <x-admin.form.inputs.listing_checkbox id="list{{$item->id}}"  onclick="changeDisplayStatus('{{$item->id}}','{{route('masters.social-media.update-status')}}')"  dataItemId="{{$item->id}}" dataUrl="{{route('masters.social-media.update-status')}}" 
               value="{{$item->id}}" checked="{{$displayStatusChecked}}"  /> 
        </td>
        <td>
            @can('masters-social-media-edit')
             <x-admin.form.buttons.edit href="{{ route('masters.social-media.edit', $item->id) }}" />
            @endcan
            &nbsp;

           {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}

           @can('masters-social-media-delete')
            <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}" url="{{route('masters.social-media.delete')}}" action="{{route('masters.social-media.delete',$item->id)}}" /> 
           @endcan
        </td>
    </tr>