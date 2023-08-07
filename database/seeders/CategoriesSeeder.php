<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder
{


    public function __construct()
    {
//        $this->categoriesNumberToInsert = DatabaseSeeder::$categoriesNumberToInsert ?? 10;
//        $this->currentId = DB::table('categories')->max('id') + 1 ?? 1;
    }

    public function run(): void
    {
        $categoriesData = [
            ['id' => 1, 'name' => 'Hовое*'],
            ['id' => 2, 'name' => 'SALE'],
            ['id' => 3, 'name' => 'Бифлекс'],
            ['id' => 4, 'name' => 'Для бальных танцев'],
            ['id' => 5, 'name' => 'Для военной формы'],
            ['id' => 6, 'name' => 'Для спортивной одежды'],
            ['id' => 7, 'name' => 'Синтетическая ткань'],
            ['id' => 8, 'name' => 'Ткани для одежды'],
            ['id' => 9, 'name' => 'джинсовая ткань'],
            ['id' => 10, 'name' => 'Для блузок'],
            ['id' => 11, 'name' => 'Для детской одежды'],
            ['id' => 12, 'name' => 'Для жилетов'],
            ['id' => 13, 'name' => 'Для костюмов'],
            ['id' => 14, 'name' => 'Для пальто'],
            ['id' => 15, 'name' => 'Для платьев'],
            ['id' => 16, 'name' => 'Для рубашек'],
            ['id' => 17, 'name' => 'Для юбок'],
            ['id' => 18, 'name' => 'НАТУРАЛЬНЫЕ'],
            ['id' => 19, 'name' => 'Ткани для жакетов'],
            ['id' => 20, 'name' => 'Ткани для фартуков'],
            ['id' => 21, 'name' => 'Ткани для штанов'],
            ['id' => 22, 'name' => 'Ткани для нижнего белья'],
            // Добавьте остальные категории здесь...
        ];


        foreach ($categoriesData as $country) {

            // print($country['name']) . PHP_EOL;
            // print($country['id']) . PHP_EOL;
            // die();


            try {
                DB::table('countries')->insert(
                    [
                        'id' => $country['id'],
                        'name' => $country['name'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            } catch (Exception $e) {
                continue; // Пропустить текущую итерацию цикла и перейти к следующей
            }
        }

    }


}


