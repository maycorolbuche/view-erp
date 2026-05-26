@if ($system)
    <x-title>
        <i class="{{ $system->icon ?? '' }}"> </i>
        <span style="padding-left:10px;">
            {{ $system->name ?? '' }}
        </span>
        <span class="badge text-bg-primary" style="padding-left:10px;">
            /{{ $system->slug ?? '' }}
        </span>
    </x-title>
@endif
