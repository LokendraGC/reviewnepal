<tr>
    <td>
        <span class="fw-600">{{ $category->name }}</span>
        <br />
        <div class="row-action">
            <span class="edit">
                <a href="{{ route('backend.category.restore', $category->id) }}" class="text-primary ">Restore</a>
                |
            </span>
            <span class="delete">
                <a href="{{ route('backend.category.delete.permanant', $category->id) }}"
                    onclick="return confirm('Are you sure you want to permanently delete?');"
                    class="text-danger">Permanently Delete</a>
            </span>
        </div>
    </td>
    <td>{{ $category->slug }}</td>
    <td>
        Deleted At
        <br>
        {{ \Carbon\Carbon::parse($category->deleted_at)->format('Y-m-d h:i a') }}
    </td>
</tr>
