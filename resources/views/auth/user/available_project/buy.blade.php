<x-containerTemplate pageTitle="Project">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Available Project', 'Buy Project']" />

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
                                            Harga Per Unit
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
                                            {{ $project->campaign->price_per_unit }}
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

        @if (session('success'))
            @push('custom-scripts')
                <script>
                    showAlert('{{ session('success') }}', "success");
                </script>
            @endpush
        @endif

        @push('custom-scripts')
            <script>
                // if document ready jquery
                $(document).ready(function() {
                    // get element
                    const decrement = document.getElementById('decrement');
                    const increment = document.getElementById('increment');
                    const quantity = document.getElementById('quantity');
                    const total = document.getElementById('total');

                    // add event listener
                    decrement.addEventListener('click', () => {
                        if (quantity.value > quantity.min) {
                            quantity.value = parseInt(quantity.value) - 1;
                            total.innerText = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(parseInt(quantity.value) * parseInt(
                                '{{ $project->campaign->price_per_unit }}'));
                        }
                    });

                    increment.addEventListener('click', () => {
                        if (quantity.value < quantity.max) {
                            quantity.value = parseInt(quantity.value) + 1;
                            total.innerText = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(parseInt(quantity.value) * parseInt(
                                '{{ $project->campaign->price_per_unit }}'));
                        }
                    });

                    quantity.addEventListener('change', () => {
                        total.innerText = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(parseInt(quantity.value) * parseInt(
                            '{{ $project->campaign->price_per_unit }}'));
                    });
                });
            </script>
        @endpush

    @endslot
</x-containerTemplate>
