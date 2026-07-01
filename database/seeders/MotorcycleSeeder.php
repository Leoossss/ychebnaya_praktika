<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Motorcycle;
use Illuminate\Database\Seeder;

class MotorcycleSeeder extends Seeder
{
    public function run(): void
    {
        $sport = Category::where('slug', 'sport')->first();
        $cruiser = Category::where('slug', 'cruiser')->first();
        $enduro = Category::where('slug', 'enduro')->first();
        $naked = Category::where('slug', 'naked')->first();
        $touring = Category::where('slug', 'touring')->first();

        $motorcycles = [
            ['category_id' => $sport->id, 'brand' => 'Yamaha', 'model' => 'YZF-R1', 'year' => 2023, 'price' => 1850000, 'stock' => 3, 'description' => 'Легендарный суперспорт 998 куб.см, 200 л.с.', 'image' => 'motorcycles/yamaha-r1.jpg', 'is_published' => true],
            ['category_id' => $sport->id, 'brand' => 'Honda', 'model' => 'CBR1000RR-R', 'year' => 2023, 'price' => 2100000, 'stock' => 2, 'description' => 'Топовый спорт с технологиями MotoGP', 'image' => 'motorcycles/honda-cbr.jpg', 'is_published' => true],
            ['category_id' => $sport->id, 'brand' => 'Kawasaki', 'model' => 'Ninja ZX-10R', 'year' => 2023, 'price' => 1950000, 'stock' => 4, 'description' => 'Чемпион WorldSBK', 'image' => 'motorcycles/kawasaki-ninja.jpg', 'is_published' => true],
            ['category_id' => $cruiser->id, 'brand' => 'Harley-Davidson', 'model' => 'Fat Boy', 'year' => 2023, 'price' => 2500000, 'stock' => 2, 'description' => 'Иконический круизер Milwaukee-Eight 114', 'image' => 'motorcycles/harley-fatboy.jpg', 'is_published' => true],
            ['category_id' => $cruiser->id, 'brand' => 'Indian', 'model' => 'Chief Dark Horse', 'year' => 2023, 'price' => 2200000, 'stock' => 3, 'description' => 'Современный круизер Thunderstroke', 'image' => 'motorcycles/indian-chief.jpg', 'is_published' => true],
            ['category_id' => $enduro->id, 'brand' => 'KTM', 'model' => '300 EXC TPI', 'year' => 2023, 'price' => 950000, 'stock' => 5, 'description' => 'Профессиональный эндуро с впрыском', 'image' => 'motorcycles/ktm-300.jpg', 'is_published' => true],
            ['category_id' => $enduro->id, 'brand' => 'Husqvarna', 'model' => 'TE 300i', 'year' => 2023, 'price' => 980000, 'stock' => 4, 'description' => 'Премиальный эндуро', 'image' => 'motorcycles/husqvarna-te300.jpg', 'is_published' => true],
            ['category_id' => $naked->id, 'brand' => 'Ducati', 'model' => 'Monster', 'year' => 2023, 'price' => 1350000, 'stock' => 3, 'description' => 'Легендарный нейкед Testastretta 937', 'image' => 'motorcycles/ducati-monster.jpg', 'is_published' => true],
            ['category_id' => $naked->id, 'brand' => 'KTM', 'model' => '890 Duke R', 'year' => 2023, 'price' => 1250000, 'stock' => 4, 'description' => 'Агрессивный нейкед 121 л.с.', 'image' => 'motorcycles/ktm-890.jpg', 'is_published' => true],
            ['category_id' => $touring->id, 'brand' => 'BMW', 'model' => 'R 1250 RT', 'year' => 2023, 'price' => 2300000, 'stock' => 2, 'description' => 'Спортивный турер boxer-двигатель', 'image' => 'motorcycles/bmw-rt.jpg', 'is_published' => true],
            ['category_id' => $touring->id, 'brand' => 'Honda', 'model' => 'Gold Wing', 'year' => 2023, 'price' => 3200000, 'stock' => 1, 'description' => 'Король туринга 1833 куб.см DCT', 'image' => 'motorcycles/honda-goldwing.jpg', 'is_published' => true],
        ];

        foreach ($motorcycles as $motorcycle) {
            Motorcycle::create($motorcycle);
        }
    }
}