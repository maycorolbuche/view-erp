<div>

    @if ($title != '')
        <div class="d-flex align-items-center gap-3 my-3 ms-2">
            <span class="{{ $icon }}"></span>
            <h6 class="mb-0">{{ $title }}</h6>
        </div>
    @endif

    <div
        class="gap-2 row-gap-3 d-flex flex-row flex-wrap align-items-stretch {{ $right ? 'justify-content-end;' : '' }}">
        {{ $slot }}
    </div>

</div>
