<?php

namespace Database\Seeders;

use App\Console\ParseData\ProductParserObject;
use App\MyFunctions\MyFunc;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsSeeder extends Seeder
{

    private string $allUrlsFilePath = 'pars_data/all_urls.txt';
    private string $productPagesPath = 'pars_data/pages/'; // with /

    public function run(): void
    {
        MyFunc::hello();
        $allUrls = explode("\n", Storage::get($this->allUrlsFilePath));

        //for ($i = 0; $i < count($allUrls) - 1; $i++) {
        $idCounter = 0;
        foreach ($allUrls as $url) {
            $idCounter++;
            $fileHtmlString = Storage::get($this->productPagesPath . MyFunc::urlToFileName($url));
            $prod = new ProductParserObject($fileHtmlString, $url);
            try {

                $country = DB::table('countries')->where('name', $prod->madeIn)->first();
                if (!$country) {
                    $country = new class {
                        public int $id = 1;
                    };
                }
                print($idCounter . ' ' . $url . ' ' . $prod->madeIn . ' => ' . $country->id) . PHP_EOL;


//                DB::table('countries')->insert(
//                    [
//                        'id' => $prod['id'],
//                        'name' => $prod['name'],
//                        'created_at' => $now,
//                        'updated_at' => $now,
//                    ]
//                );
            } catch (Exception $e) {
                continue; // Пропустить текущую итерацию цикла и перейти к следующей
            }
            if (sizeof($allUrls) + 1 == $idCounter + 2) {
                //print(sizeof($allUrls) . '==' . $idCounter+2) . PHP_EOL;
                return;
            }
        }

        //print_r($allUrls);
    }
}
