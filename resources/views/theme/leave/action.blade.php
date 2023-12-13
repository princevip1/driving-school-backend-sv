<div class="d-flex gap-1">
    @if ($row->status != 'approved' && $row->status != 'rejected')
        <a href="{{ route('leave.approve', $row->id) }}">
            <button class="btn btn-sm btn-label-primary">Approve</button>
        </a>
    @else
        <button class="btn btn-sm btn-label-primary" disabled>Approve</button>
    @endif

    @if ($row->status != 'approved' && $row->status != 'rejected')
        <a href="{{ route('leave.reject', $row->id) }}">
            <button class="btn btn-sm btn-label-danger">Reject</button>
        </a>
    @else
        <button class="btn btn-sm btn-label-danger" disabled>Reject</button>
    @endif






</div>
