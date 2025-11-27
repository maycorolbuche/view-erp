<?php

namespace App\Helpers;

use App\Models\Config;

class ConfigHelper
{
    public static function all()
    {
        $configs = Config::pluck('value', 'key')->toArray();
        return $configs;
    }

    public static function get($key, $default = null)
    {
        $config = Config::where('key', $key)->first();
        if ($config) {
            return $config->value;
        }
        return $default;
    }

    public static function set($key, $value)
    {
        $config = Config::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        return $config;
    }
}
