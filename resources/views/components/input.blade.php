@php
    $value = old(str_replace('[', '.', str_replace(']', '', $field))) ?: $value;
@endphp
<div id="group-{{ $id }}" class="form-group field"
    style="flex-shrink: 1;flex-grow: 1;flex-basis: {{ $width }}px;padding: 0 5px 0 5px;display: flex; flex-direction: column;">
    <label for="{{ $id }}{{ $pre_type == 'money' ? '_preview' : '' }}" class="form-label fw-semibold">
        {{ $label }}{{ $label && substr($label, -1) != ':' && substr($label, -1) != '?' ? ':' : '' }}
        {!! $required ? '<span class="text-danger">*</span>' : '' !!}
    </label>
    <div class="input-group {{ $errors->has($field) ? 'is-invalid' : '' }}" data-group-type="{{ $pre_type }}"
        style="{{ $type == 'boolean' || $type == 'bool' || $type == 'boolean-checkbox' || $type == 'bool-chk' ? 'display: flex;align-items: center;gap: 10px;' : '' }}">
        @if ($type == 'icon')
            <!-- -->
            <input type="hidden" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
                {{ $required ? 'required' : '' }}>

            <button type="button" id="ibt_{{ $id }}" onclick="open_popup_{{ $id }}()"
                class="btn btn-dark">
                <i class="{{ $value }}"></i>
                <span>Selecionar</span>
            </button>

            @push('scripts')
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        sel_icon_{{ $id }}('{{ $value }}');
                    });
                </script>
            @endpush
            <!-- -->
        @elseif ($type == 'select' || $type == 'multiple' || $type == 'select-multiple')
            <!-- -->
            @php
                $v = [];
                if ($type == 'select') {
                    $v[] = $value;
                } else {
                    if (is_array($value)) {
                        $v = $value;
                    } else {
                        $jsonData = is_array($value) ? $value : json_decode(html_entity_decode($value));
                        if ($jsonData !== null) {
                            $v = $jsonData;
                        } else {
                            $v[] = $value;
                        }
                    }
                }
                $value = $v;
                if (old($field)) {
                    if (is_array(old($field))) {
                        $value = old($field);
                    } else {
                        $value = [];
                        $value[] = old($field);
                    }
                }
            @endphp
            <select id="{{ $id }}"
                name="{{ $name }}{{ $type == 'multiple' || $type == 'select-multiple' ? '[]' : '' }}"
                {{ $required ? 'required' : '' }} class="form-select tom-select"
                {{ $type == 'multiple' || $type == 'select-multiple' ? 'multiple' : '' }}>
                <option></option>
                @foreach (json_decode(html_entity_decode($list), true) as $item)
                    <option value="{{ $item[$listValue] }}"
                        {{ in_array($item[$listValue], $value) ? 'selected' : '' }}>
                        {{ $item[$listText] }}
                    </option>
                @endforeach
            </select>
            <!-- -->
        @elseif ($type == 'radio')
            <!-- -->
            <div style="position: relative;display: flex;gap:10px;height: 100%;align-items: center;">
                @foreach (json_decode(html_entity_decode($list), true) as $key => $item)
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                            id="{{ $id }}_{{ $item[$listValue] }}" name="{{ $name }}"
                            value="{{ $item[$listValue] }}" {{ $value == $item[$listValue] ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $id }}_{{ $item[$listValue] }}">
                            {{ $item[$listText] }}
                        </label>
                    </div>
                @endforeach
            </div>
            <!-- -->
        @elseif ($type == 'checkbox')
            <!-- -->
            <div style="position: relative;display: flex;gap:10px;height: 100%;align-items: center;">
                @php
                    $v = [];
                    $jsonData = is_array($value) ? $value : json_decode(html_entity_decode($value), true);
                    if ($jsonData !== null) {
                        $v = $jsonData;
                    } else {
                        $v[] = $value;
                    }
                    $value = $v;
                    if (old($field)) {
                        if (is_array(old($field))) {
                            $value = old($field);
                        } else {
                            $value = [];
                            $value[] = old($field);
                        }
                    }
                @endphp
                @foreach (json_decode(html_entity_decode($list), true) as $key => $item)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                            id="{{ $id }}_{{ $item[$listValue] }}"
                            name="{{ $name }}[{{ $item[$listValue] }}]" value="{{ $item[$listValue] }}"
                            {{ in_array($item[$listValue], $value) ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $id }}_{{ $item[$listValue] }}">
                            {{ $item[$listText] }}
                        </label>
                    </div>
                @endforeach
            </div>
            <!-- -->
        @elseif ($type == 'bool-chk' || $type == 'boolean-checkbox')
            <input type="hidden" name="{{ $name }}" value="0">
            <div class="px-1 py-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="{{ $id }}"
                        name="{{ $name }}" value="1" {{ $value ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $id }}"></label>
                </div>
            </div>

            @push('scripts')
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        $("#{{ $id }}_chk").change(function() {
                            $("#{{ $id }}").val($(this).prop("checked") ? 1 : 0);
                        });
                        $("#{{ $id }}").val($(this).prop("checked") ? 1 : 0);
                    });
                </script>
            @endpush

            <!-- -->
        @elseif ($type == 'bool' || $type == 'boolean')
            <!-- -->
            <input type="hidden" name="{{ $name }}" value="0">
            <div class="px-1 py-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="{{ $id }}"
                        name="{{ $name }}" value="1" {{ $value ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $id }}"></label>
                </div>
            </div>
            <!-- -->
        @elseif ($type == 'textarea')
            <!-- -->
            <textarea id="{{ $id }}" name="{{ $name }}" class="form-control {{ $class }}"
                rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
                {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}>{{ $value }}</textarea>
            <!-- -->
        @elseif ($type != 'html')
            <!-- -->

            @if ($type == 'file' && $value)
                @php
                    $file = json_decode(htmlspecialchars_decode($value));
                    $value = null;
                @endphp

                <div id="filepreview_{{ $id }}" class="form-control">
                    <a href="{{ $file->url }}" target="_blank" data-type="file">
                        <i class="fa fa-file"></i>
                        {{ $file->original_name }}
                    </a>
                    <a href="javascript:" onclick="removeFile_{{ $id }}()" class="text-danger"
                        style="float:right">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
                <input id="id_{{ $id }}" name="id_{{ $id }}" value="{{ $file->id_file }}"
                    style="display:none">

                @push('scripts')
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            $("#{{ $id }}").hide();
                        });

                        function removeFile_{{ $id }}() {
                            $("#{{ $id }}").show();
                            $("#id_{{ $id }}").val("");
                            $("#filepreview_{{ $id }}").hide();
                        }
                    </script>
                @endpush
            @endif

            <input type="{{ $type }}" id="{{ $id }}" data-type="{{ $pre_type }}"
                name="{{ $name }}{{ $multiple ? '[ ]' : '' }}" value="{{ $value }}"
                class="form-control {{ $class }} {{ $errors->has($field) ? 'is-invalid' : '' }}"
                placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }}
                {{ $readonly ? 'readonly' : '' }} {{ $multiple ? 'multiple' : '' }}
                {{ $accept ? 'accept=' . $accept : '' }} {{ $min ? 'min=' . $min : '' }}
                {{ $max ? 'max=' . $max : '' }} {{ $onchange ? 'onchange=' . $onchange : '' }}
                {{ $mask ? 'data-mask=' . $mask : '' }} {{ $address ? 'data-address=' . $address : '' }}
                {{ $district ? 'data-district=' . $district : '' }} {{ $city ? 'data-city=' . $city : '' }}
                {{ $state ? 'data-state=' . $state : '' }}>
            <!-- -->
        @endif

        @if ($type == 'html')
            {{ $value }}
        @endif
        {{ $slot }}
    </div>

    @if ($accept != '')
        <span class="form-text">Formatos permitidos: {{ str_replace(',', ', ', $accept) }}</span>
    @endif
    @if ($tip != '')
        <span class="form-text">{{ $tip }}</span>
    @endif

    @if ($errors->has($field))
        <div id="{{ $id }}Feedback" class="invalid-feedback">
            {{ $errors->first($field) }}
        </div>
    @endif
</div>

@if ($type == 'icon')
    @include('components.partials.modal-icon', compact('id'))
@endif
