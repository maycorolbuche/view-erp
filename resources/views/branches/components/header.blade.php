@if ($branch)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $branch->name ?? '' }}
        </small>
    </h1>
@endif
