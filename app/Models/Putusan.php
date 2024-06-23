<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Putusan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function penyitaan()
    {
        return $this->belongsTo(Penyitaan::class);
    }
}
