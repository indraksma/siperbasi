<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangBukti extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function penyitaan()
    {
        return $this->belongsTo(Penyitaan::class);
    }
    public function putusan()
    {
        return $this->belongsTo(Putusan::class);
    }

    public function eksekusi()
    {
        return $this->hasOne(Eksekusi::class);
    }
}
