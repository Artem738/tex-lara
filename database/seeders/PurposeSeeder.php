<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurposeSeeder extends Seeder
{

    public function __construct()
    {
//        $this->categoriesNumberToInsert = DatabaseSeeder::$categoriesNumberToInsert ?? 10;
//        $this->currentId = DB::table('categories')->max('id') + 1 ?? 1;
    }

    public function run(): void
    {
        $purposeData = [
            ['id' => 1, 'name' => ''],
            ['id' => 2, 'name' => 'Бельевые'],
            ['id' => 3, 'name' => 'Блузка'],
            ['id' => 4, 'name' => 'Боди'],
            ['id' => 5, 'name' => 'Брюки'],
            ['id' => 6, 'name' => 'Для Пижам'],
            ['id' => 7, 'name' => 'Для Принтования'],
            ['id' => 8, 'name' => 'Купальник'],
            ['id' => 9, 'name' => 'Пальто'],
            ['id' => 10, 'name' => 'Пиджак'],
            ['id' => 11, 'name' => 'Платье'],
            ['id' => 12, 'name' => 'Плащевые'],
            ['id' => 13, 'name' => 'Подклад'],
            ['id' => 14, 'name' => 'Рубашка'],
            ['id' => 15, 'name' => 'Спортивная Одежда'],
            ['id' => 16, 'name' => 'Трикотаж'],
            ['id' => 17, 'name' => 'Шарф'],
            ['id' => 18, 'name' => 'Шуба'],
            ['id' => 19, 'name' => 'Юбка'],
        ];


        foreach ($purposeData as $pup) {

            // print($country['name']) . PHP_EOL;
            // print($country['id']) . PHP_EOL;
            // die();


            try {
                DB::table('categories')->insert(
                    [
                        'id' => $pup['id'],
                        'name' => $pup['name'],
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
