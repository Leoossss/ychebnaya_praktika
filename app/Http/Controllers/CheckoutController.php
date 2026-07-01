<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Корзина пуста');
        }
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('shop.checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        Log::info('=== ОФОРМЛЕНИЕ ЗАКАЗА ===');
        Log::info('Данные формы:', $request->all());

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email',
            'delivery_address' => 'nullable|string',
            'payment_method' => 'required|in:cash,yoomoney',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Корзина пуста');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'new',
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'] ?? null,
                'delivery_address' => $validated['delivery_address'] ?? null,
                'payment_method' => $validated['payment_method'],
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'motorcycle_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $moto = Motorcycle::find($item['id']);
                if ($moto) {
                    $moto->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();
            session()->forget('cart');

            // Оплата через ЮKassa
            if ($validated['payment_method'] === 'yoomoney') {
                try {
                    $paymentUrl = $this->createYooKassaPayment($order);
                    Log::info('Редирект на ЮKassa: ' . $paymentUrl);
                    return redirect($paymentUrl);
                } catch (\Exception $e) {
                    Log::error('YooKassa error: ' . $e->getMessage());
                    return redirect()->route('shop.order.success', $order->id)
                        ->with('warning', 'Заказ создан, но оплата не прошла: ' . $e->getMessage());
                }
            }

            return redirect()->route('shop.order.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return back()->with('error', 'Ошибка: ' . $e->getMessage());
        }
    }

    /**
     * Создание платежа в ЮKassa через cURL
     */
    private function createYooKassaPayment(Order $order): string
    {
        $shopId = config('services.yookassa.shop_id');
        $secretKey = config('services.yookassa.secret_key');

        if (empty($shopId) || empty($secretKey)) {
            throw new \Exception('ЮKassa не настроена. Добавьте YOOKASSA_SHOP_ID и YOOKASSA_SECRET_KEY в .env');
        }

        $payload = [
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
        ];

        $ch = curl_init('https://api.yookassa.ru/v3/payments');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Idempotence-Key: ' . uniqid('motosalon_', true),
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, "{$shopId}:{$secretKey}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("cURL error: " . $error);
        }

        Log::info('YooKassa response [' . $httpCode . ']: ' . $response);

        $data = json_decode($response, true);

        if ($httpCode !== 200 || !isset($data['confirmation']['confirmation_url'])) {
            $errorMsg = $data['description'] ?? $response ?? 'Unknown error';
            throw new \Exception("YooKassa API error: " . $errorMsg);
        }

        // Сохраняем payment_id в заказе
        if (isset($data['id'])) {
            $order->update(['payment_id' => $data['id']]);
        }

        return $data['confirmation']['confirmation_url'];
    }

    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        session()->forget('cart');
        return view('shop.success', compact('order'));
    }

    public function yoomoneyWebhook(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        
        if (isset($data['event']) && $data['event'] === 'payment.succeeded') {
            $paymentId = $data['object']['id'];
            $orderId = $data['object']['metadata']['order_id'] ?? null;
            
            if ($orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    $order->update([
                        'status' => 'paid',
                        'payment_id' => $paymentId,
                    ]);
                }
            }
        }
        
        return response()->json(['ok' => true]);
    }
}