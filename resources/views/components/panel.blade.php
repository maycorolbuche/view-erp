<div class="panel">
    @if ($title)
        <div class="panel-heading">
            <span class="panel-title">{{ $title }}</span>
        </div>
    @endif
    <div class="panel-body">
        {{ $slot }}
    </div>
</div>
