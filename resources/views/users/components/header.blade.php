@if ($user)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $user->name ?? '' }}
        </small>
    </h1>
@endif
