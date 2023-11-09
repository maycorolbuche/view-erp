<div class="form-group field {{ $errors->has($field) ? 'has-error' : '' }}"
    style="flex-shrink: 1;flex-grow: 1;flex-basis: {{ $width }}px;padding: 0 5px 0 5px;display: flex; flex-direction: column;">
    <label for="{{ $id }}{{ $pre_type == 'money' ? '_preview' : '' }}" class="col-lg-3 control-label" style="padding:0;width:100%;">
        {{ $label }}{{ $label && substr($label, -1) != ':' && substr($label, -1) != '?' ? ':' : '' }}
        {!! $required ? '<span class="text-danger">*</span>' : '' !!}
    </label>
    <div style="position: relative;">
        @if ($type == 'icon')
            <!-- -->
            <input type="hidden" id="{{ $id }}" name="{{ $name }}" value="{{ old($field) ?: $value }}"
                {{ $required ? 'required' : '' }}>

            <button type="button" id="ibt_{{ $id }}" onclick="open_popup_{{ $id }}()"
                class="btn btn-dark">
                <i class="{{ old($field) ?: $value }}"></i>
                <span>Selecionar</span>
            </button>

            @push('scripts')
                <script>
                    $(document).ready(function() {
                        sel_icon_{{ $id }}('{{ old($field) ?: $value }}');
                    });
                </script>
            @endpush
            <!-- -->
        @elseif ($type == 'select')
            <!-- -->
            <select id="{{ $id }}" name="{{ $name }}" {{ $required ? 'required' : '' }}
                onchange="config_select_{{ $id }}()">
                <option value="">&nbsp;</option>
                @foreach (json_decode(html_entity_decode($list), true) as $item)
                    <option value="{{ $item[$listValue] }}"
                        {{ (old($field) ?: $value) == $item[$listValue] ? 'selected' : '' }}>
                        {{ $item[$listText] }}
                    </option>
                @endforeach
            </select>

            <span class="append-icon right btn-deselect" style="margin-right:6px;z-index: 10;cursor: pointer;"
                onclick="deselect_{{ $id }}()">
                <i class="fa fa-remove"></i>
            </span>

            @push('scripts')
                <script>
                    function deselect_{{ $id }}() {
                        $('#{{ $id }} option:selected').each(function() {
                            $(this).prop('selected', false);
                        })

                        $('#{{ $id }}').multiselect('refresh');
                        config_select_{{ $id }}();
                    }

                    function config_select_{{ $id }}() {
                        let val = $('#{{ $id }} option:selected').val();
                        if (val != "") {
                            $("#{{ $id }}").parent().find(".btn-deselect").show();
                        } else {
                            $("#{{ $id }}").parent().find(".btn-deselect").hide();
                        }
                    }
                    $(document).ready(function() {
                        config_select_{{ $id }}();
                    });
                </script>
            @endpush
            <!-- -->
        @elseif ($type == 'radio')
            <!-- -->
            <div style="position: relative;display: flex;height: 100%;align-items: center;padding-top: 10px;">
                @foreach (json_decode(html_entity_decode($list), true) as $key => $item)
                    <div class="radio-custom">
                        <input type="radio" id="{{ $id }}_{{ $item[$listValue] }}"
                            name="{{ $name }}" value="{{ $item[$listValue] }}"
                            {{ (old($field) ?: $value) == $item[$listValue] ? 'checked' : '' }}>
                        <label for="{{ $id }}_{{ $item[$listValue] }}">{{ $item[$listText] }}</label>
                    </div>
                @endforeach
            </div>
            <!-- -->
        @elseif ($type == 'checkbox')
            <!-- -->
            <div style="position: relative;display: flex;height: 100%;align-items: center;padding-top: 10px;">
                @php
                    $v = [];
                    $jsonData = json_decode(html_entity_decode($value));
                    if ($jsonData !== null) {
                        $v = $jsonData;
                    } else {
                        $v[] = $value;
                    }
                    $value = $v;
                @endphp
                @foreach (json_decode(html_entity_decode($list), true) as $key => $item)
                    <div class="checkbox-custom">
                        <input type="checkbox" id="{{ $id }}_{{ $item[$listValue] }}"
                            name="{{ $name }}[{{ $item[$listValue] }}]" value="{{ $item[$listValue] }}"
                            {{ in_array($item[$listValue], is_array(old($field)) ? old($field) : $value) ? 'checked' : '' }}>
                        <label for="{{ $id }}_{{ $item[$listValue] }}">{{ $item[$listText] }}</label>
                    </div>
                @endforeach
            </div>
            <!-- -->
        @elseif ($type == 'bool' || $type == 'boolean')
            <!-- -->
            <input type="hidden" id="{{ $id }}" name="{{ $name }}"
                value="{{ old($field) ?: $value }}">

            <div class="switch switch-info round switch-inline" style="margin-top: 8px;">
                <input id="{{ $id }}_switch" name="{{ $name }}_switch" type="checkbox"
                    value="1" {{ (old($field) ?: $value) == true ? 'checked' : '' }}>
                <label for="{{ $id }}_switch"></label>
            </div>

            @push('scripts')
                <script>
                    $(document).ready(function() {
                        $("#{{ $id }}_switch").change(function() {
                            $("#{{ $id }}").val($(this).prop("checked") ? 1 : 0);
                        });
                    });
                </script>
            @endpush

            <!-- -->
        @elseif ($type == 'textarea')
            <!-- -->
            <span class="append-icon right error-icon">
                <i class="fa fa-remove"></i>
            </span>
            <span class="append-icon right success-icon">
                <i class="fa fa-check"></i>
            </span>
            <textarea id="{{ $id }}" name="{{ $name }}" class="form-control {{ $class }}"
                rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
                {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}>{{ old($field) ?: $value }}</textarea>
            <!-- -->
        @else
            <!-- -->
            <span class="append-icon right error-icon">
                <i class="fa fa-remove"></i>
            </span>
            <span class="append-icon right success-icon">
                <i class="fa fa-check"></i>
            </span>
            <input type="{{ $type }}" id="{{ $id }}{{ $pre_type == 'money' ? '_preview' : '' }}"
                name="{{ $name }}{{ $pre_type == 'money' ? '_preview' : '' }}"
                value="{{ old($field) ?: $value }}" class="form-control {{ $class }}"
                placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }}
                {{ $readonly ? 'readonly' : '' }}>


            @if ($pre_type == 'money')
                <input type="hidden" id="{{ $id }}" name="{{ $name }}"
                    value="{{ old($field) ?: $value }}">

                @push('scripts')
                    <script>
                        $(document).ready(function() {
                            $("#{{ $id }}_preview").change(function() {
                                change_money_{{ $id }}();
                            });
                            change_money_{{ $id }}();
                        });

                        function change_money_{{ $id }}() {
                            let val = $("#{{ $id }}_preview").val();
                            $("#{{ $id }}").val(parseFloat(val ? val.replace(/\./g, '').replace(',', '.') : 0));
                        }
                    </script>
                @endpush
            @endif
            <!-- -->
        @endif
    </div>

    @if ($tip != '')
        <span class="help-block mt5">{{ $tip }}</span>
    @endif

    @if ($errors->has($field))
        <em for="{{ $id }}" class="has-error">{{ $errors->first($field) }}</em>
    @endif
</div>

@if ($type == 'icon')
    @include('components.partials.modal-icon', compact('id'))
@endif
