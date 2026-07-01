<x-app-layout>
    <x-slot name="header">Оформление заказа</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <strong>Ошибки валидации:</strong>
                        <ul class="mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('shop.checkout.store') }}" method="POST" id="checkoutForm">
                    @csrf

                    <h3 class="font-bold text-lg mb-4">Контактные данные</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-bold mb-2">Имя *</label>
                            <input type="text" name="customer_name" 
                                   value="{{ old('customer_name', auth()->user()->name ?? '') }}" 
                                   class="border rounded w-full py-2 px-3" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Телефон *</label>
                            <input type="text" name="customer_phone" 
                                   placeholder="+7 (___) ___-__-__" 
                                   class="border rounded w-full py-2 px-3" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Email</label>
                            <input type="email" name="customer_email" 
                                   value="{{ old('customer_email', auth()->user()->email ?? '') }}" 
                                   class="border rounded w-full py-2 px-3">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-2">Адрес доставки</label>
                            <input type="text" name="delivery_address" 
                                   class="border rounded w-full py-2 px-3">
                        </div>
                    </div>

                    <h3 class="font-bold text-lg mb-4">Способ оплаты</h3>
                    <div class="mb-6 space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="cash" checked class="mr-2"> 
                            Наличные при получении
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="yoomoney" class="mr-2"> 
                            Онлайн оплата (ЮMoney)
                        </label>
                    </div>

                    <h3 class="font-bold text-lg mb-4">Ваш заказ</h3>
                    <table class="min-w-full divide-y divide-gray-200 mb-6">
                        <tbody>
                            @foreach($cart as $item)
                                <tr>
                                    <td class="px-4 py-2">{{ $item['name'] }} × {{ $item['quantity'] }}</td>
                                    <td class="px-4 py-2 text-right font-bold">
                                        {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} ₽
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-50">
                                <td class="px-4 py-3 font-bold text-lg">ИТОГО</td>
                                <td class="px-4 py-3 text-right font-bold text-lg text-blue-600">
                                    {{ number_format($total, 0, ',', ' ') }} ₽
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <button type="submit" 
                            class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded text-lg">
                        ✅ Подтвердить заказ
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Отладочный скрипт --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkoutForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Форма отправляется!');
                    console.log('Action:', form.action);
                    console.log('Method:', form.method);
                    
                    // Проверяем все поля
                    const formData = new FormData(form);
                    for (let [key, value] of formData.entries()) {
                        console.log(key + ': ' + value);
                    }
                });
            } else {
                console.error('Форма не найдена!');
            }
        });
    </script>
</x-app-layout>