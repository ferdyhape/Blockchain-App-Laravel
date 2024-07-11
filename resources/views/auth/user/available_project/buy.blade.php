<x-containerTemplate pageTitle="Buy Token">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Available Project', 'Buy Token']" />

        <x-contentSection>
            @slot('contentOfContentSection')
                <div class="d-flex flex-column gap-3">
                    <div class="col-12">


                        <h5>Preview Project</h5>
                        <div class="card border-0 shadow-sm p-4 my-3">
                            <div class="card-content rounded ">
                                <table class="w-100" style="">
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Nama Proyek
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $project->title }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Proyek Owner
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $project->user->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Proyek Kategori
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $project->category->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Nominal Dibutuhkan
                                        </td>
                                        <td class="text-start fw-semibold currency">
                                            {{ $project->campaign->approved_amount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Jumlah Koin Ditawarkan
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $project->campaign->offered_token_amount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Harga Per Token
                                        </td>
                                        <td class="text-start fw-semibold currency">
                                            {{ $project->campaign->price_per_unit }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Minimal Beli
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $project->campaign->minimum_purchase }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Maksimal Beli
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $project->campaign->maximum_purchase }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>

                    </div>

                    <div class="col-12">
                        <h5>Buy Action</h5>

                        <div class="card border-0 shadow-sm p-4 my-3">
                            <div class="d-flex gap-1 mb-2">
                                Saldo E-Wallet Anda:

                                <div class="currency fw-bold">
                                    {{ auth()->user()->wallet->balance }}
                                </div>
                            </div>
                            <form action="{{ route('dashboard.user.available-project.preview-transaction', $project->id) }}"
                                method="POST">
                                @method('POST')
                                @csrf
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex flex-row gap-3">
                                        <button type="button" class="btn btn-danger" id="decrement">-</button>
                                        <input type="number" name="quantity" class="form-control text-center" id="quantity"
                                            value="1" min="{{ $project->campaign->minimum_purchase }}"
                                            max="{{ $project->campaign->maximum_purchase }}">
                                        <button type="button" class="btn btn-success" id="increment">+</button>
                                    </div>
                                    <div class="p">
                                        Nominal dalam rupiah: <span id="total" class="fw-semibold currency">
                                            Rp. {{ number_format($project->campaign->price_per_unit, 2, ',', '.') }}
                                    </div>
                                    <button type="submit" class="btn btn-success">Selanjutnya</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            @endslot
        </x-contentSection>



        @push('custom-scripts')
            <script>
                $(document).ready(function() {
                    let pricePerUnit = {{ $project->campaign->price_per_unit }};
                    let minimumPurchase = {{ $project->campaign->minimum_purchase }};
                    let maximumPurchase = {{ $project->campaign->maximum_purchase }};
                    let quantity = $('#quantity').val();
                    let total = $('#total');

                    total.text(formatRupiah(pricePerUnit));

                    $('#increment').click(function() {
                        quantity = $('#quantity').val();
                        if (quantity < maximumPurchase) {
                            quantity++;
                            $('#quantity').val(quantity);
                            total.text(formatRupiah(pricePerUnit * quantity));
                        }
                    });

                    $('#decrement').click(function() {
                        quantity = $('#quantity').val();
                        if (quantity > minimumPurchase) {
                            quantity--;
                            $('#quantity').val(quantity);
                            total.text(formatRupiah(pricePerUnit * quantity));
                        }
                    });

                    $('#quantity').change(function() {
                        quantity = $('#quantity').val();
                        if (quantity < minimumPurchase) {
                            $('#quantity').val(minimumPurchase);
                            total.text(formatRupiah(pricePerUnit * minimumPurchase));
                        } else if (quantity > maximumPurchase) {
                            $('#quantity').val(maximumPurchase);
                            total.text(formatRupiah(pricePerUnit * maximumPurchase));
                        } else {
                            total.text(formatRupiah(pricePerUnit * quantity));
                        }
                    });
                });
            </script>
        @endpush


        <x-errorAlertValidation />
        <x-ifSuccessAlert />

        @if (session('error'))
            @push('custom-scripts')
                <script>
                    showAlert('{{ session('error') }}', "error");
                </script>
            @endpush
        @endif
    @endslot
</x-containerTemplate>
