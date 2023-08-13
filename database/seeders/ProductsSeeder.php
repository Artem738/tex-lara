<?php

namespace Database\Seeders;

use App\Console\ParseData\ProductParserObject;
use App\Models\Category;
use App\Models\Fabric;
use App\Models\Purpose;
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

                $insertedProductId = DB::getPdo()->lastInsertId();

                // categories
                $categoriesToAdd = explode(';', $prod->categoryAll);
                $this->attachManyToMany((new Category)->getTable(), 'category_product', 'category_id', $categoriesToAdd, $insertedProductId);

                // purposes
                $purposesToAdd = explode(';', $prod->purpose);
                $this->attachManyToMany((new Purpose)->getTable(), 'purpose_product', 'purpose_id', $purposesToAdd, $insertedProductId);

                // purposes
                $fabricsToAdd = explode(';', $prod->fabricStructure);
                $this->attachManyToMany((new Fabric)->getTable(), 'fabric_product', 'fabric_id', $fabricsToAdd, $insertedProductId);

            } catch (Exception $e) {
                var_dump($e->getMessage()); // Вывести сообщение об ошибке и остановить выполнение скрипта
                die();
            }


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

    private function attachManyToMany($table, $relationTable, $relationColumn, $dataToAdd, $insertedProductId)
    {
        $dataIdsToAdd = DB::table($table)
            ->whereIn('name', $dataToAdd)
            ->pluck('id');

        DB::table($relationTable)->insert(
            $dataIdsToAdd->map(
                function ($categoryId) use ($relationColumn, $insertedProductId) {
                    return [
                        'product_id' => $insertedProductId,
                        $relationColumn => $categoryId,
                    ];
                }
            )->toArray()
        );
    }
}
