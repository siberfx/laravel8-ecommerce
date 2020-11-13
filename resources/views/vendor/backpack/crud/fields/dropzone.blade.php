@include('vendor.backpack.crud.fields.inc.wrapper_start')
@php
    $routeIs = $field['route_prefix'].'.storeMedia';
    $fieldName = 'Media';
@endphp

    <div class="needsclick dropzone" id="media-dropzone">
    </div>

@include('vendor.backpack.crud.fields.inc.wrapper_end')


@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}

    @push('crud_fields_styles')
        <link rel="stylesheet" href="{{ asset('packages/dropzone/dist/min/dropzone.min.css') }}">
        <style>
            .dropzone-thumbnail {
                width: 120px;
                height: 120px;
                cursor: move !important;
            }
            .dropzone {
                width: 100%;
                height: 270px;
            }
        </style>
    @endpush


    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}

    @push('crud_fields_scripts')
        <script src="{{ asset('packages/dropzone/dist/min/dropzone.min.js') }}"></script>

        <script>
            var uploadedMediaMap = {}
            Dropzone.options.mediaDropzone = {
                url: '{{ route($routeIs) }}',
                maxFilesize: {{ $field['filesize'] }},
                maxFiles: {{ $field['max_file'] }},
                acceptedFiles: '.jpeg,.jpg,.png,.gif,.pdf,.xls,.xlsx,.doc,.docx,.txt',
{{--                acceptedFiles: '{{ implode(',',$field['mimes']) }}',--}}
                addRemoveLinks: true,

                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                    size: 20,
                    width: 4096,
                    height: 4096
                },
                success: function (file, response) {
                    $('form').append('<input type="hidden" name="media_files[]" value="' + response.name + '">')
                    uploadedMediaMap[file.name] = response.name
                },
                removedfile: function (file) {
                    console.log(file)
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedMediaMap[file.name]
                    }
                    $('form').find('input[name="media_files[]"][value="' + name + '"]').remove()
                },
                init: function () {
                        @if(isset($entry) && $entry->medias)
                    var files = {!! json_encode($entry->medias) !!}
                        for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        this.options.thumbnail.call(this, file, file.preview)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="media_files[]" value="' + file.path + '">')
                    }
                    @endif
                },
                error: function (file, response) {
                    if ($.type(response) === 'string') {
                        var message = response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            }
        </script>

    @endpush
@endif
