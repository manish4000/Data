@foreach($items as $item)
    <ul>
        <li>
            <a href="{{ route('menu.edit', $item->id) }}">{{ $item->title }}</a>
        </li>
        @if(count($item->child) > 0)
            @include('admin.menu.menu_child_list',['items' => $item->child])
        @endif
    </ul>
@endforeach