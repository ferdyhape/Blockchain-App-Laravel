@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'required' => false,
    'id' => null,
    'value' => null,
    'placeholder' => null,
    'usingScript' => true,
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    @switch($type)
        @case('textarea')
            <textarea
                {{ $attributes->merge([
                    'class' => 'form-control',
                    'id' => $id ?? $name,
                    'name' => $name,
                    'rows' => 3,
                    'required' => $required,
                    'placeholder' => $placeholder ?? '',
                ]) }}>{{ $value ?? '' }}</textarea>
            @error($name)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            {{-- <script>
                ClassicEditor
                    .create(document.querySelector('#{{ $id ?? $name }}'), {
                        removePlugins: ['Resize']
                    })
                    .catch(error => {
                        console.error(error);
                    });
            </script> --}}
            @if ($usingScript)
                <script>
                    ClassicEditor
                        .create(document.querySelector('#{{ $id ?? $name }}'), {
                            removePlugins: ['Resize']
                        })
                        .catch(error => {
                            console.error(error);
                        });
                </script>
            @endif
        @break

        @case('select')
            <select
                {{ $attributes->merge([
                    'class' => 'form-select',
                    'id' => $id ?? $name,
                    'name' => $name,
                    'required' => $required,
                ]) }}>
                {{ $slot }}
            </select>
            @error($name)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        @break

        @default
            <input
                {{ $attributes->merge([
                    'type' => $type,
                    'class' => 'form-control',
                    'id' => $id ?? $name,
                    'name' => $name,
                    'required' => $required,
                    'value' => $value ?? '',
                    'placeholder' => $placeholder,
                ]) }}>
            @error($name)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        @break

    @endswitch

</div>
