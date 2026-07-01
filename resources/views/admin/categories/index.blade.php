<x-admin-layout>
    <x-slot name="header">Категории</x-slot>
    <x-slot name="subheader">Управление категориями мотоциклов</x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                <i class="ri-price-tag-3-line text-2xl text-pink-600"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Всего категорий</div>
                <div class="text-2xl font-bold text-gray-800">{{ $categories->count() }}</div>
            </div>
        </div>
        <a href="{{ route('admin.categories.create') }}" 
           class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-6 rounded-xl flex items-center gap-2 shadow-lg shadow-pink-200">
            <i class="ri-add-line text-xl"></i>
            Добавить категорию
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Категория</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Описание</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Мотоциклов</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                                    <i class="ri-price-tag-3-line text-pink-600"></i>
                                </div>
                                <div class="font-bold text-gray-800">{{ $category->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <code class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-sm">{{ $category->slug }}</code>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $category->description ?? '—' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-bold">
                                {{ $category->motorcycles_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                   class="w-9 h-9 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Удалить категорию?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-9 h-9 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <i class="ri-price-tag-3-line text-4xl text-gray-300 mb-2"></i>
                            <div class="text-gray-500">Категорий пока нет</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>