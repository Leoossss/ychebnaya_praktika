<x-admin-layout>
    <x-slot name="header">Добавить мотоцикл</x-slot>
    <x-slot name="subheader">Заполните информацию о новом мотоцикле</x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('admin.motorcycles.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            @csrf

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="ri-error-warning-line text-red-500 text-xl mr-3"></i>
                        <div class="text-red-700">
                            <strong>Ошибки валидации:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Категория -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="ri-price-tag-3-line mr-1"></i> Категория *
                </label>
                <select name="category_id" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Бренд и Модель -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="ri-building-line mr-1"></i> Бренд *
                    </label>
                    <input type="text" name="brand" value="{{ old('brand') }}" 
                           class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                           placeholder="Yamaha" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="ri-motorbike-line mr-1"></i> Модель *
                    </label>
                    <input type="text" name="model" value="{{ old('model') }}" 
                           class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                           placeholder="YZF-R1" required>
                </div>
            </div>

            <!-- Год, Цена, Остаток -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="ri-calendar-line mr-1"></i> Год выпуска *
                    </label>
                    <input type="number" name="year" value="{{ old('year') }}" 
                           class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                           placeholder="2024" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="ri-money-ruble-circle-line mr-1"></i> Цена (₽) *
                    </label>
                    <input type="number" name="price" value="{{ old('price') }}" 
                           class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                           placeholder="1500000" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="ri-box-3-line mr-1"></i> На складе *
                    </label>
                    <input type="number" name="stock" value="{{ old('stock', 1) }}" 
                           class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                           placeholder="1" required>
                </div>
            </div>

            <!-- Описание -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="ri-file-text-line mr-1"></i> Описание *
                </label>
                <textarea name="description" rows="5" 
                          class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                          placeholder="Расскажите о мотоцикле..." required>{{ old('description') }}</textarea>
            </div>

            <!-- Фото -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="ri-image-line mr-1"></i> Фотография
                </label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-indigo-400 transition">
                    <input type="file" name="image" accept="image/*" class="w-full">
                    <p class="text-sm text-gray-500 mt-2">JPG, PNG до 2MB</p>
                </div>
            </div>

            <!-- Опубликовать -->
            <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" checked class="w-5 h-5 text-indigo-600 rounded">
                    <span class="ml-3 font-medium text-gray-700">
                        <i class="ri-eye-line mr-1"></i> Опубликовать на сайте
                    </span>
                </label>
            </div>

            <!-- Кнопки -->
            <div class="flex gap-3 pt-6 border-t border-gray-100">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl flex items-center gap-2 shadow-lg shadow-indigo-200 transition">
                    <i class="ri-save-line"></i>
                    Сохранить
                </button>
                <a href="{{ route('admin.motorcycles.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-8 rounded-xl flex items-center gap-2 transition">
                    <i class="ri-close-line"></i>
                    Отмена
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>