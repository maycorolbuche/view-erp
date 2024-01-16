<div class="panel {{ $type ? 'panel-' . $type : '' }}" style="{{ $height ? 'height:' . $height : '' }}">
    @if ($title)
        <div class="panel-heading">
            <span class="panel-title">{!! $title !!}</span>
        </div>
    @endif
    <div class="panel-body" style="{{ $bodyHeight ? 'height:' . $bodyHeight : '' }}">
        {{ $slot }}
    </div>
</div>
