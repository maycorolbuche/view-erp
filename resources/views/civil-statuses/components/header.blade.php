@if ($civil_status)
    <x-title>
        {{ $civil_status->description ?? '' }}
    </x-title>
@endif
