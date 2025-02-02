<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    public $timestamps = false;

    protected $fillable = ['nama', 'status', 'id_user'];

    public function User() {
        return $this->belongsTo(User::class, 'id_user');
    }
}
