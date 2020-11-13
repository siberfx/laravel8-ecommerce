<!-- select from array -->
@include('crud::fields.inc.wrapper_start')
@php
$ajaxCallId = $field['related_on_key'];
@endphp
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')
<select
    name="{{ $field['name'] }}@if (isset($field['allows_multiple']) && $field['allows_multiple']==true)[]@endif"
    id="{{ $field['name'] }}-ajax"
    @include('crud::fields.inc.attributes')
@if (isset($field['allows_multiple']) && $field['allows_multiple']==true)multiple @endif
id="{{ $field['name'] }}-ajax"
>
</select>

{{-- HINT --}}
@if (isset($field['hint']))
<p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')


{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
<!-- include select2 js-->
<script>
    let optionList = $("#{{ $field['name'] }}-ajax");
    let selectField = $('select[name={{$field["related_on_key"]}}]');

    selectField.on('change', function() {
        console.log('New value is: ' + $(this).val());

        let companyId = $(this).val();

        $.ajax({
            url: '{{ $field['related_route'] }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                companyId:companyId,
            },
            dataType: 'json',

            success:function(response) {
                optionList.empty();
                $.each(response, function(key, value) {
                    console.log(key, value)
                    var renderHtml = "<option value='"+key+"'>"+value+"</option>"
                    optionList.append(renderHtml);
                });
            }
        });
    });
</script>

@endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
