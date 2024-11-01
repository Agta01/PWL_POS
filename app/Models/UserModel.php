<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // use HasFactory;

    protected $table = 'm_user'; // Ensure this is the correct table name
    protected $primaryKey = 'user_id'; // Set the primary key
    public $incrementing = false; // If user_id is not an auto-incrementing integer
    protected $keyType = 'string'; // Set to 'string' if user_id is a string; change accordingly

    // @var array 

    protected $fillable = ['username', 'password', 'nama','level_id', 'created_at', 'updated_at'];
    protected $hidden = ['password']; // jangan di tampilkan saaat select
    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    public function getRole()
    {
        return $this->level->level_kode;
    }
}
