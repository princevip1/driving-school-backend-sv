<div class="d-flex gap-1">
    <a href="{{ route('teacher.edit', $row->id) }}">
        <button class="btn btn-sm btn-label-primary">Edit</button>
    </a>
    <a href="{{ route('teacher.delete', $row->id) }}">
        <button class="btn btn-sm btn-label-danger">Delete</button>
    </a>
</div>
