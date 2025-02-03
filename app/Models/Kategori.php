<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    public $timestamps = false;

    protected $fillable = ['nama'];

    public function KategoriBuku() {
        return $this->hasMany(KategoriBuku::class);
    }
}
