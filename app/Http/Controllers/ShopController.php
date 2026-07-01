<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Motorcycle;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Motorcycle::with('category')->published();

        // Поиск
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Фильтр по категории
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Фильтр по цене
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Сортировка
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc': $query->orderBy('price', 'asc'); break;
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            case 'name': $query->orderBy('brand')->orderBy('model'); break;
            default: $query->latest();
        }

        $motorcycles = $query->paginate(9)->withQueryString();
        $categories = Category::all();

        return view('shop.index', compact('motorcycles', 'categories'));
    }

    public function show(Motorcycle $motorcycle)
    {
        $motorcycle->load('category');
        $related = Motorcycle::where('category_id', $motorcycle->category_id)
            ->where('id', '!=', $motorcycle->id)
            ->published()
            ->take(4)
            ->get();

        return view('shop.show', compact('motorcycle', 'related'));
    }
}