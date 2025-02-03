<?php

namespace App\Models;

use App\Models\Penerbit;
use App\Models\Penulis;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    public $timestamps = false;
    
    protected $fillable = ['judul', 'id_penerbit', 'tgl_terbit', 'id_penulis', 'stock'];

    public function Penerbit() {
        return $this->belongsTo(Penerbit::class, 'id_penerbit');
    }

    public function Penulis() {
        return $this->belongsTo(Penulis::class, 'id_penulis');
    }

    public function KategoriBuku() {
        return $this->hasMany(KategoriBuku::class, 'id_buku');
    }
}
