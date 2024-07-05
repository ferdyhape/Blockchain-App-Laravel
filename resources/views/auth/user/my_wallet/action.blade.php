<div class="d-flex justify-content-center gap-2">
    @if ($model->status == 'pending' && $model->payment_proof == null)
        <button type="button" class="btn btn-sm btn-warning edit-modal" data-id="{{ $model->id }}">
            Upload Proof
        </button>
    @else
        {{-- no action needed --}}
        <div class="btn btn-sm btn-success">No Action Needed</div>
    @endif
</div>
