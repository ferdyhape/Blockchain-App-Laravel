<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="payment_method_category_id" class="form-label">Payment Method Category</label>
                        <select class="form-select" id="payment_method_category_id" name="payment_method_category_id"
                            required>
                            @foreach ($paymentMethodCategories as $paymentMethodCategory)
                                <option value="{{ $paymentMethodCategory->id }}">
                                    {{ $paymentMethodCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="editDescription" required></textarea>
                    </div>

                    <x-input label="Logo" name="logo" id="logo" type="file" placeholder="Logo" />

                    <button type="button" class="btn btn-primary"
                        onclick="handleEditFormSubmitUseFile('{{ route('dashboard.admin.payment-method.update', 'defaultId') }}')">Save
                        changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        customEditModalCheck = true;

    });

    function customEditModalFunc(response) {
        $('#payment_method_category_id').val(response.payment_method.id).change();
        changeTextAreaToCKEditor('editDescription', {
            'editDescription': response.description
        });
    }
</script>
