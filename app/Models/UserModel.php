<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'm_user';  // Mendefinisikan tabel yang digunakan model ini
    protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel

    protected $fillable = ['level_id', 'username', 'nama', 'password', 'profile_picture'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function getJWTIdentifier()
    {
        return $this -> getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function level(): BelongsTo {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function getRoleName(): string {
        return $this -> level -> level_name;
    }

    public function hasRole($role): bool {
        return $this -> level -> level_kode == $role;
    }

    public function getRole() {
        return $this -> level -> level_kode;
    }
}
