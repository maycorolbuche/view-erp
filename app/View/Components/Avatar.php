<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class Avatar extends BaseComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $name = null,
        public ?string $initials = null,
        public ?string $photo = null,
        public ?string $icon = null,
        public string|int|null $size = 32
    ) {
        $this->name = $name;
        $this->photo = $photo;
        $this->size = $size;
        $this->icon = $this->formatIcon($icon);

        $this->initials = $initials ?: $this->generateInitials($name);
    }

    /**
     * Generate initials from name.
     */
    protected function generateInitials(?string $name): string
    {
        if (!$name) {
            return "";
        }

        $parts = preg_split('/\s+/', trim($name));
        $parts = array_filter($parts);

        if (count($parts) === 1) {
            return mb_strtoupper(
                mb_substr($parts[0], 0, 1)
            );
        }

        $first = mb_substr($parts[0], 0, 1);
        $last = mb_substr(end($parts), 0, 1);

        return mb_strtoupper($first . $last);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.avatar');
    }
}
