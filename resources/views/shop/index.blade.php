<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                    <i class="ri-check-line text-green-500 text-xl mr-3"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Заголовок -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Каталог мотоциклов</h1>
                <p class="text-gray-600">Найдено: {{ $motorcycles->total() }} моделей</p>
            </div>

            <!-- Фильтры -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                <form method="GET" action="{{ route('shop.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ri-search-line"></i> Поиск
                        </label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Название или описание..." 
                               class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ri-price-tag-3-line"></i> Категория
                        </label>
                        <select name="category" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500">
                            <option value="">Все категории</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ri-sort-desc"></i> Сортировка
                        </label>
                        <select name="sort" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500">
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Сначала новые</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Сначала дешёвые</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Сначала дорогие</option>
                            <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>По названию</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-lg shadow-indigo-200">
                            <i class="ri-filter-3-line"></i> Применить
                        </button>
                    </div>
                </form>

                @if(request('search') || request('category') || request('sort'))
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-sm text-gray-500">Активные фильтры:</span>
                        <a href="{{ route('shop.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-bold">
                            <i class="ri-close-circle-line"></i> Сбросить все
                        </a>
                    </div>
                @endif
            </div>

            <!-- Сетка мотоциклов -->
            @if($motorcycles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($motorcycles as $moto)
                        <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-2 border border-gray-100">
                            <div class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
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
                                <div class="absolute top-3 left-3">
                                    <span class="bg-indigo-600 text-white text-xs px-3 py-1 rounded-full font-bold">
                                        {{ $moto->category->name ?? '—' }}
                                    </span>
                                </div>
                                @if($moto->stock < 3)
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-bold">
                                            Мало!
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="mb-3">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $moto->brand }} {{ $moto->model }}</h3>
                                    <p class="text-sm text-gray-500">{{ $moto->year }} год выпуска</p>
                                </div>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($moto->description, 100) }}</p>
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                    <div>
                                        <div class="text-2xl font-bold text-indigo-600">{{ number_format($moto->price, 0, ',', ' ') }} ₽</div>
                                        <div class="text-xs text-gray-500">В наличии: {{ $moto->stock }} шт.</div>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('shop.show', $moto->id) }}" 
                                           class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg transition">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <form action="{{ route('shop.cart.add', $moto->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition">
                                                <i class="ri-shopping-cart-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $motorcycles->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-motorbike-line text-5xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Мотоциклы не найдены</h3>
                    <p class="text-gray-500 mb-6">Попробуйте изменить параметры поиска</p>
                    <a href="{{ route('shop.index') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl">
                        Сбросить фильтры
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>