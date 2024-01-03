@if ($profile)
    <x-title>
        {{ $profile->name ?? '' }}
    </x-title>
@endif
