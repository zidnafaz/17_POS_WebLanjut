<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user';  // Mendefinisikan tabel yang digunakan model ini
    protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel
}
