<!-- ProjectCard.blade.php -->

@props(['project', 'useForRoute' => 'project-management'])

<div class="col-md-12 col-lg-4">
    <div class="card p-3 shadow border-0">
        <div class="card-body">
            {{-- head of card, project image and status --}}
            <div class="card-head">
                <div class="d-flex justify-content-between">
                    <div class="project-image">
                        <img src="https://fakeimg.pl/300/" class=" rounded-circle" alt="..." width="60"
                            height="60">
                    </div>
                    @if ($useForRoute == 'project-management')
                        <div class="btn btn-sm my-auto btn-primary">
                            {{ $project->categoryProjectSubmissionStatus->name }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- card content --}}
            <div class="card-content mt-4">

                {{-- project title --}}
                <h5 class="card-title fw-semibold fs-5"><a
                        href= "{{ route('dashboard.user.' . $useForRoute . '.show', $project) }}">{{ $project->title }}</a>
                </h5>
                <h5 class="text-secondary
                        fs-6">{{ $project->user->name }}</h5>

                {{-- coins offered --}}
                <div class="d-flex justify-content-between my-4">
                    <div class="coins-offered border px-3 py-2 rounded dashed-border text-start">
                        <h5>
                            {{ $project->campaign ? $project->campaign->offered_token_amount : '-' }}
                        </h5>
                        <p class="my-0 text-secondary">Koin Ditawarkan</p>
                    </div>
                    <div class="coins-offered border px-3 py-2 rounded dashed-border text-end">
                        <h5>
                            {{ $project->campaign ? $project->campaign->minimum_purchase : '-' }}
                        </h5>
                        <p class="my-0 text-secondary">Min Beli</p>
                    </div>
                </div>

                {{-- progress bar --}}
                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                    aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-warning"
                        style="width: {{ $project->campaign ? ($project->campaign->sold_token_amount / $project->campaign->offered_token_amount) * 100 : 0 }}%">
                    </div>
                </div>

                {{-- progress bar info --}}
                <div class="d-flex justify-content-between mt-4">
                    <div class="coins-offered rounded text-start">
                        <p class="my-1 text-secondary">Terkumpul</p>
                        @if ($project->campaign)
                            <h5>{{ $project->campaign->sold_token_amount }} Koin</h5>
                        @else
                            <h5>-</h5>
                        @endif
                    </div>
                    <div class="coins-offered rounded text-end">
                        <p class="my-1 text-secondary">Sisa hari</p>
                        <h5>
                            @if ($project->campaign)
                                {{ \Carbon\Carbon::now()->diffInDays($project->campaign->fundraising_period_end) }}
                            @else
                                -
                            @endif
                        </h5>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
