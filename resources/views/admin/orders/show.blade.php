<x-admin-layout>
    <x-slot name="header">Заказ #{{ $order->id }}</x-slot>
    <x-slot name="subheader">от {{ $order->created_at->format('d.m.Y в H:i') }}</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Левая колонка: информация -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Статус -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="ri-flag-line text-indigo-600"></i> Статус заказа
                </h3>
                
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <select name="status" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 mb-3">
                        <option value="new" {{ $order->status === 'new' ? 'selected' : '' }}>🟡 Новый</option>
                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>🟢 Оплачен</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>🔵 В обработке</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>🟣 Отправлен</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>✅ Доставлен</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Отменён</option>
                    </select>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl">
                        Сохранить статус
                    </button>
                </form>
            </div>

            <!-- Клиент -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="ri-user-3-line text-indigo-600"></i> Клиент
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center font-bold text-indigo-600 text-lg">
                            {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold text-gray-800">{{ $order->customer_name }}</div>
                            @if($order->user)
                                <div class="text-xs text-gray-500">Зарегистрирован</div>
                            @else
                                <div class="text-xs text-gray-500">Гость</div>
                            @endif
                        </div>
                    </div>
                    <div class="pt-3 border-t border-gray-100 space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="ri-phone-line text-gray-400"></i>
                            <a href="tel:{{ $order->customer_phone }}" class="hover:text-indigo-600">{{ $order->customer_phone }}</a>
                        </div>
                        @if($order->customer_email)
                            <div class="flex items-center gap-2 text-gray-600">
                                <i class="ri-mail-line text-gray-400"></i>
                                <a href="mailto:{{ $order->customer_email }}" class="hover:text-indigo-600">{{ $order->customer_email }}</a>
                            </div>
                        @endif
                        @if($order->delivery_address)
                            <div class="flex items-start gap-2 text-gray-600">
                                <i class="ri-map-pin-line text-gray-400 mt-1"></i>
                                <span>{{ $order->delivery_address }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Оплата -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="ri-wallet-3-line text-indigo-600"></i> Оплата
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Способ:</span>
                        <span class="font-medium text-gray-800">
                            {{ $order->payment_method === 'yoomoney' ? '💳 ЮMoney' : '💵 Наличные' }}
                        </span>
                    </div>
                    @if($order->payment_id)
                        <div class="flex justify-between">
                            <span class="text-gray-500">ID платежа:</span>
                            <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ Str::limit($order->payment_id, 12) }}</code>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Правая колонка: товары -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="ri-shopping-bag-3-line text-indigo-600"></i> 
                        Товары в заказе ({{ $order->items->count() }})
                    </h3>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <div class="p-6 hover:bg-gray-50 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                    @if($item->motorcycle && $item->motorcycle->image)
                                        <img src="{{ asset('storage/' . $item->motorcycle->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="ri-motorbike-line text-3xl text-gray-300"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-gray-800">
                                        {{ $item->motorcycle ? $item->motorcycle->brand . ' ' . $item->motorcycle->model : 'Товар удалён' }}
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        {{ number_format($item->price, 0, ',', ' ') }} ₽ × {{ $item->quantity }} шт.
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-indigo-600">
                                        {{ number_format($item->subtotal, 0, ',', ' ') }} ₽
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Итого -->
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="text-lg font-bold text-gray-800">ИТОГО:</div>
                        <div class="text-3xl font-bold text-indigo-600">
                            {{ number_format($order->total_amount, 0, ',', ' ') }} ₽
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800">
                    <i class="ri-arrow-left-line"></i>
                    Вернуться к списку заказов
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>