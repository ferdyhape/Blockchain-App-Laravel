<div class="d-flex justify-content-around">
    <button type="button" class="btn btn-pill btn-outline-warning btn-air-warning p-2 btn-sm edit-modal"
        data-id="{{ $model->id }}">
        <i class="fa fa-pencil mx-auto my-auto"></i>
    </button>
    <a href="{{ route('dashboard.admin.user-management.destroy', $model->id) }}"
        class="btn btn-pill btn-outline-danger btn-air-danger btn-sm me-2 py-1 px-2">
        <i class="fa fa-trash"></i>
    </a>
</div>
