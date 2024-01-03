@if ($role)
    <x-title>
        {{ $role->name ?? '' }}
    </x-title>
@endif
