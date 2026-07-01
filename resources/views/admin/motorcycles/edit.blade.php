<x-admin-layout>
    <x-slot name="header">Редактировать мотоцикл</x-slot>
    <x-slot name="subheader">{{ $motorcycle->brand }} {{ $motorcycle->model }}</x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('admin.motorcycles.update', $motorcycle->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            @csrf @method('PUT')

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="ri-error-warning-line text-red-500 text-xl mr-3"></i>
                        <ul class="text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Категория *</label>
                <select name="category_id" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $motorcycle->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Бренд *</label>
                    <input type="text" name="brand" value="{{ old('brand', $motorcycle->brand) }}" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Модель *</label>
                    <input type="text" name="model" value="{{ old('model', $motorcycle->model) }}" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Год *</label>
                    <input type="number" name="year" value="{{ old('year', $motorcycle->year) }}" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Цена (₽) *</label>
                    <input type="number" name="price" value="{{ old('price', $motorcycle->price) }}" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">На складе *</label>
                    <input type="number" name="stock" value="{{ old('stock', $motorcycle->stock) }}" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Описание *</label>
                <textarea name="description" rows="5" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500" required>{{ old('description', $motorcycle->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Фотография</label>
                @if($motorcycle->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $motorcycle->image) }}" class="h-48 rounded-xl object-cover">
                    </div>
                @endif
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-indigo-400 transition">
                    <input type="file" name="image" accept="image/*" class="w-full">
                    <p class="text-sm text-gray-500 mt-2">Загрузите новое фото, чтобы заменить</p>
                </div>
            </div>

            <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ $motorcycle->is_published ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 rounded">
                    <span class="ml-3 font-medium text-gray-700">Опубликовать на сайте</span>
                </label>
            </div>

            <div class="flex gap-3 pt-6 border-t border-gray-100">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl flex items-center gap-2 shadow-lg shadow-indigo-200">
                    <i class="ri-save-line"></i> Сохранить изменения
                </button>
                <a href="{{ route('admin.motorcycles.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-8 rounded-xl flex items-center gap-2">
                    <i class="ri-close-line"></i> Отмена
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>