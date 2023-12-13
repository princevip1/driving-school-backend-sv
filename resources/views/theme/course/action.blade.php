<div class="d-flex gap-1">
    <a href="{{ route('course.edit', $row->id) }}">
        <button class="btn btn-sm btn-label-primary">Edit</button>
    </a>
    <a href="{{ route('course.delete', $row->id) }}">
        <button class="btn btn-sm btn-label-danger">Delete</button>
    </a>
</div>
