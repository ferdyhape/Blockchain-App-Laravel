<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                    </div>

                    <div class="mb-3">
                        <label for="place_of_birth" class="form-label">Place of Birth</label>
                        <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" required>
                    </div>

                    <div class="mb-3">
                        <label for="province_id" class="form-label">Province ID</label>
                        <input type="text" class="form-control" id="province_id" name="province_id" required>
                    </div>

                    <div class="mb-3">
                        <label for="city_id" class="form-label">City ID</label>
                        <input type="text" class="form-control" id="city_id" name="city_id" required>
                    </div>

                    <div class="mb-3">
                        <label for="subdistrict_id" class="form-label">Subdistrict ID</label>
                        <input type="text" class="form-control" id="subdistrict_id" name="subdistrict_id" required>
                    </div>

                    <div class="mb-3">
                        <label for="address_detail" class="form-label">Address Detail</label>
                        <input type="text" class="form-control" id="address_detail" name="address_detail" required>
                    </div>

                    <div class="mb-3">
                        <label for="number_id" class="form-label">Number ID</label>
                        <input type="text" class="form-control" id="number_id" name="number_id" required>
                    </div>

                    <button type="button" class="btn btn-primary"
                        onclick="handleEditFormSubmit('{{ route('dashboard.admin.user-management.update', 'defaultId') }}')">Save
                        changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
