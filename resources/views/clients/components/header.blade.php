@if ($client)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $client->name ?? '' }}
        </small>
    </h1>
@endif
