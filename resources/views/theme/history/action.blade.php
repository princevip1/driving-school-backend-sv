<div class="d-flex gap-1">
    <a href="{{ route('history.edit', $row->id) }}">
        <button class="btn btn-sm btn-label-primary">Edit</button>
    </a>
    <a href="{{ route('history.delete', $row->id) }}">
        <button class="btn btn-sm btn-label-danger">Delete</button>
    </a>
</div>
