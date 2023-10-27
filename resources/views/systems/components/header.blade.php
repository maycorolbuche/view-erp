@if ($system)
    <h1 class="mtn">
        <small>
            <i class="{{ $system->icon ?? '' }}"> </i>
        </small>
        <small style="padding-left:10px;">
            {{ $system->name ?? '' }}
        </small>
        <small class="badge badge-primary" style="padding-left:10px;">
            /{{ $system->slug ?? '' }}
        </small>
    </h1>
@endif
