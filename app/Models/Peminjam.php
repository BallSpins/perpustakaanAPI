<?php

namespace App\Models;

use App\Models\User;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    protected $table = 'peminjam';
    public $timestamps = false;

    protected $fillable = ['id_user', 'tgl_pinjam', 'tgl_kembali', 'id_buku'];

    public function User() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function Buku() {
        return $this->belongsTo(Buku::class, 'id_buku');
    }
}
