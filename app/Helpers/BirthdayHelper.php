<?php

namespace App\Helpers;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class BirthdayHelper
{
    public const MONTHS = [
        1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro',
    ];

    /**
     * Load only directory fields; birth years are never sent to the views.
     *
     * @return Collection<int, array{name: string, initials: string, active: bool, month: int|null, day: int|null, date: string|null, next: CarbonImmutable|null, today: bool}>
     */
    public static function users(bool $activeOnly = false): Collection
    {
        $today = CarbonImmutable::today();

        return User::query()
            ->when($activeOnly, fn (Builder $query): Builder => $query->active())
            ->orderBy('name')
            ->get(['id_user', 'name', 'birth_date', 'active'])
            ->map(function (User $user) use ($today): array {
                $value = (string) $user->birth_date;
                $valid = preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $parts)
                    && checkdate((int) $parts[2], (int) $parts[3], (int) $parts[1]);
                $month = $valid ? (int) $parts[2] : null;
                $day = $valid ? (int) $parts[3] : null;
                $next = null;

                if ($valid) {
                    // February 29 is observed on March 1 in non-leap years.
                    $next = $today->setDate($today->year, $month, 1)->addDays($day - 1);
                    if ($next->lessThan($today)) {
                        $next = $today->setDate($today->year + 1, $month, 1)->addDays($day - 1);
                    }
                }

                return [
                    'name' => $user->name,
                    'initials' => $user->initials,
                    'active' => (bool) $user->active,
                    'month' => $month,
                    'day' => $day,
                    'date' => $valid ? sprintf('%02d/%02d', $day, $month) : null,
                    'next' => $next,
                    'today' => $next !== null && $next->isSameDay($today),
                ];
            });
    }

    /** @return Collection<int, array<string, mixed>> */
    public static function upcoming(int $limit = 3): Collection
    {
        return self::users(true)
            ->filter(fn (array $birthday): bool => $birthday['next'] !== null)
            ->sortBy('next')
            ->take($limit)
            ->values();
    }
}
