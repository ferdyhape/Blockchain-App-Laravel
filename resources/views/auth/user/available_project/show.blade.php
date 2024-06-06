<x-containerTemplate pageTitle="Show Available Project">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Available Project', 'Show Available Project']" />

        <x-contentSection>
            @slot('contentOfContentSection')
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
                                                <img src="{{ $media->getUrl() }}" class="img-fluid" alt="supporting document">
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
                                                <img src="{{ $media->getUrl() }}" class="img-fluid" alt="product catalog">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- card right project info --}}
                    <x-rightCardShowProject :project="$project" useFor="available-project" />
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
    @endslot
</x-containerTemplate>
