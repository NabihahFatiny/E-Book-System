<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use App\Models\Watchlist;


class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    // Only admin users are allowed to log in to the Filament admin panel.
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    protected $fillable = [
        'name',
        'username',
        'full_name',
        'email',
        'contact_no',
        'ic_passport',
        'role',
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

    // A user can have many borrowing records.
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    // A user can watch many books through the watchlists table.
    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
}
