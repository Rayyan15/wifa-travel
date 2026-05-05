<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Package;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create an order and decrement package seats safely using a database transaction.
     *
     * @param array $data Validated order data
     * @param int $userId The ID of the user creating the order
     * @return Order
     * @throws \Exception
     */
    public function createOrder(array $data, int $userId): Order
    {
        return DB::transaction(function () use ($data, $userId) {
            $data['order_code'] = 'ORD-' . strtoupper(uniqid());
            $data['user_id']    = $userId;

            $package = Package::findOrFail($data['package_id']);
            
            // Check remaining seats to avoid negative values
            if ($package->remaining_seats > 0) {
                $package->decrement('remaining_seats');
            } else {
                throw new \Exception('Maaf, kursi untuk paket ini sudah penuh.');
            }

            return Order::create($data);
        });
    }
}
