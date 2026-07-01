<x-app-layout>
    <x-slot name="header">Корзина</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(empty($cart))
                    <p class="text-center py-12 text-gray-500">Корзина пуста</p>
                    <a href="{{ route('shop.index') }}" class="block text-center bg-blue-500 text-white py-2 px-4 rounded">Перейти в каталог</a>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Товар</th>
                                <th class="px-4 py-2 text-left">Цена</th>
                                <th class="px-4 py-2 text-left">Кол-во</th>
                                <th class="px-4 py-2 text-left">Сумма</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $item)
                                <tr>
                                    <td class="px-4 py-3 font-bold">{{ $item['name'] }}</td>
                                    <td class="px-4 py-3">{{ number_format($item['price'], 0, ',', ' ') }} ₽</td>
                                    <td class="px-4 py-3">{{ $item['quantity'] }}</td>
                                    <td class="px-4 py-3 font-bold">{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} ₽</td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('shop.cart.remove', $item['id']) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600">✕</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6 flex justify-between items-center">
                        <div class="text-2xl font-bold">Итого: {{ number_format($total, 0, ',', ' ') }} ₽</div>
                        <div class="flex gap-2">
                            <form action="{{ route('shop.cart.clear') }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded">Очистить</button>
                            </form>
                            <a href="{{ route('shop.checkout') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">Оформить заказ</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>