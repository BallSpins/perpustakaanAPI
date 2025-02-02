<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $table = 'murid';
    public $timestamps = false;

    protected $fillable = ['nama', 'kelas', 'status', 'id_user'];

    public function User() {
        return $this->belongsTo(User::class, 'id_user');
    }
}
