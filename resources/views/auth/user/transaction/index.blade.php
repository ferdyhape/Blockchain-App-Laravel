<x-containerTemplate pageTitle="Transaction">

    <x-slot name="contentOfContainer">

        <x-headerSection :breadcrumbMenu="['Transaction']">
            @slot('headerContent')
                <div class="d-flex gap-2 align-items-center">
                    {{-- <a href="{{ route('dashboard.user.project-management.create') }}" class="btn btn-sm btn-primary">Create Project</a> --}}
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
                <div class="row gy-3">
                    @foreach ($transactions as $transaction)
                        <div class="col-md-12 col-lg-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="fw-semibold">
                                        {{ $transaction->transaction_code }}
                                    </div>
                                    @if ($transaction->status == 'pending')
                                        <div class="btn btn-sm btn-warning text-uppercase">{{ $transaction->status }}</div>
                                    @elseif ($transaction->status == 'success')
                                        <div class="btn btn-sm btn-success text-uppercase">{{ $transaction->status }}</div>
                                    @else
                                        <div class="btn btn-sm btn-danger text-uppercase">{{ $transaction->status }}</div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <table class="w-100">
                                        <tr>
                                            <td class="text-start text-secondary">
                                                Judul Proyek
                                            </td>
                                            <td class="text-end">
                                                {{ $transaction->campaign_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-start text-secondary">
                                                Total pembelian
                                            </td>
                                            <td class="text-end">
                                                {{ $transaction->transactionDetails->count() }} Token
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-start text-secondary">
                                                Total yang harus dibayar
                                            </td>
                                            <td class="text-end currency">
                                                {{ $transaction->total_price }}
                                            </td>
                                        </tr>
                                    </table>

                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('dashboard.user.transaction.show', $transaction->transaction_code) }}"
                                            class="btn btn-primary btn-sm mt-3">{{ $transaction->payment_proof == null ? 'Bayar Sekarang' : 'Lihat Detail' }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endslot
        </x-contentSection>

        <x-errorAlertValidation />
        <x-ifSuccessAlert />
    </x-slot>

</x-containerTemplate>
