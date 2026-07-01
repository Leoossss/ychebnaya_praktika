<?php

namespace App\Services;

use App\Models\Order;
use YooKassa\Client;

class YooKassaService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuth(
            config('services.yookassa.shop_id'),
            config('services.yookassa.secret_key')
        );
    }

    public function createPayment(Order $order)
    {
        $payment = $this->client->createPayment([
            'amount' => [
                'value' => number_format($order->total_amount, 2, '.', ''),
                'currency' => 'RUB',
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => route('shop.order.success', $order->id),
            ],
            'capture' => true,
            'description' => "Заказ №{$order->id} в Мотосалоне",
            'metadata' => [
                'order_id' => $order->id,
            ],
        ], uniqid('', true));

        return $payment;
    }
}