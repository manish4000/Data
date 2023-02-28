@foreach($items as $item)
    <ul style="list-style: none;">
        <li>
            <label class="form-check-label">
                <input class="form-check-input" value="{{ $item->id }}" type="checkbox" name="permissions[]" > {{ $item->name }}
            </label>
        </li>
        @if(count($item->child) > 0)
            @include('admin.roles.role_permission_child_list',['items' => $item->child ])
        @endif
    </ul>
@endforeach