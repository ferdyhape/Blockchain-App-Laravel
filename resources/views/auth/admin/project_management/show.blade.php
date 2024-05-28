<x-containerTemplate pageTitle="Project">
    @slot('contentOfContainer')
        <x-headerSection breadcrumbMenu="Admin Project Management" breadcrumbCurrent="Show Project" />


        <x-contentSection>
            @slot('contentOfContentSection')
                <x-pillNavContainer id="pill-tab-project">
                    <x-pillNavContent id="pills-info-nav" active="true" target="pills-info-tab">
                        Project Information
                    </x-pillNavContent>
                    <x-pillNavContent id="pills-status-nav" target="pills-status-tab">
                        Project Submission Status
                    </x-pillNavContent>
                </x-pillNavContainer>

                <x-pillTabContainer id="pill-tab-project">
                    <x-pillTabContent active="true" id="pills-info-tab">

                        <div class="d-flex flex-column flex-lg-row gap-4">
                            {{-- card left project info --}}
                            <div class="card col-12 col-md-12 col-lg-8 border-0 shadow-sm p-4 my-3">
                                <div class="row gy-4">
                                    <div class="project-description">
                                        <h5 class="fw-semibold">Project Description </h5>
                                        <p class="text-muted">{!! $project->description !!}</p>
                                    </div>
                                    <div class="profit-sharing">
                                        <h5 class="fw-semibold">Profit Sharing</h5>
                                        <p class="text-muted">{!! $project->description_of_profit_sharing !!}</p>
                                    </div>
                                    <div class="income-statement-upload-every d-flex">
                                        <h5>Income Statement Upload Every: <span
                                                class="text-success fw-bold">{{ $project->income_statement_upload_every }}
                                                Bulan</span>
                                        </h5>
                                    </div>
                                    <div class="supporting-documents">
                                        <h5 class="fw-semibold">Supporting Documents</h5>
                                        <div class="row">
                                            @foreach ($project->getMedia('project_supporting_documents') as $media)
                                                <div class="col-6 col-md-4 col-lg-3">
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        <img src="{{ $media->getUrl() }}" class="img-fluid"
                                                            alt="supporting document">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- make for product catalog --}}
                                    <div class="product-catalog">
                                        <h5 class="fw-semibold">Product Catalog</h5>
                                        <div class="row">
                                            @foreach ($project->getMedia('project_product_catalog') as $media)
                                                <div class="col-6 col-md-4 col-lg-3">
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        <img src="{{ $media->getUrl() }}" class="img-fluid"
                                                            alt="product catalog">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- card right project info --}}
                            <x-rightCardShowProject :project="$project" isAdmin="true" />
                        </div>

                    </x-pillTabContent>
                    <x-pillTabContent id="pills-status-tab">
                        <div class="d-flex flex-column flex-lg-row gap-4">

                            {{-- card left project info --}}
                            <div class="card col-12 col-md-12 col-lg-8 border-0 shadow-sm p-4 my-3">
                                <h5 class="fw-semibold">
                                    Progress Status of Project Submission
                                </h5>
                                <hr>
                                <!-- Section: Timeline -->
                                <section class="ms-4 py-3">
                                    <ul class="timeline-with-icons">
                                        @foreach ($allCategoryStatus as $category)
                                            @php
                                                $progresses = $project->progressStatusOfProjectSubmission->where(
                                                    'category_project_submission_status_id',
                                                    $category->id,
                                                );
                                            @endphp

                                            <li class="timeline-item {{ sizeof($progresses) > 0 ? 'mb-4' : 'mb-5' }}">
                                                <span class="timeline-icon">
                                                    <i class="fas fa-rocket text-primary fa-sm fa-fw"></i>
                                                </span>

                                                <h5 class="fw-semibold">{{ $category->name }}</h5>

                                                @foreach ($progresses as $progress)
                                                    <hr class="w-25">
                                                    <p class="my-0 text-muted">{{ $progress->created_at->format('d F Y H:i') }}
                                                    </p>
                                                    <p class="my-0 text-muted fs-6 ">
                                                        {{ $progress->subCategoryProjectSubmission->notes }}
                                                    </p>
                                                    @if ($progress->note)
                                                        <p class="my-0 text-muted fs-6 ">
                                                            <span
                                                                class="text-danger fw-semibold">{{ $progress->categoryProjectSubmissionStatus->name == 'Ditolak' ? 'Alasan Penolakan' : 'Revisi' }}
                                                            </span>
                                                            {!! $progress->note !!}
                                                        </p>
                                                    @endif
                                                    @if ($progress->subCategoryProjectSubmission->name == 'revised')
                                                        <a href="{{ route('dashboard.admin.project-management.show', $project->id) }}"
                                                            class="btn btn-sm btn-primary mt-3">
                                                            Lihat Revisi
                                                        </a>
                                                    @endif
                                                @endforeach

                                            </li>
                                        @endforeach

                                    </ul>
                                </section>
                                <!-- Section: Timeline -->

                            </div>

                            {{-- card right project info --}}
                            <x-rightCardShowProject :project="$project" isAdmin="true" />
                        </div>
                    </x-pillTabContent>
                </x-pillTabContainer>
            @endslot
        </x-contentSection>


        {{-- REVISI --}}
        <x-inputModal modalTitle="Revisi" id="revisiProjectModal" method="POST"
            route="dashboard.admin.project-management.add-revision" buttonName="Save" routeParams="{{ $project->id }}">
            <x-slot name="input">
                <x-input label="Input revisi" name="revision_note" id="revision_note" type="textarea"
                    placeholder="Isi Revisi" />
            </x-slot>
        </x-inputModal>

        {{-- TOLAK --}}
        <x-inputModal modalTitle="Tolak Project" id="tolakProjectModal" method="POST"
            route="dashboard.admin.project-management.reject" buttonName="Tolak" routeParams="{{ $project->id }}">
            <x-slot name="input">
                <x-input label="Alasan Penolakan" name="rejection_note" id="rejection_note" type="textarea"
                    placeholder="Isi Alasan Penolakan" />
            </x-slot>
        </x-inputModal>


        {{-- TERIMA --}}
        <x-inputModal modalTitle="Terima Project" id="terimaProjectModal" method="POST"
            route="dashboard.admin.project-management.accept" buttonName="Terima" routeParams="{{ $project->id }}">
            <x-slot name="input">
                <p>Apakah anda yakin ingin menerima project <span class="fw-bold">{{ $project->title }}</span>?</p>
            </x-slot>
        </x-inputModal>

        {{-- TERIMA REVISI --}}
        <x-inputModal modalTitle="Terima Revisi" id="terimaRevisiProjectModal" method="POST"
            route="dashboard.admin.project-management.accept-revision" buttonName="Terima Revisi"
            routeParams="{{ $project->id }}">
            <x-slot name="input">
                <p>Apakah anda yakin ingin menerima project <span class="fw-bold">{{ $project->title }}</span>?</p>
            </x-slot>
        </x-inputModal>


        {{-- APPROVE COMITTE --}}
        <x-inputModal modalTitle="Approve Dari Committee" id="approveProjectModal" method="POST"
            route="dashboard.admin.project-management.approve-committee" buttonName="Approve"
            routeParams="{{ $project->id }}">
            <x-slot name="input">
                <x-input label="Nominal Disetujui" name="approved_amount" id="approved_amount" type="number"
                    placeholder="Isi Nominal Disetujui" />
                <x-input label="Jumlah Token yang Ditawarkan" name="offered_token_amount" id="offered_token_amount"
                    type="number" placeholder="Isi Jumlah Token yang Ditawarkan" />
                <x-input label="Harga Per Unit" name="price_per_unit" id="price_per_unit" type="number"
                    placeholder="Harga Per Unit" disabled />
                <x-input label="Pembelian Minimum" name="minimum_purchase" id="minimum_purchase" type="number"
                    placeholder="Isi Pembelian Minimum" />
                <x-input label="Pembelian Maksimum" name="maximum_purchase" id="maximum_purchase" type="number"
                    placeholder="Isi Pembelian Maksimum" />
            </x-slot>
        </x-inputModal>

        {{-- REJECT COMITTE --}}
        <x-inputModal modalTitle="Reject Dari Committee" id="rejectProjectModal" method="POST"
            route="dashboard.admin.project-management.reject-committee" buttonName="Reject"
            routeParams="{{ $project->id }}">
            <x-slot name="input">
                <x-input label="Alasan Penolakan" name="rejection_comittee_note" id="rejection_comittee_note"
                    type="textarea" placeholder="Isi Alasan Penolakan" />
            </x-slot>
        </x-inputModal>


        @if ($project->campaign)
            {{-- TERIMA KONTRAK --}}
            <x-inputModal modalTitle="Acc Kontrak" id="terimaContractProjectModal" method="POST"
                route="dashboard.admin.project-management.accept-contract" buttonName="Acc Kontrak"
                routeParams="{{ $project->id }}">
                <x-slot name="input">
                    <div class="card-content">
                        <div class="mb-4">
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
                                        Nominal Disetujui
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
                    <x-input label="Periode Penggalangan Dimulai" name="fundraising_period_start"
                        id="fundraising_period_start" type="date" placeholder="Isi Periode Penggalangan Dimulai"
                        required="true" />
                    <x-input label="Periode Penggalangan Berakhir" name="fundraising_period_end"
                        id="fundraising_period_end" type="date" placeholder="Isi Periode Penggalangan Berakhir"
                        required="true" />
                </x-slot>
            </x-inputModal>
        @endif


        {{-- make script for auto calculate price_per_unit --}}
        @push('custom-scripts')
            <script>
                $(document).ready(function() {
                    $('#approved_amount, #offered_token_amount').on('input', function() {
                        let approvedAmount = parseFloat($('#approved_amount').val());
                        let offeredTokenAmount = parseFloat($('#offered_token_amount').val());
                        let pricePerUnit = '';

                        if (!isNaN(approvedAmount) && !isNaN(offeredTokenAmount) && approvedAmount > 0 &&
                            offeredTokenAmount > 0) {
                            pricePerUnit = (approvedAmount / offeredTokenAmount).toFixed(2);
                        }

                        $('#price_per_unit').val(pricePerUnit);
                    });
                });
            </script>
        @endpush

        @if (session('success'))
            @push('custom-scripts')
                <script>
                    showAlert('{{ session('success') }}', "success");
                </script>
            @endpush
        @endif

        @if ($errors->any())
            @push('custom-scripts')
                <script>
                    @foreach ($errors->all() as $error)
                        showAlert('{{ $error }}', "error");
                    @endforeach
                </script>
            @endpush
        @endif
    @endslot
</x-containerTemplate>
