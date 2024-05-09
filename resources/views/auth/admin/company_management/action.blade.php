<div class="d-flex justify-content-around">

    <a href="{{ route('dashboard.admin.company-management.show', $model->id) }}"
        class="btn btn-pill btn-outline-info btn-air-info btn-sm me-2 py-1 px-2">
        <i class="fa fa-eye"></i>
    </a>
    {{-- <a href="{{ route('dashboard.admin.company-management.edit', $model->id) }}"
        class="btn btn-pill btn-outline-warning btn-air-warning btn-sm me-2 py-1 px-2">
        <i class="fa fa-pencil"></i>
    </a> --}}
    <a href="#" class="btn btn-pill btn-outline-warning btn-air-warning btn-sm me-2 py-1 px-2 edit-modal"
        data-id="{{ $model->id }}">
        <i class="fa fa-pencil"></i>
    </a>
    <a href="{{ route('dashboard.admin.company-management.destroy', $model->id) }}"
        class="btn btn-pill btn-outline-danger btn-air-danger btn-sm me-2 py-1 px-2">
        <i class="fa fa-trash"></i>
    </a>
</div>
