<div
    {{ $attributes->merge([
        'class' => 'avatar d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white',
        'style' => 'width: ' . $size . 'px; height: ' . $size . 'px; font-size: ' . $size / 2.5 . 'px;',
    ]) }}>
    @if ($photo)
        <img src="{{ $photo }}" alt="{{ $name }}" class="rounded-circle w-100 h-100 object-fit-cover">
    @elseif($icon)
        <i class="{{ $icon }}" style="font-size:{{ $size / 2 }}px;"></i>
    @elseif($initials)
        {{ $initials }}
    @else
        <i class="bi bi-person-fill" style="font-size:{{ $size / 2 }}px;"></i>
    @endif
</div>
