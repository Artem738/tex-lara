<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatternsSeeder extends Seeder
{


    public function __construct()
    {
//        $this->categoriesNumberToInsert = DatabaseSeeder::$categoriesNumberToInsert ?? 10;
//        $this->currentId = DB::table('categories')->max('id') + 1 ?? 1;
    }

    public function run(): void
    {
        $patternsData = [

            ['id' => 1, 'name' => 'Ёлочка'],
            ['id' => 2, 'name' => 'Голограмма'],
            ['id' => 3, 'name' => 'Горошек'],
            ['id' => 4, 'name' => 'Гусиная Лапка'],
            ['id' => 5, 'name' => 'Звёзды'],
            ['id' => 6, 'name' => 'Зигзаг'],
            ['id' => 7, 'name' => 'Змеиная Кожа'],
            ['id' => 8, 'name' => 'Камуфляж'],
            ['id' => 9, 'name' => 'Кант'],
            ['id' => 10, 'name' => 'Клетка'],
            ['id' => 11, 'name' => 'Круги'],
            ['id' => 12, 'name' => 'Купон'],
            ['id' => 13, 'name' => 'Леопард'],
            ['id' => 14, 'name' => 'Матовый'],
            ['id' => 15, 'name' => 'Меняющий Цвет'],
            ['id' => 16, 'name' => 'Мятый'],
            ['id' => 17, 'name' => 'Однотонный'],
            ['id' => 18, 'name' => 'Перламутр'],
            ['id' => 19, 'name' => 'Полоска'],
            ['id' => 20, 'name' => 'Принт'],
            ['id' => 21, 'name' => 'Ракушка'],
            ['id' => 22, 'name' => 'Узор'],
            ['id' => 23, 'name' => 'Хамелеон'],

        ];


        foreach ($patternsData as $line) {

            try {
                DB::table('patterns')->insert(
                    [
                        'id' => $line['id'],
                        'name' => $line['name'],
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


