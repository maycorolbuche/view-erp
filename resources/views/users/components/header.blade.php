@if ($user)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $user->name ?? '' }}
        </small>
        @if ($user->id_branch)
            <small class="badge badge-success" style="padding-left:10px;">
                {{ $user->branch->name ?? '' }}
            </small>
        @endif
        @if ($user->id_employment_type)
            <small class="badge badge-primary" style="padding-left:10px;">
                {{ $user->employment_type->description ?? '' }}
            </small>
        @endif
    </h1>
    @if ($user->root == true)
        <blockquote class="blockquote-warning">
            <p>Este é um usuário do sistema.</p>
        </blockquote>
    @endif
@endif
