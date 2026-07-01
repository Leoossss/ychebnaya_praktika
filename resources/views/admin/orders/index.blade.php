<x-admin-layout>
    <x-slot name="header">Заказы</x-slot>
    <x-slot name="subheader">Управление заказами клиентов</x-slot>

    <div class="mb-6 flex items-center gap-3">
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
            <i class="ri-shopping-bag-3-line text-2xl text-green-600"></i>
        </div>
        <div>
            <div class="text-sm text-gray-500">Всего заказов</div>
            <div class="text-2xl font-bold text-gray-800">{{ $orders->total() }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">№</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Клиент</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Товары</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Сумма</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Оплата</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Статус</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Дата</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800">#{{ $order->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center font-bold text-indigo-600">
                                    {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $order->customer_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $order->items->count() }} шт.
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($order->payment_method === 'yoomoney')
                                <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded-full font-medium">
                                    <i class="ri-wallet-3-line"></i> ЮMoney
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full font-medium">
                                    <i class="ri-bank-card-line"></i> Наличные
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusConfig = [
                                    'new' => ['bg-yellow-100', 'text-yellow-700', 'ri-time-line', 'Новый'],
                                    'paid' => ['bg-green-100', 'text-green-700', 'ri-check-line', 'Оплачен'],
                                    'processing' => ['bg-blue-100', 'text-blue-700', 'ri-loader-4-line', 'В обработке'],
                                    'shipped' => ['bg-purple-100', 'text-purple-700', 'ri-truck-line', 'Отправлен'],
                                    'delivered' => ['bg-emerald-100', 'text-emerald-700', 'ri-gift-line', 'Доставлен'],
                                    'cancelled' => ['bg-red-100', 'text-red-700', 'ri-close-circle-line', 'Отменён'],
                                ];
                                $status = $statusConfig[$order->status] ?? $statusConfig['new'];
                            @endphp
                            <span class="{{ $status[0] }} {{ $status[1] }} text-xs px-3 py-1 rounded-full font-medium inline-flex items-center gap-1">
                                <i class="{{ $status[2] }}"></i>
                                {{ $status[3] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $order->created_at->format('d.m.Y') }}
                            <div class="text-xs">{{ $order->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                Подробнее →
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <i class="ri-shopping-bag-3-line text-4xl text-gray-300 mb-2"></i>
                            <div class="text-gray-500">Заказов пока нет</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</x-admin-layout>