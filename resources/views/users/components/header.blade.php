@if ($user)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $user->name ?? '' }}
        </small>
        @if ($user->id_employment_type)
            <small class="badge badge-primary" style="padding-left:10px;">
                {{ $user->employment_type->description ?? '' }}
            </small>
        @endif
    </h1>
@endif
