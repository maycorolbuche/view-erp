<div class="list-row">
    @if (!empty($icon))
        <div class="ico">
            <i class="{{ $icon }}"></i>
        </div>
    @endif

    <div class="grow">
        <div class="label">{{ $title }}</div>
        <div class="num">{{ $slot }}</div>
    </div>
    <div class="pct">
        @if (!empty($infoIcon))
            <i class="{{ $infoIcon }}"></i>
        @endif
        @if (!empty($infoValue))
            {{ $infoValue }}
        @endif
    </div>
</div>
