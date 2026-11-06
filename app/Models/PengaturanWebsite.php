<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanWebsite extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_websites';

    protected $fillable = ['key', 'value', 'label', 'tipe'];

    /**
     * Get setting by key with optional default.
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting by key.
     */
    public static function setValue(string $key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get all settings as key => value array.
     */
    public static function getAllSettings()
    {
        return static::pluck('value', 'key')->toArray();
    }
}
