    @php

    $display = ( ($item->parent_id != null) && request()->input('search.parentOnlyShowAll') != 1 ) ?
    "item-tr-display-none" :'';
    $childTdColor = ( $item->parent_id > 0 )? "child-td-color" :'';

    $marginLeft = '0';
    if( $item->parent_id > 0 ) {
    $marginLeft = "1.5rem;";
    }
    @endphp

    <tr class="parent-id-{{$item->parent_id}} {{$display}}">
        <td>
            <x-admin.form.inputs.multiple_select_checkbox id="select{{$item->id}}" value="{{$item->id}}"
                customClass="checkbox" />
        </td>
        <td @if($childTdColor !='' ) class="{{$childTdColor}}" @endif>
            <span style=" margin-left: {{$marginLeft}}">{{$item->id}}</span>
        </td>
        <td @if($childTdColor !='' ) class="{{$childTdColor}}" @endif>
            @php echo str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string">'.
                request()->input('search.keyword').'</span>',$item->name) @endphp
        </td>
        <td> @if(isset($item->country)) {{$item->country}} @endif</td>
        <td>
            @if(!empty($item->logo) && isset($item->logo) && is_file(public_path('masters/association').'/'.$item->logo))
            <img src="{{asset('masters/association')}}/{{$item->logo}}" alt="logo" class="rounded" id="logo-preview" width="60"
                height="60">
            @else
            <img src="{{asset('assets/images/portrait/small/no-photo.jpg')}}" alt="logo" class="rounded"
                id="logo-preview" width="60" height="60">
            @endif
        </td>
        <td>{{$item->text}}</td>

        <td>
            @if( $item->children_count > 0 )
            @php
            $collapsedClass = 'collasped';
            $caretClass = 'fa-caret-right';

            if(request()->input('search.parentOnlyShowAll') == 1){
            $collapsedClass = 'expanded';
            $caretClass = 'fa-caret-down';
            }
            @endphp

            <a href="#" class="load-child-records {{$collapsedClass}}"
                data-itemId="{{$item->id}}">{{$item->children_count}} <i class="fa {{$caretClass}}"></i> </a>
            @else
            {{$item->children_count}}
            @endif
        </td>
        <td>
            @php
            $displayStatusChecked = '';
            if( strcasecmp($item->display, 'Yes') == 0) {
            $displayStatusChecked = 'checked';
            }
            @endphp

            <x-admin.form.inputs.listing_checkbox id="list{{$item->id}}"
                onclick="changeDisplayStatus('{{$item->id}}','{{route('masters.company.association.update-status')}}')"
                dataItemId="{{$item->id}}" dataUrl="{{route('masters.company.association.update-status')}}"
                value="{{$item->id}}" checked="{{$displayStatusChecked}}" />
        </td>
        <td>
            @can('masters-company-association-edit')
            <x-admin.form.buttons.edit href="{{ route('masters.company.association.edit', $item->id) }}" />
            @endcan
            &nbsp;

            {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}

            @can('masters-company-association-delete')
            <x-admin.form.buttons.delete id="{{$item->id}}" name="{{$item->name}}"
                url="{{route('masters.company.association.delete')}}"
                action="{{route('masters.company.association.delete',$item->id)}}" />
            @endcan
        </td>
    </tr>