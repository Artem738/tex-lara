<?php

namespace Database\Seeders;

use App\Console\ParseData\ProductParserObject;
use App\MyFunctions\MyFunc;
use Exception;
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
                //print($idCounter . ' ' . $url . ' ' . $prod->madeIn . ' => ' . $country->id) . PHP_EOL;


                DB::table('products')->insert(
                    [
                        'id' => $idCounter,
                        'name' => $prod->title,
                        'sku' => $prod->sku,
                        'good_url' => $prod->goodUrl,
                        'description' => $prod->description,
                        'category_all' => $prod->categoryAll,
                        'purpose' => $prod->purpose,
                        'roll_width' => $prod->rollWidth,
                        'roll_width_category' => $prod->rollWidthCategory,
                        'density' => $prod->density,
                        'country_id' => $country->id,
                        'fabric_tone' => $prod->fabricTone,
                        'pattern_type' => $prod->patternType,
                        'fabric_structure' => $prod->fabricStructure,
                        'price' => $prod->price,
                        'regular_price' => $prod->regularPrice,
                        'sale_price' => $prod->salePrice,
                        'img_url' => $prod->imgUrl,
                        'all_img_url' => $prod->allImgUrl,
                        'opt_discount' => $prod->optDiscount,
                        'sale_discount' => $prod->saleDiscount,
                        'cut_discount' => $prod->cutDiscount,
                        'roll_discount' => $prod->rollDiscount,
                        'prod_status' => $prod->prodStatus,
                        'similar_products' => $prod->similarProducts,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            } catch (Exception $e) {
                continue; // Пропустить текущую итерацию цикла и перейти к следующей
            }
            if (sizeof($allUrls) + 1 == $idCounter + 2) {
                //print(sizeof($allUrls) . '==' . $idCounter+2) . PHP_EOL;
                return;
            }
            if ($idCounter == 10) {
                //print(sizeof($allUrls) . '==' . $idCounter+2) . PHP_EOL;
               // return;
            }
        }

        //print_r($allUrls);
    }
}
