@if ($discount)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $discount->name ?? '' }}
        </small>
    </h1>
@endif
