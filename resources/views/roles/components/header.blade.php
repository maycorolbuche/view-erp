@if ($role)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $role->name ?? '' }}
        </small>
    </h1>
@endif
