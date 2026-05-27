<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value', 'type', 'label', 'description', 'is_encrypted', 'sort_order'];

    protected $casts = ['is_encrypted' => 'boolean'];

    // Get decoded value
    public function getDecodedValue(): ?string
    {
        if (!$this->value) return null;
        if ($this->is_encrypted) {
            try { return Crypt::decryptString($this->value); }
            catch (\Exception $e) { return null; }
        }
        return $this->value;
    }

    // Static helper to get a setting value by key
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) return $default;
        return $setting->getDecodedValue() ?? $default;
    }

    // Static helper to set a value
    public static function set(string $key, mixed $value): void
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) return;

        $storeValue = $setting->is_encrypted
            ? Crypt::encryptString((string) $value)
            : (string) $value;

        $setting->update(['value' => $storeValue]);
    }
}