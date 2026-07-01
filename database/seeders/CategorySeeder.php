<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Спортивные', 'slug' => 'sport', 'description' => 'Быстрые мотоциклы для трека'],
            ['name' => 'Круизеры', 'slug' => 'cruiser', 'description' => 'Комфортные мотоциклы для дальних поездок'],
            ['name' => 'Эндуро', 'slug' => 'enduro', 'description' => 'Внедорожные мотоциклы'],
            ['name' => 'Нейкеды', 'slug' => 'naked', 'description' => 'Универсальные мотоциклы без обтекателя'],
            ['name' => 'Туристические', 'slug' => 'touring', 'description' => 'Для комфортных путешествий'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}