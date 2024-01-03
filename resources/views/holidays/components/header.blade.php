@if ($holiday)
    <x-title>
        {{ $holiday->name ?? '' }}
    </x-title>
@endif
