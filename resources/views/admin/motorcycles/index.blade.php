<x-admin-layout>
    <x-slot name="header">Мотоциклы</x-slot>
    <x-slot name="subheader">Управление каталогом мотоциклов</x-slot>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="ri-motorbike-line text-2xl text-indigo-600"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Всего в каталоге</div>
                <div class="text-2xl font-bold text-gray-800">{{ $motorcycles->total() }}</div>
            </div>
        </div>
        <a href="{{ route('admin.motorcycles.create') }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl flex items-center gap-2 shadow-lg shadow-indigo-200 transition">
            <i class="ri-add-line text-xl"></i>
            Добавить мотоцикл
        </a>
    </div>

    @if($motorcycles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($motorcycles as $moto)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden card-hover">
                    <!-- Изображение -->
                    <div class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                        @if($moto->image)
                            <img src="{{ asset('storage/' . $moto->image) }}" 
                                 alt="{{ $moto->brand }} {{ $moto->model }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="ri-motorbike-line text-6xl text-gray-300"></i>
                            </div>
                        @endif
                        
                        <!-- Бейджи -->
                        <div class="absolute top-3 left-3 flex gap-2">
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
                        
                        <div class="absolute top-3 right-3">
                            <span class="bg-white text-gray-700 text-xs px-2 py-1 rounded-full font-medium shadow">
                                {{ $moto->category->name ?? '—' }}
                            </span>
                        </div>
                    </div>

                    <!-- Информация -->
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">{{ $moto->brand }} {{ $moto->model }}</h3>
                                <p class="text-sm text-gray-500">{{ $moto->year }} год</p>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-bold text-indigo-600">{{ number_format($moto->price, 0, ',', ' ') }} ₽</div>
                            </div>
                        </div>

                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $moto->description }}</p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-2 text-sm">
                                <i class="ri-box-3-line text-gray-400"></i>
                                <span class="text-gray-600">
                                    На складе: <strong class="{{ $moto->stock < 3 ? 'text-red-500' : 'text-gray-800' }}">{{ $moto->stock }}</strong>
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.motorcycles.edit', $moto->id) }}" 
                                   class="w-9 h-9 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition"
                                   title="Редактировать">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <form action="{{ route('admin.motorcycles.destroy', $moto->id) }}" method="POST" class="inline" onsubmit="return confirm('Удалить мотоцикл?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="w-9 h-9 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition"
                                            title="Удалить">
                                        <i class="ri-delete-bin-line"></i>
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
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ri-motorbike-line text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Каталог пуст</h3>
            <p class="text-gray-500 mb-6">Добавьте первый мотоцикл, чтобы начать продажи</p>
            <a href="{{ route('admin.motorcycles.create') }}" 
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl">
                <i class="ri-add-line"></i>
                Добавить мотоцикл
            </a>
        </div>
    @endif
</x-admin-layout>