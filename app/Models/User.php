<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'pterodactyl_user_id',
        'role_id',
    ];

    /**
     * Get the role that owns the user.
     */
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the tickets for the user.
     */
    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Check if the user has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        return $this->role?->permissions->contains('slug', $permission) ?? false;
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role?->slug === $role;
    }

    /**
     * Scope a query to only include users with a specific role.
     */
    public function scopeWithRole($query, string $role)
    {
        return $query->whereHas('role', function ($q) use ($role) {
            $q->where('slug', $role);
        });
    }

    /**
     * Scope a query to only include admins.
     */
    public function scopeAdmin($query)
    {
        return $this->scopeWithRole($query, 'admin');
    }

    /**
     * Scope a query to only include users linked to Pterodactyl.
     */
    public function scopeWithPterodactyl($query)
    {
        return $query->whereNotNull('pterodactyl_user_id')->where('pterodactyl_user_id', '>', 0);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (!$user->role_id) {
                $user->role_id = Role::where('slug', 'user')->first()?->id;
            }
        });
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

    /**
     * Nom d'affichage: « Prénom Nom » si disponible, sinon `name`.
     */
    public function getDisplayNameAttribute(): string
    {
        $first = trim((string) ($this->first_name ?? ''));
        $last = trim((string) ($this->last_name ?? ''));
        $composed = trim($first . ' ' . $last);
        return $composed !== '' ? $composed : (string) ($this->name ?? '');
    }

    /**
     * Normalise les espaces (trim + compresse multiples espaces) pour éviter les doublons invisibles.
     */
    private static function normalizeSpaces(?string $value): string
    {
        $value = trim((string) $value);
        return (string) preg_replace('/\s+/u', ' ', $value);
    }

    public function setFirstNameAttribute($value): void
    {
        $this->attributes['first_name'] = self::normalizeSpaces($value);
    }

    public function setLastNameAttribute($value): void
    {
        $this->attributes['last_name'] = self::normalizeSpaces($value);
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = self::normalizeSpaces($value);
    }
}
