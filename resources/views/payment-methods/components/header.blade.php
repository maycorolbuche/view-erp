@if ($payment_method)
    <x-title>
        {{ $payment_method->name ?? '' }}
    </x-title>
@endif
