<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasRoles;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['admin', 'provider']);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isProvider(): bool
    {
        return $this->hasRole('provider');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function providerProfile(): HasOne
    {
        return $this->hasOne(ProviderProfile::class);
    }

    public function providedServices(): HasMany
    {
        return $this->hasMany(Service::class, 'provider_id');
    }

    public function assignedBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'provider_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
