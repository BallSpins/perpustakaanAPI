<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';
    public $timestamps = false;

    protected $fillable = ['nama', 'id_user'];

    public function User() {
        return $this->belongsTo(User::class, 'id_user');
    }
}
