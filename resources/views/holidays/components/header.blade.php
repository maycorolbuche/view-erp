@if ($holiday)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $holiday->name ?? '' }}
        </small>
    </h1>
@endif
