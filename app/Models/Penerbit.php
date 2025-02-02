<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    protected $table = 'penerbit';
    public $timestamps = false;

    protected $fillable = ['nama'];

    public function Buku() {
        return $this->hasMany(Buku::class);
    }
}
