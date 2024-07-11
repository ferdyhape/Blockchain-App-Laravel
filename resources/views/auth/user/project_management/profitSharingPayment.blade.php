<x-containerTemplate pageTitle="Profit Sharing Payment">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Available Project', 'Profit Sharing Payment']" />

        <x-contentSection>
            <x-slot name="contentOfContentSection">

                <div class="d-flex flex-column gap-3">

                    @if ($project->campaign->status == 'closed')
                        {{-- Alert reminder untuk pengingat saatnya topup profit_sharing_payment --}}
                        <div class="alert alert-warning" role="alert" id="alert-profit-sharing">
                            <p>
                                Proyek ini telah selesai, silahkan melakukan topup pembayaran profit sharing, sesuai
                                dengan ketentuan di awal pengajuan proyek, maka total pembayaran yang harus dilakukan
                                dengan rincian sebagai berikut:
                            </p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Presentase Bagi Hasil</td>
                                        <td>{{ $project->profit_sharing_percentage }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Harga Per Token</td>
                                        <td class="currency">{{ $project->campaign->price_per_unit }}</td>
                                    </tr>

                                    <tr>
                                        <td>Jumlah Token Terbeli</td>
                                        <td>{{ $project->campaign->sold_token_amount }}</td>
                                    </tr>

                                </tbody>
                            </table>

                            <p>
                                Berdasar keterangan diatas, maka kalkulasinya adalah sebagai berikut
                            </p>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>Kalkulasi</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Seluruh Harga Token (Harga Per Token x Jumlah Token Terbeli)</td>
                                        <td class=>
                                            <span class="currency">{{ $project->campaign->price_per_unit }}</span> x
                                            {{ $project->campaign->sold_token_amount }}

                                        </td>
                                        <td class="currency">
                                            {{ $project->campaign->price_per_unit * $project->campaign->sold_token_amount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Rupiah Bagi Hasil (Presentase Bagi Hasil x Seluruh Harga Token)
                                        </td>
                                        <td>
                                            <span>{{ $project->profit_sharing_percentage }}%</span> x
                                            <span
                                                class="currency">{{ $project->campaign->price_per_unit * $project->campaign->sold_token_amount }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="currency">{{ ($project->campaign->price_per_unit * $project->campaign->sold_token_amount * $project->profit_sharing_percentage) / 100 }}</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Rupiah yang perlu dikembalikan (Seluruh Harga Token + Jumlah Bagi Hasil)
                                        </td>
                                        <td>
                                            <span
                                                class="currency">{{ $project->campaign->price_per_unit * $project->campaign->sold_token_amount }}</span>
                                            +
                                            <span
                                                class="currency">{{ ($project->campaign->price_per_unit * $project->campaign->sold_token_amount * $project->profit_sharing_percentage) / 100 }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="currency">{{ $project->campaign->price_per_unit * $project->campaign->sold_token_amount +
                                                    ($project->campaign->price_per_unit * $project->campaign->sold_token_amount * $project->profit_sharing_percentage) /
                                                        100 }}</span>
                                        </td>
                                    </tr>
                                </tbody>


                            </table>

                            <p>
                                Berdasar kalkulasi diatas, berikut yang harus dibayarkan
                            </p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Rupiah yang harus dibayar</td>
                                        <td class="currency">
                                            {{ $project->campaign->price_per_unit * $project->campaign->sold_token_amount +
                                                ($project->campaign->price_per_unit * $project->campaign->sold_token_amount * $project->profit_sharing_percentage) /
                                                    100 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Uang yang masih ada dalam wallet proyek</td>
                                        <td class="currency">
                                            {{ $project->campaign->wallet->balance }}
                                        </td>
                                    </tr>



                                    <tr class="fw-bold">
                                        <td>Total yang harus dibayarkan</td>
                                        <td class="currency">
                                            {{ $project->campaign->price_per_unit * $project->campaign->sold_token_amount +
                                                ($project->campaign->price_per_unit * $project->campaign->sold_token_amount * $project->profit_sharing_percentage) /
                                                    100 -
                                                $project->campaign->wallet->balance }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>
                                Silahkan memilih metode pembayaran dibawah ini dan lakukan pembayaran dengan nominal
                                <span class="fw-bold currency">
                                    {{ $project->campaign->price_per_unit * $project->campaign->sold_token_amount +
                                        ($project->campaign->price_per_unit * $project->campaign->sold_token_amount * $project->profit_sharing_percentage) /
                                            100 -
                                        $project->campaign->wallet->balance }}
                                </span>

                            </p>
                        </div>

                        <div class="fw-semibold">Pilih Metode Pembayaran</div>
                        <div class="d-flex my-3 gap-2">
                            @foreach ($paymentMethods as $paymentMethod)
                                <div class="col-md-4 col-lg-3 col-sm-6">
                                    <label>
                                        <input type="radio" name="paymentMethod" value="{{ $paymentMethod->id }}"
                                            class="card-input-element" />
                                        <div class="card card-default text-center p-2 card-input dashed-border border">
                                            {{ $paymentMethod->name }}
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        {{-- this div will deisplay detail if detail exist on paymentMethod->details --}}
                        <div class="accordion my-3" id="paymentMethodDetailAccordion">
                            <!-- Accordion content will be injected here -->
                        </div>

                        <style>
                            label {
                                width: 100%;
                            }

                            .card-input-element {
                                display: none;
                            }

                            .card-input:hover {
                                cursor: pointer;
                            }

                            .card-input-element:checked+.card-input {
                                box-shadow: 0 0 2px 2px #2ecc71;
                            }
                        </style>
                    @endif
                    <hr>
                </div>

            </x-slot>

        </x-contentSection>
        @push('custom-scripts')
            <script>
                $(document).ready(function() {
                    let getPaymentMethodDetailUrl = "{{ route('get-payment-methods-details-for-buy-token') }}";
                    let routeTopup =
                        "{{ route('dashboard.user.project-management.profit-sharing-payment.post', $project->id) }}";

                    $('input[name="paymentMethod"]').change(function() {
                        let paymentMethodId = $(this).val();
                        console.log("Selected payment method ID:", paymentMethodId);
                        $.ajax({
                            url: getPaymentMethodDetailUrl,
                            type: "GET",
                            data: {
                                paymentMethodId: paymentMethodId,
                            },
                            success: function(response) {
                                let accordionContent = $("#paymentMethodDetailAccordion");
                                accordionContent.empty();
                                if (response.data.length > 0) {
                                    let content = response.data
                                        .map(
                                            (detail, index) => `
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading${index}">
                                                    <button class="accordion-button ${
                                                        index !== 0
                                                            ? "collapsed"
                                                            : ""
                                                    }" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="${
                                    index === 0
                                }" aria-controls="collapse${index}">
                                                        ${detail.name}
                                                    </button>
                                                </h2>
                                                <div id="collapse${index}" class="accordion-collapse collapse ${
                                    index === 0 ? "show" : ""
                                }" aria-labelledby="heading${index}" data-bs-parent="#paymentMethodDetailAccordion">
                                                    <div class="accordion-body px-5 d-flex flex-column">
                                                        <p class="">
                                                            ${detail.description}
                                                        </p>
                                                        <button class="btn btn-primary mt-2 select-payment-method-detail"
                                                            data-payment-method-id="${
                                                                detail.id
                                                            }">Pilih</button>
                                                    </div>
                                                </div>
                                            </div>
                                        `
                                        )
                                        .join("");
                                    accordionContent.html(content).show();
                                } else {
                                    accordionContent.hide();
                                }
                            },
                            error: function(error) {
                                $("#paymentMethodDetailAccordion")
                                    .html("<p>Error fetching payment method details</p>")
                                    .show();
                            },
                        });
                    });

                    $(document).on("click", ".select-payment-method-detail", function() {
                        let paymentMethodId = $(this).data("payment-method-id");
                        let amount = $("#amount").val();

                        $.ajax({
                            url: routeTopup,
                            type: "POST",
                            data: {
                                amount: amount,
                                payment_method_detail_id: paymentMethodId,
                            },
                            success: function(response) {
                                console.log(response);
                                window.location.href = response.redirect;
                            },
                            error: function(error) {
                                console.log(error.responseJSON.message);
                                showAlert(error.responseJSON.message, "error");
                            },
                        });
                    });
                });
            </script>
        @endpush
        <x-errorAlertValidation />
        <x-ifSuccessAlert />
    @endslot
</x-containerTemplate>
