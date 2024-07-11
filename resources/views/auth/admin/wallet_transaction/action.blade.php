<div class="d-flex justify-content-center gap-2">
    @if ($model->payment_proof != null && $model->status == 'pending')
        <button type="button" class="btn btn-pill btn-outline-success btn-air-success p-2 btn-sm accept-modal"
            data-id="{{ $model->id }}">
            <i class="fa fa-check mx-auto my-auto"></i>
        </button>
        <button type="button" class="btn btn-pill btn-outline-danger btn-air-danger p-2 btn-sm reject-modal"
            data-id="{{ $model->id }}">
            <i class="fa fa-times mx-auto my-auto"></i>
        </button>
    @elseif(
        $model->status == 'pending' &&
            $model->payment_proof == null &&
            ($model->type == 'withdraw_campaign' || $model->type == 'withdraw'))
        <button type="button" class="btn btn-sm btn-warning edit-modal" data-id="{{ $model->id }}">
            Upload Proof
        </button>
    @else
        <div class="btn btn-sm btn-success">No Action Needed</div>
    @endif
</div>
