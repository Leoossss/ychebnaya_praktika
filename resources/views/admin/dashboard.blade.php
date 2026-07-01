<x-admin-layout>
    <x-slot name="header">Дашборд</x-slot>
    <x-slot name="subheader">Добро пожаловать, {{ Auth::user()->name }}! Вот что происходит в вашем мотосалоне.</x-slot>

    <!-- Карточки статистики -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Выручка -->
        <div class="stat-card-1 rounded-2xl p-6 text-white card-hover shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-sm opacity-80 mb-1">Общая выручка</div>
                    <div class="text-3xl font-bold">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} ₽</div>
                    <div class="text-xs opacity-80 mt-2">
                        <i class="ri-money-ruble-circle-line"></i> Оплаченные заказы
                    </div>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="ri-money-ruble-circle-line text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Заказы -->
        <div class="stat-card-2 rounded-2xl p-6 text-white card-hover shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-sm opacity-80 mb-1">Всего заказов</div>
                    <div class="text-3xl font-bold">{{ $stats['total_orders'] }}</div>
                    <div class="text-xs opacity-80 mt-2">
                        <i class="ri-alarm-warning-line"></i> Новых: {{ $stats['new_orders'] }}
                    </div>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="ri-shopping-bag-3-line text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Мотоциклы -->
        <div class="stat-card-3 rounded-2xl p-6 text-white card-hover shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-sm opacity-80 mb-1">Мотоциклы</div>
                    <div class="text-3xl font-bold">{{ $stats['total_motorcycles'] }}</div>
                    <div class="text-xs opacity-80 mt-2">
                        <i class="ri-check-double-line"></i> Опубликовано: {{ $stats['published_motorcycles'] }}
                    </div>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="ri-motorbike-line text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Клиенты -->
        <div class="stat-card-4 rounded-2xl p-6 text-white card-hover shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-sm opacity-80 mb-1">Клиенты</div>
                    <div class="text-3xl font-bold">{{ $stats['total_users'] }}</div>
                    <div class="text-xs opacity-80 mt-2">
                        <i class="ri-error-warning-line"></i> Заканчивается: {{ $stats['low_stock'] }}
                    </div>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="ri-user-3-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Быстрые действия -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('admin.motorcycles.create') }}" 
           class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition flex items-center space-x-4 card-hover border border-gray-100">
            <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="ri-add-line text-3xl text-indigo-600"></i>
            </div>
            <div>
                <div class="font-bold text-gray-800">Добавить мотоцикл</div>
                <div class="text-sm text-gray-500">Новая позиция в каталог</div>
            </div>
        </a>

        <a href="{{ route('admin.categories.create') }}" 
           class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition flex items-center space-x-4 card-hover border border-gray-100">
            <div class="w-14 h-14 bg-pink-100 rounded-xl flex items-center justify-center">
                <i class="ri-price-tag-3-line text-3xl text-pink-600"></i>
            </div>
            <div>
                <div class="font-bold text-gray-800">Новая категория</div>
                <div class="text-sm text-gray-500">Организуйте каталог</div>
            </div>
        </a>

        <a href="{{ route('admin.orders.index') }}" 
           class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition flex items-center space-x-4 card-hover border border-gray-100">
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center relative">
                <i class="ri-shopping-bag-3-line text-3xl text-green-600"></i>
                @if($stats['new_orders'] > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center">
                        {{ $stats['new_orders'] }}
                    </span>
                @endif
            </div>
            <div>
                <div class="font-bold text-gray-800">Посмотреть заказы</div>
                <div class="text-sm text-gray-500">
                    @if($stats['new_orders'] > 0)
                        <span class="text-red-500 font-medium">{{ $stats['new_orders'] }} новых заказов!</span>
                    @else
                        Нет новых заказов
                    @endif
                </div>
            </div>
        </a>
    </div>

    <!-- Последние заказы и Топ мотоциклов -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Последние заказы -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Последние заказы</h3>
                    <p class="text-sm text-gray-500">5 самых свежих заказов</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Все заказы →
                </a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentOrders as $order)
                    <div class="p-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <i class="ri-shopping-bag-line text-indigo-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">Заказ #{{ $order->id }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->customer_name }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-gray-800">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</div>
                                <span class="text-xs px-2 py-1 rounded-full
                                    @if($order->status === 'paid') bg-green-100 text-green-700
                                    @elseif($order->status === 'new') bg-yellow-100 text-yellow-700
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                                    @else bg-blue-100 text-blue-700 @endif">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                        </div>
                        <div class="text-xs text-gray-400 mt-2">
                            <i class="ri-time-line"></i> {{ $order->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <i class="ri-inbox-line text-4xl mb-2"></i>
                        <div>Заказов пока нет</div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Топ мотоциклов -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-800">Популярные мотоциклы</h3>
                <p class="text-sm text-gray-500">Топ-5 по количеству заказов</p>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($topMotorcycles as $index => $moto)
                    <div class="p-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg 
                                    @if($index === 0) bg-yellow-100 text-yellow-600
                                    @elseif($index === 1) bg-gray-200 text-gray-600
                                    @elseif($index === 2) bg-orange-100 text-orange-600
                                    @else bg-gray-100 text-gray-500 @endif
                                    flex items-center justify-center font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $moto->brand }} {{ $moto->model }}</div>
                                    <div class="text-xs text-gray-500">{{ $moto->category->name ?? '—' }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-gray-800">{{ number_format($moto->price, 0, ',', ' ') }} ₽</div>
                                <div class="text-xs text-gray-500">
                                    <i class="ri-shopping-cart-line"></i> {{ $moto->order_items_count }} заказов
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <i class="ri-motorbike-line text-4xl mb-2"></i>
                        <div>Мотоциклов пока нет</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Статусы заказов -->
    @if(count($ordersByStatus) > 0)
        <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-lg text-gray-800 mb-4">Заказы по статусам</h3>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                @php
                    $statusColors = [
                        'new' => ['bg-yellow-100', 'text-yellow-700', 'Новые'],
                        'paid' => ['bg-green-100', 'text-green-700', 'Оплачены'],
                        'processing' => ['bg-blue-100', 'text-blue-700', 'В обработке'],
                        'shipped' => ['bg-purple-100', 'text-purple-700', 'Отправлены'],
                        'delivered' => ['bg-emerald-100', 'text-emerald-700', 'Доставлены'],
                        'cancelled' => ['bg-red-100', 'text-red-700', 'Отменены'],
                    ];
                @endphp
                @foreach($statusColors as $status => $colors)
                    <div class="{{ $colors[0] }} rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold {{ $colors[1] }}">
                            {{ $ordersByStatus[$status] ?? 0 }}
                        </div>
                        <div class="text-sm {{ $colors[1] }} mt-1">{{ $colors[2] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-admin-layout>