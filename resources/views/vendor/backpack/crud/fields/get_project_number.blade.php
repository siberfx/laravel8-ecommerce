<!-- text input -->
@include('vendor.backpack.crud.fields.inc.wrapper_start')

@php
    $model = new $field['options']();

    $field['value'] = $field['value'] ?? $model->generateProjectNumber();

@endphp

    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <div class="input-group">
        <div class="input-group-prepend"><span class="input-group-text">{!! $model::CODE !!}</span></div>
        <input
            type="text"
            name="{{ $field['name'] }}"
            value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
            @include('crud::fields.inc.attributes')
        >
        @if(isset($field['suffix'])) <div class="input-group-append"><span class="input-group-text">{!! $field['suffix'] !!}</span></div> @endif
   </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
