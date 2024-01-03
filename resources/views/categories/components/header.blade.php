@if ($category)
    <x-title>
        {{ $category->name ?? '' }}
    </x-title>
@endif
