@if ($user)
    <x-title>
        {{ $user->name ?? '' }}
        @if ($user->id_branch)
            <span class="badge badge-success" style="padding-left:10px;">
                {{ $user->branch->name ?? '' }}
            </span>
        @endif
        @if ($user->id_employment_type)
            <span class="badge badge-primary" style="padding-left:10px;">
                {{ $user->employment_type->description ?? '' }}
            </span>
        @endif
    </x-title>
    @if ($user->root == true)
        <x-note type="warning">
            Este é um usuário do sistema.
        </x-note>
    @endif
@endif
