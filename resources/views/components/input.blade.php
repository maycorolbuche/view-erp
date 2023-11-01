<div class="form-group field {{ $errors->has($field) ? 'has-error' : '' }}"
    style="flex-shrink: 1;flex-grow: 1;flex-basis: {{ $width }}px;padding: 0 5px 0 5px;display: flex; flex-direction: column;">
    <label for="{{ $id }}" class="col-lg-3 control-label" style="padding:0;width:100%;">
        {{ $label ? $label . ':' : '' }}&nbsp;{!! $required ? '<span class="text-danger">*</span>' : '' !!}
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
        @else
            <!-- -->
            <span class="append-icon right error-icon">
                <i class="fa fa-remove"></i>
            </span>
            <span class="append-icon right success-icon">
                <i class="fa fa-check"></i>
            </span>
            <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}"
                value="{{ old($field) ?: $value }}" class="form-control {{ $class }}"
                placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }}
                {{ $readonly ? 'readonly' : '' }}>
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
