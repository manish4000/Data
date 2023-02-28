@foreach($items as $item)
    <ul style="list-style: none;">
        <li>
            <label class="form-check-label">
                <input class="form-check-input" value="{{ $item->id }}" type="checkbox" name="permissions[]" <?php if ($user->can($item->slug)) echo 'checked'; ?> > {{ $item->name }}
            </label>
        </li>
        @if(count($item->child) > 0)
            @include('admin.permission_child_list',['items' => $item->child, 'user' => $user ])
        @endif
    </ul>
@endforeach