<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    protected $table = 'penulis';
    protected $fillable = ['nama'];

    public function Buku() {
        return $this->hasMany(Buku::class);
    }
}
