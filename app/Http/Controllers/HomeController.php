<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // 6 последних опубликованных мотоциклов
        $featuredMotorcycles = Motorcycle::where('is_published', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Все категории с количеством мотоциклов
        $categories = Category::withCount('motorcycles')->get();

        // Самые дешёвые мотоциклы (для блока "Выгодно")
        $cheapMotorcycles = Motorcycle::where('is_published', true)
            ->with('category')
            ->orderBy('price', 'asc')
            ->take(4)
            ->get();

        return view('home', compact('featuredMotorcycles', 'categories', 'cheapMotorcycles'));
    }
}