<?php

namespace App\Models;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    protected $table = 'kategori_buku';
    public $timestamps = false;

    protected $fillable = ['id_buku', 'id_kategori'];

    public function Buku() {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    public function Kategori() {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
