@if ($employment_type)
    <x-title>
        {{ $employment_type->description ?? '' }}
    </x-title>
@endif
