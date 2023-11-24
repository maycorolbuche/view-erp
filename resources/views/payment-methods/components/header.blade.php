@if ($payment_method)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $payment_method->name ?? '' }}
        </small>
    </h1>
@endif
