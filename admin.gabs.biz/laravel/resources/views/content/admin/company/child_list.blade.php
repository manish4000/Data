@foreach($items as $item)
    <ul>
        @if(count($item->menuChild) > 0)
            <li class="jstree-open">
                <label class="form-check-label">
                    <input class="form-check-input" value="{{ $item->id }}" type="checkbox" name="permissions[]"  > {{ $item->title }}
                </label>
                @include('content.admin.company.child_list',['items' => $item->menuChild, 'user' => $user ])
            </li>
        @else
            <li>
                <label class="form-check-label">
                    <input class="form-check-input" value="{{ $item->id }}" type="checkbox" name="permissions[]"  > {{ $item->title }}
                </label>
            </li>
        @endif
    </ul>
@endforeach

