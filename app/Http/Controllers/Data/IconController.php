<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;

class IconController extends Controller
{
    public function index()
    {
        $icons = [];

        $path = base_path('node_modules/bootstrap-icons/icons');
        $bi = array_map(
            fn($file) => 'bi-' . str_replace('.svg', '', $file),
            array_filter(scandir($path), fn($file) => $file !== '.' && $file !== '..')
        );

        $icons['bi'] = array_values($bi);

        return $icons;
    }
}
