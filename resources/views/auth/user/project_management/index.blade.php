<x-containerTemplate pageTitle="Project">
    @slot('contentOfContainer')
        <x-headerSection :breadcrumbMenu="['Project']">
            @slot('headerContent')
                <div class="d-flex gap-2 align-items-center">
                    <a href="{{ route('dashboard.user.project-management.create') }}" class="btn btn-sm btn-primary">Create
                        Project</a>
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
                    @foreach ($projects as $project)
                        <x-projectCard :project="$project" />
                    @endforeach
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
