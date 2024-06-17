<x-containerTemplate pageTitle="Show Token">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Token', 'Show Token']" />

        <x-contentSection>
            @slot('contentOfContentSection')
                <div class="d-flex flex-column gap-3">

                    <div id="campaign-detail">
                        <h5 class="fw-semibold">Project Detail</h5>
                        <div class="card border-0 shadow-sm p-4 my-3">
                            <div class="card-content rounded">
                                <table class="w-100" style="">
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Judul Proyek
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $campaign->project->title }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Proyek Owner
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $campaign->project->user->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Proyek Kategori
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $campaign->project->category->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Nominal Dibutuhkan
                                        </td>
                                        <td class="text-start fw-semibold currency">
                                            {{ $campaign->project->campaign->approved_amount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Jumlah Koin Ditawarkan
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $campaign->project->campaign->offered_token_amount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Harga Per Token Sekarang
                                        </td>
                                        <td class="text-start fw-semibold currency">
                                            {{ $campaign->project->campaign->price_per_unit }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Minimal Beli
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $campaign->project->campaign->minimum_purchase }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start text-secondary">
                                            Maksimal Beli
                                        </td>
                                        <td class="text-start fw-semibold">
                                            {{ $campaign->project->campaign->maximum_purchase }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="table-token">
                        <h5 class="fw-semibold">Token Dimiliki</h5>
                        <table class="table my-3 ">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 20px">No</th>
                                    <th scope="col">Token</th>
                                    <th scope="col">Kode Transaksi</th>
                                    <th scope="col">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tokens as $token)
                                    <tr>
                                        <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                        <td>{{ $token->token }}</td>
                                        <td>{{ $token->transaction_code }}</td>
                                        <td class="currency">{{ $token->campaign->price_per_unit }}</td>
                                    </tr>
                                @endforeach
                                <tr class="fw-semibold">
                                    <td colspan="3" class="text-center">Total</td>
                                    <td class="currency">
                                        {{ $campaign->user_token_count * $campaign->price_per_unit }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div id="sell-token">
                        <h5>Sell Action</h5>
                        <div class="card border-0 shadow-sm p-4 my-3">

                            <form action="{{ route('dashboard.user.token.sell', $campaign->id) }}" method="POST">
                                @method('POST')
                                @csrf
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex flex-row gap-3">
                                        <button type="button" class="btn btn-danger" id="decrement">-</button>
                                        <input type="number" name="quantity" class="form-control text-center" id="quantity"
                                            value="1" min="1" max="{{ $tokens->count() }}">
                                        <button type="button" class="btn btn-success" id="increment">+</button>
                                    </div>
                                    <div class="p">
                                        Nominal dalam rupiah: <span id="total" class="fw-semibold currency">
                                            {{ $tokens->first()->campaign->price_per_unit }}
                                    </div>
                                    <button type="submit" class="btn btn-success">Selanjutnya</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endslot
        </x-contentSection>

        <x-errorAlertValidation />
        <x-ifSuccessAlert />


        @push('custom-scripts')
            <script>
                $(document).ready(function() {
                    let tokenPrice = {{ $tokens->first()->campaign->price_per_unit }};
                    let tokenCount = {{ $tokens->count() }};
                    let quantity = 1;
                    // handle increment and decrement with auto add currency class
                    $('#increment').click(function() {
                        if (quantity < tokenCount) {
                            quantity++;
                            $('#quantity').val(quantity);
                            $('#total').text((tokenPrice * quantity).toLocaleString('id-ID'));
                        }
                    });

                    $('#decrement').click(function() {
                        if (quantity > 1) {
                            quantity--;
                            $('#quantity').val(quantity);
                            $('#total').text((tokenPrice * quantity).toLocaleString('id-ID'));
                        }
                    });

                    $('#quantity').change(function() {
                        quantity = $(this).val();
                        $('#total').text((tokenPrice * quantity).toLocaleString('id-ID'));
                    });
                });
            </script>
        @endpush
    @endslot
</x-containerTemplate>
