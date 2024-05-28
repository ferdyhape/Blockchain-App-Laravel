<x-containerTemplate pageTitle="Project">
    @slot('contentOfContainer')
        <x-headerSection breadcrumbMenu="User Project Management" breadcrumbCurrent="Show Project" />

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
                            <x-rightCardShowProject :project="$project" />
                        </div>

                    </x-pillTabContent>
                    <x-pillTabContent id="pills-status-tab">
                        <div class="d-flex flex-column flex-lg-row gap-4">

                            {{-- card left project info --}}
                            <div class="card col-12 col-md-12 col-lg-8 border-0 shadow-sm p-4 my-3">
                                <h5 class="fw-semibold">Progress Status of Project Submission</h5>
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

                                            <li class="timeline-item {{ $progresses->isNotEmpty() ? 'mb-4' : 'mb-5' }}">
                                                <span class="timeline-icon">
                                                    <i class="fas {{ $category->icon }} text-primary fa-sm fa-fw"></i>
                                                </span>

                                                <h5 class="fw-semibold">{{ $category->name }}</h5>
                                                @foreach ($progresses as $progress)
                                                    <hr class="w-25">
                                                    <div class="my-2">
                                                        <p class="my-0 text-muted">
                                                            {{ $progress->created_at->format('d F Y H:i') }}
                                                        </p>
                                                        <p class="my-0 text-muted fs-6">
                                                            {{ $progress->subCategoryProjectSubmission->notes }}</p>

                                                        @if ($progress->note)
                                                            <div class="border dashed-border rounded my-2 p-3">
                                                                <p class="my-0 fw-semibold text-danger">
                                                                    {{ $progress->categoryProjectSubmissionStatus->name == 'Ditolak' ? 'Alasan Penolakan:' : 'Revisi:' }}
                                                                </p>
                                                                <p class="my-0 fs-6">{!! $progress->note !!}</p>
                                                                @if (
                                                                    $progress->subCategoryProjectSubmission->name == 'need_revision' &&
                                                                        $progress->id == $progresses->last()->id &&
                                                                        !$project->isRejected())
                                                                    <a href="{{ route('dashboard.user.project-management.revise', $project->id) }}"
                                                                        class="btn btn-sm btn-primary mt-2">
                                                                        Revisi Project
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        @if ($progress->subCategoryProjectSubmission->name == 'on_contract_signing' && $progress->id == $progresses->last()->id)
                                                            <div
                                                                class="col-12 py-3 align-items-center d-flex justify-content-start gap-2">
                                                                <div class="">
                                                                    <a href="{{ route('dashboard.user.project-management.upload-signed-contract', $project->id) }}"
                                                                        class="btn btn-primary btn-sm">Upload
                                                                        Signed Contract</a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ul>
                                </section>
                                <!-- Section: Timeline -->
                            </div>

                            {{-- card right project info --}}
                            <x-rightCardShowProject :project="$project" />
                        </div>
                    </x-pillTabContent>
                </x-pillTabContainer>
            @endslot
        </x-contentSection>

        @if (session('success'))
            @push('custom-scripts')
                <script>
                    showAlert('{{ session('success') }}', "success");
                </script>
            @endpush
        @endif
    @endslot
</x-containerTemplate>
