<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Filesystem\FilesystemAdapter;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellidos',
        'fecha_nacimiento',
        'genero',
        'username',  // Campo crucial para autenticación
        'email',
        'email_verified_at',  // Importante para verificación
        'password',
        'rol', 
        'foto_perfil'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'fecha_nacimiento' => 'date:Y-m-d',
        'password' => 'hashed',  // Auto-hashing para Laravel 10+
    ];

    /**
     * Get the field name for authentication.
     *
     * @return string
     */
    // public function getAuthIdentifierName()
// {
//     return 'username';
// }


    /**
     * Calculate user age.
     *
     * @return int|null
     */
    public function getEdadAttribute(): ?int
    {
        return $this->fecha_nacimiento ? Carbon::parse($this->fecha_nacimiento)->age : null;
    }

    /**
     * Get full profile picture URL.
     *
     * @return string
     */
    public function getFotoPerfilUrlAttribute(): string
    {
        if (empty($this->foto_perfil)) {
            return asset('images/default-profile.png');
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        return $disk->exists($this->foto_perfil)
            ? $disk->url($this->foto_perfil)
            : asset('images/default-profile.png');

        /*return Storage::disk('public')->exists($this->foto_perfil)
            ? Storage::disk('public')->url($this->foto_perfil)
            : asset('images/default-profile.png');
        */
    }

    /**
     * Automatically hash passwords.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::needsRehash($value) 
            ? bcrypt($value) 
            : $value;
    }

    /**
     * Scope for active (verified) users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    /**
     * Get user's full name.
     *
     * @return string
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim(sprintf('%s %s', $this->nombre, $this->apellidos));
    }

    /**
     * Find user by username or email.
     *
     * @param  string  $identifier
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function findForAuth($identifier)
    {
        return static::where('username', $identifier)
            ->orWhere('email', $identifier)
            ->first();
    }

    // ✅ Relación con ventas
    public function ventas()
        {
            return $this->hasMany(Venta::class);
        }

    public function productos()
        {
    return $this->hasMany(Producto::class);
        }

}