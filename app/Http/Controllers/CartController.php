<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('shop.cart', compact('cart', 'total'));
    }

    public function add(Request $request, Motorcycle $motorcycle)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$motorcycle->id])) {
            $cart[$motorcycle->id]['quantity']++;
        } else {
            $cart[$motorcycle->id] = [
                'id' => $motorcycle->id,
                'name' => $motorcycle->full_name,
                'price' => $motorcycle->price,
                'image' => $motorcycle->image,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Мотоцикл добавлен в корзину!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Товар удалён из корзины');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Корзина очищена');
    }
}