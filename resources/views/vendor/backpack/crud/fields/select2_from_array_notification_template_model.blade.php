<!-- select2 from array notification template model -->
@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    <select
        @if(isset($entry)) disabled="disabled" @endif
        name="{{ $field['name'] }}@if (isset($field['allows_multiple']) && $field['allows_multiple']==true)[]@endif"
        style="width: 100%"
        @include('crud::fields.inc.attributes', ['default_class' =>  'form-control select2_from_array'])
        @if (isset($field['allows_multiple']) && $field['allows_multiple']==true)multiple @endif
        >

        @if (isset($field['allows_null']) && $field['allows_null']==true)
            <option value="">-</option>
        @endif

            @if (count($field['options']))
                @foreach ($field['options'] as $key => $value)
                    <option value="{{ $key }}"
                        @if (isset($field['value']) && ($key==$field['value'] || (is_array($field['value']) && in_array($key, $field['value'])))
                            || ( ! is_null( old($field['name']) ) && old($field['name']) == $key))
                             selected
                        @endif
                    >{{ $value }}</option>
                @endforeach
            @endif
    </select>
    @if(isset($entry))
        <input type="hidden" name="{{ $field['name'] }}" value="{{ $field['value'] }}" />
    @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include select2 css-->
        <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
    @if (app()->getLocale() !== 'en')
        <script src="{{ asset('packages/select2/dist/js/i18n/' . app()->getLocale() . '.js') }}"></script>
    @endif
    <script>
        function insertIntoCkeditor(str){
            CKEDITOR.instances['ckeditor-body'].insertText(str) // @todo cant initialize this
        }

        function getNotificationVars() {
            let model = $('select[name="model"] option:selected').val();
            $('#listAvailableVars').empty();

            $.ajax({
                url: '{{ route('listModelVariables') }}',
                type: 'POST',
                data: {
                    model: @if (isset($entry) && $entry->model) '{{ $entry->model }}' @else model @endif
                },
            })
                .done(function(res) {
                    if (res) {
                        $.each(res, function(key, val) {
                            $('#listAvailableVars').append('<li class="variable small" data-var=" \{\{ ' + val + ' }} "><a href="javascript:void(0)">\{\{ ' + val + ' }}</a></li>')
                        });
                    } else {
                        $('#listAvailableVars').append('<small class="text-center">No variables available</small>')
                    }
                })
        }

        $(document).ready(function () {
            getNotificationVars()
        });

        $(document).on('change', 'select[name="model"]', function () {
            let model = $('select[name="model"] option:selected').val();
            $('#listAvailableVars').empty()

            $.ajax({
                url: '{{ route('listModelVariables') }}',
                type: 'POST',
                data: {
                    model: model
                },
            })
                .done(function(response) {
                    if (response) {
                        $.each(response, function(key, val) {
                            $('#listAvailableVars').append('<li class="variable small" data-var=" \{\{ ' + val + ' }} "><a href="javascript:void(0)">\{\{ ' + val + ' }}</a></li>')
                        });
                    } else {
                        $('#listAvailableVars').append('<small class="text-center">No variables available</small>')
                    }
                })
        })

        $(document).on('click', '.variable', function () {
            let variable = $(this).data('var');
            $('.note-editable').append(variable);
        })
    </script>
    <script>
        jQuery(document).ready(function($) {
            // trigger select2 for each untriggered select2 box
            $('.select2_from_array').each(function (i, obj) {
                if (!$(obj).hasClass("select2-hidden-accessible"))
                {
                    $(obj).select2({
                        theme: "bootstrap"
                    });
                }
            });
        });
    </script>
    @endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
