<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

abstract class BaseComponent extends Component
{
    /**
     * Formata ícones do Bootstrap Icons.
     */
    protected function formatIcon(?string $icon): string
    {
        if (empty($icon)) {
            return '';
        }

        // já possui classe completa
        if (Str::startsWith($icon, 'bi ')) {
            return $icon;
        }

        return 'bi bi-' . $icon;
    }
}
