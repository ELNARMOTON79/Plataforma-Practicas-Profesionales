<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class SystemSettings
{
    protected static $defaults = [
        'maintenance_mode' => false,
        'send_emails' => true,
        'clean_logs_days' => 180,
    ];

    /**
     * Get the path to the settings file.
     */
    public static function path(): string
    {
        return storage_path('app/settings.json');
    }

    /**
     * Get all configuration settings merged with defaults.
     */
    public static function all(): array
    {
        $path = self::path();
        if (!File::exists($path)) {
            return self::$defaults;
        }

        try {
            $content = File::get($path);
            $settings = json_decode($content, true);
            return array_merge(self::$defaults, is_array($settings) ? $settings : []);
        } catch (\Exception $e) {
            \Log::error('Error reading settings file: ' . $e->getMessage());
            return self::$defaults;
        }
    }

    /**
     * Get a specific setting value.
     */
    public static function get(string $key, $default = null)
    {
        $settings = self::all();
        return $settings[$key] ?? $default;
    }

    /**
     * Set a specific setting value.
     */
    public static function set(string $key, $value): void
    {
        $settings = self::all();
        $settings[$key] = $value;
        self::save($settings);
    }

    /**
     * Persist the configuration array to the settings.json file.
     */
    public static function save(array $settings): void
    {
        try {
            $path = self::path();
            $dir = dirname($path);
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            File::put($path, json_encode($settings, JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            \Log::error('Error saving settings file: ' . $e->getMessage());
        }
    }
}
