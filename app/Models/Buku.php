<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = ['judul', 'id_penerbit', 'tgl_terbit', 'id_penulis', 'stock'];

    public function Penerbit() {
        return $this->belongsTo(Penerbit::class);
    }

    public function Penulis() {
        return $this->belongsTo(Penulis::class);
    }
}
