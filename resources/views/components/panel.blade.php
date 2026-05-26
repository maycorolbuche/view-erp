<x-card title="{{ $title }}">
    {{ $slot }}
</x-card>
<?php /*
<div class="panel {{ $type ? 'panel-' . $type : '' }}" style="{{ $height ? 'height:' . $height : '' }}">
    @if ($title)
        <div class="panel-heading">
            <span class="panel-title">{!! $title !!}</span>
            @if ($badge)
                <span class='badge'>{{ $badge }}</span>
            @endif
        </div>
    @endif
    <div class="panel-body" style="{{ $bodyHeight ? 'height:' . $bodyHeight : '' }}">
        {{ $slot }}
    </div>
</div>
*/
?>
