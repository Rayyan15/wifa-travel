<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function roomList()
    {
        return $this->belongsTo(RoomList::class);
    }

    public function busSeater()
    {
        return $this->hasOne(BusSeater::class);
    }
}