<!-- checkbox field -->

@include('crud::fields.inc.wrapper_start')
    @include('crud::fields.inc.translatable_icon')
    <div class="checkbox">
{{--        <input type="hidden" name="{{ $field['name'] }}" value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? 0 }}">--}}

        {{ $field['label'] }}<br>
        <label class="switch switch-success">
            <input
                name="{{ $field['name'] }}"
                class="switch-input"
                type="checkbox"
                @if (old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? 0)
                checked="checked"
                @endif
                @if (isset($field['attributes']))
                    @foreach ($field['attributes'] as $attribute => $value)
                        {{ $attribute }}="{{ $value }}"
                    @endforeach
                @endif
            >
            <span class="switch-slider"></span>
        </label>
        {{-- HINT --}}
        @if (isset($field['hint']))
            <p class="help-block">{!! $field['hint'] !!}</p>
        @endif
    </div>
@include('crud::fields.inc.wrapper_end')

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp
    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')

    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
