@if ($transaction_type)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $transaction_type->name ?? '' }}
        </small>
    </h1>
@endif
