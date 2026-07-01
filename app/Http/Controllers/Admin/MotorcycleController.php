<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotorcycleController extends Controller
{
    public function index()
    {
        $motorcycles = Motorcycle::with('category')->latest()->paginate(10);
        return view('admin.motorcycles.index', compact('motorcycles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.motorcycles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2100',
            'price' => 'required|numeric|min:0|max:999999999999',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('motorcycles', 'public');
        }

        Motorcycle::create($validated);
        return redirect()->route('admin.motorcycles.index')->with('success', 'Мотоцикл добавлен!');
    }

    public function edit(Motorcycle $motorcycle)
    {
        $categories = Category::all();
        return view('admin.motorcycles.edit', compact('motorcycle', 'categories'));
    }

    public function update(Request $request, Motorcycle $motorcycle)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2100',
            'price' => 'required|numeric|min:0|max:999999999999',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            if ($motorcycle->image) {
                Storage::disk('public')->delete($motorcycle->image);
            }
            $validated['image'] = $request->file('image')->store('motorcycles', 'public');
        }

        $motorcycle->update($validated);
        return redirect()->route('admin.motorcycles.index')->with('success', 'Мотоцикл обновлён!');
    }

    public function destroy(Motorcycle $motorcycle)
    {
        if ($motorcycle->image) {
            Storage::disk('public')->delete($motorcycle->image);
        }
        $motorcycle->delete();
        return redirect()->route('admin.motorcycles.index')->with('success', 'Мотоцикл удалён!');
    }
}