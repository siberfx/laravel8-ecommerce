<!-- text input -->
@include('crud::fields.inc.wrapper_start')

@php
    $model = new $field['options']();

    if (! request()->has('parentId')) {
        return null;
    }
    $parentId = request()->get('parentId');
    $fetch = $model->where('project_number', $parentId)->first();
    $field['value'] = $field['value'] ?? $fetch->generateNextJobNumber();
    $myPrefix = $model->generate_project_code($parentId);

@endphp

    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <div class="input-group">
        <div class="input-group-prepend"><span class="input-group-text">{!! $myPrefix !!}</span></div>
        <input
            type="text"
            name="{{ $field['name'] }}"
            value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
            readonly
            @include('crud::fields.inc.attributes')
        >
        @if(isset($field['suffix'])) <div class="input-group-append"><span class="input-group-text">{!! $field['suffix'] !!}</span></div> @endif
    @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
