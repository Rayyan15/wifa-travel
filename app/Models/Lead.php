<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $guarded = ['id'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::updated(function ($lead) {
            if ($lead->wasChanged('status') && in_array($lead->status, ['ordered', 'lunas'])) {
                $paymentStatus = $lead->status === 'lunas' ? 'paid' : 'unpaid';
                
                $package = $lead->package;
                if ($package && $package->remaining_seats <= 0) {
                    throw new \Exception('Gagal mengubah status: Kursi untuk paket ini sudah penuh.');
                }

                $order = Order::firstOrCreate(
                    ['lead_id' => $lead->id],
                    [
                        'package_id' => $lead->package_id,
                        'order_code' => 'ORD-' . strtoupper(substr(uniqid(), -6)),
                        'user_id' => auth()->id(),
                        'total_amount' => $package ? $package->price : 0,
                        'payment_status' => $paymentStatus
                    ]
                );

                if ($order->wasRecentlyCreated && $package) {
                    $package->decrement('remaining_seats');
                }

                if (!$order->wasRecentlyCreated && $paymentStatus === 'paid' && $order->payment_status !== 'paid') {
                    $order->update(['payment_status' => 'paid']);
                }
            }
        });
    }
}