<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="storeForm" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <x-input label="Name" name="name" id="name" type="text" placeholder="Name" />
                    <x-input label="Payment Method Category" name="payment_method_category_id"
                        id="payment_method_category_id" type="select">
                        @foreach ($paymentMethodCategories as $paymentMethodCategory)
                            <option value="{{ $paymentMethodCategory->id }}">
                                {{ $paymentMethodCategory->name }}
                            </option>
                        @endforeach
                    </x-input>
                    <x-input label="Description" name="description" id="description" type="textarea"
                        placeholder="Description" :usingScript="false" />

                    <x-input label="Logo" name="logo" id="logo" type="file" placeholder="Logo" />

                    <button type="button" class="btn btn-primary"
                        onclick="handleStoreFormSubmitUseFile('{{ route('dashboard.admin.payment-method.store') }}')">Save
                        changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
