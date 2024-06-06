<x-containerTemplate pageTitle="Available Project">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Available Project']">
            @slot('headerContent')
                <div class="d-flex gap-2 align-items-center">
                    <div class="my-auto">
                        <select class="form-select my-auto form-select-sm" aria-label="Default select example">
                            <option value="1">All</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
            @endslot
        </x-headerSection>

        <x-contentSection>
            @slot('contentOfContentSection')
                <div class="row gy-4">
                    @foreach ($campaigns as $campaign)
                        <x-projectCard :project="$campaign->project" useForRoute="available-project" />
                    @endforeach
                </div>
            @endslot
        </x-contentSection>

        @include('components.errorAlertValidation')
        @include('components.ifSuccessAlert')
    @endslot
</x-containerTemplate>
