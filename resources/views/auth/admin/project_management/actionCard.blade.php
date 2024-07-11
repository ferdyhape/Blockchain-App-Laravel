@if (!$project->isRejected())
    <div class="card border-0 shadow-sm p-4 my-3" style="max-height: 450px">
        <div class="card-body">
            <div class="card-content mt-4">
                <h5 class="card-title fw-semibold fs-5 mb-4">Actions</h5>

                @if ($project->isOnReview())
                    <div class="d-flex flex-column justify-content-center gap-2">
                        <div class="col-12">
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                                data-bs-target="#revisiProjectModal"
                                {{ $project->categoryProjectSubmissionStatus->name == 'Ditolak' || $project->progressStatusOfProjectSubmission->last()->subCategoryProjectSubmission->name == 'need_revision' ? 'disabled' : '' }}>
                                Revisi
                            </button>
                        </div>
                        <div class="col-12 d-flex justify-content-between">
                            <div class="col-6 pe-1">
                                <button type="button" class="btn btn-success w-100" data-bs-toggle="modal"
                                    data-bs-target="#{{ $project->progressStatusOfProjectSubmission->last()->subCategoryProjectSubmission->name == 'revised' ? 'terimaRevisiProjectModal' : 'terimaProjectModal' }}"
                                    {{ $project->categoryProjectSubmissionStatus->name == 'Ditolak' ? 'disabled' : '' }}>
                                    Terima
                                </button>
                            </div>
                            <div class="col-6 ps-1">
                                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                                    data-bs-target="#tolakProjectModal"
                                    {{ $project->categoryProjectSubmissionStatus->name == 'Ditolak' ? 'disabled' : '' }}>
                                    Tolak
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($project->isOnApproveCommittee())
                    <div class="d-flex flex-column justify-content-center gap-2">
                        <div class="col-12">
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                                data-bs-target="#approveProjectModal">
                                Approve Dari Committee
                            </button>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                                data-bs-target="#rejectProjectModal">
                                Reject Dari Committee
                            </button>
                        </div>
                    </div>
                @elseif($project->isSigningContract())
                    <div class="d-flex flex-column justify-content-center gap-2">
                        @if ($project->getMedia('project_contract_document')->first())
                            <div class="col-12">
                                <a href="{{ $project->getMedia('project_contract_document')->first()->getUrl() }}"
                                    target="_blank" class="btn btn-warning w-100">
                                    Cek Document
                                </a>
                            </div>
                        @endif
                        <div class="col-12">
                            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal"
                                data-bs-target="#{{ $project->progressStatusOfProjectSubmission->last()->subCategoryProjectSubmission->name == 'contract_signed' ? 'terimaContractProjectModal' : '' }}"
                                {{ $project->progressStatusOfProjectSubmission->last()->subCategoryProjectSubmission->name == 'contract_signed' ? '' : 'disabled' }}>
                                Acc Kontrak
                            </button>
                        </div>
                    </div>
                @else
                    {{-- <h1>Masuk Else</h1> --}}
                    {{-- add no action needed --}}
                    <div class="btn btn-sm btn-success w-100">No Action Needed</div>
                @endif

            </div>
        </div>
    </div>
@endif
