<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Хлебные крошки -->
            <nav class="mb-6 text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-indigo-600">Главная</a>
                <i class="ri-arrow-right-s-line mx-2"></i>
                <a href="{{ route('shop.index') }}" class="hover:text-indigo-600">Каталог</a>
                <i class="ri-arrow-right-s-line mx-2"></i>
                <span class="text-gray-800">{{ $motorcycle->brand }} {{ $motorcycle->model }}</span>
            </nav>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    <!-- Фото -->
                    <div>
                        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 aspect-square">
                            @if($motorcycle->image)
                                <img src="{{ asset('storage/' . $motorcycle->image) }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="ri-motorbike-line text-9xl text-gray-300"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Информация -->
                    <div>
                        <div class="mb-4">
                            <span class="inline-block bg-indigo-100 text-indigo-700 text-sm px-3 py-1 rounded-full font-bold mb-3">
                                {{ $motorcycle->category->name ?? '—' }}
                            </span>
                            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                                {{ $motorcycle->brand }} {{ $motorcycle->model }}
                            </h1>
                            <p class="text-gray-500">{{ $motorcycle->year }} год выпуска</p>
                        </div>

                        <div class="mb-6">
                            <div class="text-4xl font-bold text-indigo-600 mb-2">
                                {{ number_format($motorcycle->price, 0, ',', ' ') }} ₽
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                @if($motorcycle->stock > 0)
                                    <span class="inline-flex items-center gap-1 text-green-600 font-bold">
                                        <i class="ri-checkbox-circle-fill"></i> В наличии ({{ $motorcycle->stock }} шт.)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-red-600 font-bold">
                                        <i class="ri-close-circle-fill"></i> Нет в наличии
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <i class="ri-file-text-line text-indigo-600"></i> Описание
                            </h3>
                            <p class="text-gray-700 leading-relaxed">{{ $motorcycle->description }}</p>
                        </div>

                        <!-- Характеристики -->
                        <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-xl">
                            <div>
                                <div class="text-xs text-gray-500 mb-1">Бренд</div>
                                <div class="font-bold text-gray-800">{{ $motorcycle->brand }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 mb-1">Модель</div>
                                <div class="font-bold text-gray-800">{{ $motorcycle->model }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 mb-1">Год</div>
                                <div class="font-bold text-gray-800">{{ $motorcycle->year }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 mb-1">Категория</div>
                                <div class="font-bold text-gray-800">{{ $motorcycle->category->name ?? '—' }}</div>
                            </div>
                        </div>

                        <!-- Кнопки -->
                        @if($motorcycle->stock > 0)
                            <form action="{{ route('shop.cart.add', $motorcycle->id) }}" method="POST" class="mb-4">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-xl text-lg transition transform hover:scale-105 shadow-lg shadow-indigo-200 flex items-center justify-center gap-2">
                                    <i class="ri-shopping-cart-line text-2xl"></i>
                                    Добавить в корзину
                                </button>
                            </form>
                        @else
                            <button disabled 
                                    class="w-full bg-gray-300 text-white font-bold py-4 px-6 rounded-xl text-lg cursor-not-allowed">
                                Нет в наличии
                            </button>
                        @endif

                        <a href="{{ route('shop.index') }}" 
                           class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 px-6 rounded-xl text-center transition flex items-center justify-center gap-2">
                            <i class="ri-arrow-left-line"></i> Вернуться в каталог
                        </a>
                    </div>
                </div>
            </div>

            <!-- Похожие мотоциклы -->
            @if($related->count() > 0)
                <div class="mt-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Похожие мотоциклы</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($related as $moto)
                            <a href="{{ route('shop.show', $moto->id) }}" 
                               class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-2 border border-gray-100">
                                <div class="relative h-40 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
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
                                    <h3 class="font-bold text-gray-800 mb-1">{{ $moto->brand }} {{ $moto->model }}</h3>
                                    <p class="text-sm text-gray-500 mb-2">{{ $moto->year }} г.</p>
                                    <div class="text-xl font-bold text-indigo-600">{{ number_format($moto->price, 0, ',', ' ') }} ₽</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>