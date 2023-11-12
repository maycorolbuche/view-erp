@if ($civil_status)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $civil_status->description ?? '' }}
        </small>
    </h1>
@endif
