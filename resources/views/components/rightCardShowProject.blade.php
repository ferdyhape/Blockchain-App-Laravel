<!-- components/right-card.blade.php -->

@props(['project', 'isAdmin' => false, 'useFor' => 'show-project'])

<div class="col-12 col-md-12 col-lg-4">
    <div class="card border-0 shadow-sm p-4 my-3" style="max-height: 450px">
        <div class="card-body">
            <div class="card-head">
                <div class="d-flex justify-content-between">
                    <div class="project-image">
                        <img src="https://fakeimg.pl/300/" class=" rounded-circle" alt="..." width="60"
                            height="60">
                    </div>
                    <div class="btn btn-sm my-auto btn-primary">
                        {{ $project->categoryProjectSubmissionStatus->name }}
                    </div>
                </div>
            </div>

            <div class="card-content mt-4">
                <h5 class="card-title fw-semibold fs-5">{{ $project->title }}</h5>
                <h5 class="text-secondary fs-6">{{ $project->user->name }}</h5>
                @if ($useFor == 'available-project')
                    <div class="my-4">
                        <table class="w-100" style="">
                            <tr>
                                <td class="text-start text-secondary">
                                    Jumlah Koin Ditawarkan
                                </td>
                                <td class="text-end">
                                    {{ $project->campaign->offered_token_amount }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Harga Per Token
                                </td>
                                <td class="text-end currency">
                                    {{ $project->campaign->price_per_unit }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Minimal Beli
                                </td>
                                <td class="text-end">
                                    {{ $project->campaign->minimum_purchase }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Maksimal Beli
                                </td>
                                <td class="text-end">
                                    {{ $project->campaign->maximum_purchase }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Jumlah Token Terbeli
                                </td>
                                <td class="text-end">
                                    {{ $project->campaign->sold_token_amount }}
                                </td>
                            </tr>
                        </table>
                    </div>
                @else
                    <div class="my-4">
                        <table class="w-100">
                            <tr>
                                <td class="text-start text-secondary">
                                    Target Dana
                                </td>
                                <td class="text-end currency">
                                    {{ $project->nominal_required }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Aset Jaminan
                                </td>
                                <td class="text-end">
                                    {{ $project->collateral_assets }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Nominal Jaminan
                                </td>
                                <td class="text-end currency">
                                    {{ $project->collateral_value }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <hr>

                    <div class="my-4">
                        <h5 class="fs-5">Model dan Rencana Bisnis</h5>
                        <table class="w-100">
                            <tr>
                                <td class="text-start text-secondary">
                                    Pendapatan/bulan
                                </td>
                                <td class="text-end currency">
                                    {{ $project->income_per_month }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Pengeluaran/bulan
                                </td>
                                <td class="text-end currency">
                                    {{ $project->expenses_per_month }}
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if ($isAdmin)
        <div class="card border-0 shadow-sm p-4 my-3" style="max-height: 450px">
            <div class="card-body">
                <div class="card-content mt-4">
                    <h5 class="card-title fw-semibold fs-5">Kontak Pemilik Proyek</h5>
                    <div class="my-4">
                        <table class="w-100">
                            <tr>
                                <td class="text-start text-secondary">
                                    No. Whatsapp
                                </td>
                                <td class="text-end">
                                    {{ $project->user->phone }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start text-secondary">
                                    Email
                                </td>
                                <td class="text-end">
                                    {{ $project->user->email }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('auth.admin.project_management.actionCard')
    @elseif(
        $project->campaign &&
            $project->user->id == auth()->user()->id &&
            $project->categoryProjectSubmissionStatus->name != 'Proses Penggalangan Dana')
        @include('auth.user.project_management.actionCard')
        {{-- @if ($project->campaign->status == 'on_fundraising')
        @endif --}}
    @elseif($useFor == 'available-project' && $project->user->id != auth()->user()->id)
        @include('auth.user.available_project.actionCard')
    @endif
</div>
