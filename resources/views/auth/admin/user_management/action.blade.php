<div class="d-flex justify-content-around">
    <a href="{{ route('dashboard.admin.user-management.edit', $model->id) }}"
        class="btn btn-pill btn-outline-warning btn-air-warning btn-sm me-2 py-1 px-2">
        <i class="fa fa-pencil"></i>
    </a>
    <a href="{{ route('dashboard.admin.user-management.destroy', $model->id) }}"
        class="btn btn-pill btn-outline-danger btn-air-danger btn-sm me-2 py-1 px-2">
        <i class="fa fa-trash"></i>
    </a>
</div>
