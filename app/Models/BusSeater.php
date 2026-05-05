<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusSeater extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function manifest()
    {
        return $this->belongsTo(Manifest::class);
    }
}
