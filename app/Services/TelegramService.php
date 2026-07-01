<?php

namespace App\Services;

use App\Models\Order;

class TelegramService
{
    private $botToken;
    private $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');
    }

    public function sendNewOrderNotification(Order $order)
    {
        $text = "🏍 *Новый заказ №{$order->id}*\n\n";
        $text .= "👤 *Клиент:* {$order->customer_name}\n";
        $text .= "📞 *Телефон:* {$order->customer_phone}\n";
        if ($order->customer_email) {
            $text .= "📧 *Email:* {$order->customer_email}\n";
        }
        if ($order->delivery_address) {
            $text .= "📍 *Адрес:* {$order->delivery_address}\n";
        }
        $text .= "\n*Товары:*\n";
        
        foreach ($order->items as $item) {
            $text .= "• {$item->motorcycle->full_name} × {$item->quantity} = " . 
                     number_format($item->subtotal, 0, ',', ' ') . " ₽\n";
        }
        
        $text .= "\n💰 *Итого:* " . number_format($order->total_amount, 0, ',', ' ') . " ₽";
        $text .= "\n💳 *Оплата:* " . ($order->payment_method === 'yoomoney' ? 'ЮMoney' : 'Наличные');

        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id' => $this->chatId,
            'text' => $text,
            'parse_mode' => 'Markdown',
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}