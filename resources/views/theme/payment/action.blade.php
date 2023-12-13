<div class="d-flex gap-1">
    <a href="{{ route('payment.payment.view', $row->id) }}">
        <button class="btn btn-sm btn-label-primary">View</button>
    </a>
    <button class="btn btn-sm btn-label-danger" disabled>Send</button>
</div>
