<a class="dropdown-trigger d-flex align-items-center gap-2 p-1" href="#" id="{{ $id }}" role="button"
    data-bs-toggle="dropdown" aria-expanded="false">
    @if ($icon)
        <span class="ic">
            <i class="{{ $icon }}"></i>
            @if ($count > 0)
                <span class="dot">{{ $count }}</span>
            @endif
        </span>
    @endif
    @if ($avatar)
        <x-avatar photo="{{ $avatar }}" />
    @endif
    @if ($title || $subtitle)
        <div class="d-flex flex-column">
            @if ($title)
                <span class="fw-medium text-dark">{{ $title }}</span>
            @endif
            @if ($subtitle)
                <span class="text-primary">{{ $subtitle }}</span>
            @endif
        </div>
    @endif
    {{ $trigger ?? '' }}
</a>
<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="{{ $id }}">
    @if ($headerTitle)
        <li class="dropdown-header">
            {{ $headerTitle }}
        </li>
    @endif
    {{ $slot }}
</ul>
