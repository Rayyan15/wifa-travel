<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function manifest()
    {
        return $this->hasOne(Manifest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($order) {
            Manifest::firstOrCreate(['order_id' => $order->id]);
        });

        static::updated(function ($order) {
            if ($order->wasChanged('payment_status') && $order->payment_status === 'paid') {
                Manifest::firstOrCreate(['order_id' => $order->id]);
            }
        });
    }
}