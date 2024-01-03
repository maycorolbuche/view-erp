@if ($client)
    <x-title>
        {{ $client->name ?? '' }}
    </x-title>
@endif
