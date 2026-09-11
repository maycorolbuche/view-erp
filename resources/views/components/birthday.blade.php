@props(['birthday'])

<div class="bday">
    <x-avatar :initials="$birthday['initials']" :size="38" class="flex-shrink-0" aria-hidden="true" />
    <div class="text-break">
        <div class="n">
            {{ $birthday['name'] }}
            @unless ($birthday['active'])
                <span class="badge text-bg-secondary">Inativo</span>
            @endunless
        </div>
        <div class="w">
            @if ($birthday['today'])
                <span class="text-primary fw-semibold">Hoje 🎉</span> ·
            @endif
            {{ $birthday['date'] ?? 'Data não informada' }}
        </div>
    </div>
</div>
