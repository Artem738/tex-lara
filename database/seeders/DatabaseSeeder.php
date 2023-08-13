<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Fabric;
use App\MyFunctions\MyFunc;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        MyFunc::hello();
        //        $this->call(CategorySeeder::class);
        //        $this->call(BookSeeder::class);
        $this->call(
            [
                CountriesSeeder::class,
                CategoriesSeeder::class,
                PurposeSeeder::class,
                FabricsSeeder::class,
                ProductsSeeder::class,

            ]
        );

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
