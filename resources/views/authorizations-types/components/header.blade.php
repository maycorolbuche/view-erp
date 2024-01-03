@if ($authorization_type)
    <x-title>
        {{ $authorization_type->name ?? '' }}
    </x-title>
@endif
