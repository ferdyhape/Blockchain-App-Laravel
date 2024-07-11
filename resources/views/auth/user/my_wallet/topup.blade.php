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
                <div class="my-5" id="payment-methods">
                    {{-- input amount --}}
                    <x-input type="number" label="Nominal topup" name="amount" required="true" id="amount" placeholder="Nominal topup" />

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
            @endslot
        @endcomponent

        @push('custom-scripts')
            <script>
                $(document).ready(function() {
                    let getPaymentMethodDetailUrl = "{{ route('get-payment-methods-details-for-buy-token') }}";
                    let routeTopup = "{{ route('dashboard.user.my-wallet.topup') }}";

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

                        console.log("Selected payment method detail ID:", paymentMethodId);
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
@endcomponent
