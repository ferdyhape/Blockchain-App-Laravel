@component('components.containerTemplate', [
    'pageTitle' => 'Topup Saldo',
])

    @php
        $bankData = getBankTransferList();
    @endphp

    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Project', 'Topup Saldo']" />

        {{-- content --}}
        @component('components.contentSection')
            @slot('contentOfContentSection')
                <div id="action">
                    <form action="{{ route('dashboard.user.my-wallet.withdraw.post') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="card border-0 shadow-sm p-4 my-3">
                            <div class="card-content rounded">
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-semibold">Withdraw</h5>
                                    <a href="{{ route('dashboard.user.my-wallet.add-bank-account') }}"
                                        class="btn btn-primary btn-sm">Tambah Rekening Tujuan</a>
                                </div>

                                @if (count($wallets) >= 1)
                                    <div class="d-flex flex-column mb-3">
                                        <p>Pilih Bank Tujuan</p>
                                        @foreach ($wallets as $wallet)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment_method_detail_id"
                                                    id="radio-payment-{{ $wallet->id }}" value="{{ $wallet->id }}"
                                                    {{ $loop->first ? 'checked' : '' }}>
                                                <label class="form-check-label" for="radio-payment-{{ $wallet->id }}">
                                                    <div class="fw-semibold">
                                                        {{ $wallet->name }}
                                                    </div>
                                                    <div>
                                                        {{ $wallet->description }}
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- <p class="fw-bold">Saldo Wallet anda: {{ auth()->user()->wallet->balance }}
                                    </p> --}}
                                    {{-- make d-flex --}}
                                    <div class="d-flex gap-2">
                                        <p>Saldo Wallet anda:</p>
                                        <p class="fw-bold currency">{{ auth()->user()->wallet->balance }}</p>
                                    </div>
                                    <div class="d-flex flex-column gap-2">
                                        <x-input type="number" label="Nominal Withdraw" name="amount" required="true" id="amount"
                                            placeholder="Masukkan Nominal Withdraw" max="{{ auth()->user()->wallet->balance }}" />
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Withdraw</button>
                                @else
                                    <p>Anda tidak memiliki rekening untuk withdraw, silahkan tambah rekening tujuan
                                        terlebih
                                        dahulu</p>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            @endslot
        @endcomponent

        <x-errorAlertValidation />
        <x-ifSuccessAlert />
    @endslot


@endcomponent
