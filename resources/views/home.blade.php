<x-app-layout>
    {{-- Hero Section --}}
    <div class="relative bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-900 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="text-center">
                <div class="inline-block px-4 py-2 bg-indigo-500 bg-opacity-30 rounded-full text-sm font-medium mb-6 border border-indigo-400">
                    🏍️ Официальный дилер лучших брендов
                </div>
                <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight">
                    Мотосалон <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-pink-400">PRO</span>
                </h1>
                <p class="text-xl md:text-2xl mb-10 text-gray-300 max-w-3xl mx-auto">
                    Лучшие мотоциклы для настоящих ценителей скорости и свободы
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('shop.index') }}" class="inline-block bg-white text-indigo-900 font-bold py-4 px-8 rounded-full hover:bg-gray-100 transition transform hover:scale-105 shadow-2xl">
                        🛒 Перейти в каталог
                    </a>
                    <a href="#categories" class="inline-block bg-indigo-600 text-white font-bold py-4 px-8 rounded-full hover:bg-indigo-700 transition transform hover:scale-105 shadow-2xl">
                        📁 Категории
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Категории --}}
<div id="categories" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Категории мотоциклов</h2>
            <p class="text-lg text-gray-600">Выберите свой стиль езды</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('shop.index', ['category' => $category->id]) }}" 
                   class="group bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-2xl transition transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                        {{-- Иконка мотоцикла --}}
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $category->motorcycles_count }} моделей</p>
                </a>
            @endforeach
        </div>
    </div>
</div>

    {{-- Новинки каталога --}}
<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-4xl font-bold text-gray-800 mb-2">Новинки каталога</h2>
                <p class="text-lg text-gray-600">Последние поступления в наш мотосалон</p>
            </div>
            <a href="{{ route('shop.index') }}" class="hidden md:inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-bold">
                Смотреть все 
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredMotorcycles as $moto)
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-2 border border-gray-100">
                    <div class="relative h-56 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                        @if($moto->image)
                            <img src="{{ asset('storage/' . $moto->image) }}" 
                                 alt="{{ $moto->brand }} {{ $moto->model }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            {{-- Заглушка, если нет фото --}}
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="bg-indigo-600 text-white text-xs px-3 py-1 rounded-full font-bold">
                                {{ $moto->category->name ?? '—' }}
                            </span>
                        </div>
                        @if($moto->stock < 3)
                            <div class="absolute top-4 right-4">
                                <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-bold">
                                    Мало!
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $moto->brand }}</h3>
                                <p class="text-gray-500">{{ $moto->model }} • {{ $moto->year }} г.</p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit($moto->description, 100) }}</p>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div>
                                <div class="text-2xl font-bold text-indigo-600">{{ number_format($moto->price, 0, ',', ' ') }} ₽</div>
                                <div class="text-xs text-gray-500">В наличии: {{ $moto->stock }} шт.</div>
                            </div>
                            <a href="{{ route('shop.show', $moto->id) }}" 
                               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-bold transition">
                                Подробнее
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-12 md:hidden">
            <a href="{{ route('shop.index') }}" class="inline-block bg-indigo-600 text-white font-bold py-3 px-8 rounded-full hover:bg-indigo-700 transition">
                Смотреть все мотоциклы
            </a>
        </div>
    </div>
</div>

    {{-- Выгодные предложения --}}
    @if($cheapMotorcycles->count() > 0)
        <div class="py-20 bg-gradient-to-r from-amber-50 to-orange-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <div class="inline-block px-4 py-2 bg-amber-500 text-white rounded-full text-sm font-bold mb-4">
                        🔥 СПЕЦПРЕДЛОЖЕНИЯ
                    </div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-2">Самые доступные модели</h2>
                    <p class="text-lg text-gray-600">Начните своё путешествие с доступных мотоциклов</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($cheapMotorcycles as $moto)
                        <a href="{{ route('shop.show', $moto->id) }}" 
                           class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-2">
                            <div class="relative h-40 bg-gradient-to-br from-amber-100 to-orange-100 overflow-hidden">
                                @if($moto->image && file_exists(public_path('storage/' . $moto->image)))
    <img src="{{ asset('storage/' . $moto->image) }}" 
         alt="{{ $moto->brand }} {{ $moto->model }}"
         class="w-full h-full object-cover">
@else
    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
        <i class="ri-motorbike-line text-7xl text-gray-400 mb-2"></i>
        <span class="text-xs text-gray-500">Нет фото</span>
    </div>
@endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800">{{ $moto->brand }} {{ $moto->model }}</h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $moto->year }} г.</p>
                                <div class="text-xl font-bold text-amber-600">{{ number_format($moto->price, 0, ',', ' ') }} ₽</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Преимущества --}}
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Почему выбирают нас</h2>
                <p class="text-lg text-gray-600">Мы делаем покупку мотоцикла простой и приятной</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition shadow-lg">
                        <i class="ri-shield-check-line text-4xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Гарантия качества</h3>
                    <p class="text-gray-600">Только оригинальные мотоциклы от проверенных производителей</p>
                </div>
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition shadow-lg">
                        <i class="ri-truck-line text-4xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Быстрая доставка</h3>
                    <p class="text-gray-600">Доставим ваш мотоцикл в любую точку страны</p>
                </div>
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition shadow-lg">
                        <i class="ri-customer-service-line text-4xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Поддержка 24/7</h3>
                    <p class="text-gray-600">Наши специалисты всегда готовы помочь вам</p>
                </div>
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition shadow-lg">
                        <i class="ri-bank-card-line text-4xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Удобная оплата</h3>
                    <p class="text-gray-600">Принимаем наличные и онлайн-платежи через ЮMoney</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Готовы к приключению?</h2>
            <p class="text-xl mb-8 text-indigo-100">Выберите свой мотоцикл прямо сейчас и получите бесплатную консультацию</p>
            <a href="{{ route('shop.index') }}" class="inline-block bg-white text-indigo-600 font-bold py-4 px-10 rounded-full hover:bg-gray-100 transition transform hover:scale-105 shadow-2xl">
                🏍️ Выбрать мотоцикл
            </a>
        </div>
    </div>
</x-app-layout>