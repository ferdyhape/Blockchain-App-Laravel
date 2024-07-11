<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Upload Proof</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Payment Proof</label>
                        <input type="file" class="form-control" id="payment_proof" name="payment_proof" required>
                    </div>

                    <button type="button" class="btn btn-primary"
                        onclick="handleEditFormSubmitUseFile('{{ route('dashboard.admin.wallet-transaction.upload-proof', 'defaultId') }}')">Save
                        changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
