<li>
    <a class="dropdown-item d-flex align-items-center gap-2 p-2 py-3 {{ $type ? 'text-' . $type : '' }}"
        href="{{ $href }}">
        @if ($icon)
            <div>
                <i class="icon {{ $icon }}"></i>
            </div>
        @endif
        <div class="d-flex flex-column flex-fill">
            @if ($title)
                <span class="fw-medium">{{ $title }}</span>
            @endif
            @if ($subtitle)
                <span class="fw-light">{{ $subtitle }}</span>
            @endif
            {{ $slot }}
        </div>
        @if ($count > 0)
            <span class="badge bg-primary">{{ $count }}</span>
        @endif
    </a>
</li>
