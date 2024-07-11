@component('components.containerTemplate', [
    'pageTitle' => 'Add Bank Account',
])

    @php
        $bankData = getBankTransferList();
    @endphp

    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Add Bank Account']" />

        {{-- content --}}
        @component('components.contentSection')
            @slot('contentOfContentSection')
                <form action="{{ route('dashboard.user.my-wallet.add-bank-account.post') }}" method="POST">
                    @csrf
                    @method('POST')

                    <x-input type="select" label="Nama Bank" name="bank_name" required="true" id="bank_name">
                        <option selected disabled>-- Pilih Bank --</option>
                        @foreach ($bankData as $bank)
                            <option value="{{ $bank }}">{{ $bank }}</option>
                        @endforeach
                    </x-input>
                    <x-input type="number" label="Nomor Rekening" name="account_number" required="true" id="account_number"
                        placeholder="Nomor Rekening" />

                    <x-input type="text" label="Atas Nama" name="account_name" required="true" id="account_name"
                        placeholder="Atas Nama" />


                    <button type="submit" class="btn btn-primary mb-5 w-100">Submit</button>
                </form>
            @endslot
        @endcomponent
    @endslot

    <x-errorAlertValidation />
    <x-ifSuccessAlert />

@endcomponent
