<x-app-layout>
    <x-slot name="header">Заказ оформлен</x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                <div class="text-6xl mb-4">✅</div>
                <h2 class="text-2xl font-bold mb-4">Спасибо за заказ!</h2>
                <p class="text-gray-600 mb-2">Ваш заказ №<strong>{{ $order->id }}</strong> успешно оформлен.</p>
                <p class="text-gray-600 mb-6">Сумма: <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</strong></p>
                <a href="{{ route('shop.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Вернуться в каталог</a>
            </div>
        </div>
    </div>
</x-app-layout>