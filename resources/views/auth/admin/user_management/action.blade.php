<div class="d-flex justify-content-around">
    <button type="button" class="btn btn-pill btn-outline-warning btn-air-warning p-2 btn-sm edit-modal"
        data-id="{{ $model->id }}">
        <i class="fa fa-pencil mx-auto my-auto"></i>
    </button>
    <button type="button" class="btn btn-pill btn-outline-danger btn-air-danger p-2 btn-sm delete-modal"
        data-id="{{ $model->id }}"
        onclick="deleteData('{{ route('dashboard.admin.user-management.destroy', $model->id) }}', '{{ csrf_token() }}')">
        <i class="fa fa-trash mx-auto my-auto"></i>
    </button>
</div>
