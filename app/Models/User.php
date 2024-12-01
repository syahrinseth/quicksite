<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, 'syahrinseth@gmail.com') && $this->hasVerifiedEmail();
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public static function getForm()
    {
        return [
                \Filament\Forms\Components\TextInput::make('name')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                \Filament\Forms\Components\DateTimePicker::make('email_verified_at'),
                \Filament\Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(),
                \Filament\Forms\Components\TextInput::make('current_team_id')
                    ->numeric(),
                \Filament\Forms\Components\TextInput::make('profile_photo_path'),
                \Filament\Forms\Components\Textarea::make('two_factor_secret')
                    ->columnSpanFull(),
                    \Filament\Forms\Components\Textarea::make('two_factor_recovery_codes')
                    ->columnSpanFull(),
                \Filament\Forms\Components\DateTimePicker::make('two_factor_confirmed_at'),
        ];
    }
}
