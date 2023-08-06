<?php

namespace Database\Seeders;


use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CountriesSeeder extends Seeder
{
//    private int $categoriesNumberToInsert;
//    protected int $currentId;
//    protected int $duplicatedEntryCount = 0;

    public function __construct()
    {
//        $this->categoriesNumberToInsert = DatabaseSeeder::$categoriesNumberToInsert ?? 10;
//        $this->currentId = DB::table('categories')->max('id') + 1 ?? 1;
    }

    public function run(): void
    {
        $countriesData = [
            ['id' => 1, 'name' => 'Отсутствует'],
            ['id' => 2, 'name' => 'Китай'],
            ['id' => 3, 'name' => 'Индия'],
            ['id' => 4, 'name' => 'Турция'],
            ['id' => 5, 'name' => 'Китай (Северная Монголия)'],
            ['id' => 6, 'name' => 'Франция'],
            ['id' => 7, 'name' => 'Италия'],
            ['id' => 8, 'name' => 'Корея'],
            ['id' => 9, 'name' => 'Бельгия'],
            ['id' => 10, 'name' => 'Пакистан'],
            ['id' => 11, 'name' => 'Белорусь'],
            ['id' => 12, 'name' => 'Европа'],
        ];


        $now = now();

        foreach ($countriesData as $country) {

           // print($country['name']) . PHP_EOL;
           // print($country['id']) . PHP_EOL;
            // die();


            try {
                DB::table('countries')->insert(
                    [
                        'id' => $country['id'],
                        'name' => $country['name'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            } catch (Exception $e) {
                continue; // Пропустить текущую итерацию цикла и перейти к следующей
            }
        }

    }


}
