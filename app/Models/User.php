<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Role constants
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_EDITOR = 'editor';
    const ROLE_USER = 'user';

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is editor
     */
    public function isEditor(): bool
    {
        return $this->role === self::ROLE_EDITOR;
    }

    /**
     * Check if user is admin or editor
     */
    public function isAdminOrEditor(): bool
    {
        return $this->isAdmin() || $this->isEditor();
    }

    /**
     * Check if user can access a specific resource
     */
    public function canAccess(string $resource): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->isEditor()) {
            // Editor can access: Pages, Articles, Intentions, Events, Gallery, Cadastros
            $editorResources = [
                'pages',
                'articles',
                'prayer-intentions',
                'events',
                'media-gallery',
                'member-registrations',
                'registration-tokens',
                'categories',
            ];
            
            return in_array($resource, $editorResources);
        }

        return false;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
