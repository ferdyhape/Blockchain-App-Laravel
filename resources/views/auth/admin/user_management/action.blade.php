<div class="d-flex justify-content-center gap-2">
    @if ($model->email_verified_at == null)
        <button type="button" class="btn btn-pill btn-outline-success btn-air-success p-2 btn-sm accept-modal"
            data-id="{{ $model->id }}">
            <i class="fa fa-check mx-auto my-auto"></i>
        </button>
        <button type="button" class="btn btn-pill btn-outline-danger btn-air-danger p-2 btn-sm reject-modal"
            data-id="{{ $model->id }}">
            <i class="fa fa-times mx-auto my-auto"></i>
        </button>
    @else
        <button type="button" class="btn btn-pill btn-outline-warning btn-air-warning p-2 btn-sm edit-modal"
            data-id="{{ $model->id }}">
            <i class="fa fa-pencil mx-auto my-auto"></i>
        </button>
        <button type="button" class="btn btn-pill btn-outline-danger btn-air-danger p-2 btn-sm delete-modal"
            data-id="{{ $model->id }}"
            onclick="deleteData('{{ route('dashboard.admin.user-management.destroy', $model->id) }}', '{{ csrf_token() }}')">
            <i class="fa fa-trash mx-auto my-auto"></i>
        </button>
    @endif
</div>
