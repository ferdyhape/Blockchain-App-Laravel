<x-containerTemplate pageTitle="My Wallet">

    <x-slot name="contentOfContainer">

        <x-headerSection :breadcrumbMenu="['My Wallet']">
            @slot('headerContent')
                <div class="d-flex gap-2 align-items-center">
                    <a href="{{ route('dashboard.user.my-wallet.create') }}" class="btn btn-sm btn-primary">Add Wallet</a>
                    <div class="my-auto">
                        <select class="form-select my-auto form-select-sm" aria-label="Default select example">
                            <option value="1">All</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
            @endslot
        </x-headerSection>

        <x-contentSection>
            @slot('contentOfContentSection')
                <div class="row">
                    {{ $wallets }}
                </div>
            @endslot
        </x-contentSection>

        <x-errorAlertValidation />
        <x-ifSuccessAlert />
    </x-slot>

</x-containerTemplate>
