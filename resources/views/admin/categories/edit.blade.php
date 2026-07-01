<x-admin-layout>
    <x-slot name="header">Редактировать категорию</x-slot>
    <x-slot name="subheader">{{ $category->name }}</x-slot>

    <div class="max-w-2xl">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            @csrf @method('PUT')

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                    <ul class="text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Название *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-pink-500" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Описание</label>
                <textarea name="description" rows="4" class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-pink-500">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="flex gap-3 pt-6 border-t border-gray-100">
                <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-8 rounded-xl flex items-center gap-2 shadow-lg shadow-pink-200">
                    <i class="ri-save-line"></i> Сохранить
                </button>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-8 rounded-xl flex items-center gap-2">
                    <i class="ri-close-line"></i> Отмена
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>