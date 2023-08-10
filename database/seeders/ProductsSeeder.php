<?php

namespace Database\Seeders;

use App\Console\ParseData\ProductParserObject;
use App\Models\Category;
use App\MyFunctions\MyFunc;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ProductsSeeder extends Seeder
{

    private string $allUrlsFilePath = 'pars_data/all_urls.txt';
    private string $productPagesPath = 'pars_data/pages/'; // with /

    public function run(): void
    {
        MyFunc::hello();
        $allUrls = explode("\n", Storage::get($this->allUrlsFilePath));
//        $progressBar = new ProgressBar(new ConsoleOutput, count($allUrls)); // BAR
//        $progressBar->start(); // BAR
//        $startTime = time(); // BAR


        $currentProductId = 0;
        foreach ($allUrls as $url) {
            $currentProductId++;
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


                $insertedProductId = DB::table('products')->insert(
                    [
                        'id' => $currentProductId,
                        'name' => $prod->title,
                        'sku' => $prod->sku,
                        'good_url' => $prod->goodUrl,
                        'description' => $prod->description,
                        // 'category_id' => null,
                        //'purpose_id' =>  null,
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
                /* insert Category */
                $insertedProductId = DB::getPdo()->lastInsertId();

                $categoriesToAdd = explode(';', $prod->categoryAll);
                $categoryIdsToAdd = DB::table('categories')
                    ->whereIn('name', $categoriesToAdd)
                    ->pluck('id');

                DB::table('category_product')->insert(
                    $categoryIdsToAdd->map(
                        function ($categoryId) use ($insertedProductId) {
                            return [
                                'product_id' => $insertedProductId,
                                'category_id' => $categoryId,
                            ];
                        }
                    )->toArray()
                );

                // Get the first category associated with the product
                $firstCategory = DB::table('category_product')
                    ->where('product_id', $insertedProductId)
                    ->first();

                // Update the category_id in the products table
                if ($firstCategory) {
                    DB::table('products')
                        ->where('id', $insertedProductId)
                        ->update(['category_id' => $firstCategory->category_id]);
                }

                /* insert Purpose */
                $purposesToAdd = explode(';', $prod->purpose);
                $purposeIdsToAdd = DB::table('purposes')
                    ->whereIn('name', $purposesToAdd) // Use 'whereIn' instead of 'insertGetId'
                    ->pluck('id');

                DB::table('purpose_product')->insert(
                    $purposeIdsToAdd->map(
                        function ($purposeId) use ($insertedProductId) {
                            return [
                                'purpose_id' => $purposeId,
                                'product_id' => $insertedProductId,
                            ];
                        }
                    )->toArray()
                );

                // Get the first purpose associated with the product
                $firstPurpose = DB::table('purpose_product')
                    ->where('product_id', $insertedProductId)
                    ->first();

                // Update the purpose_id in the products table
                if ($firstPurpose) {
                    DB::table('products')
                        ->where('id', $insertedProductId)
                        ->update(['purpose_id' => $firstPurpose->purpose_id]);
                }


            } catch (Exception $e) {
                var_dump($e->getMessage()); // Вывести сообщение об ошибке и остановить выполнение скрипта
                die();
            }
//            $progressBar->setFormat(
//                "   Current Id:" . ($currentProductId) .
//                ", Batch-%current% [%bar%] %percent:3s%% %elapsed:5s%"
//            );
//            $progressBar->advance(); // BAR

            if (sizeof($allUrls) + 1 == $currentProductId + 2) {
                //print(sizeof($allUrls) . '==' . $idCounter+2) . PHP_EOL;
                return;
            }
            if ($currentProductId == 10) {
                //print(sizeof($allUrls) . '==' . $idCounter+2) . PHP_EOL;
                // return;
            }
        }
        //   $progressBar->finish(); // BAR

        //print_r($allUrls);
    }
}
