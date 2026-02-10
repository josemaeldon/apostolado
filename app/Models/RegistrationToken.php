<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationToken extends Model
{
    protected $fillable = [
        'token',
        'description',
        'is_active',
        'max_uses',
        'used_count',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Check if the token is valid for use
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Increment the used count
     */
    public function incrementUsedCount(): void
    {
        $this->increment('used_count');
    }

    /**
     * Generate a random token (3 uppercase letters + 2 numbers)
     */
    public static function generateToken(): string
    {
        do {
            $letters = '';
            for ($i = 0; $i < 3; $i++) {
                $letters .= chr(rand(65, 90)); // A-Z
            }
            $numbers = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
            $token = $letters . $numbers;
        } while (self::where('token', $token)->exists());

        return $token;
    }
}
