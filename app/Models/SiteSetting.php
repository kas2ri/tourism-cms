<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    /**
     * Cache key for site settings.
     */
    public const CACHE_KEY = 'site_settings';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget(self::CACHE_KEY);
        });

        static::deleted(function () {
            Cache::forget(self::CACHE_KEY);
        });
    }

    /**
     * Get a setting value by its key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::rememberForever(self::CACHE_KEY, function () {
            return static::all()->keyBy('key');
        });

        $setting = $settings->get($key);

        if (! $setting) {
            return $default;
        }

        return match ($setting->type) {
            'json', 'array' => is_array($setting->value) ? $setting->value : json_decode($setting->value, true),
            'boolean', 'bool' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'integer', 'int' => (int) $setting->value,
            'float', 'double' => (float) $setting->value,
            default => $setting->value,
        };
    }

    /**
     * Set or update a setting value.
     */
    public static function set(string $key, mixed $value, string $type = 'text', string $group = 'general'): self
    {
        $stringValue = is_array($value) || is_object($value)
            ? json_encode($value)
            : (string) $value;

        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $stringValue,
                'type' => $type,
                'group' => $group,
            ]
        );

        Cache::forget(self::CACHE_KEY);

        return $setting;
    }
}

