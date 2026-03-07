<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationToken extends Model
{
    public const MEMBER_CITIES = [
        'Augusto Corrêa',
        'Aurora do Pará',
        'Bonito',
        'Bragança do Pará',
        'Cachoeira do Piriá',
        'Capitão Poço',
        'Dom Eliseu',
        'Garrafão do Norte',
        'Ipixuna do Pará',
        'Irituia',
        'Mãe do Rio',
        'Nova Esperança do Piriá',
        'Ourém',
        'Paragominas',
        'Rondon do Pará',
        'Santa Luzia do Pará',
        'São Miguel do Guamá',
        'Tracuateua',
        'Ulianópolis',
        'Viseu',
    ];

    public const MEMBER_PARISHES = [
        'Cristo Crucificado',
        'Imaculada Conceição',
        'Nossa Senhora Aparecida',
        'Nossa Senhora da Divina Providência',
        'Nossa Senhora da Piedade',
        'Nossa Senhora de Nazaré',
        'Nossa Senhora do Perpétuo Socorro',
        'Nossa Senhora do Rosário',
        'Sagrado Coração de Jesus',
        'Santa Luzia',
        'Santa Teresinha do Menino Jesus',
        'Santo Antônio Maria Zaccaria',
        'São Francisco de Assis',
        'São João Batista',
        'São José',
        'São Miguel Arcanjo',
        'São Pedro Apóstolo',
        'São Raimundo Nonato',
        'São Sebastião',
    ];

    protected $fillable = [
        'token',
        'description',
        'is_active',
        'max_uses',
        'used_count',
        'expires_at',
        'member_city',
        'member_parish',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Whether this token enforces city/parish choices.
     */
    public function hasScopedMemberLocation(): bool
    {
        return filled($this->member_city) && filled($this->member_parish);
    }

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
