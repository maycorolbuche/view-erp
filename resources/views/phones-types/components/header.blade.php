@if ($phone_type)
    <x-title>
        {{ $phone_type->description ?? '' }}
    </x-title>
@endif
