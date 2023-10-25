<div class="form-group field {{ $errors->has($field) ? 'has-error' : '' }}"
    style="flex-shrink: 1;flex-grow: 1;flex-basis: {{ $width }}px;padding: 0 5px 0 5px;">
    <label for="{{ $id }}" class="col-lg-3 control-label" style="padding:0;width:100%;">
        {{ $label ? $label . ':' : '' }}&nbsp;{!! $required ? '<span class="text-danger">*</span>' : '' !!}
    </label>
    <div style="position: relative;">
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
    </div>
    @if ($errors->has($field))
        <em for="{{ $id }}" class="has-error">{{ $errors->first($field) }}</em>
    @endif
</div>
