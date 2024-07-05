<div class="card border-0 shadow-sm p-4 my-3" style="max-height: 450px">
    <div class="card-body">
        <div class="card-content ">
            <div class="d-flex flex-column justify-content-center gap-2">
                @if (
                    $project->campaign->status == 'on_fundraising' &&
                        now() >= $project->campaign->fundraising_period_start &&
                        now() <= $project->campaign->fundraising_period_end)
                    <div class="col-12">
                        <a href="{{ route('dashboard.user.available-project.buy', $project->id) }}"
                            class="btn btn-success w-100">Beli</a>
                    </div>
                @endif
                <div class="col-12">
                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#">
                        Download Prospectus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
