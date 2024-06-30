<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eksekusi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function barangbukti()
    {
        return $this->belongsTo(BarangBukti::class);
    }
}
