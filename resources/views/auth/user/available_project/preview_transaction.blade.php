<x-containerTemplate pageTitle="Project">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Available Project', 'Buy Project', 'Preview Transaction']" />

        <x-contentSection>
            @slot('contentOfContentSection')
                <h5 class="fw-semibold">Detail Transaksi</h5>
                <div class="card border-0 shadow-sm p-4 my-3">
                    <div class="card-content rounded">
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
                                    Jumlah Koin Dibeli
                                </td>
                                <td class="text-start fw-semibold">
                                    {{ $quantityBuy }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Total Harga
                                </td>
                                <td class="text-start fw-semibold currency">
                                    {{ $totalPrice }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="my-5" id="payment-methods">
                    <h5 class="fw-semibold">Pilih Metode Pembayaran</h5>
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
        </x-contentSection>

        @if (session('success'))
            @push('custom-scripts')
                <script>
                    showAlert('{{ session('success') }}', "success");
                </script>
            @endpush
        @endif

        @push('custom-scripts')
            <script>
                $(document).ready(function() {
                    // If a payment method radio button is selected, show the details in the div
                    $('input[name="paymentMethod"]').change(function() {
                        let paymentMethodId = $(this).val();
                        $.ajax({
                            url: "{{ route('get-payment-methods-details') }}",
                            type: "GET",
                            data: {
                                paymentMethodId: paymentMethodId
                            },
                            success: function(response) {
                                let accordionContent = $('#paymentMethodDetailAccordion');
                                accordionContent.empty();
                                if (response.data.length > 0) {
                                    let content = response.data.map((detail, index) => `
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading${index}">
                                                <button class="accordion-button ${index !== 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="${index === 0}" aria-controls="collapse${index}">
                                                    ${detail.name}
                                                </button>
                                            </h2>
                                            <div id="collapse${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading${index}" data-bs-parent="#paymentMethodDetailAccordion">
                                                <div class="accordion-body px-5 d-flex flex-column">
                                                    <p class="">
                                                        ${detail.description}
                                                    </p>
                                                    <button class="btn btn-primary mt-2 select-payment-method"
                                                        data-payment-method-id="${detail.id}">Pilih</button>
                                                </div>
                                            </div>
                                        </div>
                                    `).join('');
                                    accordionContent.html(content).show();
                                } else {
                                    accordionContent.hide();
                                }
                            },
                            error: function(error) {
                                $('#paymentMethodDetailAccordion').html(
                                    '<p>Error fetching payment method details</p>').show();
                            }
                        });
                    });

                    $(document).on('click', '.select-payment-method', function() {
                        let paymentMethodId = $(this).data('payment-method-id');
                        // Perform further actions here, like submitting the selected payment method ID
                        // through another AJAX request or form submission.
                        // console.log('Selected payment method ID:', paymentMethodId);
                        console.log([
                            'payment method ID: ' + paymentMethodId,
                            'project ID: ' + '{{ $project->id }}',
                            'quantity buy: ' + '{{ $quantityBuy }}',
                        ])
                        // Example: You can submit the selected payment method ID through AJAX here.
                    });
                });
            </script>
        @endpush

    @endslot
</x-containerTemplate>
