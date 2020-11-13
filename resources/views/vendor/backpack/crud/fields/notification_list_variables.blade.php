@include('crud::fields.inc.wrapper_start')
<label>Available Variables</label>
<ul id="listAvailableVars">
    <small>Select Model first</small>
</ul>
@include('crud::fields.inc.wrapper_end')

{{-- FIELD CSS - will be loaded in the after_styles section --}}
@push('crud_fields_styles')
    <style>
        .available-variables ul {
            list-style-type: none;
            padding: 0;
        }
    </style>
@endpush

